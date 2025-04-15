<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $table = 'pengeluaran'; 

    protected $fillable = [
        'nominal',
        'keterangan',
        'tanggal_pengeluaran',
        'bukti_pengeluaran',
    ];
}
