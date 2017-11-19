<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Test_table;

use DB;
use Auth;

class TestTablesController extends Controller
{
    public $title;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_',' ','Test_tables'));
    }


    public function index(Request $request)
	{
            $title = $this->title;
	    return view('test_tables.index', compact('title'));
	}

	public function create(Request $request)
	{
            $title = $this->title;
	    return view('test_tables.add', compact('title'));
	}

	public function edit(Request $request, $id)
	{
		$test_table = Test_table::findOrFail($id);
	    return view('test_tables.add', [
	        'model' => $test_table	    ]);
	}

	public function show(Request $request, $id)
	{
		$test_table = Test_table::findOrFail($id);
	    return view('test_tables.show', [
	        'model' => $test_table	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT *,1,2 ";
		$presql = " FROM test_tables a ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE name LIKE '%".$_GET['search']['value']."%' ";
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
		$test_table = null;
                $user_id = Auth::user()->id;
                
		if($request->id > 0) { 
                    $test_table = Test_table::findOrFail($request->id);
                    $test_table->updated_by = $user_id;
                    
                }else { 
			$test_table = new Test_table;
                        $test_table->created_by = $user_id;
		}
	    

	    		
			    $test_table->id = $request->id?:0;
		            
		
	    		
		            
			    $test_table->name = $request->name;
		
	    		
		            
			    $test_table->created_by = $request->created_by;
		
	    		
		            
			    $test_table->created_at = $request->created_at;
		
	    		
		            
			    $test_table->updated_by = $request->updated_by;
		
	    		
		            
			    $test_table->updated_at = $request->updated_at;
		
	    	    //$test_table->user_id = $request->user()->id;
	    $test_table->save();

	    return redirect('/test_tables');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$test_table = Test_table::findOrFail($id);

		$test_table->delete();
		return "OK";
	    
	}

	
}