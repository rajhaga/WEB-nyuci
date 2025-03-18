<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white shadow-lg rounded-lg p-6 flex">
        <!-- QRIS Image -->
        <div class="mr-6">
            <h2 class="font-bold text-xl text-center mb-2">Scan QRIS untuk Membayar</h2>
            <img src="{{ asset('images/qris-payment.png') }}" alt="QRIS" class="w-64 border rounded-lg">
        </div>

        <!-- Detail Pesanan -->
        <div class="flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-semibold">Detail Pesanan</h3>
                <p class="text-sm text-gray-700">Mitra: <strong>{{ $pesanan->mitra->nama_laundry }}</strong></p>
                <p class="text-sm text-gray-700">Total: <strong>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong></p>
                <p class="text-sm text-gray-700">Kode Pesanan: <strong>{{ $pesanan->id }}</strong></p>
            </div>

            <form action="{{ route('pesanan.konfirmasi', ['pesanan' => $pesanan->id]) }}" method="POST">
                @csrf
                <button type="submit" class="mt-4 w-full bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Saya Sudah Membayar
                </button>
            </form>
        </div>
    </div>

</body>
</html>
