<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    public function origins()
    {
        return $this->hasOne('App\Station','id', 'origin');
    }
    
    public function destinations()
    {
        return $this->hasOne('App\Station','id', 'destination');
    }
    
    public function waybill_manifest(){
        return $this->belongsTo(Waybill_manifest::class,"waybill","id");
    }
}
