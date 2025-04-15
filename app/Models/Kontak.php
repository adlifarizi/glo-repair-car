<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontak extends Model
{
    protected $fillable = [
        'email',
        'nomor_telepon',
        'nomor_whatsapp',
        'instagram',
    ];

    protected $table = "kontak";
}
