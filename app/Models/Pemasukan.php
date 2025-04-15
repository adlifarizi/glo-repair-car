<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemasukan extends Model
{
    protected $fillable = [
        'id_servis',
        'nominal',
        'keterangan',
        'tanggal_pemasukan',
        'bukti_pemasukan',
    ];

    protected $table = 'pemasukan';

    public function EntriServis()
    {
        return $this->hasOne(Entri_Servis::class);
    }
}
