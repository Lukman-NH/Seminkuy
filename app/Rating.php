<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'users_id', 
        'events_id', 
        'rating'
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
