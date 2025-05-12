@extends('layouts.mitra')

@section('mitracontent')
<div class="min-h-screen p-6 animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8 animate-fade-in-down">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Kelola Pesanan
                </h1>
                <p class="text-gray-600 mt-1">Kelola semua pesanan pelanggan Anda</p>
            </div>
            <div class="relative mb-6">
                <form method="GET" action="{{ route('mitra.kelolaPesanan') }}" class="flex items-center">
                    <input 
                        type="text" 
                        name="search"
                        placeholder="Cari pesanan..." 
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                        value="{{ request()->get('search') }}" 
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </form>
            </div>            
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <div class="mb-6 animate-fade-in-down animation-delay-100">
        <div class="flex flex-wrap gap-2">
            <!-- Filter Links for Different Statuses -->
            <a href="{{ route('mitra.kelolaPesanan') }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === null ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Diproses']) }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === 'Diproses' ? 'bg-orange-600 text-white shadow-md' : 'bg-orange-100 text-orange-700 hover:bg-orange-200' }}">
                Diproses
            </a>
            <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Selesai']) }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === 'Selesai' ? 'bg-green-600 text-white shadow-md' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
                Selesai
            </a>
            <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Dibatalkan']) }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === 'Dibatalkan' ? 'bg-red-600 text-white shadow-md' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                Dibatalkan
            </a>
        </div>
    </div>

    <!-- Orders Grid -->
    @if($orders->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        @foreach($orders as $order)
            <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all hover:scale-105 animate-fade-in animation-delay-{{ ($loop->index % 4) * 100 + 200 }}">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <div>
                        <span class="text-xs font-semibold text-gray-500">ORDER #{{ $order->kode_referral }}</span>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full 
                        @if($order->status === 'Selesai') bg-green-100 text-green-800
                        @elseif($order->status === 'Diproses') bg-orange-100 text-orange-800
                        @elseif($order->status === 'Dibatalkan') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ $order->status }}
                    </span>
                </div>
                <!-- Order Details -->
                <div class="px-6 py-4">
                    <div class="flex justify-between mb-3">
                        <span class="text-sm text-gray-500">Tanggal</span>
                        <span class="text-sm font-medium">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between mb-3">
                        <span class="text-sm text-gray-500">Total</span>
                        <span class="text-sm font-bold">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Pembayaran</span>
                        <span class="text-sm font-medium">{{ $order->metode_pembayaran }}</span>
                    </div>
                </div>
                <!-- Order Actions -->
                <div class="px-6 py-4 bg-gray-50 flex justify-center"> 
                    <a href="{{ route('mitra.editStatus', $order->id) }}" class="w-full px-3 py-3 bg-indigo-600 text-white text-sm rounded-xl text-center hover:bg-indigo-700 transition-colors flex items-center justify-center">
                        Update
                    </a>
                </div>
            </div>
        @endforeach
    </div>
    @else
    <div class="bg-white rounded-xl shadow-md p-12 text-center animate-fade-in animation-delay-200">
        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pesanan</h3>
        <p class="mt-1 text-sm text-gray-500">
            @if(request()->status)
                Tidak ada pesanan dengan status "{{ request()->status }}"
            @else
                Belum ada pesanan yang diterima
            @endif
        </p>
    </div>
    @endif

    <!-- Pagination -->
    {{ $orders->links() }}
</div>
@endsection
