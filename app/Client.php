<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function invoice(){
        return $this->hasMany(Invoice::class,"id","client_id");
    }
    
    public function waybill(){
        return $this->hasMany(Waybill::class,"id","client_id");
    }
}
