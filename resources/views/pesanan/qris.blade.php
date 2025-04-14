<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - {{ $pesanan->kode_referral }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-4 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-center mb-6">Pembayaran Laundry</h1>
            
            <div class="flex flex-col md:flex-row gap-8">
                <!-- QRIS Section -->
                <div class="flex-1 text-center">
                    <div class="bg-white p-4 rounded-lg border border-gray-200 inline-block">
                        <img src="{{ asset('storage/'.$pesanan->qris_image) }}" 
                             alt="QRIS Pembayaran"
                             class="w-64 h-64 mx-auto">
                    </div>
                    
                    <div class="mt-4 bg-blue-50 p-3 rounded-lg">
                        <p class="text-gray-600">Total Pembayaran:</p>
                        <p class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Order ID: {{ $pesanan->midtrans_order_id }}
                        </p>
                    </div>
                </div>
                
                <!-- Payment Details -->
                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-4">Detail Pesanan</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-gray-600">Nama Laundry:</p>
                            <p class="font-medium">{{ $pesanan->mitra->nama_laundry }}</p>
                        </div>
                        
                        <div>
                            <p class="text-gray-600">Status Pembayaran:</p>
                            <p class="font-medium capitalize 
                                @if($pesanan->status === 'paid') text-green-600
                                @elseif($pesanan->status === 'pending') text-yellow-600
                                @else text-red-600 @endif">
                                {{ $pesanan->status }}
                            </p>
                        </div>
                        
                        <div class="pt-4 border-t">
                            <form action="{{ route('pesanan.konfirmasi', $pesanan) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg">
                                    Saya Sudah Bayar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 text-center text-sm text-gray-500">
                <p>Scan QR code menggunakan aplikasi e-wallet atau mobile banking</p>
                <p>Pesanan akan otomatis diperbarui setelah pembayaran berhasil</p>
            </div>
        </div>
    </div>
</body>
</html>