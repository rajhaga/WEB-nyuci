@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <!-- Progress Steps -->
    <!-- <div class="mb-8">
        <div class="flex justify-between items-center text-sm font-medium text-gray-500">
            <div class="flex items-center">
                <div class="w-6 h-6 bg-gray-300 text-white rounded-full flex items-center justify-center">✓</div>
                <span class="ml-2">Keranjang</span>
            </div>
            <div class="flex-1 h-px bg-gray-200 mx-2"></div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-gray-300 text-white rounded-full flex items-center justify-center">✓</div>
                <span class="ml-2">Pembayaran</span>
            </div>
            <div class="flex-1 h-px bg-gray-200 mx-2"></div>
            <div class="flex items-center">
                <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center">3</div>
                <span class="ml-2">Selesai</span>
            </div>
        </div>
    </div> -->

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">
        <!-- Success Icon -->
        <div class="mb-6 flex justify-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-4">Pesanan Berhasil!</h1>
        <p class="text-gray-600 text-lg mb-8">Terima kasih telah memilih laundry kami. Pesanan Anda sedang diproses.</p>

        <!-- Order Details Card -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Nomor Pesanan</p>
                    <p class="font-semibold text-gray-800">#{{ session('orderCount', 1) }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pembayaran</p>
                    <p class="font-semibold text-blue-600 text-xl">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status Pesanan</p>
                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">{{ $pesanan->status }}</span>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Metode Pembayaran</p>
                    <p class="font-medium text-gray-800">{{ $pesanan->metode_pembayaran }}</p>
                </div>
            </div>

            <!-- Referral Section -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-sm text-gray-500 mb-2">Kode Referral Anda</p>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <span class="font-mono text-purple-600 text-lg tracking-wide">{{ $pesanan->kode_referral }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Bagikan kode ini untuk mendapatkan poin rewards</p>
            </div>
        </div>

        <!-- Next Steps -->
<div class="mb-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Apa Selanjutnya?</h3>
    <div class="flex justify-center space-x-4">
        @if($pesanan->status == 'Menunggu')
            <div class="flex items-center">
                <div class="w-8 h-8 bg-gray-300 text-white rounded-full flex items-center justify-center mr-2">1</div>
                <span class="text-gray-600">Menunggu Mitra untuk Menerima Pesanan</span>
            </div>
        @elseif($pesanan->status == 'Diterima')
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center mr-2">2</div>
                <span class="text-gray-600">Mitra Menerima Pesanan - Silakan Melakukan Pembelian</span>
            </div>
        @elseif($pesanan->status == 'Diproses')
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-100 text-blue-500 rounded-full flex items-center justify-center mr-2">3</div>
                <span class="text-gray-600">Sedang Dicuci</span>
            </div>
        @elseif($pesanan->status == 'Selesai')
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center mr-2">4</div>
                <span class="text-gray-600">Selesai Dicuci</span>
            </div>
        @elseif($pesanan->status == 'Dibatalkan')
            <div class="flex items-center">
                <div class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center mr-2">5</div>
                <span class="text-gray-600">Pesanan Dibatalkan oleh Mitra</span>
            </div>
        @endif
    </div>
</div>

        <!-- Action Buttons -->
        <div class="flex justify-center space-x-4">
            <a href="{{ route('home') }}" class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
            <button onclick="window.location.href='{{ route('download.invoice', $pesanan->id) }}'" class="px-6 py-3 border border-blue-500 text-blue-500 rounded-lg hover:bg-blue-50 transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Unduh Invoice
            </button>
        
        </div>

        <!-- Social Sharing -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <p class="text-sm text-gray-500 mb-4">Bagikan pengalaman Anda</p>
            <div class="flex justify-center space-x-4">
                <button class="text-blue-600 hover:text-blue-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </button>
                <button class="text-blue-600 hover:text-blue-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/></svg>
                </button>
                <button class="text-blue-600 hover:text-blue-700">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection