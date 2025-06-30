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
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk'); // Disini primary key otomatis dari id
            $table->string('nama_produk');
            $table->decimal('harga', 10, 2);
            $table->integer('jumlah_produk');
            $table->string('kategori'); // Kategori ini hanya Makanan, dan Minuman untuk sementara
            $table->text('deskripsi'); // Deskripsi panjang produk
            $table->string('foto')->nullable(); // Path/nama file foto produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
