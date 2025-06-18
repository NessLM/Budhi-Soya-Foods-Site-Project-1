<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar di BudhiSoyaFoods</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
    <style>
        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }
        
        .strength-weak { color: #dc2626; }
        .strength-medium { color: #f59e0b; }
        .strength-strong { color: #16a34a; }
        
        .password-requirements {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
            line-height: 1.4;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            gap: 5px;
            margin: 2px 0;
        }
        
        .requirement.met {
            color: #16a34a;
        }
        
        .requirement.unmet {
            color: #dc2626;
        }
        
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
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <a href="/" class="back-button" title="Kembali ke halaman utama">←  Kembali ke Halaman Utama</a>
        <h2>Daftar di BudhiSoyaFoods</h2>
        <p class="description">Selamat datang, pengguna baru! Buat akunmu sekarang</p>

        <form method="POST" action="{{ route('register.user') }}" id="registerForm">
            @csrf

            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       value="{{ old('username') }}" 
                       required
                       minlength="3"
                       maxlength="20"
                       pattern="[a-zA-Z0-9_]+"
                       title="Username hanya boleh mengandung huruf, angka, dan underscore">
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="password-requirements" id="usernameReqs" style="display: none;">
                    <div class="requirement" id="usernameLength">
                        <span>•</span> 3-20 karakter
                    </div>
                    <div class="requirement" id="usernameChars">
                        <span>•</span> Hanya huruf, angka, dan underscore
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required
                       minlength="6">
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
                <div class="password-strength" id="passwordStrength"></div>
                <div class="password-requirements" id="passwordReqs" style="display: none;">
                    <div class="requirement" id="lengthReq">
                        <span>•</span> Minimal 6 karakter
                    </div>
                    <div class="requirement" id="upperReq">
                        <span>•</span> Minimal 1 huruf besar
                    </div>
                    <div class="requirement" id="lowerReq">
                        <span>•</span> Minimal 1 huruf kecil
                    </div>
                    <div class="requirement" id="numberReq">
                        <span>•</span> Minimal 1 angka
                    </div>
                </div>
            </div>

            <div class="input-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required>
                <div id="passwordMatch" style="font-size: 12px; margin-top: 5px;"></div>
            </div>

            @if(session('success'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="error-message">{{ session('error') }}</div>
            @endif

            <button type="submit" id="submitBtn">
                <i class="fas fa-user-plus"></i>
                Daftar Sekarang
            </button>

            <div class="form-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const submitBtn = document.getElementById('submitBtn');
            
            // Username validation
            usernameInput.addEventListener('focus', function() {
                document.getElementById('usernameReqs').style.display = 'block';
            });
            
            usernameInput.addEventListener('blur', function() {
                document.getElementById('usernameReqs').style.display = 'none';
            });
            
            usernameInput.addEventListener('input', function() {
                const value = this.value;
                const lengthReq = document.getElementById('usernameLength');
                const charsReq = document.getElementById('usernameChars');
                
                // Length check
                if (value.length >= 3 && value.length <= 20) {
                    lengthReq.classList.add('met');
                    lengthReq.classList.remove('unmet');
                } else {
                    lengthReq.classList.add('unmet');
                    lengthReq.classList.remove('met');
                }
                
                // Characters check
                if (/^[a-zA-Z0-9_]*$/.test(value)) {
                    charsReq.classList.add('met');
                    charsReq.classList.remove('unmet');
                } else {
                    charsReq.classList.add('unmet');
                    charsReq.classList.remove('met');
                }
            });
            
            // Password validation
            passwordInput.addEventListener('focus', function() {
                document.getElementById('passwordReqs').style.display = 'block';
            });
            
            passwordInput.addEventListener('blur', function() {
                document.getElementById('passwordReqs').style.display = 'none';
            });
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const strengthDiv = document.getElementById('passwordStrength');
                
                // Requirements check
                const lengthReq = document.getElementById('lengthReq');
                const upperReq = document.getElementById('upperReq');
                const lowerReq = document.getElementById('lowerReq');
                const numberReq = document.getElementById('numberReq');
                
                // Length
                if (password.length >= 6) {
                    lengthReq.classList.add('met');
                    lengthReq.classList.remove('unmet');
                } else {
                    lengthReq.classList.add('unmet');
                    lengthReq.classList.remove('met');
                }
                
                // Uppercase
                if (/[A-Z]/.test(password)) {
                    upperReq.classList.add('met');
                    upperReq.classList.remove('unmet');
                } else {
                    upperReq.classList.add('unmet');
                    upperReq.classList.remove('met');
                }
                
                // Lowercase
                if (/[a-z]/.test(password)) {
                    lowerReq.classList.add('met');
                    lowerReq.classList.remove('unmet');
                } else {
                    lowerReq.classList.add('unmet');
                    lowerReq.classList.remove('met');
                }
                
                // Number
                if (/[0-9]/.test(password)) {
                    numberReq.classList.add('met');
                    numberReq.classList.remove('unmet');
                } else {
                    numberReq.classList.add('unmet');
                    numberReq.classList.remove('met');
                }
                
                // Strength calculation
                let strength = 0;
                if (password.length >= 6) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                if (password.length === 0) {
                    strengthDiv.textContent = '';
                } else if (strength <= 2) {
                    strengthDiv.textContent = 'Lemah';
                    strengthDiv.className = 'password-strength strength-weak';
                } else if (strength <= 3) {
                    strengthDiv.textContent = 'Sedang';
                    strengthDiv.className = 'password-strength strength-medium';
                } else {
                    strengthDiv.textContent = 'Kuat';
                    strengthDiv.className = 'password-strength strength-strong';
                }
                
                checkPasswordMatch();
            });
            
            // Password confirmation
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
            
            function checkPasswordMatch() {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const matchDiv = document.getElementById('passwordMatch');
                
                if (confirmPassword.length === 0) {
                    matchDiv.textContent = '';
                    return;
                }
                
                if (password === confirmPassword) {
                    matchDiv.textContent = '✓ Password cocok';
                    matchDiv.style.color = '#16a34a';
                } else {
                    matchDiv.textContent = '✗ Password tidak cocok';
                    matchDiv.style.color = '#dc2626';
                }
            }
            
            // Form submission
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                
                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Password dan konfirmasi password tidak cocok!');
                    confirmPasswordInput.focus();
                    return;
                }
                
                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    passwordInput.focus();
                    return;
                }
                
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftar...';
            });
        });
    </script>
</body>
</html>