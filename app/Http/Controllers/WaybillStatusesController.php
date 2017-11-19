<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Waybill_status;
use DB;
use Auth;

class WaybillStatusesController extends Controller {

    public $title;

    public function __construct() {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_', ' ', 'Waybill_status'));
    }

    public function index(Request $request) {
        $title = $this->title;
        return view('waybill_statuses.index', compact('title'));
    }

    public function create(Request $request) {
        $title = $this->title;
        return view('waybill_statuses.add', compact('title'));
    }

    public function edit(Request $request, $id) {
        $model = Waybill_status::findOrFail($id);
        $title = $this->title;
        return view('waybill_statuses.add', compact('model', 'title'));
    }

    public function show(Request $request, $id) {
        $waybill_status = Waybill_status::findOrFail($id);
        return view('waybill_statuses.show', [
            'model' => $waybill_status]);
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,waybill_status,users.name,a.created_at,if(users2.name IS NULL,'N/A',users2.name),a.updated_at,1,2 ";
        $presql = " FROM waybill_statuses a ";
        $presql .= " LEFT JOIN users ON a.created_by = users.id ";
        $presql .= " LEFT JOIN users users2 ON a.updated_by = users2.id ";

        if ($_GET['search']['value']) {
            $presql .= " WHERE waybill_status LIKE '%" . $_GET['search']['value'] . "%' ";
        }

        $presql .= "  ";

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

        echo json_encode($ret);
    }

    public function update(Request $request) {
        //
        /* $this->validate($request, [
          'name' => 'required|max:255',
          ]); */
        $waybill_status = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $waybill_status = Waybill_status::findOrFail($request->id);
            $waybill_status->updated_by = $user_id;
        } else {
            $waybill_status = new Waybill_status;
            $waybill_status->created_by = $user_id;
        }



        $waybill_status->id = $request->id ?: 0;

        $waybill_status->waybill_status = $request->waybill_status;

        //$waybill_status->user_id = $request->user()->id;
        $waybill_status->save();

        return redirect('/waybill_statuses');
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $waybill_status = Waybill_status::findOrFail($id);

        $waybill_status->delete();
        return "OK";
    }

}
