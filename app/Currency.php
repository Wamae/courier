<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function stations()
    {
        return $this->hasMany(Station::class,'currency_id', 'id');
    }
}
