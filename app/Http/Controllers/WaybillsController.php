<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Waybill;
use App\Station;
use App\Package_type;
use App\payment_mode;
use App\Waybill_status;
use DB;
use Auth;

class WaybillsController extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function index(Request $request) {
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $waybill_statuses = Waybill_status::select('id', 'waybill_status')->get();

        return view('waybills.index', compact('package_types', 'stations', 'waybill_statuses'));
    }

    public function create(Request $request) {
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $payment_modes = payment_mode::select('id', 'payment_mode')->where('status', ACTIVE)->get();

        return view('waybills.add', compact('stations', 'package_types', 'payment_modes'));
    }

    public function edit(Request $request, $id) {
        $model = Waybill::findOrFail($id);

        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->get();
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $payment_modes = payment_mode::select('id', 'payment_mode')->where('status', ACTIVE)->get();

        return view('waybills.add', compact('model', 'stations', 'package_types', 'payment_modes'));
    }

    public function show(Request $request, $id) {
        $waybill = Waybill::findOrFail($id);
        return view('waybills.show', [
            'model' => $waybill]);
    }

    public function grid(Request $request) {
        
        return datatables(
                        DB::table('waybills AS a')
                ->leftJoin('users AS u', 'a.created_by', '=', 'u.id')
                ->leftJoin('stations', 'a.origin', '=', 'stations.id')
                ->leftJoin('waybill_statuses AS wbs', 'a.status', '=', 'wbs.id')
                ->leftJoin('stations AS stations2', 'a.destination', '=', 'stations2.id')
                ->leftJoin('package_types', 'a.package_type', '=', 'package_types.id')
                //->groupBy(['a.id','cs.office_code','cs2.office_code','a.created_at','cs.office_name','cs2.office_name','u.name','a.status','ms.status'])
                                ->select(["a.id","waybill_no",DB::raw("DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at"),"consignor","consignee","package_types.package_type","quantity","stations.office_name as origin","stations2.office_name AS destination", "wbs.waybill_status", "a.id AS X"
                        ])->orderBy('a.id','DESC'))->toJson();
    }

    public function update(Request $request) {
        //
        /* $this->validate($request, [
          'name' => 'required|max:255',
          ]); */
        $waybill = null;
        $user_id = Auth::user()->id;

        if ($request->id > 0) {
            $waybill = Waybill::findOrFail($request->id);
            $waybill->updated_by = $user_id;
        } else {
            $waybill = new Waybill;
            $waybill->created_by = $user_id;
        }



        $waybill->id = $request->id ?: 0;

        $waybill->client_id = $request->client_id;

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


        $waybill->status = ACTIVE;

        $waybill->save();

        return redirect('/waybills');
    }

    public function create_waybill_no($o_office_code, $d_office_code) {
        $rand_string = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -4);
        $month = strtoupper(date("M"));
        $year = date("Y");
        return $o_office_code . "-" . $d_office_code . "-" . $year . "-" . $month . "-" . $rand_string;
    }

    public function store(Request $request) {
        return $this->update($request);
    }

    public function destroy(Request $request, $id) {

        $waybill = Waybill::findOrFail($id);

        $waybill->delete();
        return "OK";
    }

    public function print_waybill(Request $request) {
        $id = $request["id"];
        $waybill = Waybill::find($id);

        $pdf = \App::make('dompdf.wrapper');
        
        $pdf->loadView('pdf.waybill',compact('waybill'))->setPaper('a5', 'landscape');
        return $pdf->stream();
    }
    
    public function tracking(){
        return view('waybills.tracking');
    }
    
    public function trackWaybill($waybillNo){
        $waybill = Waybill::select(['waybill_no','waybill_status'])
                ->join('waybill_statuses','waybill_statuses.id','=','waybills.status')
                ->where('waybill_no',$waybillNo)->get()->first();
        echo json_encode($waybill);
    }

}
