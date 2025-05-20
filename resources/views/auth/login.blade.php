<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>

<body>
    <div class="form-container">
        <a href="/" class="back-button" title="Kembali ke halaman utama">←  Kembali ke Halaman Utama</a>
        <h2 class="form-title">Login di <span class="brand">BudhiSoyaFoods</span></h2>
        <p class="description">Selamat datang kembali, pengguna setia!</p>

        <form method="POST" action="{{ route('login.user') }}">
            @csrf

            <div class="form-group">
                <label for="login">Username atau Email</label>
                <input type="text" id="login" name="login" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            {{-- ERROR MESSAGE --}}
            @if(session('error'))
                <p class="error-message">{{ session('error') }}</p>
            @endif

            <button type="submit" class="submit-button">Login</button>

            <p class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </form>
    </div>
</body>
</html>
