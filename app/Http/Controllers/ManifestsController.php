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
        //$len = $_GET['length'];
        //$start = $_GET['start'];

        $select = "SELECT a.id,CONCAT(CONCAT(CONCAT(cs.office_code,'-',cs2.office_code),'-','MANIFEST'),':',a.id) AS loading_manifest,DATE_FORMAT(a.created_at,'%a %d/%m/%Y') AS created_at,cs.office_name AS origin,cs2.office_name AS destination,u.name AS uname,"
                . "COUNT(DISTINCT waybill_manifests.waybill) AS loaded,ms.status,1,2";
        $presql = " FROM manifests a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN stations cs ON a.origin = cs.id ";
        $presql .= " LEFT JOIN manifest_statuses ms ON a.status = ms.id ";
        $presql .= " LEFT JOIN stations cs2 ON a.destination = cs2.id ";
        $presql .= " LEFT JOIN waybill_manifests ON a.id = waybill_manifests.manifest";

        //if ($_GET['search']['value']) {
        //    $presql .= " WHERE origin LIKE '%" . $_GET['search']['value'] . "%' ";
        //}


        $presql .= "  ";

        $sql = $select . $presql . " GROUP BY a.id,cs.office_code,cs2.office_code,"
                . "a.created_at,cs.office_name,cs2.office_name,u.name,a.status,ms.status";
        //. "  LIMIT " . $start . "," . $len;
        //dd(DB::select($sql))[0];
        $data = DB::select($sql);
        //return \Yajra\DataTables\Facades\DataTables::of($data)->make(true);
        return datatables(
                        DB::table('manifests AS a')
                ->leftJoin('users AS u', 'a.created_by', '=', 'u.id')
                ->leftJoin('stations AS cs', 'a.origin', '=', 'cs.id')
                ->leftJoin('manifest_statuses AS ms', 'a.status', '=', 'ms.id')
                ->leftJoin('stations AS cs2', 'a.destination', '=', 'cs2.id')
                ->leftJoin('waybill_manifests', 'a.id', '=', 'waybill_manifests.manifest')
                ->groupBy(['a.id','cs.office_code','cs2.office_code','a.created_at','cs.office_name','cs2.office_name','u.name','a.status','ms.status'])
                                ->select([
                                        "a.id", DB::raw("CONCAT(CONCAT(CONCAT(cs.office_code,'-',cs2.office_code),'-','MANIFEST'),':',a.id) AS loading_manifest"), DB::raw("DATE_FORMAT(a.created_at,'%a %d/%m/%Y') AS created_at"), "cs.office_name AS origin", "cs2.office_name AS destination", "u.name AS created_by", DB::raw("COUNT(DISTINCT waybill_manifests.waybill) AS loaded"), "ms.status", "a.id AS X",DB::raw("a.id+1 AS Y"),
                        ]))->toJson();
        //return datatables(DB::select($sql))->toJson();

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

        DB::transaction(function () use($manifest, $waybill_manifests, $result) {
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
        $manifest = Manifest::where('id', $id)->with('waybill_manifest.waybills')->get()->first();
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView('pdf.manifest', compact('manifest'));
        return $pdf->stream();
    }

    public function offload_manifest(Request $request) {
        return view('manifests.offload');
    }

    public function offload(Request $request) {

        $id = $request['id'];

        if ($id == "") {
            echo "0";
            return;
        }

        $manifest = Manifest::where('id', $id)->with('waybill_manifest.waybills')->get()->first();

        $waybill_manifests = $manifest->waybill_manifest()->get()->toArray();

        //dd($waybill_manifests);

        $result = true;

        $waybills = array();

        DB::transaction(function () use($manifest, $waybill_manifests, $result, &$waybills) {
            try {

                $user_id = Auth::user()->id;
                $manifest->updated_by = $user_id;
                $manifest->status = OFFLOADED;
                $manifest->save();

                for ($i = 0; $i <= count($waybill_manifests); $i++) {
                    $id = $waybill_manifests[$i]['waybill'];

                    $data = array("updated_by" => $user_id, "status" => DELIVERED);
                    DB::table('waybills')->where('id', $id)->update($data);

                    $waybill = \App\Waybill::find($id);

                    array_push($waybills, $waybill);
                }
            } catch (\Exception $e) {
                $result = false;
            }
        });

        if ($result) {
            //dd($waybills);
            foreach ($waybills as $waybill) {
                //dd($waybill->destinations->office_name);
                $message = "Hello, " . $waybill->consignee . ". Your package has arrived at " . $waybill->destinations->office_name . " station. Kindly collect.";
                //\Illuminate\Support\Facades\Log::info('SMS: "'.$message.'" | Phone: '.$waybill->consignee_tel);

                dispatch(new \App\Jobs\SendSMS($waybill->consignee_tel, $message));
            }
        }
        //$CSV_numbers = implode(",", $waybills);



        echo ($result) ? "1" : "0";
    }

    public function autocomplete(Request $request) {
        $term = $request->term;
        $data = Manifest::where('manifest_no', 'LIKE', '%' . $term . '%')
                ->where('origin', Auth::user()->station)
                //->where('created',Auth::user()->station)
                ->where('status', DISPATCHED)
                ->get();
        $result = array();

        foreach ($data as $key => $v) {
            $result[] = [
                'value' => $v->manifest_no,
                'id' => $v->id,
                'registration_no' => $v->registration_no,
                'driver' => $v->driver,
                'conductor' => $v->conductor,
                'destination' => $v->destinations->office_name];
        }

        return response()->json($result);
    }

}
