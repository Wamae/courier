<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Waybill;
use App\Station;
use App\Package_type;
use App\payment_mode;
use App\Currency;
use App\Waybill_status;
use DB;
use Auth;

class User_reportsController extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function index(Request $request) {
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $waybill_statuses = Waybill_status::select('id', 'waybill_status')->get();
        $payment_modes = Payment_mode::select('id', 'payment_mode')->get();  
        $currencies = Currency::select('id', 'currency')->get();  

        return view('reports.users', compact('package_types', 'stations', 'waybill_statuses','payment_modes','currencies'));
    }
    
    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,waybill_no,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,"
                . "consignor,package_types.package_type,quantity,stations.office_name AS origin,"
                . "stations2.office_name AS destination,weight, wbs.waybill_status,1,a.payment_mode";
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
    
    public function show(){
        
    }
    
    public function print_waybill(Request $request) {
        $id = $request["id"];
        $waybill = Waybill::find($id);

        $pdf = \App::make('dompdf.wrapper');
        
        $pdf->loadView('pdf.waybill',compact('waybill'))->setPaper('a5', 'landscape');
        return $pdf->stream('waybill_'.$waybill->consignor.'.pdf');
    }

}
