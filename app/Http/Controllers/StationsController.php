<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Station;

use DB;

class StationsController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{
	    return view('stations.index', []);
	}

	public function create(Request $request)
	{
	    return view('stations.add', [
	        []
	    ]);
	}

	public function edit(Request $request, $id)
	{
		$station = Station::findOrFail($id);
	    return view('stations.add', [
	        'model' => $station	    ]);
	}

	public function show(Request $request, $id)
	{
		$station = Station::findOrFail($id);
	    return view('stations.show', [
	        'model' => $station	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT *,1,2 ";
		$presql = " FROM stations a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE office_name LIKE '%".$_GET['search']['value']."%' ";
		}
		
		$presql .= "  ";

		$sql = $select.$presql." LIMIT ".$start.",".$len;


		$qcount = DB::select("SELECT COUNT(a.id) c".$presql);
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
	    /*$this->validate($request, [
	        'name' => 'required|max:255',
	    ]);*/
		$station = null;
		if($request->id > 0) { $station = Station::findOrFail($request->id); }
		else { 
			$station = new Station;
		}
	    

	    		
			    $station->id = $request->id?:0;
				
	    		
					    $station->office_name = $request->office_name;
		
	    		
					    $station->office_code = $request->office_code;
		
	    		
					    $station->telephone_number = $request->telephone_number;
		
	    		
					    $station->currency = $request->currency;
		
	    		
					    $station->main_office = $request->main_office;
		
	    		
					    $station->status = $request->status;
		
	    		
					    $station->created_at = $request->created_at;
		
	    		
					    $station->created_by = $request->created_by;
		
	    		
					    $station->updated_at = $request->updated_at;
		
	    		
					    $station->updated_by = $request->updated_by;
		
	    	    //$station->user_id = $request->user()->id;
	    $station->save();

	    return redirect('/stations');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$station = Station::findOrFail($id);

		$station->delete();
		return "OK";
	    
	}

	
}