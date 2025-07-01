<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_logs';

    protected $fillable = ['username', 'role', 'created_at'];
    
    // Disable updated_at timestamp karena tabel tidak memiliki kolom ini
    public $timestamps = false;
}