<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lacak Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-3">Lacak Pesanan</h1>
        <p>Lacak pesananmu untuk mengetahui status pesanan laundry-mu secara real-time.</p>
        
        <!-- Status Filter Form -->
        <div class="mb-3">
            <form action="{{ route('lacak.pesanan') }}" method="GET">
                <button type="submit" name="status" value="semua" class="btn btn-primary">Semua</button>
                <button type="submit" name="status" value="Pending" class="btn btn-outline-secondary">Pending</button>
                <button type="submit" name="status" value="Dibayar" class="btn btn-outline-secondary">Dibayar</button>
                <button type="submit" name="status" value="Diproses" class="btn btn-outline-secondary">Diproses</button>
                <button type="submit" name="status" value="Selesai" class="btn btn-outline-secondary">Selesai</button>
                <button type="submit" name="status" value="Dibatalkan" class="btn btn-outline-secondary">Dibatalkan</button>
            </form>
        </div>

        <!-- Orders List -->
        <div class="row">
            @forelse($pesanan as $order)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $order->mitra->nama }}</h5>
                            @foreach($order->pesananItems as $item)
                                <span class="badge bg-primary">{{ $item->jenisPakaian->nama }}</span>
                            @endforeach
                            <p class="mt-2"><strong>Status:</strong> <span class="text-danger">{{ $order->status }}</span></p>
                            <p><strong>Kode Referral:</strong> {{ $order->kode_referral }}</p>
                            <p><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                            <p><strong>Total Biaya:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran ?? 'Bayar ditempat' }}</p>
                            @if($order->status == 'Dibayar')
                                <button class="btn btn-primary">Bayar</button>
                            @elseif($order->status == 'Selesai')
                                <button class="btn btn-primary">Nilai</button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p>Tidak ada pesanan dengan status tersebut.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </nav>

        <footer class="text-center mt-4">
            <p>&copy; 2025 Hak Cipta Nyuci. Semua Hak Dilindungi.</p>
        </footer>
    </div>
</body>
</html>
