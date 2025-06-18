<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
    <style>
        .otp-input-container {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin: 20px 0;
        }
        
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            border: 2px solid #cbd5e1;
            border-radius: 8px;
            background-color: #f0fdf4;
            transition: all 0.3s ease;
        }
        
        .otp-input:focus {
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
            outline: none;
            background-color: #ecfdf5;
        }
        
        .otp-input.filled {
            background-color: #dcfce7;
            border-color: #16a34a;
        }
        
        .timer-container {
            text-align: center;
            margin: 15px 0;
            font-size: 14px;
            color: #6b7280;
        }
        
        .timer {
            font-weight: bold;
            color: #dc2626;
        }
        
        .resend-container {
            text-align: center;
            margin: 20px 0;
        }
        
        .resend-btn {
            background: none;
            border: none;
            color: #0f766e;
            text-decoration: underline;
            cursor: pointer;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .resend-btn:hover:not(:disabled) {
            color: #0d9488;
        }
        
        .resend-btn:disabled {
            color: #9ca3af;
            cursor: not-allowed;
            text-decoration: none;
        }
        
        .verification-info {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #0c4a6e;
        }
        
        .email-display {
            font-weight: bold;
            color: #16a34a;
        }
        
        .loading {
            display: none;
            text-align: center;
            margin: 10px 0;
            color: #6b7280;
        }
        
        .success-animation {
            animation: successPulse 0.6s ease-in-out;
        }
        
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <a href="{{ route('register') }}" class="back-button" title="Kembali ke halaman registrasi">←  Kembali ke Registrasi</a>
        
        <h2 class="form-title">
            <i class="fas fa-envelope-circle-check" style="color: #22c55e; margin-right: 8px;"></i>
            Verifikasi Email
        </h2>
        
        <div class="verification-info">
            <p><strong>📧 Kode OTP telah dikirim ke:</strong></p>
            <p class="email-display">{{ $email }}</p>
            <p style="margin-top: 10px; font-size: 13px;">
                Silakan cek inbox atau folder spam email Anda.
            </p>
        </div>

        <form id="otpForm" method="POST" action="{{ route('verify.email') }}">
            @csrf
            
            <label for="otp_code">Masukkan Kode OTP (6 digit)</label>
            
            <div class="otp-input-container">
                <input type="text" class="otp-input" maxlength="1" data-index="0">
                <input type="text" class="otp-input" maxlength="1" data-index="1">
                <input type="text" class="otp-input" maxlength="1" data-index="2">
                <input type="text" class="otp-input" maxlength="1" data-index="3">
                <input type="text" class="otp-input" maxlength="1" data-index="4">
                <input type="text" class="otp-input" maxlength="1" data-index="5">
            </div>
            
            <input type="hidden" name="otp_code" id="otp_code">
            
            <div class="timer-container">
                <p>Kode akan kadaluarsa dalam: <span class="timer" id="timer">10:00</span></p>
            </div>

            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif

            <div class="loading" id="loading">
                <i class="fas fa-spinner fa-spin"></i> Memverifikasi...
            </div>

            <button type="submit" id="submitBtn" class="submit-button">
                <i class="fas fa-check-circle"></i> Verifikasi Email
            </button>
        </form>

        <div class="resend-container">
            <p style="font-size: 14px; color: #6b7280; margin-bottom: 10px;">
                Tidak menerima kode?
            </p>
            <button type="button" id="resendBtn" class="resend-btn">
                <i class="fas fa-paper-plane"></i> Kirim Ulang Kode OTP
            </button>
        </div>

        <div class="form-footer">
            <p style="font-size: 13px; color: #6b7280;">
                Dengan memverifikasi email, Anda menyetujui 
                <a href="#" style="color: #0f766e;">Syarat & Ketentuan</a> kami.
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpCodeInput = document.getElementById('otp_code');
            const submitBtn = document.getElementById('submitBtn');
            const resendBtn = document.getElementById('resendBtn');
            const timerElement = document.getElementById('timer');
            const loadingElement = document.getElementById('loading');
            const form = document.getElementById('otpForm');
            
            let timeLeft = 600; // 10 minutes in seconds
            let timerInterval;
            let resendCooldown = 0;

            // OTP Input handling
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    const value = e.target.value;
                    
                    // Only allow numbers
                    if (!/^\d*$/.test(value)) {
                        e.target.value = '';
                        return;
                    }
                    
                    // Add filled class
                    if (value) {
                        e.target.classList.add('filled');
                        // Move to next input
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    } else {
                        e.target.classList.remove('filled');
                    }
                    
                    updateOTPCode();
                });
                
                input.addEventListener('keydown', function(e) {
                    // Handle backspace
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].classList.remove('filled');
                        updateOTPCode();
                    }
                    
                    // Handle paste
                    if (e.key === 'v' && (e.ctrlKey || e.metaKey)) {
                        e.preventDefault();
                        navigator.clipboard.readText().then(text => {
                            const numbers = text.replace(/\D/g, '').slice(0, 6);
                            if (numbers.length === 6) {
                                otpInputs.forEach((input, i) => {
                                    input.value = numbers[i] || '';
                                    if (numbers[i]) {
                                        input.classList.add('filled');
                                    }
                                });
                                updateOTPCode();
                            }
                        });
                    }
                });
            });

            function updateOTPCode() {
                const otp = Array.from(otpInputs).map(input => input.value).join('');
                otpCodeInput.value = otp;
                
                // Enable submit button if OTP is complete
                if (otp.length === 6) {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                } else {
                    submitBtn.disabled = true;
                    submitBtn.style.opacity = '0.6';
                }
            }

            // Timer countdown
            function startTimer() {
                timerInterval = setInterval(() => {
                    timeLeft--;
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    
                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        timerElement.textContent = 'Kadaluarsa';
                        timerElement.style.color = '#dc2626';
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Kode Kadaluarsa';
                    }
                }, 1000);
            }

            // Resend OTP
            function startResendCooldown() {
                resendCooldown = 60; // 1 minute cooldown
                resendBtn.disabled = true;
                
                const cooldownInterval = setInterval(() => {
                    resendBtn.textContent = `Kirim Ulang (${resendCooldown}s)`;
                    resendCooldown--;
                    
                    if (resendCooldown < 0) {
                        clearInterval(cooldownInterval);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Ulang Kode OTP';
                    }
                }, 1000);
            }

            resendBtn.addEventListener('click', function() {
                if (resendBtn.disabled) return;
                
                fetch('{{ route("resend.otp") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ ' + data.success);
                        // Reset timer
                        timeLeft = 600;
                        startTimer();
                        startResendCooldown();
                        
                        // Clear OTP inputs
                        otpInputs.forEach(input => {
                            input.value = '';
                            input.classList.remove('filled');
                        });
                        updateOTPCode();
                        otpInputs[0].focus();
                    } else {
                        alert('❌ ' + (data.error || 'Gagal mengirim ulang kode OTP'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Terjadi kesalahan. Silakan coba lagi.');
                });
            });

            // Form submission
            form.addEventListener('submit', function(e) {
                if (otpCodeInput.value.length !== 6) {
                    e.preventDefault();
                    alert('Silakan masukkan kode OTP 6 digit yang lengkap.');
                    return;
                }
                
                loadingElement.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memverifikasi...';
            });

            // Initialize
            startTimer();
            otpInputs[0].focus();
            updateOTPCode();
            
            // Auto-focus first empty input on page load
            const firstEmpty = Array.from(otpInputs).find(input => !input.value);
            if (firstEmpty) {
                firstEmpty.focus();
            }
        });
    </script>
</body>
</html>