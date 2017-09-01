<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Waybill_manifest;
use DB;
use Auth;
use App\Station;
use App\Waybill_status;
use App\Package_type;
use View;

class Waybill_manifestsController extends Controller {

    public $title;

    public function __construct() {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_', ' ', 'Loading Manifests'));
    }

    public function index(Request $request) {
        $title = $this->title;
        return view('waybill_manifests.index', compact('title'));
    }

    public function create(Request $request) {
        $title = $this->title;
        return view('waybill_manifests.add', compact('title'));
    }

    public function edit(Request $request, $id) {
        $model = Waybill_manifest::findOrFail($id);
        $title = $this->title;
        return view('waybill_manifests.add', compact('model', 'title'));
    }

    public function create_manifest_no($o_office_code, $d_office_code, $id) {

        return $o_office_code . "-" . $d_office_code . "-MANIFEST:" . $id;
    }

    public function show(Request $request, $manifest_id) {
//		$waybill_manifest = Waybill_manifest::with("waybills")
//                        ->select('id','manifest','waybill')
//                        ->findOrFail($id);
        //$model = Waybill_manifest::manifest($id)->get();
        $model = Waybill_manifest::where("manifest", $manifest_id)->groupBy('manifest', 'waybill_manifests.id', 'waybill_manifests.waybill', 'waybill_manifests.status', 'waybill_manifests.created_by', 'waybill_manifests.created_at', 'waybill_manifests.updated_by', 'waybill_manifests.updated_at')->first();
        if($model){
        $origin_id = $model->manifests->origin;
        $destination_id = $model->manifests->destination;

        $origin = Station::find($origin_id);
        $destination = Station::find($destination_id);

        $manifest_no = $this->create_manifest_no($origin["office_code"], $destination["office_code"], $manifest_id);

        $from = $origin->office_name;
        $to = $destination->office_name;

        $manifest = \App\Loading_manifest::find($model->manifest);

        $driver = $manifest->driver;
        $conductor = $manifest->conductor;
        $reg_no = $manifest->registration_no;

        $manifest_date = $manifest->created_at->format("D d/m/Y");

        $items = $model->distinct()->get(['waybill'])->count();

        return view('waybill_manifests.show', compact('model', 'manifest_id', 'manifest_no', 'from', 'to', 'driver', 'conductor', 'reg_no', 'manifest_date', 'items'));
        }else{
            $manifest = \App\Loading_manifest::find($manifest_id);
            return view('waybill_manifests.show',compact('manifest'));
        }
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        /* $select = "SELECT a.id,manifest,waybills.status,users.name AS created_by,"
          . "DATE_FORMAT(a.created_at,'%d-%m-%Y') AS created_at,"
          . "IF(users2.name IS NULL,'N/A',users2.name) AS updated_by,"
          . "DATE_FORMAT(a.updated_at,'%d-%m-%Y') AS updated_at,1,2 ";
          $presql = " FROM waybill_manifests a ";
          $presql .= " LEFT JOIN waybills ON a.waybill = waybills.id ";
          $presql .= " LEFT JOIN loading_manifests ON a.manifest = loading_manifests.id ";
          $presql .= " LEFT JOIN users ON a.created_by = users.id ";
          $presql .= " LEFT JOIN users users2 ON a.updated_by = users2.id "; */

        $select = "SELECT waybills.id,CONCAT(CONCAT(CONCAT(stations.office_code,'-',stations2.office_code),'-',UCASE(DATE_FORMAT(a.created_at,'%a'))),'-',a.id) AS waybill,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,consignor,consignee,package_types.package_type,quantity,stations.office_name as origin,stations2.office_name AS destination,weight,if(a.status = 1,'ACTIVE','INACTIVE') AS status";
        $presql = " FROM waybill_manifests a ";
        $presql .= " LEFT JOIN waybills ON waybills.id = a.waybill";
        $presql .= " LEFT JOIN stations ON waybills.origin = stations.id ";
        $presql .= " LEFT JOIN stations AS stations2 ON waybills.destination = stations2.id ";
        $presql .= " LEFT JOIN package_types ON waybills.package_type = package_types.id ";
        $presql .= " WHERE a.waybill IS NOT NULL";

        $presql .= "  ";

        $sql = $select . $presql . "LIMIT " . $start . "," . $len;


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
        $presql .= " WHERE waybill_manifests.waybill IS NULL";

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
            $presql .= " AND consignor LIKE '%" . $_GET['search']['value'] . "%' "
                    . "OR consignee LIKE '%" . $_GET['search']['value'] . "%' "
                    . "OR stations.office_name LIKE '%" . $_GET['search']['value'] . "%' "
                    . "OR stations2.office_name LIKE '%" . $_GET['search']['value'] . "%' "
                    . "OR consignee_tel LIKE '%" . $_GET['search']['value'] . "%' "
            ;
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
        //dd($sql);
        echo json_encode($ret);
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $waybill_manifest = Waybill_manifest::findOrFail($id);

        $waybill_manifest->delete();
        return "OK";
    }

    public function add_batch(Request $request) {
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
        echo Waybill_manifest::insert($waybill_manifests);
    }

    public function remove_batch(Request $request) {
        $waybill_ids = $request["waybill_ids"];
        
        echo Waybill_manifest::whereIn("waybill",$waybill_ids)->delete();
    }

}
