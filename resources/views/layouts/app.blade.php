<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nyuci - Home')</title>

    <!-- Tailwind CSS -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">
    @include('partials.navbar')

    <div class="container mx-auto p-4">
        
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-white p-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-yellow-500 text-white p-3 rounded-lg mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>

    @include('partials.footer')

    <!-- Auto Hide Notification Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                let alertBox = document.querySelector(".bg-green-500, .bg-red-500, .bg-yellow-500");
                if (alertBox) {
                    alertBox.style.transition = "opacity 1s";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 1000);
                }
            }, 5000);
        });
    </script>
</body>

</html>
