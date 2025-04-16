@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 flex gap-8">

    <!-- Sidebar Filter -->
    <aside class="w-64 bg-white p-4 rounded-lg shadow border border-gray-200">
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori:</label>
            @php
                $kategoriDipilih = request('kategori_layanan', 'semua');
                $opsiKategori = [
                    'semua' => 'Semua Kategori',
                    'cuci' => 'Cuci',
                    'setrika' => 'Setrika',
                    'cuci dan setrika' => 'Cuci dan Setrika',
                ];
            @endphp

            <div class="space-y-2">
                @foreach($opsiKategori as $key => $label)
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input
                            type="radio"
                            name="kategori_layanan"
                            value="{{ $key }}"
                            onchange="this.form.submit()"
                            {{ $kategoriDipilih === $key ? 'checked' : '' }}
                            class="text-blue-600 focus:ring-blue-500 border-gray-300"
                        >
                        <span class="text-gray-800">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

    </aside>

    <!-- Main Content -->
    <div class="flex-1">
        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-2 mb-4">
            <a href="?kategori_layanan=semua" class="px-3 py-1 rounded-full border text-sm {{ request('kategori_layanan') == 'semua' ? 'bg-blue-600 text-white' : 'text-blue-600 border-blue-600' }}">Semua</a>
            <a href="?kategori_layanan=cuci" class="px-3 py-1 rounded-full border text-sm {{ request('kategori_layanan') == 'cuci' ? 'bg-blue-600 text-white' : 'text-blue-600 border-blue-600' }}">Paket Pakaian</a>
            <a href="?kategori_layanan=setrika" class="px-3 py-1 rounded-full border text-sm {{ request('kategori_layanan') == 'setrika' ? 'bg-blue-600 text-white' : 'text-blue-600 border-blue-600' }}">Paket Rumah Tangga & Hotel</a>
            <a href="?kategori_layanan=cuci dan setrika" class="px-3 py-1 rounded-full border text-sm {{ request('kategori_layanan') == 'cuci dan setrika' ? 'bg-blue-600 text-white' : 'text-blue-600 border-blue-600' }}">Paket Sepatu & Aksesoris</a>
        </div>

        <!-- Title -->
        <h2 class="text-xl font-semibold text-blue-700 mb-6">Rekomendasi Tempat Laundry</h2>

        <!-- Catalog Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($mitras as $mitra)
                <div class="bg-white rounded-xl border shadow-sm overflow-hidden">
                    <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="w-full h-48 object-cover rounded-t-xl" alt="{{ $mitra->nama_laundry }}">
                    <div class="p-4 space-y-2">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-base text-gray-800">{{ $mitra->nama_laundry }}</h3>
                            <span class="text-sm text-blue-600">Mulai dari Rp{{ number_format($mitra->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex flex-wrap gap-1 text-xs">
                            <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">{{ $mitra->kategori_layanan }}</span>
                            @foreach($mitra->paketPakaian as $paket)
                                <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">{{ $paket->nama }}</span>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-1 text-yellow-500 text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.562-.955L10 0l2.948 5.955 6.562.955-4.755 4.635 1.123 6.545z"/></svg>
                            <span class="text-gray-700">{{ number_format($mitra->rating ?? 4.7, 1) }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">Tidak ada mitra ditemukan.</p>
            @endforelse
        </div>

        {{-- Pagination 
        <div class="mt-8 flex justify-center">
            {{ $mitras->links('vendor.pagination.tailwind') }}
        </div>--}}
    </div>
</div>
@endsection
