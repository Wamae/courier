<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
   public function transactions(){
        return $this->belongsTo(Transaction::class,"transaction_type_id","id");
    } 
}
