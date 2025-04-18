<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran COD - {{ $pesanan->kode_referral }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-center mb-6">Pembayaran Cash (COD)</h1>
            
            <div class="space-y-6">
                <!-- Order Details -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold mb-2">Detail Pesanan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Kode Pesanan:</p>
                            <p class="font-bold text-blue-600">{{ $pesanan->kode_referral }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal:</p>
                            <p class="font-medium">{{ $pesanan->created_at->format('d-m-Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Nama Laundry:</p>
                            <p class="font-medium">{{ $pesanan->mitra->nama_laundry }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Status:</p>
                            <p class="font-medium capitalize text-yellow-600">{{ $pesanan->status }}</p>
                        </div>
                    </div>
                </div>

                <!-- Payment Instructions -->
                <div class="border border-yellow-200 bg-yellow-50 p-4 rounded-lg">
                    <h3 class="font-bold text-lg mb-2">Instruksi Pembayaran</h3>
                    <ol class="list-decimal pl-5 space-y-2">
                        <li>Tunjukkan kode pesanan <strong>{{ $pesanan->kode_referral }}</strong> ke mitra laundry</li>
                        <li>Mitra akan memverifikasi pesanan Anda</li>
                        <li>Bayar sesuai total yang tertera di bawah</li>
                        <li>Klik tombol "Saya Sudah Bayar" setelah melakukan pembayaran</li>
                    </ol>
                </div>

                <!-- Payment Amount -->
                <div class="bg-white border border-gray-200 p-4 rounded-lg text-center">
                    <p class="text-gray-600">Total Pembayaran:</p>
                    <p class="text-3xl font-bold text-blue-600">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Contact Mitra -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-bold mb-2">Kontak Mitra</h3>
                    <div class="flex items-center space-x-4">
                        <div class="bg-blue-100 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-600">Nomor Telepon</p>
                            <a href="tel:{{ $pesanan->mitra->no_telp }}" class="font-medium text-blue-600 hover:text-blue-800">
                                {{ $pesanan->mitra->no_telp }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Payment Confirmation -->
                <form action="{{ route('pesanan.konfirmasi', $pesanan) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg text-lg font-bold">
                        Saya Sudah Bayar
                    </button>
                </form>
            </div>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Pastikan Anda telah membayar ke mitra sebelum mengklik tombol konfirmasi</p>
                <p>Pesanan akan segera diproses setelah pembayaran dikonfirmasi</p>
            </div>
        </div>
    </div>
</body>
</html>