<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class CreateAdminAccount extends Command
{
    protected $signature = 'admin:create';
    protected $description = 'Buat akun admin baru melalui CLI';

    public function handle(): int
    {
        $username = $this->ask('Masukkan username admin');
        $password = $this->ask('Masukkan password admin');

        if (Admin::where('username', $username)->exists()) {
            $this->error("Username '$username' sudah digunakan.");
            return Command::FAILURE;
        }

        Admin::create([
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        $this->info("Akun admin '$username' berhasil dibuat!");
        return Command::SUCCESS;
    }
}
