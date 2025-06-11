<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerification;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->only('login', 'password');
        $loginInput = $credentials['login'];
        $password = $credentials['password'];
    
        // Tentukan field login: email atau username
        $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    
        // Gabungkan field login dan password ke dalam array credentials
        $loginData = [
            $field => $loginInput,
            'password' => $password
        ];
    
        // Coba login dengan Auth::attempt()
        if (Auth::attempt($loginData)) {
            $user = Auth::user();
            
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()->with('error', 'Email Anda belum diverifikasi. Silakan verifikasi email terlebih dahulu.')->withInput();
            }
            
            $request->session()->regenerate(); // cegah session fixation
            return redirect()->intended('/')->with('success', 'Selamat datang kembali, ' . $user->username . '!');
        }
    
        // Jika gagal login
        return back()->with('error', 'Username, email, atau password salah.')->withInput();
    }
    
    
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create user but don't verify email yet
        $user = User::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_email_verified' => false,
        ]);

        // Generate and send OTP
        $emailVerification = EmailVerification::createForEmail($request->email);
        
        try {
            Mail::to($request->email)->send(new OTPMail($emailVerification->otp_code, $request->username));
            
            // Store user data in session for verification process
            session([
                'pending_verification_email' => $request->email,
                'pending_verification_username' => $request->username
            ]);
            
            return redirect()->route('verify.email.form')->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk kode verifikasi OTP.');
        } catch (\Exception $e) {
            // If email sending fails, delete the user and show error
            $user->delete();
            return back()->with('error', 'Gagal mengirim email verifikasi. Silakan coba lagi.')->withInput();
        }
    }

    public function showVerifyEmail() {
        $email = session('pending_verification_email');
        $username = session('pending_verification_username');
        
        if (!$email) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan daftar ulang.');
        }
        
        return view('auth.verify-email', compact('email', 'username'));
    }

    public function verifyEmail(Request $request) {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $email = session('pending_verification_email');
        
        if (!$email) {
            return redirect()->route('register')->with('error', 'Sesi verifikasi tidak ditemukan. Silakan daftar ulang.');
        }

        $verification = EmailVerification::where('email', $email)
            ->where('otp_code', $request->otp_code)
            ->where('is_verified', false)
            ->first();

        if (!$verification) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah digunakan.');
        }

        if ($verification->isExpired()) {
            return back()->with('error', 'Kode OTP sudah kadaluarsa. Silakan minta kode baru.');
        }

        // Mark verification as used
        $verification->update(['is_verified' => true]);

        // Mark user email as verified
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->markEmailAsVerified();
        }

        // Clear session
        session()->forget(['pending_verification_email', 'pending_verification_username']);

        return redirect()->route('login')->with('success', 'Email berhasil diverifikasi! Sekarang Anda dapat login.');
    }

    public function resendOTP(Request $request) {
        $email = session('pending_verification_email');
        $username = session('pending_verification_username');
        
        if (!$email) {
            return response()->json(['error' => 'Sesi verifikasi tidak ditemukan.'], 400);
        }

        // Check if user can request new OTP (rate limiting)
        $lastOTP = EmailVerification::where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastOTP && $lastOTP->created_at->diffInMinutes(now()) < 1) {
            return response()->json(['error' => 'Tunggu 1 menit sebelum meminta kode OTP baru.'], 429);
        }

        // Generate new OTP
        $emailVerification = EmailVerification::createForEmail($email);
        
        try {
            Mail::to($email)->send(new OTPMail($emailVerification->otp_code, $username));
            return response()->json(['success' => 'Kode OTP baru telah dikirim ke email Anda.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengirim email. Silakan coba lagi.'], 500);
        }
    }

    public function logout(Request $request) {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/')->with('success', 'Anda telah logout dengan aman.');
    }
    
}