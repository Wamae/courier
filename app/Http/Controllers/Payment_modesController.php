<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Payment_mode;

use DB;
use Auth;

class Payment_modesController extends Controller
{
    public $title;
    
    public function __construct()
    {
        $this->middleware('auth');
        $this->title = ucfirst(str_replace('_',' ','Payment_modes'));
    }


    public function index(Request $request)
	{
            $title = $this->title;
	    return view('payment_modes.index', compact('title'));
	}

	public function create(Request $request)
	{
            $title = $this->title;
	    return view('payment_modes.add', compact('title'));
	}

	public function edit(Request $request, $id)
	{
            $model = Payment_mode::findOrFail($id);
            $title = $this->title;
	    return view('payment_modes.add', compact('model','title'));
	}

	public function show(Request $request, $id)
	{
		$payment_mode = Payment_mode::findOrFail($id);
	    return view('payment_modes.show', [
	        'model' => $payment_mode	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT a.id,payment_mode,if(a.status = 1,'ACTIVE','INACTIVE') AS status,u.name AS uname,a.created_at,u2.name,a.updated_at,1,2 ";
		$presql = " FROM payment_modes a ";
		$presql .= " LEFT JOIN users u ON a.created_by = u.id ";
		$presql .= " LEFT JOIN users u2 ON a.updated_by = u2.id ";
                
		if($_GET['search']['value']) {	
			$presql .= " WHERE payment_mode LIKE '%".$_GET['search']['value']."%' ";
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
		$payment_mode = null;
                $user_id = Auth::user()->id;
                
		if($request->id > 0) { 
                    $payment_mode = Payment_mode::findOrFail($request->id);
                    $payment_mode->updated_by = $user_id;
                    
                }else { 
			$payment_mode = new Payment_mode;
                        $payment_mode->created_by = $user_id;
		}
	    

	    		
			    $payment_mode->id = $request->id?:0;
		            
		
	    		
		            
			    $payment_mode->payment_mode = $request->payment_mode;
		
	    		
		            
			    $payment_mode->status = $request->status;
		
	    	    //$payment_mode->user_id = $request->user()->id;
	    $payment_mode->save();

	    return redirect('/payment_modes');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$payment_mode = Payment_mode::findOrFail($id);

		$payment_mode->delete();
		return "OK";
	    
	}

	
}