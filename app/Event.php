<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'categories_id', 'pembicara', 'harga', 'deskripsi', 'slug'
    ];

    protected $hidden = [

    ];

    public function galleries()
    {
        return $this->hasMany( EventGallery::class, 'events_id', 'id' );
    }

    public function category()
    {
        return $this->belongsTo( Category::class, 'categories_id', 'id' );
    }

    public function rating()
    {
        return $this->hasOne( Rating::class, 'events_id', 'id' );
    }
}