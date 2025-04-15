<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entri_servis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelanggan');
            $table->string('plat_no');
            $table->enum('status', ['Dalam antrian','Sedang diperbaiki', 'Selesai']);
            $table->string('nomor_whatsapp');
            $table->text('keterangan')->nullable();
            $table->text('prediksi')->nullable();
            $table->integer('harga');
            $table->timestamp('tanggal_selesai')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entri_servis');
    }
};
