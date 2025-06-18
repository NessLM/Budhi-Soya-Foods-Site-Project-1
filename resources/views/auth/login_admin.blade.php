<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="/assets/css/login_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
            animation: shake 0.3s ease-in-out;
        }
        
        .input-error {
            border-color: #e74c3c !important;
            box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.2) !important;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
        
        .success-message {
            color: #27ae60;
            font-size: 13px;
            margin-top: 12px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            animation: fadeIn 0.4s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-box">
            <h2>Login Admin</h2>
            <p class="desc">Akses hanya untuk administrator.</p>

            <form method="POST" action="{{ route('login.admin') }}">
                @csrf

                <div class="input-group">
                    <div class="input-icon">
                        <label for="username">Username Admin</label>
                        <i class="fas fa-user-shield"></i>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               value="{{ old('username') }}"
                               class="{{ $errors->has('username') || session('error') ? 'input-error' : '' }}"
                               required>
                    </div>
                    @error('username')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group">
                    <div class="input-icon">
                        <label for="password">Password</label>
                        <i class="fas fa-lock"></i>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="{{ $errors->has('password') || session('error') ? 'input-error' : '' }}"
                               required>
                    </div>
                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @if(session('error'))
                    <div class="error-message" style="text-align: center; margin-top: 10px;">
                        <i class="fas fa-times-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <button type="submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus on first input with error or first input
            const errorInput = document.querySelector('.input-error');
            const firstInput = document.querySelector('#username');
            
            if (errorInput) {
                errorInput.focus();
            } else if (firstInput) {
                firstInput.focus();
            }
            
            // Clear error styling on input
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('input-error');
                    const errorMsg = this.closest('.input-group').querySelector('.error-message');
                    if (errorMsg) {
                        errorMsg.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>