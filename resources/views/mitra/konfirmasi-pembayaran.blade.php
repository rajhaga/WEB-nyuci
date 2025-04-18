@extends('layouts.mitra')

@section('mitracontent')
<div class="container mx-auto p-4 md:p-6 max-w-4xl">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="bg-blue-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white text-center">Konfirmasi Pembayaran</h2>
        </div>

        <div class="p-6 md:p-8">
            <!-- Order Summary -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold mb-4 pb-2 border-b border-gray-200">Detail Pesanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <p class="text-gray-600"><strong>Kode Pesanan:</strong></p>
                        <p class="text-blue-600 font-medium">{{ $pesanan->kode_referral }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><strong>Tanggal Pesanan:</strong></p>
                        <p class="text-gray-800">{{ $pesanan->created_at->format('d F Y H:i') }}</p>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="font-bold text-lg mb-2">Item Pesanan:</h4>
                    <ul class="divide-y divide-gray-100">
                        @forelse($pesanan->items as $item)
                        <li class="py-3 flex justify-between">
                            <span>{{ $item->jenisPakaian->nama }}</span>
                            <span class="font-medium">{{ $item->jumlah }} pcs</span>
                        </li>
                        @empty
                        <li class="py-3 text-gray-500">Tidak ada item dalam pesanan.</li>
                        @endforelse
                    </ul>
                </div>

                @if($pesanan->catatan)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <h4 class="font-bold text-yellow-800">Catatan Tambahan:</h4>
                    <p class="text-yellow-700">{{ $pesanan->catatan }}</p>
                </div>
                @endif
            </div>

            <!-- Payment Method Section -->
            <div class="mb-8 p-5 border border-gray-200 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Metode Pembayaran</h3>
                
                <div class="flex flex-col items-center space-y-4">
                    @if($pesanan->metode_pembayaran === 'qris')
                    <div class="text-center">
                        <img src="{{ asset('images/qris-logo.png') }}" alt="QRIS" class="w-24 mx-auto mb-3">
                        <p class="text-gray-700">Pembayaran via QRIS</p>
                    </div>
                    <a href="{{ route('pesanan.qris', $pesanan) }}" 
                       target="_blank"
                       class="w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd" />
                        </svg>
                        Lihat QRIS Pembayaran
                    </a>
                    @else
                    <div class="text-center">
                        <img src="{{ asset('images/cash-logo.png') }}" alt="Cash" class="w-24 mx-auto mb-3">
                        <p class="text-gray-700">Pembayaran Cash (COD)</p>
                    </div>
                    <a href="{{ route('pesanan.cod', $pesanan) }}" 
                       class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                        </svg>
                        Instruksi Pembayaran COD
                    </a>
                    @endif
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="bg-gray-50 p-5 rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Ringkasan Pembayaran</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Biaya Layanan:</span>
                        <span class="font-medium">Rp{{ number_format(8000, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-200 my-2"></div>
                    <div class="flex justify-between text-lg">
                        <span class="font-bold">Total Pembayaran:</span>
                        <span class="font-bold text-blue-600">Rp{{ number_format($pesanan->total_harga + 8000, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
