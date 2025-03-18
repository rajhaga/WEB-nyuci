@extends('layouts.mitra')

@section('mitracontent')
<div class="container">
    <h2 class="text-lg font-bold mb-4">Daftar Pesanan Belum Dibayar</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($pesananBelumDibayar->isEmpty())
        <p class="text-gray-500">Tidak ada pesanan yang belum dibayar.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($pesananBelumDibayar as $pesanan)
                <div class="p-4 bg-white shadow-md rounded-lg">
                    <h3 class="text-lg font-semibold">Kode: {{ $pesanan->kode_referral }}</h3>
                    <p><strong>Total:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                    <p><strong>Metode:</strong> {{ $pesanan->metode_pembayaran }}</p>
                    <p><strong>Status:</strong> <span class="text-red-500 font-semibold">{{ $pesanan->status }}</span></p>
                    
                    <form action="{{ route('mitra.konfirmasiPembayaran', $pesanan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">
                            KONFIRMASI PEMBAYARAN
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
