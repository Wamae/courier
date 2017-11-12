<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceWaybills extends Model
{
    public function transactionType(){
        return $this->hasOne(TransactionType::class,"id","transaction_type_id");
    }
    
    public function invoice(){
        return $this->hasMany(Invoice::class,"id","invoice_id");
    }
    
    public function waybill(){
        return $this->hasMany(Waybill::class,"id","waybill_id");
    }
}
