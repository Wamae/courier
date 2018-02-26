<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Waybill;
use App\Station;
use App\Package_type;
use App\Payment_mode;
use App\Currency;
use App\Waybill_status;
use App\User;
use DB;
use Auth;

class StationReportsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $users_station_id = Auth::user()->station;
                
        $package_types = Package_type::select('id', 'package_type')->where('status', ACTIVE)->get();
        $stations = Station::select('id', 'office_name')->where('status', ACTIVE)->where('id','!=',$users_station_id)->get();
        $waybill_statuses = Waybill_status::select('id', 'waybill_status')->get();
        $payment_modes = Payment_mode::select('id', 'payment_mode')->get();
        $currencies = Currency::select('id', 'currency')->get();

        // get all users with all roles
        $users = User::with('roles')->where('station','=',$users_station_id)->get();

        // filter to list those without the "admin" role
        $staff = $users->reject(function ($user, $key) {
            return $user->hasRole('admin');
        });

        return view('reports.stations', compact('package_types', 'stations', 'waybill_statuses', 'payment_modes', 'currencies', 'staff'));
    }

    public function grid(Request $request) {
        $len = $_GET['length'];
        $start = $_GET['start'];

        $select = "SELECT a.id,waybill_no,DATE_FORMAT(a.created_at,'%a %d/%m/%2017') AS created_at,"
                . "consignor,package_types.package_type,quantity,stations.office_name AS origin,"
                . "stations2.office_name AS destination,u.name,a.amount,1,a.payment_mode,stations.currency_id,a.created_at AS ca";
        $presql = " FROM waybills a ";
        $presql .= " LEFT JOIN users u ON a.created_by = u.id ";
        $presql .= " LEFT JOIN waybill_statuses wbs ON a.status = wbs.id ";
        $presql .= " LEFT JOIN stations ON a.origin = stations.id ";
        $presql .= " LEFT JOIN stations AS stations2 ON a.destination = stations2.id ";
        $presql .= " LEFT JOIN package_types ON a.package_type = package_types.id ";

        $presql .= "  ";

        if ($_GET["columns"]) {
            $first = true;
            for ($i = 0; $i < count($_GET["columns"]); $i++) {
                $name = $_GET["columns"][$i]["name"];
                $search_value = $_GET["columns"][$i]["search"]["value"];
                if ($search_value && $name) {
                    if ($first && $name != "a.created_at") {
                        $presql .= " WHERE {$name} = '" . $search_value . "' ";
                        $first = false;
                    } else if ($first && $name == "a.created_at") {
                        $search_value = explode('|', $search_value);
                        $start_date = $search_value[0];
                        $end_date = $search_value[1];

                        $presql .= " WHERE DATE({$name})  >= '" . $start_date . "' ";
                        $presql .= " AND DATE({$name})  <= '" . $end_date . "' ";
                    } else if (!$first && $name == "a.created_at") {
                        $search_value = explode('|', $search_value);
                        $start_date = $search_value[0];
                        $end_date = $search_value[1];

                        $presql .= " AND DATE({$name})  >= '" . $start_date . "' ";
                        $presql .= " AND DATE({$name})  <= '" . $end_date . "' ";
                    } else {
                        $presql .= " AND {$name} = '" . $search_value . "' ";
                    }
                }
            }
        }

        if ($_GET['search']['value']) {
            $presql .= " WHERE consignor LIKE '%" . $_GET['search']['value'] . "%' "
//                            . "OR consignee LIKE '%".$_GET['search']['value']."%' "
//                            . "OR stations.office_name LIKE '%".$_GET['search']['value']."%' "
//                            . "OR stations2.office_name LIKE '%".$_GET['search']['value']."%' "
//                            . "OR consignee_tel LIKE '%".$_GET['search']['value']."%' "
            ;
        }
        //dd($presql);
        $sql = $select . $presql . " LIMIT " . $start . "," . $len;

        $qcount = DB::select("SELECT COUNT(a.id) c" . $presql);

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

    public function show() {
        
    }

    public function getReportData(Request $request) {
        $station_id = $request["station_id"];
        $user_id = $request["user_id"];
        $pdf_orientation = $request["orientation"];
        $currency_id = $request["currency_id"];
        $start_date = $request["start_date"];
        $end_date = $request["end_date"];

        $stationData = $this->getStationData($station_id, $user_id, $start_date, $end_date);

        echo json_encode($stationData);
    }

    public function printWaybill(Request $request) {
        $id = $request["id"];
        $waybill = Waybill::find($id);

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView('pdf.waybill', compact('waybill'))->setPaper('a5', 'landscape');
        return $pdf->stream('waybill_' . $waybill->consignor . '.pdf');
    }

    /**
     * Display stations report
     * @param Request $request
     * @return pdf
     */
    public function printStationsReport(Request $request) {
        $station_id = $request->station_id;
        $user_id = $request->user_id;
        $currency_id = $request->currency_id;
        $pdf_orientation_id = $request->pdf_orientation_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $station_data = $this->getStationData($station_id, $user_id, $start_date, $end_date);

        $pdf = \App::make('dompdf.wrapper');

        $pdf_orientation = ($pdf_orientation_id == PORTRAIT) ? "portrait" : "landscape";

        $pdf->loadView('pdf.stations_report', compact('station_data', "end_date", "end_date"))->setPaper('a4', $pdf_orientation);
        return $pdf->stream('stations_report_' . date("Y-m-d H:i:s") . '_' . Auth::user()->stations->office_name . '.pdf');
    }

    /**
     * Print Cashiers' report
     * @param Request $request
     */
    public function printCashierReport(Request $request) {
        //TODO: Get all waybills and totals created
        //$id = $request["id"];
        $waybills = Waybill::where("created_by", Auth::user()->id)->get();
        //dd($waybills);

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadView('pdf.cashiers_report', compact('waybills'))->setPaper('a4', 'landscape');
        return $pdf->stream(Auth::user()->stations->office_name . '_' . '.pdf');
    }

    /**
     * @param $station_id
     * @param $user_id
     * @param $start_date
     * @param $end_date
     * @return array
     */
    public function getStationData($station_id, $user_id, $start_date, $end_date) {
        $sql = DB::table('waybills')
                ->select(['destination', 'office_name', 'payment_mode', 'amount', 'vat'])
                ->join('stations', 'waybills.destination', '=', 'stations.id')
                ->groupBy(['waybills.id'])
        ->where('origin','=',Auth::user()->station);

        if ($station_id != "0") {
            $sql->where('destination', $station_id);
        }

        if ($user_id != "0") {
            $sql->where('waybills.created_by', $user_id);
        }

        if (!empty($start_date)) {
            $sql->whereDate(DB::raw('DATE(waybills.created_at)'), '>=', $start_date);
        }

        if (!empty($end_date)) {
            $sql->whereDate(DB::raw('DATE(waybills.created_at)'), '<=', $end_date);
        }

        $cash = $sql->get()->toArray();
        //dd($cash);
        $cash = array_map(function ($item) {
            return (array) $item;
        }, $cash);

        $query = Station::select(['id', 'office_name', DB::raw('0 AS cod_amount'),
                    DB::raw('0 AS cod_vat'),
                    //DB::raw('0 AS cod_total'),
                    DB::raw('0 AS acc_amount'),
                    DB::raw('0 AS acc_vat'),
                    //DB::raw('0 AS acc_total'),
                    DB::raw('0 AS cash_amount'),
                    DB::raw('0 AS cash_vat'),
                        //DB::raw('0 AS cash_total')
        ]);

        if ($station_id != "0") {
            $query->where('id', $station_id);
        }

        $allStations = $query->get()->toArray();

        $allStations = array_map(function ($item) {
            return (array) $item;
        }, $allStations);

        for ($i = 0; $i < count($cash); $i++) {
            for ($j = 0; $j < count($allStations); $j++) {
                if ($cash[$i]["destination"] == $allStations[$j]["id"]) {
                    if ($cash[$i]["payment_mode"] == CASH_PAYMENT) {
                        $allStations[$j]["cash_amount"] += $cash[$i]["amount"];
                        $allStations[$j]["cash_vat"] += round($cash[$i]["vat"]);
                    } else if ($cash[$i]["payment_mode"] == ACCOUNT_PAYMENT) {
                        $allStations[$j]["acc_amount"] += $cash[$i]["amount"];
                        $allStations[$j]["acc_vat"] += $cash[$i]["vat"];
                    } else if ($cash[$i]["payment_mode"] == CASH_ON_DELIVERY) {
                        $allStations[$j]["cod_amount"] += $cash[$i]["amount"];
                        $allStations[$j]["cod_vat"] += $cash[$i]["vat"];
                    }
                }
            }
        }
        return $allStations;
    }

}
