<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<!-- Tailwind CSS -->
@vite('resources/css/app.css')

</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-5 p-4 bg-white rounded shadow-lg">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid w-25">
                <h2 class="mt-3">Selamat Datang</h2>
                <p class="text-muted">Masukkan username dan password untuk masuk ke <span class="text-primary">Nyuci</span></p>
            </div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Username</label>
                    <input type="nama" id="nama" name="nama" class="form-control" required autofocus>
                </div>
                <div class="mb-3 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" required>
                        <button type="button" id="togglePassword" class="btn btn-outline-secondary">👁</button>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" id="remember_me" name="remember" class="form-check-input">
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-primary text-decoration-none">Lupa Password?</a>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
            <p class="mt-3 text-center">Belum punya akun? <a href="{{ route('register') }}" class="text-primary text-decoration-none">Daftar</a></p>
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>