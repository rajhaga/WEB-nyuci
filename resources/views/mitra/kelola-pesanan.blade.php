@extends('layouts.mitra')

@section('mitracontent')
<main class="w-3/4 ml-6 bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Kelola Pesanan</h2>
    <div class="mb-4 flex gap-2">
        <a href="{{ route('mitra.kelolaPesanan') }}" class="px-4 py-2 bg-gray-300 text-black rounded">Semua</a>
        <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Diproses']) }}" class="px-4 py-2 bg-green-500 text-white rounded">Diproses</a>
        <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Selesai']) }}" class="px-4 py-2 bg-blue-500 text-white rounded">Selesai</a>
        <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Dibatalkan']) }}" class="px-4 py-2 bg-red-500 text-white rounded">Dibatalkan</a>
    </div>
    <div class="grid grid-cols-4 gap-4">
        @foreach($orders as $order)
            <div class="bg-white p-4 rounded-lg shadow-md">
                <p class="font-semibold">Kode Referral: {{ $order->kode_referral }}</p>
                <p>Status: <span class="text-gray-700">{{ $order->status }}</span></p>
                <p>Total Biaya: Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                <p>Metode Pembayaran: {{ $order->metode_pembayaran }}</p>

                <a href="{{ route('mitra.editStatus', $order->id) }}" class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded">
                    Perbarui Status
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</main>
@endsection
