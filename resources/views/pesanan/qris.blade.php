<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - {{ $pesanan->kode_referral }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .qris-container {
            position: relative;
            width: 256px;
            height: 256px;
            margin: 0 auto;
        }
        .qris-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255,255,255,0.9);
            z-index: 10;
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.03); }
            100% { transform: scale(1); }
        }
        .countdown {
            font-family: 'Roboto Mono', monospace;
        }
        .payment-steps li {
            position: relative;
            padding-left: 1.75rem;
            margin-bottom: 0.5rem;
        }
        .payment-steps li:before {
            content: counter(step);
            counter-increment: step;
            position: absolute;
            left: 0;
            width: 1.25rem;
            height: 1.25rem;
            background-color: #3b82f6;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center">
    <div class="container mx-auto p-4 max-w-4xl">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 p-6 text-white">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Pembayaran Laundry</h1>
                        <p class="text-blue-100 mt-1">Kode Referensi: {{ $pesanan->kode_referral }}</p>
                    </div>
                    <div class="mt-3 md:mt-0">
                        <span class="inline-block bg-blue-700 rounded-full px-3 py-1 text-sm font-semibold">
                            {{ $pesanan->metode_pembayaran === 'qris' ? 'QRIS' : 'Pembayaran Digital' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- QRIS Section -->
                    <div class="flex-1">
                        <div class="text-center">
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">Scan Kode QR</h2>
                                <p class="text-gray-600 text-sm">Gunakan aplikasi e-wallet atau mobile banking</p>
                            </div>
                            
                            <div class="qris-container pulse">
                                @if($pesanan->qris_url)
                                    <img src="{{ $pesanan->qris_url }}" 
                                         alt="QRIS Pembayaran"
                                         class="w-full h-full">
                                @else
                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center rounded-lg">
                                        <p class="text-gray-500">QR Code tidak tersedia</p>
                                    </div>
                                @endif
                                
                                @if($pesanan->status_pembayaran === 'paid')
                                <div class="qris-overlay rounded-lg">
                                    <div class="text-center p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <p class="font-semibold text-green-600">Pembayaran Berhasil</p>
                                        <p class="text-sm text-gray-600 mt-1">{{ $pesanan->tanggal_pembayaran->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div class="mt-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
                                <p class="text-gray-600 text-sm font-medium">TOTAL PEMBAYARAN</p>
                                <p class="text-3xl font-bold text-blue-600 my-2">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </p>
                                
                                <div class="grid grid-cols-2 gap-2 text-sm mt-3">
                                    <div class="text-left text-gray-600">Order ID:</div>
                                    <div class="text-right font-mono text-gray-800">{{ $pesanan->midtrans_order_id }}</div>
                                    
                                    @if($pesanan->payment_expiry)
                                    <div class="text-left text-gray-600">Batas Waktu:</div>
                                    <div class="text-right">
                                        <span class="countdown font-mono {{ \Carbon\Carbon::parse($pesanan->payment_expiry)->isPast() ? 'text-red-600' : 'text-blue-600' }}" 
                                            data-expiry="{{ \Carbon\Carbon::parse($pesanan->payment_expiry)->format('Y-m-d\TH:i:s') }}">
                                            {{ \Carbon\Carbon::parse($pesanan->payment_expiry)->format('H:i:s') }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Details -->
                    <div class="flex-1">
                        <div class="space-y-6">
                            <!-- Order Summary -->
                            <div class="bg-white rounded-lg border border-gray-200 p-5">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    Detail Pesanan
                                </h2>
                                
                                <div class="space-y-3">
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Nama Laundry:</span>
                                        <span class="font-medium text-gray-800">{{ $pesanan->mitra->nama_laundry }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Tanggal Order:</span>
                                        <span class="font-medium text-gray-800">{{ $pesanan->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium capitalize 
                                            @if($pesanan->status_pembayaran === 'paid') text-green-600
                                            @elseif($pesanan->status_pembayaran === 'pending') text-yellow-600
                                            @else text-red-600 @endif">
                                            {{ $pesanan->status_pembayaran === 'paid' ? 'Paid' : ($pesanan->status_pembayaran === 'pending' ? 'pending' : $pesanan->status_pembayaran) }}
                                        </span>
                                    </div>
                                    
                                    @if($pesanan->status_pembayaran === 'paid')
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Waktu Pembayaran:</span>
                                        <span class="font-medium text-gray-800">{{ $pesanan->tanggal_pembayaran->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Payment Instructions -->
                            <div class="bg-yellow-50 p-5 rounded-lg border border-yellow-200">
                                <h3 class="font-semibold text-yellow-800 mb-3 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Panduan Pembayaran
                                </h3>
                                <ol class="payment-steps list-none space-y-2 text-sm text-yellow-800">
                                    <li>Buka aplikasi e-wallet (GoPay, OVO, DANA, LinkAja) atau mobile banking yang mendukung QRIS</li>
                                    <li>Pilih menu <strong>"Scan QR Code"</strong> atau <strong>"Bayar dengan QRIS"</strong></li>
                                    <li>Arahkan kamera ke QR Code di sebelah kiri</li>
                                    <li>Pastikan nominal pembayaran sesuai (Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }})</li>
                                    <li>Konfirmasi dan selesaikan pembayaran</li>
                                </ol>
                            </div>
                            
                            <!-- Payment Actions -->
                            <div class="space-y-3">
                                @if($pesanan->status_pembayaran === 'pending')
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <form action="{{ route('pesanan.konfirmasi', $pesanan) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium flex items-center justify-center transition-all shadow-md hover:shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Saya Sudah Bayar
                                        </button>
                                    </form>
                                    
                                    <button onclick="checkPaymentStatus()"
                                            class="flex-1 bg-white border border-blue-500 text-blue-600 hover:bg-blue-50 py-3 px-4 rounded-lg font-medium flex items-center justify-center transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Cek Status
                                    </button>
                                </div>
                                @elseif($pesanan->status_pembayaran === 'paid')
                                <a href="{{ route('pesanan.invoice', $pesanan) }}"
                                   class="block w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium text-center transition-all shadow-md hover:shadow-lg">
                                    Lihat Invoice Pembayaran
                                </a>
                                @endif
                                
                                <p class="text-center text-xs text-gray-500 mt-2">
                                    Pembayaran akan diverifikasi otomatis dalam 1-2 menit
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center text-sm text-gray-500 border-t pt-4">
                    <p>Untuk bantuan atau masalah pembayaran, hubungi kami di</p>
                    <p class="font-medium text-blue-600 mt-1">08xx-xxxx-xxxx (Customer Service)</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Countdown timer
        function updateCountdown() {
            const countdownElements = document.querySelectorAll('.countdown');
            
            countdownElements.forEach(el => {
                const expiry = new Date(el.dataset.expiry).getTime();
                const now = new Date().getTime();
                const distance = expiry - now;
                
                if (distance < 0) {
                    el.textContent = "EXPIRED";
                    el.classList.remove('text-blue-600');
                    el.classList.add('text-red-600');
                    return;
                }
                
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                el.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            });
        }
        
        // Check payment status
        async function checkPaymentStatus() {
            try {
                const response = await fetch(`/pesanan/{{ $pesanan->id }}/check-payment`);
                const data = await response.json();
                
                if (data.status === 'success') {
                    if (data.data.transaction_status === 'settlement') {
                        // Show success message
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        
                        Toast.fire({
                            icon: 'success',
                            title: 'Pembayaran berhasil diverifikasi'
                        });
                        
                        // Reload page after 3 seconds
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Status Pembayaran',
                            text: `Transaksi masih dalam status: ${data.data.transaction_status}`,
                            confirmButtonText: 'Mengerti'
                        });
                    }
                } else {
                    throw new Error(data.message || 'Gagal memeriksa status pembayaran');
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: error.message,
                    confirmButtonText: 'Tutup'
                });
            }
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateCountdown();
            setInterval(updateCountdown, 1000);
            
            // Auto check payment status every 30 seconds if still pending
            @if($pesanan->status_pembayaran === 'pending')
            setInterval(checkPaymentStatus, 30000);
            @endif
        });
    </script>
</body>
</html>