<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mitra - Nyuci</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Mitra Navbar -->
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

    <!-- Dashboard Section -->
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar for Mitra -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="/mitra/dashboard" class="list-group-item list-group-item-action active">Dashboard</a>
                    <a href="/mitra/orders" class="list-group-item list-group-item-action">Kelola Pesanan</a>
                    <a href="/mitra/payment" class="list-group-item list-group-item-action">Pembayaran</a>
                    <a href="/mitra/reports" class="list-group-item list-group-item-action">Laporan</a>
                    <a href="/mitra/settings" class="list-group-item list-group-item-action">Pengaturan</a>
                </div>
            </div>

            <!-- Mitra Dashboard Content -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h3>Dashboard Mitra</h3>
                    </div>
                    <div class="card-body">
                        <!-- Total Saldo & Pendapatan Bulanan -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Total Saldo</h5>
                                <p>Rp{{ number_format($mitra->total_saldo, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Total Pendapatan Bulanan</h5>
                                <p>Rp{{ number_format($mitra->total_pendapatan_bulanan, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Order Status Section -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <h5>Pesanan Menunggu</h5>
                                <p>{{ $mitra->orders_pending }}</p>
                            </div>
                            <div class="col-md-3">
                                <h5>Pesanan Diterima</h5>
                                <p>{{ $mitra->orders_accepted }}</p>
                            </div>
                            <div class="col-md-3">
                                <h5>Pesanan Diproses</h5>
                                <p>{{ $mitra->orders_processing }}</p>
                            </div>
                            <div class="col-md-3">
                                <h5>Pesanan Selesai</h5>
                                <p>{{ $mitra->orders_completed }}</p>
                            </div>
                        </div>

                        <!-- Earnings & Orders Chart Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Grafik Pesanan per Tahun</h5>
                                <div id="orders-chart"></div>  <!-- You can integrate a chart library like Chart.js or ApexCharts here -->
                            </div>
                            <div class="col-md-6">
                                <h5>Grafik Pendapatan</h5>
                                <div id="earnings-chart"></div> <!-- Another chart for earnings -->
                            </div>
                        </div>

                        <!-- Laundry Details -->
                        <div class="mt-5">
                            <h4>Detail Akun Mitra</h4>
                            <p><strong>Nama Laundry:</strong> {{ $mitra->nama_laundry }}</p>
                            <p><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
                            <p><strong>Jam Operasional:</strong> {{ $mitra->jam_operasional }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ $mitra->metode_pembayaran }}</p>
                            <p><strong>Kategori Layanan:</strong> {{ $mitra->kategori_layanan }}</p>

                            <h5>Jenis Pakaian yang Diterima:</h5>
                            <ul>
                                @foreach ($mitra->paketPakaian as $paket)
                                    <li>
                                        <strong>{{ $paket->nama }}</strong>
                                        <ul>
                                            @foreach ($paket->jenisPakaian as $jenis)
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
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p>&copy; 2023 Nyuci. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
