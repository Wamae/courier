<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function currency(){
        return $this->hasOne(Currency::class,"id","currency_id");
    }
    
    public function client(){
        return $this->hasOne(Client::class,"id","client_id");
    }
    
    public function waybills(){
        return $this->hasManyThrough(Waybill::class, InvoiceWaybills::class, 'waybill_id', 'id');
    }
    
    public function transactions(){
        return $this->hasMany(Transaction::class, 'invoice_id', 'id');
    }
}
