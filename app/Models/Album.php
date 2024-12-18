<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = [
        'name',
        'uri',
        'artist_uri',
        'release_year',
        'cover_art',
    ];

    public function artista()
    {
        return $this->belongsTo(Artista::class, 'artist_uri', 'uri');
    }
}
