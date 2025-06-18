<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'otp_code',
        'expires_at',
        'is_verified'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_verified' => 'boolean'
    ];

    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    public function isValid()
    {
        return !$this->is_verified && !$this->isExpired();
    }

    public static function generateOTP()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function createForEmail($email)
    {
        // Delete existing OTP for this email
        self::where('email', $email)->delete();

        return self::create([
            'email' => $email,
            'otp_code' => self::generateOTP(),
            'expires_at' => Carbon::now()->addMinutes(10), // OTP valid for 10 minutes
        ]);
    }
}