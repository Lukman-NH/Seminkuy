<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventGallery extends Model
{
    protected $fillable = [
        'events_id','photos'
    ];

    protected $hidden = [

    ];
    public function event()
    {
        return $this->belongsTo(Event::class, 'events_id', 'id' );
    }
}
