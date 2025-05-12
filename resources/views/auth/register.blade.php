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
                
                <!-- Menampilkan Error untuk Nama -->
                @error('nama')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" value="{{ old('nama') }}" required>
                </div>

                <!-- Menampilkan Error untuk Email -->
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                </div>
                
                <!-- Menampilkan Error untuk Phone -->
                @error('phone')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                
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
