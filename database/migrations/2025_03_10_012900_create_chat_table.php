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
        Schema::create('chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_chat_sessions'); #simpan ke local storage
            $table->enum('sender', ['Pelanggan', 'Admin']);
            $table->text('content');
            $table->timestamps();
            

            $table->foreign('id_chat_sessions')->references('id')->on('chat_sessions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
