<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    protected $fillable = [
        'name',
        'uri',
        'image_url',
    ];

    public function albums()
    {
        return $this->hasMany(Album::class, 'artist_id');
    }
}
