<?php

namespace [[appns]]Http\Controllers;

use Illuminate\Http\Request;

use [[appns]]Http\Requests;
use [[appns]]Http\Controllers\Controller;

use [[appns]][[model_uc]];

use DB;
use Auth;

class [[controller_name]]Controller extends Controller
{
    public $title;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_',' ','[[controller_name]]'));
    }


    public function index(Request $request)
	{
            $title = $this->title;
	    return view('[[view_folder]].index', compact('title'));
	}

	public function create(Request $request)
	{
            $title = $this->title;
	    return view('[[view_folder]].add', compact('title'));
	}

	public function edit(Request $request, $id)
	{
            $model = [[model_uc]]::findOrFail($id);
            $title = $this->title;
	    return view('[[view_folder]].add', compact('model','title'));
	}

	public function show(Request $request, $id)
	{
		$[[model_singular]] = [[model_uc]]::findOrFail($id);
	    return view('[[view_folder]].show', [
	        'model' => $[[model_singular]]
	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT a.id,manifest,waybill,users.name AS created_by,"
                        . "DATE_FORMAT(a.created_at,'%d-%m-%Y') AS created_at,"
                        . "IF(users2.name IS NULL,'N/A',users2.name) AS updated_by,"
                        . "DATE_FORMAT(a.updated_at,'%d-%m-%Y') AS updated_at,1,2 ";
		$presql = " FROM [[prefix]][[tablename]] a ";
                $presql .= " LEFT JOIN users ON a.created_by = users.id ";
                $presql .= " LEFT JOIN users users2 ON a.updated_by = users2.id ";
		if($_GET['search']['value']) {	
			$presql .= " WHERE [[first_column_nonid]] LIKE '%".$_GET['search']['value']."%' ";
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
		$[[model_singular]] = null;
                $user_id = Auth::user()->id;
                
		if($request->id > 0) { 
                    $[[model_singular]] = [[model_uc]]::findOrFail($request->id);
                    $[[model_singular]]->updated_by = $user_id;
                    
                }else { 
			$[[model_singular]] = new [[model_uc]];
                        $[[model_singular]]->created_by = $user_id;
		}
	    

	    [[foreach:columns]]
		
		[[if:i.name=='id']]
	    $[[model_singular]]->[[i.name]] = $request->[[i.name]]?:0;
		[[endif]]
            
		[[if:i.name!='id']]
	    $[[model_singular]]->[[i.name]] = $request->[[i.name]];
		[[endif]]

	    [[endforeach]]
	    //$[[model_singular]]->user_id = $request->user()->id;
	    $[[model_singular]]->save();

	    return redirect('/[[route_path]]');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$[[model_singular]] = [[model_uc]]::findOrFail($id);

		$[[model_singular]]->delete();
		return "OK";
	    
	}

	
}