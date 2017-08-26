<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Package_type;
use DB;
use Auth;

class Package_typesController extends Controller {

    public $title;

    public function __construct() {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_', ' ', 'Package_types'));
    }

    public function index(Request $request) {
        $title = $this->title;
        return view('package_types.index', compact('title'));
    }

    public function create(Request $request) {
        $title = $this->title;
        return view('package_types.add', compact('title'));
    }

    public function edit(Request $request, $id) {

        $model = Package_type::findOrFail($id);
        $title = $this->title;

        return view('package_types.add', compact('model', 'title'));
    }

    public function show(Request $request, $id) {
        $package_type = Package_type::findOrFail($id);
        return view('package_types.show', [
            'model' => $package_type]);
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,package_type,description,if(a.status = 1,'ACTIVE','INACTIVE') AS status,a.created_at,u.name AS uname,a.updated_at,u2.name,1,2 ";
        $presql = " FROM package_types a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN users u2 ON a.updated_by = u2.id ";

        if ($_GET['search']['value']) {
            $presql .= " WHERE package_type LIKE '%" . $_GET['search']['value'] . "%' ";
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
        $package_type = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $package_type = Package_type::findOrFail($request->id);
            $package_type->updated_by = $user_id;
        } else {
            $package_type = new Package_type;
            $package_type->created_by = $user_id;
        }



        $package_type->id = $request->id ?: 0;




        $package_type->package_type = $request->package_type;



        $package_type->description = $request->description;



        $package_type->status = $request->status;

        //$package_type->user_id = $request->user()->id;
        $package_type->save();

        return redirect('/package_types');
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $package_type = Package_type::findOrFail($id);

        $package_type->delete();
        return "OK";
    }

}
