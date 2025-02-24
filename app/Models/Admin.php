<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Tambahkan ini

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable; // Pastikan HasApiTokens ada di sini

    protected $table = 'admins'; // Jika tabel di database bernama "admin"

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}

