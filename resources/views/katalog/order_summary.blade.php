@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Checkout Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Checkout Laundry</h1>
        <div class="flex justify-center items-center">
            <div class="h-1 bg-blue-500 w-12 rounded-full"></div>
        </div>
    </div>

    <!-- Progress Steps -->
    <!-- <div class="mb-8">
        <div class="flex justify-between items-center text-sm font-medium text-gray-500">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center">1</div>
                <span class="ml-2">Keranjang</span>
            </div>
            <div class="flex-1 h-px bg-gray-200 mx-2"></div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center">2</div>
                <span class="ml-2">Pembayaran</span>
            </div>
            <div class="flex-1 h-px bg-gray-200 mx-2"></div>
            <div class="flex items-center">
                <div class="w-6 h-6 border-2 border-gray-300 text-gray-300 rounded-full flex items-center justify-center">3</div>
                <span class="ml-2">Selesai</span>
            </div>
        </div>
    </div> -->

    <!-- Mitra Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-start">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                    </svg>
                    {{ $mitra->nama_laundry }}
                </h3>
                <p class="text-gray-600 mt-2 flex items-center">
                    <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    {{ $mitra->alamat }}
                </p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Estimasi</p>
                <p class="font-semibold text-blue-600">2-3 Hari</p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Pesanan</h3>
        
        <div class="space-y-4">
            @foreach($items as $item)
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 last:border-0">
                <div>
                    <p class="font-medium text-gray-800">{{ $item['jenis'] }}</p>
                    <p class="text-sm text-gray-500">{{ $item['quantity'] }} item</p>
                </div>
                <div class="text-right">
                    <p class="font-medium text-blue-600">Rp{{ number_format($item['cost'], 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
            
            <!-- Added Layanan Aplikasi -->
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 last:border-0">
                <div>
                    <p class="font-medium text-gray-800">Layanan Aplikasi</p>
                    <p class="text-sm text-gray-500">1 item</p>
                </div>
                <div class="text-right">
                    <p class="font-medium text-blue-600">Rp8.000</p>
                </div>
            </div>
        </div>
    
        <!-- Total Section -->
        <div class="pt-6 mt-6 border-t border-gray-100">
            <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-800">Total Pembayaran</span>
                <span class="text-xl font-bold text-blue-600">Rp{{ number_format(array_sum(array_column($items, 'cost')) + 8000, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Metode Pembayaran</h3>
        
        <form action="{{ route('katalog.placeOrder', $mitra->id) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <label class="flex items-center p-4 border rounded-lg hover:border-blue-400 cursor-pointer">
                    <input type="radio" name="payment_method" value="qris" class="h-5 w-5 text-blue-500" checked>
                    <div class="ml-3">
                        <span class="font-medium text-gray-800">QRIS</span>
                        <p class="text-sm text-gray-500">Bayar menggunakan QR Code (DANA, OVO, ShopeePay)</p>
                    </div>
                    <img src="/images/qris.png" class="ml-auto h-8" alt="QRIS">
                </label>

                <label class="flex items-center p-4 border rounded-lg hover:border-blue-400 cursor-pointer">
                    <input type="radio" name="payment_method" value="cod" class="h-5 w-5 text-blue-500">
                    <div class="ml-3">
                        <span class="font-medium text-gray-800">Bayar di Tempat (COD)</span>
                        <p class="text-sm text-gray-500">Bayar ketika laundry diantar kembali</p>
                    </div>
                    <img src="/images/cash.png" class="ml-auto h-8" alt="COD">
                </label>
            </div>

            <button type="submit" class="w-full mt-6 bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors shadow-lg">
                Konfirmasi Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection