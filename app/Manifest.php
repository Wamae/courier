<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
