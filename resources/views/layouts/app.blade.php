<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Nyuci - Home')</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body class="bg-gray-100">
    @include('partials.navbar')

    <div class="container mx-auto p-4">
        @yield('content')
    </div>

    @include('partials.footer')
</body>
</html>
