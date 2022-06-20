<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = [
        'transactions_id', 
        'events_id',
        'harga',
        'kode',
    ];

    protected $hidden = [

    ];

    public function event(){
        return $this->hasOne( Event::class, 'id', 'events_id' );
    }

    public function transaction(){
        return $this->hasOne( Transaction::class, 'id', 'transactions_id' );
    }
    
}
