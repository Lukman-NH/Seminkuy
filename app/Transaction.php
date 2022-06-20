<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'users_id', 
        'total_harga',
        'status',
        'kode',
    ];

    protected $hidden = [

    ];
    
    public function user(){
        return $this->belongsTo( User::class, 'users_id', 'id');
    }
    
}
