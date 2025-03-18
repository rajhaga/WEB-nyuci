@extends('layouts.mitra')

@section('mitracontent')
        <!-- Content -->
        <main class="w-3/4 ml-6 bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold mb-4">Dashboard Mitra</h2>
            <!-- Total Saldo -->
            <div class="container mx-auto mt-6">
                <h2 class="text-xl font-semibold mb-4">Kelola Pesanan</h2>
            
                <!-- Filter buttons for order status -->
                <div class="mb-4">
                    <button class="px-4 py-2 bg-blue-500 text-white rounded">Semua</button>
                    <button class="px-4 py-2 bg-yellow-500 text-white rounded">Menunggu</button>
                    <button class="px-4 py-2 bg-orange-500 text-white rounded">Diproses</button>
                    <button class="px-4 py-2 bg-green-500 text-white rounded">Selesai</button>
                </div>
            
                <!-- Orders -->
                <div class="grid grid-cols-4 gap-4">
                    @foreach($orders as $order)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <p class="font-semibold">Kode Referral: {{ $order->kode_referral }}</p>
                        <p>Status: 
                            @if($order->status == 'Pending')
                            <span class="text-yellow-500">{{ $order->status }}</span>
                            @elseif($order->status == 'Diproses')
                            <span class="text-orange-500">{{ $order->status }}</span>
                            @elseif($order->status == 'Selesai')
                            <span class="text-green-500">{{ $order->status }}</span>
                            @else
                            <span class="text-gray-500">{{ $order->status }}</span>
                            @endif
                        </p>
                        <p>Tanggal Pemesanan: {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</p>
                        <p>Total Biaya: Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        <p>Metode Pembayaran: {{ $order->metode_pembayaran }}</p>
                        <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Perbarui Status</button>
                    </div>
                    @endforeach
                </div>
            
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            </div>

        </main>
    </div>
@endsection
