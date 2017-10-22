<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Waybill;
use App\Loading_manifest;

class Waybill_manifest extends Model
{
    
    
    public function waybills(){
        return $this->hasMany(Waybill::class,"id","waybill");
    }
    
    public function manifests(){
        return $this->hasMany(Loading_manifest::class,"id","manifest");
    }
    
    public function dispatch_waybills($id){
        return $this::where('manifest', '=', $id)->update(['status' => LOADED]);
    }
}
