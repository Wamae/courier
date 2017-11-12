<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function transactionTypes(){
        return $this->hasOne(TransactionType::class,"id","transaction_type_id");
    }
}
