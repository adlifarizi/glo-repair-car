<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entri_Servis extends Model
{
    protected $fillable = [
        'plat_no',
        'nama_pelanggan',
        'status',
        'nomor_whatsapp',
        'keterangan',
        'prediksi',
        'harga',
        'tanggal_selesai',
    ];

    protected $table = 'entri_servis';
}
