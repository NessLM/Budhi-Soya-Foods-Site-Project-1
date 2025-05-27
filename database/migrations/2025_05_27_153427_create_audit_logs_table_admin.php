<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_log_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->string('action'); // contoh: tambah, ubah, hapus
            $table->string('target_username'); // siapa yang diubah
            $table->text('description'); // deskripsi log misalnya "Admin A menghapus Admin B"
            $table->timestamps(); // created_at untuk waktu kejadian
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};