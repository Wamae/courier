<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Invoice;
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
        return view('invoices.add', compact('title'));
    }

    public function edit(Request $request, $id) {
        $model = Invoice::findOrFail($id);
        $title = $this->title;
        return view('invoices.add', compact('model', 'title'));
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

        $presql .= "  ";

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
        //
        /* $this->validate($request, [
          'name' => 'required|max:255',
          ]); */
        $waybill_manifest = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $waybill_manifest = Waybill_manifest::findOrFail($request->id);
            $waybill_manifest->updated_by = $user_id;
        } else {
            $waybill_manifest = new Waybill_manifest;
            $waybill_manifest->created_by = $user_id;
        }



        $waybill_manifest->id = $request->id ?: 0;




        $waybill_manifest->manifest = $request->manifest;



        $waybill_manifest->waybill = $request->waybill;



        $waybill_manifest->status = $request->status;



        $waybill_manifest->created_by = $request->created_by;



        $waybill_manifest->created_at = $request->created_at;



        $waybill_manifest->updated_by = $request->updated_by;



        $waybill_manifest->updated_at = $request->updated_at;

        //$waybill_manifest->user_id = $request->user()->id;
        $waybill_manifest->save();

        return redirect('/waybill_manifests');
    }

    public function filters($manifest_id) {
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $waybill_statuses = Waybill_status::select('id', 'waybill_status')->get();

        $data = compact('package_types', 'stations', 'waybill_statuses', 'manifest_id');

        return (String) view("filters/waybill_filters", $data);
    }

    public function filter_grid($manifest_id) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,CONCAT(CONCAT(CONCAT(stations.office_code,'-',stations2.office_code),'-',UCASE(DATE_FORMAT(a.created_at,'%a'))),'-',a.id) AS waybill,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,consignor,consignee,package_types.package_type,quantity,stations.office_name as origin,stations2.office_name AS destination,weight,if(a.status = 1,'ACTIVE','INACTIVE') AS status";
        $presql = " FROM waybills a ";
        $presql .= " LEFT JOIN waybill_manifests ON a.id = waybill_manifests.waybill";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN stations ON a.origin = stations.id ";
        $presql .= " LEFT JOIN stations AS stations2 ON a.destination = stations2.id ";
        $presql .= " LEFT JOIN package_types ON a.package_type = package_types.id ";

        $presql .= "  ";

        if ($_GET["columns"]) {
            $first = true;
            for ($i = 0; $i < count($_GET["columns"]); $i++) {
                $name = $_GET["columns"][$i]["name"];
                $search_value = $_GET["columns"][$i]["search"]["value"];
                if ($search_value && $name) {
                    $presql .= " AND {$name} = '" . $search_value . "' ";
                }
            }
        }

        if ($_GET['search']['value']) {
            $presql .= " WHERE client_name LIKE '%" . $_GET['search']['value'] . "%' ";
        }

        $sql = $select . $presql . " LIMIT " . $start . "," . $len;

        $qcount = DB::select("SELECT COUNT(a.id) c" . $presql);
        //dd($sql);
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

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $invoice = Invoice::findOrFail($id);

        $invoice->delete();
        return "OK";
    }

    /*public function add_batch(Request $request) {
        $waybill_ids = $request["waybill_ids"];
        $manifest_id = $request["manifest_id"];
        $created_by = Auth::user()->id;
        $created_at = date("Y-m-d H:i:s");

        $waybill_manifests = array();
        for ($i = 0; $i < count($waybill_ids); $i++) {
            $waybill_manifests[$i] = array(
                "status" => ACTIVE,
                "waybill" => $waybill_ids[$i],
                "manifest" => $manifest_id,
                "created_by" => $created_by,
                "created_at" => $created_at);
        }
        echo Invoive::insert($waybill_manifests);
    }*/

    public function cancelInvoices(Request $request) {
        $invoiceIds = $request["invoice_ids"];

        echo Invoice::whereIn("invoices", $invoiceIds)->delete();
    }

}
