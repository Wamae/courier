<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Client;
use App\Currency;
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

        return view('invoice.show', compact('invoice'));
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT '1','2', a.id,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,"
                . "client_name,COUNT(DISTINCT invoice_waybills.waybill_id) AS items,SUM(waybills.amount) AS amount, SUM(vat) AS vat,"
                . "SUM(waybills.amount + waybills.vat) AS total,SUM(transactions.amount) AS paid,"
                . "(SUM(waybills.amount + waybills.vat) - SUM(transactions.amount)) AS balance,'status' AS status";

        $presql = " FROM invoices a ";
        $presql .= " LEFT JOIN clients ON clients.id = a.client_id";
        $presql .= " LEFT JOIN invoice_waybills ON invoice_waybills.invoice_id = a.id";
        $presql .= " LEFT JOIN waybills ON waybills.id = invoice_waybills.waybill_id";
        $presql .= " LEFT JOIN transactions ON transactions.invoice_id = a.id";

        $presql .= " GROUP BY a.id ";

        $sql = $select . $presql . "LIMIT " . $start . "," . $len;

        $qcount = DB::select("SELECT COUNT(a.id) c" . $presql);

        $count = $qcount[0]->c;
        //dd($sql);
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

        echo Invoice::whereIn("invoices", $invoiceIds)->delete();
    }

}
