<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah kolom `full_name` dan `is_active` ke tabel `users`
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom untuk nama lengkap pengguna, ditambahkan setelah `username`
            $table->string('full_name')->nullable()->after('username');
            
            // Kolom untuk menandai status aktif pengguna, ditambahkan setelah `last_login_at`
            $table->boolean('is_active')->default(true)->after('preferences');
        });
    }

    /**
     * Reverse the migrations.
     * Menghapus kolom `full_name` dan `is_active` jika migrasi di-rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['full_name', 'is_active']);
        });
    }
};