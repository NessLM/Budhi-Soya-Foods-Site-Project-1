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
        Schema::create('kurir', function (Blueprint $table) {
            $table->id('id_kurir');
            $table->foreignId('id_pesanan')->constrained('pesanan')->onDelete('cascade');
            $table->string('alamat');
            $table->date('tanggal_pesanan');
            $table->string('waktu_pengantaran');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};
