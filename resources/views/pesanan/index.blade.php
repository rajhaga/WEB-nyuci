@extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Lacak Pesanan</h1>
    <p class="text-gray-600 mb-6">Lacak pesananmu untuk mengetahui status pesanan laundry-mu secara real-time.</p>
    @foreach($pesanan as $order)
@endforeach

    <!-- Status Filter -->
    <form action="{{ route('lacak.pesanan') }}" method="GET" class="flex space-x-3 mb-6">
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 hover:shadow-lg transition">Semua</button>
        <button type="submit" name="status" value="Menunggu" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 hover:shadow-lg transition">Menunggu</button>
        <button type="submit" name="status" value="Diterima" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 hover:shadow-lg transition">Diterima</button>
        <button type="submit" name="status" value="Diproses" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 hover:shadow-lg transition">Diproses</button>
        <button type="submit" name="status" value="Selesai" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 hover:shadow-lg transition">Selesai</button>
        <button type="submit" name="status" value="Dibatalkan" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg shadow hover:bg-gray-300 hover:shadow-lg transition">Dibatalkan</button>
    </form>

    <!-- Orders List -->
    <div class="grid grid-cols-1 md-grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($pesanan as $order)
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <h2 class="text-lg font-semibold text-gray-800">{{ $order->mitra->nama }}</h2>
                <div class="flex flex-wrap gap-2 mt-2">
                    @foreach($order->pesananItems as $item)
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-lg text-sm">{{ $item->jenisPakaian->nama }}</span>
                    @endforeach
                </div>
                <p class="mt-2 text-gray-700"><strong>Status:</strong> <span class="font-semibold text-{{ $order->status == 'Menunggu' ? 'red-500' : ($order->status == 'Diterima' ? 'green-500' : ($order->status == 'Diproses' ? 'yellow-500' : 'blue-500')) }}">{{ $order->status }}</span></p>
                <p class="text-gray-700"><strong>Kode Referral:</strong> {{ $order->kode_referral }}</p>
                <p class="text-gray-700"><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                <p class="text-gray-700"><strong>Total Biaya:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                <p class="text-gray-700"><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran ?? 'Bayar ditempat' }}</p>
                @if($order->status == 'Diterima')
                    {{-- <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Bayar</button> --}}
                    <button class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg">Diterima</button>
                @elseif($order->status == 'Selesai')
                    <button class="mt-4 w-full bg-green-500 text-white py-2 rounded-lg">Nilai</button>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection

