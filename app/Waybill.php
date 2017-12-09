<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Waybill extends Model
{
    public function origins()
    {
        return $this->hasOne(Station::class,'id', 'origin');
    }
    
    public function destinations()
    {
        return $this->hasOne('App\Station','id', 'destination');
    }
    
    public function waybill_manifest(){
        return $this->belongsTo(Waybill_manifest::class,"waybill","id");
    }
    
    public function waybill_status(){
        return $this->hasOne(Waybill_status::class,"id","status");
    }
    
    public function package_types(){
        return $this->hasOne(Package_type::class,"id","package_type");
    } 
    
    public function creator(){
        return $this->hasOne(User::class,"id","created_by");
    }
    
    public function waybill(){
        return $this->hasOne(Client::class,"id","client_id");
    }
}
