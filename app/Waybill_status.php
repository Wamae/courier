<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waybill_status extends Model
{
    public function waybill_status(){
        return $this->belongsTo(Waybill::class,"status","id");
    }
}
