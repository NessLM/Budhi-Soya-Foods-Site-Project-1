<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar di BudhiSoyaFoods</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="form-container">
        <a href="/" class="back-button" title="Kembali ke halaman utama">←  Kembali ke Halaman Utama</a>
        <h2>Daftar di BudhiSoyaFoods</h2>
        <p class="description">Selamat datang, pengguna baru! Buat akunmu sekarang</p>

        <form method="POST" action="{{ route('register.user') }}">
            @csrf

            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required>
            @error('username')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>

            <button type="submit">Daftar</button>

            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif

            <div class="form-footer">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </form>
    </div>

    <script src="assets/js/register-validation.js"></script>
</body>
</html>
