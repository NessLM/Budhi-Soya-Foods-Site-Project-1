<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>

<body>
    <div class="form-container">
        <h2>Login di BudhiSoyaFoods</h2>
        <p class="description">Selamat datang kembali, pengguna setia!</p>

        <!-- resources/views/auth/login.blade.php -->
        <form method="POST" action="{{ route('login.custom') }}">
            @csrf

            <h2>Login di BudhiSoyaFoods</h2>
            <p>Selamat datang kembali, pengguna lama!</p>

            <label for="login">Username atau Email</label><br>
            <input type="text" id="login" name="login" value="{{ old('login') }}" required><br>

            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" required><br>

            {{-- ERROR MESSAGE --}}
            @if(session('error'))
                <p style="color: red; margin-top: 10px;">{{ session('error') }}</p>
            @endif

            <button type="submit">Login</button>

            <p style="margin-top: 10px;">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </form>

    </div>

</body>

</html>