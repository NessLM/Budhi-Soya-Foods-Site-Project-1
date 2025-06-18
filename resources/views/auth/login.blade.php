<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
    <style>
        .input-group {
            position: relative;
            margin-bottom: 18px;
        }
        
        .success-message {
            background-color: #dcfce7;
            border: 1px solid #16a34a;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin: 15px 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: slideIn 0.3s ease;
        }
        
        .login-help {
            text-align: center;
            margin: 15px 0;
            font-size: 13px;
            color: #6b7280;
        }
        
        .login-help a {
            color: #0f766e;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-help a:hover {
            text-decoration: underline;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <a href="/" class="back-button" title="Kembali ke halaman utama">←  Kembali ke Halaman Utama</a>
        <h2 class="form-title">Login di <span style="color: #22c55e;">BudhiSoyaFoods</span></h2>
        <p class="description">Selamat datang kembali, pengguna setia!</p>

        <form method="POST" action="{{ route('login.user') }}" id="loginForm">
            @csrf

            <div class="input-group">
                <label for="login">Username atau Email</label>
                <input type="text" 
                       id="login" 
                       name="login" 
                       value="{{ old('login') }}"
                       required
                       placeholder="Masukkan username atau email Anda">
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required
                       placeholder="Masukkan password Anda">
            </div>

            @if(session('error'))
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <button type="submit" class="submit-button" id="submitBtn">
                <i class="fas fa-sign-in-alt"></i>
                Login
            </button>

            <div class="login-help">
                <a href="#" onclick="alert('Fitur reset password akan segera tersedia!')">Lupa password?</a>
            </div>

            <p class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const loginInput = document.getElementById('login');
            
            // Auto-focus on login input
            loginInput.focus();
            
            // Form submission
            form.addEventListener('submit', function(e) {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Masuk...';
                
                // Re-enable button after 3 seconds in case of error
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Login';
                }, 3000);
            });
            
            // Clear any error messages when user starts typing
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    const errorMsg = document.querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.style.opacity = '0.5';
                    }
                });
            });
        });
    </script>
</body>
</html>