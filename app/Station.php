<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    public function currency()
    {
        return $this->hasOne(Currency::class,'id', 'currency_id');
    }
    
    public function main_office()
    {
        return $this->hasOne(Main_office::class,'id', 'main_office_id');
    }
}
