<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Main_office;

use DB;
use Auth;

class Main_officesController extends Controller
{
    public $title;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_',' ','Main_offices'));
    }


    public function index(Request $request)
	{
            $title = $this->title;
	    return view('main_offices.index', compact('title'));
	}

	public function create(Request $request)
	{
            $title = $this->title;
	    return view('main_offices.add', compact('title'));
	}

	public function edit(Request $request, $id)
	{
            $model = Main_office::findOrFail($id);
            $title = $this->title;
	    return view('main_offices.add', compact('model','title'));
	}

	public function show(Request $request, $id)
	{
		$main_office = Main_office::findOrFail($id);
	    return view('main_offices.show', [
	        'model' => $main_office	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT a.id,main_office,if(a.status = 1,'ACTIVE','INACTIVE') AS status,a.created_at,u.name AS uname,a.updated_at,u2.name,1,2 ";
		$presql = " FROM main_offices a ";
		$presql .= " LEFT JOIN users u ON a.created_by = u.id ";
		$presql .= " LEFT JOIN users u2 ON a.updated_by = u2.id ";
                
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
		$main_office = null;
                $user_id = Auth::user()->id;
                
		if($request->id > 0) { 
                    $main_office = Main_office::findOrFail($request->id);
                    $main_office->updated_by = $user_id;
                    
                }else { 
			$main_office = new Main_office;
                        $main_office->created_by = $user_id;
		}
	    

	    		
			    $main_office->id = $request->id?:0;
		            
		
	    		
		            
			    $main_office->main_office = $request->main_office;
		
	    		
		            
			    $main_office->status = $request->status;
		
	    	    //$main_office->user_id = $request->user()->id;
	    $main_office->save();

	    return redirect('/main_offices');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$main_office = Main_office::findOrFail($id);

		$main_office->delete();
		return "OK";
	    
	}

	
}