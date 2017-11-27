<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use DB;
use Auth;

class ClientsController extends Controller {

    public $title;

    public function __construct() {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_', ' ', 'Clients'));
    }

    public function index(Request $request) {
        $title = $this->title;
        return view('clients.index', compact('title'));
    }

    public function create(Request $request) {
        $title = $this->title;
        return view('clients.add', compact('title'));
    }

    public function edit(Request $request, $id) {
        $model = Client::findOrFail($id);
        $title = $this->title;
        return view('clients.add', compact('model', 'title'));
    }

    public function show(Request $request, $id) {
        $client = Client::findOrFail($id);
        return view('clients.show', [
            'model' => $client]);
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,client_name,client_telephone,billing_address,if(a.status = 1,'ACTIVE','INACTIVE') AS status,u.name AS uname,a.created_at,u2.name,a.updated_at,1,2 ";
        $presql = " FROM clients a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN users u2 ON a.updated_by = u2.id ";

        if ($_GET['search']['value']) {
            $presql .= " WHERE client_name LIKE '%" . $_GET['search']['value'] . "%' ";
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
        $client = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $client = Client::findOrFail($request->id);
            $client->updated_by = $user_id;
        } else {
            $client = new Client;
            $client->created_by = $user_id;
        }



        $client->id = $request->id ?: 0;




        $client->client_name = $request->client_name;



        $client->client_telephone = $request->client_telephone;



        $client->billing_address = $request->billing_address;



        $client->status = $request->status;

        //$client->user_id = $request->user()->id;
        $client->save();

        return redirect('/clients');
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $client = Client::findOrFail($id);

        $client->delete();
        return "OK";
    }

    public function getAllClients() {
        $clients = Client::all();
        echo json_encode($clients);
    }

}
