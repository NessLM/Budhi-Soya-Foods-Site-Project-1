<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="assets/css/login_admin.css">
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-box">
            <h2>Login Admin</h2>
            <p class="desc">Akses hanya untuk administrator.</p>

            <form method="POST" action="{{ route('login.admin') }}">
                @csrf

                <label for="username">Username Admin</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>

                @if(session('error'))
                    <p class="error-message">{{ session('error') }}</p>
                @endif

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
