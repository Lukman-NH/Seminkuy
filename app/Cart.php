<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'events_id', 'users_id'
    ];

    protected $hidden = [

    ];

    public function event(){
        return $this->hasOne( Event::class, 'id', 'events_id' );
    }

    public function user(){
        return $this->belongsTo( User::class, 'users_id', 'id');
    }
}
