<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>No Internet Connection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-6xl font-bold text-yellow-500 mb-4">No Connection</h1>
        <h2 class="text-xl text-gray-800 mb-4">It looks like you're offline.</h2>
        <p class="text-gray-500 mb-6">Please check your internet connection and try again.</p>
        <button onclick="window.location.reload();" class="bg-yellow-500 text-white px-6 py-3 rounded-md hover:bg-yellow-600 transition duration-300">Retry</button>
    </div>
</body>
</html>
