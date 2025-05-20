<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - BudhiSoyaFoods</title>
    <link rel="stylesheet" href="assets/css/login_admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-box">
            <h2>Login Admin</h2>
            <p class="desc">Akses hanya untuk administrator.</p>

            <form method="POST" action="{{ route('login.admin') }}">
                @csrf

                <div class="input-icon">
                    <label for="username">Username Admin</label>
                    <i class="fas fa-user-shield"></i>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="input-icon">
                    <label for="password">Password</label>
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required>
                </div>

                @if(session('error'))
                    <p class="error-message">{{ session('error') }}</p>
                @endif

                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
