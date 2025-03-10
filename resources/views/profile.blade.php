<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Nyuci</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Nyuci</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->nama }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/profile">Profile</a></li>
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Section -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <img src="https://via.placeholder.com/150" class="rounded-circle" alt="Profile Picture">
                        </div>
                        <table class="table table-bordered">
                            <tr>
                                <th>nama</th>
                                <td>{{ $user->nama }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>{{ $user->role }}</td>
                            </tr>
                            <tr>
                                <th>Registered At</th>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        </table>
                        <div class="text-center">
                            <a href="/profile/edit" class="btn btn-primary">Edit Profile</a>
                        </div>
                    </div>
                    @if(auth()->user()->role == 'mitra')
    <h3>Detail Akun Mitra</h3>
    <p>Nama Laundry: {{ auth()->user()->mitra->nama_laundry }}</p>
    <p>Alamat: {{ auth()->user()->mitra->alamat }}</p>
    <p>Jam Operasional: {{ auth()->user()->mitra->jam_operasional }}</p>
    <p>Metode Pembayaran: {{ auth()->user()->mitra->metode_pembayaran }}</p>
    <p>Kategori Layanan: {{ auth()->user()->mitra->kategori_layanan }}</p>

    <p>Jenis Pakaian yang Diterima:</p>
    <ul>
        @foreach(auth()->user()->mitra->paketPakaian as $paket)
            <h4>{{ $paket->nama }}</h4>
            <ul>
                @foreach($paket->jenisPakaian as $jenis)
                    <li>
                        {{ $jenis->nama }} - Rp{{ number_format($jenis->pivot->price, 0, ',', '.') }}
                        <form action="{{ route('mitra.updatePrice', $jenis->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="price" value="{{ $jenis->pivot->price }}" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-success">Update Price</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endforeach
    </ul>
@endif


                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p>&copy; 2023 Nyuci. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and Font Awesome -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>