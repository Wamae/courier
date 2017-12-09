<?php

namespace App\Observers;

use Log;

class WaybillObserver {
    public function updating($waybill) {
        Log::info("updating waybill...");
        $waybill->waybill_no = $this->create_waybill_no($waybill->origins->office_code, $waybill->destinations->office_code,$waybill->created_at);
    }
    
    public function creating($waybill) {
        Log::info("creating waybill...");
        $waybill->waybill_no = $this->create_waybill_no($waybill->origins->office_code, $waybill->destinations->office_code,date("Y-m-d H:i:s"));
    }

    public function create_waybill_no($o_office_code, $d_office_code,$created_at) {
        $rand_string = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -4);
        $month = strtoupper(date("M", strtotime($created_at)));
        $year = date("Y", strtotime($created_at));
        
        return $o_office_code . "-" . $d_office_code . "-" . $year . "-" . $month . "-" . $rand_string;
    }

}
