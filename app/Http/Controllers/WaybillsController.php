<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Waybill;
use App\Station;
use App\Package_type;
use App\payment_mode;

use DB;
use Auth;

class WaybillsController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index(Request $request)
	{
	    return view('waybills.index', []);
	}

	public function create(Request $request)
	{
		$stations = Station::select('id','office_name')->where('status',ACTIVE)->get();
		$package_types = Package_type::select('id','package_type')->where('status',ACTIVE)->get();
		$payment_modes = payment_mode::select('id','payment_mode')->where('status',ACTIVE)->get();

	    return view('waybills.add', compact('stations','package_types','payment_modes'));
	}

	public function edit(Request $request, $id)
	{
		$model = Waybill::findOrFail($id);
                
                $stations = Station::select('id','office_name')->where('status',ACTIVE)->get();
		$package_types = Package_type::select('id','package_type')->where('status',ACTIVE)->get();
		$payment_modes = payment_mode::select('id','payment_mode')->where('status',ACTIVE)->get();
                
	    return view('waybills.add',  compact('model','stations','package_types','payment_modes'));
	}

	public function show(Request $request, $id)
	{
		$waybill = Waybill::findOrFail($id);
	    return view('waybills.show', [
	        'model' => $waybill	    ]);
	}

	public function grid(Request $request)
	{
		$len = $_GET['length'];
		$start = $_GET['start'];

		$select = "SELECT a.id,CONCAT(CONCAT(CONCAT(cs.office_code,'-',cs2.office_code),'-',DATE_FORMAT(a.created_at,'%a')),'-',a.id) AS waybill,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,consignor,consignee,pt.package_type,quantity,cs.office_name as origin,cs2.office_name AS destination,if(a.status = 1,'ACTIVE','INACTIVE') AS status,1,2";
		$presql = " FROM waybills a ";
		$presql .= " LEFT JOIN users u ON a.created_by = u.id ";
		$presql .= " LEFT JOIN stations cs ON a.origin = cs.id ";
		$presql .= " LEFT JOIN stations cs2 ON a.destination = cs2.id ";
		$presql .= " LEFT JOIN package_types pt ON a.package_type = pt.package_type ";

		if($_GET['search']['value']) {	
			$presql .= " WHERE consignor LIKE '%".$_GET['search']['value']."%' ";
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
		$waybill = null;
		$user_id = Auth::user()->id;

		if($request->id > 0) { 
			$waybill = Waybill::findOrFail($request->id); 
			$waybill->updated_by = $user_id;
		}else { 
			$waybill = new Waybill;
			$waybill->created_by = $user_id;
		}
	    

	    		
			    $waybill->id = $request->id?:0;
				
	    		
					    $waybill->consignor = $request->consignor;
		
	    		
					    $waybill->consignor_tel = $request->consignor_tel;
		
	    		
					    $waybill->consignee = $request->consignee;
		
	    		
					    $waybill->consignee_tel = $request->consignee_tel;
		
	    		
					    $waybill->origin = $request->origin;
		
	    		
					    $waybill->destination = $request->destination;
		
	    		
					    $waybill->package_type = $request->package_type;
		
	    		
					    $waybill->quantity = $request->quantity;
		
	    		
					    $waybill->weight = $request->weight;
                                            
                                            $waybill->cbm = $request->cbm;
                                            
                                            $waybill->description = $request->description;
		
	    		
					    $waybill->consignor_email = $request->consignor_email;
		
	    		
					    $waybill->payment_mode = $request->payment_mode;
		
	    		
					    $waybill->amount_per_item = $request->amount_per_item;
                                            
                                            $waybill->vat = $request->vat;
                                            
                                            $waybill->amount = $request->amount;
		
	    		
					    $waybill->status = 1;
		
	    	    //$waybill->user_id = $request->user()->id;
	    $waybill->save();

	    return redirect('/waybills');

	}

	public function store(Request $request)
	{
		return $this->update($request);
	}

	public function destroy(Request $request, $id) {
		
		$waybill = Waybill::findOrFail($id);

		$waybill->delete();
		return "OK";
	    
	}

	
}