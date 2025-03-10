<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <!-- Logo Section on the Left -->
        <a class="navbar-brand" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Nyuci Logo" style="width: 30px;"> Nyuci
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links Section on the Left -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Menu Items -->
                <li class="nav-item">
                    <a class="nav-link" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/catalog">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('lacak.pesanan') }}">Lacak</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/contact">Hubungi Kami</a>
                </li>
            </ul>
        </div>

        <!-- User Authentication Links on the Right -->
        <ul class="navbar-nav ms-auto">
            @auth
                <!-- Account Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> Akun
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!-- Conditional Link for Admin Dashboard -->
                        @if(Auth::user()->role === 'admin')
                            <li><a class="dropdown-item" href="/admin/dashboard">Dashboard Admin</a></li>
                            <li><hr class="dropdown-divider"></li>
                        @endif
                        <!-- Profile and Logout Links -->
                        <li><a class="dropdown-item" href="/profile">Profile</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <!-- For Unauthenticated Users -->
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="/register">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="/login">Login</a>
                </li>
            @endauth
        </ul>
    </div>
</nav>
