<nav class="bg-white shadow-md p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo Section on the Left -->
        <a class="flex items-center text-lg font-semibold" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Nyuci Logo" class="w-8 h-8 mr-2"> Nyuci
        </a>
        
        <!-- Toggle Button for Mobile -->
        <button id="menu-toggle" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        
        <!-- Navbar Links Section -->
        <div id="menu" class="hidden md:flex space-x-6">
            <a class="text-gray-700 hover:text-blue-500" href="/">Beranda</a>
            <a class="text-gray-700 hover:text-blue-500" href="/catalog">Katalog</a>
            <a class="text-gray-700 hover:text-blue-500" href="{{ route('lacak.pesanan') }}">Lacak</a>
            <a class="text-gray-700 hover:text-blue-500" href="/contact">Hubungi Kami</a>
        </div>
        
        <!-- User Authentication Links -->
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <!-- Account Dropdown -->
                <div class="relative">
                    <button id="account-menu" class="flex items-center text-gray-700 hover:text-blue-500 focus:outline-none">
                        <i class="fas fa-user-circle mr-2"></i> Akun
                    </button>
                    <div id="account-dropdown" class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg hidden">
                        @if(Auth::user()->role === 'admin')
                            <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" href="/admin/dashboard">Dashboard Admin</a>
                            <hr>
                        @endif
                        <a class="block px-4 py-2 text-gray-700 hover:bg-gray-100" href="/profile">Profile</a>
                        <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2">
                            @csrf
                            <button type="submit" class="w-full text-left text-gray-700 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- For Unauthenticated Users -->
                <a class="px-4 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-500 hover:text-white" href="/register">Register</a>
                <a class="px-4 py-2 border border-blue-500 text-blue-500 rounded hover:bg-blue-500 hover:text-white" href="/login">Login</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        document.getElementById('menu').classList.toggle('hidden');
    });
    document.getElementById('account-menu')?.addEventListener('click', function() {
        document.getElementById('account-dropdown').classList.toggle('hidden');
    });
</script>
