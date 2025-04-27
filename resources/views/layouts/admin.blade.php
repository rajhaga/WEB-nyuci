<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nyuci</title>
    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Chart.js library (global) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Nyuci</a>
            <div class="relative">
                <button onclick="toggleDropdown()" class="flex items-center space-x-2">
                    <span class="hidden md:inline">{{ Auth::user()->nama }}</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <ul id="dropdown-menu" class="absolute right-0 mt-2 bg-white text-black rounded shadow-md hidden">
                    <li><a href="/profile" class="block px-4 py-2 hover:bg-gray-200 transition duration-200">Profile</a></li>
                    <li><a href="/logout" class="block px-4 py-2 hover:bg-gray-200 transition duration-200">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Container -->
    <div class="container mx-auto mt-6 flex">
        <!-- Sidebar -->
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow-md space-y-2">
            <nav>
                <a href="/admin/dashboard" class="block p-3 rounded-lg text-white bg-blue-500 hover:bg-blue-600 transition duration-300">Dashboard</a>
                <a href="/admin/hubungi-kami" class="block p-3 rounded-lg hover:bg-gray-100 text-gray-700 transition duration-300 hover:text-blue-500">Hubungi Kami</a>
                <a href="/admin/kelola-pelanggan" class="block p-3 rounded-lg hover:bg-gray-100 text-gray-700 transition duration-300 hover:text-blue-500">Kelola Pelanggan</a>
                <a href="/admin/verifikasi-mitra" class="block p-3 rounded-lg hover:bg-gray-100 text-gray-700 transition duration-300 hover:text-blue-500">Verifikasi Mitra</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="w-3/4 ml-6">
            <div class="bg-white p-6 rounded-lg shadow-md">
                @yield('admincontent')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="mt-10 text-center text-gray-600 py-4">
        <p>&copy; 2025 Nyuci. All rights reserved.</p>
    </footer>

    <!-- Scripts -->
    <script>
        // Toggle Dropdown Menu
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown-menu');
            dropdown.classList.toggle('hidden');
        }
    </script>

    {{-- stack for page-specific scripts --}}
    @stack('scripts')
</body>
</html>
