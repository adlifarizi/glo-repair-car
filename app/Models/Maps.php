<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maps extends Model
{
    protected $fillable = [
        'latitude',
        'longitude',
        'embed_url',
    ];
}
