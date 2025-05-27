<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditLogAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'action',
        'target_username',
        'description',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    // Buat akses admin username dari relasi
    public function getAdminUsernameAttribute()
    {
        return $this->admin ? $this->admin->username : 'Unknown';
    }
}
