<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Station;

use DB;
use Auth;
use App\Main_office;

class StationsController extends Controller
{
    public $title;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_',' ','Stations'));
    }


    public function index(Request $request)
	{
            $title = $this->title;
	    return view('stations.index', compact('title'));
	}

	public function create(Request $request)
	{
            $title = $this->title;
            $main_offices = Main_office::select('id','main_office')->where('status',ACTIVE)->get();
	    return view('stations.add', compact('title','main_offices'));
	}

	public function edit(Request $request, $id)
	{
            $model = Station::findOrFail($id);
            $title = $this->title;
            $main_offices = Main_office::select('id','main_office')->where('status',ACTIVE)->get();
            
	    return view('stations.add', compact('model','title','main_offices'));
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
			$presql .= " WHERE main_office LIKE '%".$_GET['search']['value']."%' ";
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
                $user_id = Auth::user()->id;
                
		if($request->id > 0) { 
                    $station = Station::findOrFail($request->id);
                    $station->updated_by = $user_id;
                    
                }else { 
			$station = new Station;
                        $station->created_by = $user_id;
		}
	    

	    		
			    $station->id = $request->id?:0;
		            
		
	    		
		            
			    $station->main_office = $request->main_office;
		
	    		
		            
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