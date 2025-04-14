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
        Schema::create('pemasukan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_servis');
            $table->integer('nominal');
            $table->text('keterangan')->nullable();
            $table->text('bukti_pemasukan');
            $table->timestamp('tanggal_pemasukan');
            $table->timestamps();

            $table->foreign('id_servis')->references('id')->on('entri_servis')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukan');
    }
};
