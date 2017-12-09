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
        return $this->hasMany(Waybill_manifest::class,'manifest', 'id');
    }
    
    public function statuses()
    {
        return $this->hasOne(ManifestStatus::class,'id', 'status');
    }
    
    public function waybills(){
        return $this->hasManyThrough(Waybill::class, Waybill_manifest::class, 'waybill', 'id');
    }
}
