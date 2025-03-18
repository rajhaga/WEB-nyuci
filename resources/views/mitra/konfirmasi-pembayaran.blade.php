@extends('layouts.mitra')

@section('mitracontent')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold text-center mb-4">Konfirmasi Pembayaran</h2>

    <div class="bg-white p-6 shadow-lg rounded-lg">
        <h3 class="text-xl font-semibold mb-2">Detail yang Dipesan</h3>
        <p class="text-gray-700"><strong>Kode Pesanan:</strong> {{ $pesanan->kode_referral }}</p>
        <p class="text-gray-700"><strong>Tanggal:</strong> {{ $pesanan->created_at->format('d-m-Y') }}</p>

        <div class="mt-4">
            <h4 class="font-bold">Item yang Dipesan:</h4>
            <ul class="list-disc pl-5">
                @if ($pesanan->items->isNotEmpty())
                    @foreach($pesanan->items as $item)
                        <li>{{ $item->jenisPakaian->nama }} - {{ $item->jumlah }} pcs</li>
                    @endforeach
                @else
                    <p class="text-gray-500">Tidak ada item dalam pesanan.</p>
                @endif
            </ul>
        </div>

        <div class="mt-4 p-4 border rounded">
            <h4 class="font-bold">Catatan Tambahan:</h4>
            <p class="text-gray-600">{{ $pesanan->catatan ?? 'Tidak ada catatan tambahan' }}</p>
        </div>

        <div class="mt-4 p-4 border rounded">
            <h4 class="font-bold">Metode Pembayaran</h4>
            @if($pesanan->metode === 'qris')
                <img src="{{ asset('images/qris-logo.png') }}" alt="QRIS" class="w-20">
            @else
                <img src="{{ asset('images/cash-logo.png') }}" alt="Cash" class="w-20">
            @endif
        </div>        

        <div class="mt-4">
            <h4 class="text-lg font-bold">Total Biaya</h4>
            <p>Subtotal: <strong>Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong></p>
            <p>Biaya Layanan: <strong>Rp{{ number_format(8000, 0, ',', '.') }}</strong></p>
            <p class="text-xl font-bold">Total Pembayaran: Rp{{ number_format($pesanan->total_harga + 8000, 0, ',', '.') }}</p>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('pesanan.qris', ['pesanan' => $pesanan->id]) }}" 
               target="_blank" 
               class="bg-blue-600 text-white px-6 py-2 rounded">
                KONFIRMASI PEMBAYARAN
            </a>
        </div>
        
    </div>
</div>
@endsection
