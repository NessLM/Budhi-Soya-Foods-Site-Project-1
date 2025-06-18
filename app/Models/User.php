<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'email_verified_at',
        'is_email_verified',
    ];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_email_verified' => 'boolean',
        ];
    }

    /**
     * Check if user's email is verified
     */
    public function hasVerifiedEmail()
    {
        return $this->is_email_verified && $this->email_verified_at !== null;
    }

    /**
     * Mark email as verified
     */
    public function markEmailAsVerified()
    {
        $this->update([
            'email_verified_at' => now(),
            'is_email_verified' => true,
        ]);
    }
}