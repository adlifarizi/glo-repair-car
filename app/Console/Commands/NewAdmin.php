<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class NewAdmin extends Command
{
    /**
     * Nama command yang akan dipanggil di terminal.
     *
     * @var string
     */
    protected $signature = 'admin:create {name} {email} {password}';

    /**
     * Deskripsi command.
     *
     * @var string
     */
    protected $description = 'Membuat admin baru dengan nama, email, dan password';

    /**
     * Eksekusi command.
     */
    public function handle()
    {
        // Ambil input dari command
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Cek apakah email sudah ada
        if (Admin::where('email', $email)->exists()) {
            $this->error('Admin dengan email ini sudah ada!');
            return;
        }

        // Simpan admin ke database
        $admin = Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Tampilkan pesan sukses
        $this->info("Admin {$admin->name} berhasil dibuat!");
    }
}
