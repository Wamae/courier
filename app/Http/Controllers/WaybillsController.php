<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Waybill;
use App\Station;
use App\Package_type;
use App\payment_mode;
use App\Waybill_status;
use DB;
use Auth;

class WaybillsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $waybill_statuses = Waybill_status::select('id', 'waybill_status')->get();

        return view('waybills.index', compact('package_types', 'stations', 'waybill_statuses'));
    }

    public function create(Request $request) {
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $payment_modes = payment_mode::select('id', 'payment_mode')->where('status', ACTIVE)->get();

        return view('waybills.add', compact('stations', 'package_types', 'payment_modes'));
    }

    public function edit(Request $request, $id) {
        $model = Waybill::findOrFail($id);

        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $payment_modes = payment_mode::select('id', 'payment_mode')->where('status', ACTIVE)->get();

        return view('waybills.add', compact('model', 'stations', 'package_types', 'payment_modes'));
    }

    public function show(Request $request, $id) {
        $waybill = Waybill::findOrFail($id);
        return view('waybills.show', [
            'model' => $waybill]);
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,waybill_no,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,consignor,consignee,package_types.package_type,quantity,stations.office_name as origin,stations2.office_name AS destination,weight, wbs.waybill_status,1";
        $presql = " FROM waybills a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN waybill_statuses wbs ON a.status = wbs.id ";
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
                    if ($first) {
                        $presql .= " WHERE {$name} = '" . $search_value . "' ";
                        $first = false;
                    } else {
                        $presql .= " AND {$name} = '" . $search_value . "' ";
                    }
                }
            }
        }

        if ($_GET['search']['value']) {
            $presql .= " WHERE consignor LIKE '%" . $_GET['search']['value'] . "%' "
//                            . "OR consignee LIKE '%".$_GET['search']['value']."%' "
//                            . "OR stations.office_name LIKE '%".$_GET['search']['value']."%' "
//                            . "OR stations2.office_name LIKE '%".$_GET['search']['value']."%' "
//                            . "OR consignee_tel LIKE '%".$_GET['search']['value']."%' "
            ;
        }

        $sql = $select . $presql . " LIMIT " . $start . "," . $len;

        $qcount = DB::select("SELECT COUNT(a.id) c" . $presql);
        //print_r($qcount);
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
        //dd($sql);
        echo json_encode($ret);
    }

    public function update(Request $request) {
        //
        /* $this->validate($request, [
          'name' => 'required|max:255',
          ]); */
        $waybill = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $waybill = Waybill::findOrFail($request->id);
            $waybill->updated_by = $user_id;
        } else {
            $waybill = new Waybill;
            $waybill->created_by = $user_id;
        }



        $waybill->id = $request->id ?: 0;


        $waybill->consignor = $request->consignor;


        $waybill->consignor_tel = $request->consignor_tel;


        $waybill->consignee = $request->consignee;


        $waybill->consignee_tel = $request->consignee_tel;


        $waybill->origin = $request->origin;


        $waybill->destination = $request->destination;


        $waybill->package_type = $request->package_type;


        $waybill->quantity = $request->quantity;


        $waybill->weight = $request->weight;

        $waybill->cbm = $request->cbm;

        $waybill->description = $request->description;


        $waybill->consignor_email = $request->consignor_email;


        $waybill->payment_mode = $request->payment_mode;


        $waybill->amount_per_item = $request->amount_per_item;

        $waybill->vat = $request->vat;

        $waybill->amount = $request->amount;


        $waybill->status = ACTIVE;

        $waybill->save();

        return redirect('/waybills');
    }

    public function create_waybill_no($o_office_code, $d_office_code) {
        $rand_string = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -4);
        $month = strtoupper(date("M"));
        $year = date("Y");
        return $o_office_code . "-" . $d_office_code . "-" . $year . "-" . $month . "-" . $rand_string;
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $waybill = Waybill::findOrFail($id);

        $waybill->delete();
        return "OK";
    }

    public function print_waybill(Request $request) {
        $id = $request["id"];
        $waybill = Waybill::find($id);

        $pdf = \App::make('dompdf.wrapper');
        
        $pdf->loadView('pdf.waybill',compact('waybill'))->setPaper('a5', 'landscape');
        return $pdf->stream();
    }

}
