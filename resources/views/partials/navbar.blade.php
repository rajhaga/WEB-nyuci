<nav class="bg-white shadow-lg p-4 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo untuk semua device -->
        <a class="flex items-center text-xl font-bold" href="/">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Nyuci Logo" class="h-10 mr-2"> 
            <span class="bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Nyuci</span>
        </a>

        <!-- Toggle Menu untuk Mobile -->
        <button id="menu-toggle" class="md:hidden focus:outline-none p-2 rounded-lg hover:bg-gray-100 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- Navbar Links di Desktop -->
        <div id="menu" class="hidden md:flex space-x-1">
            <a class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 font-medium {{ request()->is('/') ? 'text-blue-600 bg-blue-50' : '' }}" href="/">
                <span class="relative group">
                    Beranda
                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 transition-all duration-300 {{ request()->is('/') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                </span>
            </a>
            <a class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 font-medium {{ request()->is('catalog*') ? 'text-blue-600 bg-blue-50' : '' }}" href="/catalog">
                <span class="relative group">
                    Katalog
                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 transition-all duration-300 {{ request()->is('catalog*') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                </span>
            </a>
            <a class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 font-medium {{ request()->routeIs('lacak.pesanan') ? 'text-blue-600 bg-blue-50' : '' }}" href="{{ route('lacak.pesanan') }}">
                <span class="relative group">
                    Lacak
                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 transition-all duration-300 {{ request()->routeIs('lacak.pesanan') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                </span>
            </a>
            <a class="px-4 py-2 rounded-lg text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-all duration-300 font-medium {{ request()->is('contact*') ? 'text-blue-600 bg-blue-50' : '' }}" href="/contact">
                <span class="relative group">
                    Hubungi Kami
                    <span class="absolute left-0 bottom-0 w-full h-0.5 bg-blue-600 transition-all duration-300 {{ request()->is('contact*') ? 'opacity-100' : 'opacity-0 group-hover:opacity-100' }}"></span>
                </span>
            </a>
        </div>

        <!-- User Authentication - Desktop Only -->
        <div class="hidden md:flex items-center space-x-3">
            @auth
                <!-- Profile -->
                <div class="relative">
                    <button id="account-menu" class="flex items-center space-x-2 px-3 py-2 rounded-full hover:bg-gray-100 transition-all duration-300 focus:outline-none">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/40' }}" alt="Profile" class="w-8 h-8 rounded-full object-cover border-2 border-blue-100">
                        <span class="font-medium text-gray-700">{{ Auth::user()->nama }}</span>
                        <svg class="w-4 h-4 text-gray-500 transition-transform duration-200" id="dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="account-dropdown" class="absolute right-0 mt-2 w-56 bg-white border border-gray-200 rounded-xl shadow-xl overflow-hidden hidden transition-all duration-300 transform origin-top">
                        @if(Auth::user()->role === 'admin')
                            <a class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200 flex items-center" href="/admin/dashboard">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Dashboard Admin
                            </a>
                            <hr class="border-gray-100">
                        @elseif(Auth::user()->role === 'mitra')
                            <a class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200 flex items-center" href="/mitra/dashboard">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Dashboard Mitra
                            </a>
                            <hr class="border-gray-100">
                        @endif
                        <a class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200 flex items-center" href="/profile">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profile
                        </a>
                        <a class="block px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200 flex items-center" href="{{ route('order.history') }}">
                            <svg xmlns="http://www.w3.org/2000/svg"class="w-5 h-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            Riwayat Pesanan
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-3 text-gray-700 hover:bg-blue-50 transition-colors duration-200 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a class="px-4 py-2 rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition-all duration-300 font-medium" href="/register">Register</a>
                <a class="px-4 py-2 rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition-all duration-300 font-medium shadow-md hover:shadow-lg" href="/login">Login</a>
            @endauth
        </div>
    </div>

    <!-- Dropdown Menu untuk Mobile -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 shadow-lg">
        <div class="container mx-auto px-4 py-2 space-y-1">
            <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium" href="/">Beranda</a>
            <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium" href="/catalog">Katalog</a>
            <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium" href="{{ route('lacak.pesanan') }}">Lacak</a>
            <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium" href="/contact">Hubungi Kami</a>
            
            @auth
                <div class="pt-2 border-t border-gray-100 space-y-1">
                    <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium flex items-center" href="/profile">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>
                    @if(Auth::user()->role === 'admin')
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium flex items-center" href="/admin/dashboard">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Dashboard Admin
                        </a>
                    @elseif(Auth::user()->role === 'mitra')
                        <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium flex items-center" href="/mitra/dashboard">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Dashboard Mitra
                        </a>
                    @endif
                    <a class="block px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium flex items-center" href="{{ route('order.history') }}">
                        <svg xmlns="http://www.w3.org/2000/svg"class="w-5 h-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        Riwayat Pesanan
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300 font-medium flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-2 border-t border-gray-100 space-y-2">
                    <a class="block px-4 py-2 text-center rounded-lg border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white transition-all duration-300 font-medium" href="/register">Register</a>
                    <a class="block px-4 py-2 text-center rounded-lg bg-blue-500 text-white hover:bg-blue-600 transition-all duration-300 font-medium" href="/login">Login</a>
                </div>
            @endguest
        </div>
    </div>
</nav>

<script>
    
    // Toggle untuk menu mobile
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
        
        // Animasi icon toggle
        const icon = this.querySelector('svg');
        if (menu.classList.contains('hidden')) {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>';
        } else {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
        }
    });

    // Toggle untuk dropdown akun (desktop only)
    const accountMenu = document.getElementById('account-menu');
    if (accountMenu) {
        accountMenu.addEventListener('click', function() {
            const dropdown = document.getElementById('account-dropdown');
            const arrow = document.getElementById('dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('scale-95');
            dropdown.classList.toggle('opacity-0');
            dropdown.classList.toggle('scale-100');
            dropdown.classList.toggle('opacity-100');
            
            arrow.classList.toggle('rotate-180');
        });
        
        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (!accountMenu.contains(e.target) && !document.getElementById('account-dropdown').contains(e.target)) {
                const dropdown = document.getElementById('account-dropdown');
                const arrow = document.getElementById('dropdown-arrow');
                
                dropdown.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        });
    }
</script>