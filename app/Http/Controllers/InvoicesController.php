<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Client;
use App\Currency;
use App\TransactionType;
use DB;
use Auth;
use View;

class InvoicesController extends Controller {

    public $title;

    public function __construct() {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_', ' ', 'Invoice'));
    }

    public function index(Request $request) {
        $title = $this->title;
        return view('invoices.index', compact('title'));
    }

    public function create(Request $request) {
        $title = $this->title;
        $clients = Client::select('id', 'client_name')->get();
        $currencies = Currency::select('id', 'currency')->get();

        return view('invoices.add', compact(['title', 'clients', 'currencies']));
    }

    public function edit(Request $request, $id) {
        $model = Invoice::findOrFail($id);
        $title = $this->title;
        $clients = Client::select('id', 'client_name')->get();
        $currencies = Currency::select('id', 'currency')->get();

        return view('invoices.add', compact('model', 'title', 'clients', 'currencies'));
    }

    public function show(Request $request, $id) {
        $invoice = Invoice::find($id);
        $transactionTypes = TransactionType::all();

        return view('invoices.show', compact(['invoice', 'transactionTypes']));
    }

    public function grid(Request $request) {
        return datatables(
                        DB::table('invoices AS a')
                                ->leftJoin('clients', 'a.client_id', '=', 'clients.id')
                                ->leftJoin('invoice_waybills', 'a.id', '=', 'invoice_waybills.invoice_id')
                                ->leftJoin('waybills', 'invoice_waybills.waybill_id', '=', 'waybills.id')
                                ->leftJoin('transactions', 'a.id', '=', 'transactions.invoice_id')
                                ->groupBy(['a.id'])
                                ->select(["a.id AS X",
                                    DB::raw("a.id +1 AS Y"),
                                    "a.id",
                                    DB::raw("DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at"),
                                    "client_name",
                                    DB::raw("COUNT(DISTINCT invoice_waybills.waybill_id) AS items"),
                                    DB::raw("SUM(waybills.amount) AS amount"),
                                    DB::raw("SUM(vat) AS vat"),
                                    DB::raw("SUM(waybills.amount + waybills.vat) AS total"),
                                    DB::raw("SUM(transactions.amount) AS paid"),
                                    DB::raw("(SUM(waybills.amount + waybills.vat) - SUM(transactions.amount)) AS balance"),
                                    DB::raw("a.id + 2 AS stats")
                                ])->where('a.status', ACTIVE)->orderBy('a.id', 'DESC'))->toJson();
    }

    public function update(Request $request) {
        $this->validate($request, [
            'client_id' => 'required',
            'currency_id' => 'required',
            'due_date' => 'required',
        ]);

        $invoice = null;
        $userId = Auth::user()->id;

        if ($request->id > 0) {
            $invoice = Invoice::findOrFail($request->id);
            $invoice->updated_by = $userId;
        } else {
            $invoice = new Invoice;
            $invoice->created_by = $userId;
        }

        $invoice->id = $request->id ?: 0;

        $invoice->client_id = $request->client_id;

        $invoice->currency_id = $request->currency_id;

        $invoice->due_date = $request->due_date;

        $invoice->save();

        return redirect('/invoices');
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $invoice = Invoice::findOrFail($id);

        $invoice->delete();
        return "OK";
    }

    public function cancelInvoices(Request $request) {
        $invoiceIds = $request["invoice_ids"];

        echo Invoice::whereIn("id", $invoiceIds)->update(['status' => 0, 'updated_by' => Auth::user()->id, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public function getWaybills(Request $request, $invoice_id) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT waybills.id,"
                . "CONCAT(CONCAT(CONCAT(stations.office_code,'-',stations2.office_code),'-',UCASE(DATE_FORMAT(a.created_at,'%a'))),'-',a.id) AS waybill,"
                . "DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,"
                . "package_types.package_type,consignee,FORMAT(amount,2),FORMAT(vat,2),"
                . "FORMAT(SUM(amount+ vat),2)";
        $presql = " FROM invoice_waybills a ";
        $presql .= " LEFT JOIN waybills ON waybills.id = a.waybill_id";
        $presql .= " LEFT JOIN invoices ON invoices.id = a.invoice_id";
        $presql .= " LEFT JOIN currencies ON currencies.id = invoices.currency_id";
        $presql .= " LEFT JOIN stations ON waybills.origin = stations.id ";
        $presql .= " LEFT JOIN stations AS stations2 ON waybills.destination = stations2.id ";
        $presql .= " LEFT JOIN package_types ON waybills.package_type = package_types.id ";
        $presql .= " WHERE a.invoice_id = " . $invoice_id;

        return datatables(
                        DB::table('invoice_waybills AS a')
                                ->leftJoin('waybills', 'waybills.id', '=', 'a.waybill_id')
                                ->leftJoin('invoices', 'invoices.id', '=', 'a.invoice_id')
                                ->leftJoin('currencies', 'currencies.id', '=', 'invoices.currency_id')
                                ->leftJoin('stations', 'stations.id', '=', 'waybills.origin')
                                ->leftJoin('stations AS stations2', 'stations2.id', '=', 'waybills.destination')
                                ->leftJoin('package_types', 'package_types.id', '=', 'waybills.package_type')
                                //->groupBy(['a.id','cs.office_code','cs2.office_code','a.created_at','cs.office_name','cs2.office_name','u.name','a.status','ms.status'])
                                ->select([
                                    "waybills.id",
                                    DB::raw("CONCAT(CONCAT(CONCAT(stations.office_code,'-',stations2.office_code),'-',UCASE(DATE_FORMAT(a.created_at,'%a'))),'-',a.id) AS waybill"),
                                    DB::raw("DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at"),
                                    "package_types.package_type",
                                    "consignee",
                                    DB::raw("FORMAT(amount,2) AS amount"), 
                                    DB::raw("FORMAT(vat,2) AS vat"),
                                            DB::raw("FORMAT(SUM( amount + vat),2) AS total")
                                ])->where('a.invoice_id',$invoice_id)->orderBy('a.id', 'DESC')->groupBy('a.id'))->toJson();
    }

    public function getTransactions(Request $request, $invoice_id) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,"
                . "transaction_type,ref,name AS created_by,FORMAT(amount,2)";
        $presql = " FROM transactions a ";
        $presql .= " LEFT JOIN users ON users.id = a.created_by";
        $presql .= " LEFT JOIN transaction_types ON transaction_types.id = a.transaction_type_id";
        $presql .= " WHERE a.invoice_id = " . $invoice_id;

        $presql .= "  ";

        $sql = $select . $presql . "LIMIT " . $start . "," . $len;


        $qcount = DB::select("SELECT COUNT(a.id) c" . $presql);
        $count = $qcount[0]->c;

        $results = DB::select($sql);
        $ret = [];
        foreach ($results as $row) {
            $r = [];
            foreach ($row as $value) {
                $r[] = $value;
            }
            $ret[] = $r;
        }

        $ret['data'] = $ret;
        $ret['recordsTotal'] = $count;
        $ret['iTotalDisplayRecords'] = $count;

        $ret['recordsFiltered'] = count($ret);
        $ret['draw'] = $_GET['draw'];

        echo json_encode($ret);
    }

}
