<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\InvoiceWaybills;
use Illuminate\Support\Facades\DB;

class ClientReportsController extends Controller {

    public function __construct() {
        //$this->middleware('auth');
    }

    public function index(Request $request) {
        $invoices = DB::table('clients')->select(['client_name', DB::raw('SUM(waybills.amount) AS total_amount')
            , DB::raw('SUM(waybills.vat) AS total_vat'),'currency'])
                ->join('invoices','invoices.client_id','=','clients.id')
                ->join('currencies','currencies.id','=','invoices.currency_id')
                ->join('invoice_waybills','invoice_waybills.invoice_id','=','invoices.id')
                ->join('waybills','waybills.id','=','invoice_waybills.waybill_id')
                ->get();
        //dd($invoiceWaybills);
        return view('reports.clients', compact('invoices'));
    }

}
