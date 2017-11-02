<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Main_office extends Model
{
    public function station()
    {
        return $this->hasMany(Station::class,'main_office_id', 'id');
    }
}
