<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Manifest;
use DB;
use Auth;
use App\Station;
use App\user;
use App\Waybill_manifest;
use App\Manifest_status;

class ManifestsController extends Controller {

    //
    public function __construct() {
        //$this->middleware('auth');
    }

    public function index(Request $request) {
        return view('manifests.index', []);
    }

    public function create(Request $request) {
        $users_station = Auth::user()->station;

        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)
                        ->where('id', '!=', $users_station)->get();

        $manifest_status = Manifest_status::all();

        return view('manifests.add', compact('stations', 'manifest_status'));
    }

    public function edit(Request $request, $id) {
        $users_station = Auth::user()->station;
        $model = Manifest::findOrFail($id);

        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)
                        ->where('id', '!=', $users_station)->get();

        $manifest_status = Manifest_status::all();

        return view('manifests.add', compact('model', 'stations', 'manifest_status'));
    }

    public function show(Request $request, $id) {
        $manifest = Manifest::findOrFail($id);
        return view('manifests.show', [
            'model' => $manifest]);
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,CONCAT(CONCAT(CONCAT(cs.office_code,'-',cs2.office_code),'-','MANIFEST'),':',a.id) AS loading_manifest,DATE_FORMAT(a.created_at,'%a %d/%m/%Y') AS created_at,cs.office_name AS origin,cs2.office_name AS destination,u.name AS uname,"
                . "COUNT(DISTINCT waybill_manifests.waybill) AS loaded,ms.status,1,2";
        $presql = " FROM manifests a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN stations cs ON a.origin = cs.id ";
        $presql .= " LEFT JOIN manifest_statuses ms ON a.status = ms.id ";
        $presql .= " LEFT JOIN stations cs2 ON a.destination = cs2.id ";
        $presql .= " LEFT JOIN waybill_manifests ON a.id = waybill_manifests.manifest";

        if ($_GET['search']['value']) {
            $presql .= " WHERE origin LIKE '%" . $_GET['search']['value'] . "%' ";
        }

        $presql .= "  ";

        $sql = $select . $presql . " GROUP BY a.id,cs.office_code,cs2.office_code,"
                . "a.created_at,cs.office_name,cs2.office_name,u.name,a.status,ms.status"
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
        $manifest = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $manifest = Manifest::findOrFail($request->id);
            $manifest->updated_by = $user_id;
        } else {
            $manifest = new Manifest;
            $manifest->created_by = $user_id;
        }



        $manifest->id = $request->id ?: 0;


        $manifest->origin = $request->origin;


        $manifest->destination = $request->destination;


        $manifest->registration_no = $request->registration_no;


        $manifest->driver = $request->driver;


        $manifest->conductor = $request->conductor;


        $manifest->status = $request->status;

        $manifest->save();

        return redirect('/manifests');
    }

    public function dispatch_manifest(Request $request) {
        $id = $request["manifest_id"];

        $manifest = Manifest::findOrFail($id);

        $waybill_manifests = Waybill_manifest::where("manifest", $id)->get();


        $result = true;

        DB::transaction(function () use($manifest, $waybill_manifests,$result) {
                    try {

                        $user_id = Auth::user()->id;
                        $manifest->updated_by = $user_id;
                        $manifest->status = DISPATCHED;

                        foreach ($waybill_manifests as $waybill_manifest) {
                            $waybill = $waybill_manifest->waybill;

                            $data = array("updated_by" => $user_id, "status" => LOADED);
                            $bill_update = DB::table('waybills')->where('id', $waybill)->update($data);
                            
                        }

                        $manifest->save();
                    } catch (\Exception $e) {
                        $result = false; 
                    }
                });
                
        echo ($result) ? "1" : "0";
    }

    public function cancelled($id) {
        $manifest = Manifest::findOrFail($id);

        $user_id = Auth::user()->id;
        $manifest->updated_by = $user_id;
        $manifest->status = CANCELLED;
        //TODO: Add log for who cancelled manifest
        $manifest->save();
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $manifest = Manifest::findOrFail($id);

        $manifest->delete();
        return "OK";
    }
    
    public function print_manifest(Request $request) {
        $id = $request["id"];
        $manifest = Manifest::where('id',$id)->with('waybill_manifest.waybills')->get()->first();
        $pdf = \App::make('dompdf.wrapper');
        //dd($manifest);
        $pdf->loadView('pdf.manifest',compact('manifest'));
        return $pdf->stream();
    }

}
