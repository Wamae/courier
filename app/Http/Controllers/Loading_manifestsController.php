<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Loading_manifest;
use DB;
use Auth;
use App\Station;
use App\user;

class Loading_manifestsController extends Controller {

    //
    public function __construct() {
        //$this->middleware('auth');
    }

    public function index(Request $request) {
        return view('loading_manifests.index', []);
    }

    public function create(Request $request) {
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $id = Auth::user()->id;
        //$users_station = User::find($id)->stations->get();
        //dd($users_station);
        $users_station = "dummy_station";
        //$users_station = Auth::user()->stations->office_name;

        return view('loading_manifests.add', compact('stations', 'users_station'));
    }

    public function edit(Request $request, $id) {
        $loading_manifest = Loading_manifest::findOrFail($id);
        return view('loading_manifests.add', [
            'model' => $loading_manifest]);
    }

    public function show(Request $request, $id) {
        $loading_manifest = Loading_manifest::findOrFail($id);
        return view('loading_manifests.show', [
            'model' => $loading_manifest]);
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,CONCAT(CONCAT(CONCAT(cs.office_code,'-',cs2.office_code),'-','MANIFEST'),':',a.id) AS loading_manifest,DATE_FORMAT(a.created_at,'%a %d/%m/%Y') AS created_at,cs.office_name AS origin,cs2.office_name AS destination,u.name AS uname,"
                . "COUNT(DISTINCT waybill_manifests.waybill) AS loaded,if(a.status = 1,'ACTIVE','INACTIVE') AS status,1,2";
        $presql = " FROM loading_manifests a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN stations cs ON a.origin = cs.id ";
        $presql .= " LEFT JOIN stations cs2 ON a.destination = cs2.id ";
        $presql .= " LEFT JOIN waybill_manifests ON a.id = waybill_manifests.manifest";

        if ($_GET['search']['value']) {
            $presql .= " WHERE origin LIKE '%" . $_GET['search']['value'] . "%' ";
        }

        $presql .= "  ";

        $sql = $select . $presql . " GROUP BY a.id,cs.office_code,cs2.office_code,"
                . "a.created_at,cs.office_name,cs2.office_name,u.name,a.status"
                . "  LIMIT " . $start . "," . $len;


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
        $loading_manifest = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $loading_manifest = Loading_manifest::findOrFail($request->id);
            $loading_manifest->updated_by = $user_id;
        } else {
            $loading_manifest = new Loading_manifest;
            $loading_manifest->created_by = $user_id;
        }



        $loading_manifest->id = $request->id ?: 0;


        $loading_manifest->origin = $request->origin;


        $loading_manifest->destination = $request->destination;


        $loading_manifest->registration_no = $request->registration_no;


        $loading_manifest->driver = $request->driver;


        $loading_manifest->conductor = $request->conductor;


        $loading_manifest->status = $request->status;


        //$loading_manifest->loaded = $request->loaded;
        //$loading_manifest->user_id = $request->user()->id;
        $loading_manifest->save();

        return redirect('/loading_manifests');
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $loading_manifest = Loading_manifest::findOrFail($id);

        $loading_manifest->delete();
        return "OK";
    }

}
