<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-blue-600 mb-4">404</h1>
        <h2 class="text-xl text-gray-800 mb-4">Page Not Found</h2>
        <p class="text-gray-500 mb-6">Sorry, the page you're looking for might have been moved or deleted.</p>
        <a href="{{ url('/') }}" class="bg-blue-500 text-white px-6 py-3 rounded-md hover:bg-blue-600 transition duration-300">Go to Homepage</a>
    </div>
</body>
</html>
