{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center">Register</h2>
                
                <!-- Laravel Validation Error Alerts -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Username</label>
                        <input type="text" name="nama" class="form-control" required minlength="3" maxlength="50">
                        <div class="form-text">Username should be between 3 and 50 characters.</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                        <div class="form-text">Please provide a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" name="phone" class="form-control" required pattern="[0-9]{10,15}" title="Phone number should be 10-15 digits.">
                        <div class="form-text">Phone number should be between 10 and 15 digits.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                        <div class="form-text">Password must be at least 6 characters long.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Nyuci</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow-lg border-primary" style="max-width: 400px; width: 100%;">
        <div class="card-body text-center">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-fluid mb-3" style="height: 100px;">
            <h2 class="fw-bold">Selamat Datang</h2>
            <p class="text-muted">Masukkan data Anda untuk mendaftar di <span class="text-primary">Nyuci</span></p>
            
            <form action="{{ route('register') }}" method="POST" class="text-start">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">No Handphone</label>
                    <input type="tel" name="phone" class="form-control" placeholder="Nomor HP" value="{{ old('phone') }}" required pattern="[0-9]{10,15}" title="Phone number should be 10-15 digits.">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required minlength="6">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">👁</button>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Ulangi Password</label>
                    <div class="input-group">
                        <input type="password" id="confirmPassword" name="password_confirmation" class="form-control" placeholder="Ulangi Password" required>
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">👁</button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>
            
            <p class="mt-3">Sudah punya akun? <a href="#" class="text-primary">Login</a></p>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        });
        
        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const confirmPasswordField = document.getElementById('confirmPassword');
            confirmPasswordField.type = confirmPasswordField.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>