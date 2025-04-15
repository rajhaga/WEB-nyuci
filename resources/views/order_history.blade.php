@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5f5f5] text-black flex justify-center px-4 sm:px-6 lg:px-8 py-8">
    <main class="w-full max-w-5xl">
        <h1 class="text-2xl sm:text-3xl font-semibold text-blue-500 mb-6">Riwayat Pesanan</h1>

        <!-- Filter Status -->
        <div class="flex flex-wrap gap-2 mb-6">
            @php
                $statuses = ['' => 'Semua', 'Menunggu' => 'Menunggu', 'Dibayar' => 'Dibayar', 'Diproses' => 'Diproses', 'Selesai' => 'Selesai'];
                $currentStatus = request('status');
            @endphp

            @foreach($statuses as $key => $label)
                <a href="{{ url()->current() }}{{ $key !== '' ? '?status=' . $key : '' }}"
                   class="px-4 py-2 rounded-xl text-sm font-medium border
                   {{ $currentStatus === $key || ($key === '' && $currentStatus === null) ? 'bg-blue-500 text-white border-transparent' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- List Pesanan -->
        <div class="space-y-4">
            @forelse($pesanans as $pesanan)
                <div class="bg-white rounded-md shadow-sm border border-gray-200 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                        <div class="flex-1">
                            <p class="text-sm text-gray-400">Kode Referral</p>
                            <p class="text-base font-medium text-gray-800">{{ $pesanan->kode_referral }}</p>
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-400">Harga</p>
                            <p class="text-base font-medium text-gray-800">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-400">Tanggal Pemesanan</p>
                            <p class="text-base font-medium text-gray-800">{{ $pesanan->created_at->format('Y-m-d') }}</p>
                        </div>

                        <div class="flex-1">
                            <p class="text-sm text-gray-400">Status</p>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                                @if($pesanan->status == 'Menunggu') bg-red-100 text-red-600
                                @elseif($pesanan->status == 'Dibayar') bg-green-100 text-green-600
                                @elseif($pesanan->status == 'Diproses') bg-yellow-100 text-yellow-600
                                @elseif($pesanan->status == 'Selesai') bg-blue-100 text-blue-600
                                @else bg-gray-100 text-gray-600
                                @endif">
                                {{ $pesanan->status }}
                            </span>
                        </div>

                        <div class="w-full sm:w-auto flex justify-start sm:justify-center">
                            @if($pesanan->status === 'Selesai')
                                <a href="#" class="text-sm text-white bg-blue-500 hover:bg-blue-700 transition px-4 py-2 rounded-md">
                                    Ulas Pesanan
                                </a>
                            @else
                                <span class="invisible text-sm px-4 py-2">Ulas Pesanan</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Tidak ada pesanan ditemukan.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center gap-4 items-center">
            <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 px-3 py-1 rounded">←</button>
            <span class="font-semibold text-gray-800">1</span>
            <button class="bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 px-3 py-1 rounded">→</button>
        </div>
    </main>
</div>
@endsection
