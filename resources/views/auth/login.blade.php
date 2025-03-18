<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-4">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="mx-auto w-24">
            <h2 class="mt-3 text-xl font-bold">Selamat Datang</h2>
            <p class="text-gray-600">Masukkan username dan password untuk masuk ke <span class="text-blue-500">Nyuci</span></p>
        </div>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nama" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300" required autofocus>
            </div>
            <div class="mb-3 relative">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300 pr-10" required>
                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-2 flex items-center text-gray-600">👁</button>
                </div>
            </div>
            <div class="flex justify-between items-center mb-3">
                <div>
                    <input type="checkbox" id="remember_me" name="remember" class="rounded border-gray-300 text-blue-500 focus:ring focus:ring-blue-300">
                    <label for="remember_me" class="text-sm text-gray-700">Ingat saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline text-sm">Lupa Password?</a>
                @endif
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">Masuk</button>
        </form>
        <p class="mt-3 text-center text-sm">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Daftar</a></p>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            passwordField.type = passwordField.type === 'password' ? 'text' : 'password';
        });
    </script>
</body>
</html>
