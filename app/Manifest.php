<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Waybill_manifest;

class Manifest extends Model
{
    public function origins()
    {
        return $this->hasOne('App\Station','id', 'origin');
    }
    
    public function destinations()
    {
        return $this->hasOne('App\Station','id', 'destination');
    }
    
    public function waybill_manifest()
    {
        return $this->hasOne(Waybill_manifest::class,'id', 'waybill');
    }
}
