<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra - Nyuci</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-xl font-bold" href="/">Nyuci</a>
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center space-x-2">
                    <span class="hidden md:inline">{{ Auth::user()->nama }}</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-menu" class="absolute right-0 mt-2 bg-white text-black rounded shadow-md hidden">
                    <li><a class="block px-4 py-2 hover:bg-gray-200 transition duration-200" href="/profile">Profile</a></li>
                    <li><a class="block px-4 py-2 hover:bg-gray-200 transition duration-200" href="/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard -->
    <div class="container mx-auto mt-6 flex">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow-md">
            <nav class="space-y-1">
                <a href="/mitra/dashboard" class="block p-3 rounded-lg transition duration-300 border-l-4 {{
                    request()->is('mitra/dashboard') 
                    ? 'border-blue-500 bg-blue-50 text-blue-600' 
                    : 'border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                }}">
                    Dashboard
                </a>

                <a href="{{ route('mitra.kelolaPesanan') }}" class="block p-3 rounded-lg transition duration-300 border-l-4 {{
                    Route::currentRouteNamed('mitra.kelolaPesanan') 
                    ? 'border-blue-500 bg-blue-50 text-blue-600' 
                    : 'border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                }}">
                    Kelola Pesanan
                </a>

                <a href="/mitra/payment" class="block p-3 rounded-lg transition duration-300 border-l-4 {{
                    request()->is('mitra/payment') 
                    ? 'border-blue-500 bg-blue-50 text-blue-600' 
                    : 'border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                }}">
                    Pembayaran
                </a>

                <a href="/mitra/reports" class="block p-3 rounded-lg transition duration-300 border-l-4 {{
                    request()->is('mitra/reports') 
                    ? 'border-blue-500 bg-blue-50 text-blue-600' 
                    : 'border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                }}">
                    Laporan
                </a>

                @if(isset($mitra) && $mitra->id)
                <a href="{{ route('mitra.pengaturan', $mitra->id) }}" class="block p-3 rounded-lg transition duration-300 border-l-4 {{
                    Route::currentRouteNamed('mitra.pengaturan') 
                    ? 'border-blue-500 bg-blue-50 text-blue-600' 
                    : 'border-transparent text-gray-600 hover:bg-gray-100 hover:text-gray-800'
                }}">
                    Pengaturan
                </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 ml-6 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Dashboard Mitra</h2>
            @yield('mitracontent')
        </main>
    </div>

    <!-- Footer -->
    <footer class="mt-10 text-center text-gray-600 py-4">
        <p>&copy; 2023 Nyuci. All rights reserved.</p>
    </footer>
    @stack('scripts')
    <script>
        // Toggle Dropdown Menu
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }
    </script>
</body>
</html>

