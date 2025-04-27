@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 flex flex-col md:flex-row gap-4 md:gap-8">
    <!-- Mobile Filter Toggle Button -->
    <div class="md:hidden flex items-center gap-2">
        <button id="filter-toggle" class="flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
            Filter
        </button>
    </div>

    <!-- Sidebar Filter -->
    <aside id="sidebar-filter" class="hidden md:block w-full md:w-64 bg-white p-4 rounded-lg shadow border border-gray-200">
        <form method="GET" action="{{ route('catalog') }}" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Layanan:</label>
                @php
                    $kategoriDipilih = request('kategori_layanan', 'semua');
                    $opsiKategori = [
                        'semua' => 'Semua',
                        'cuci' => 'Cuci',
                        'setrika' => 'Setrika',
                        'cuci dan setrika' => 'Cuci dan Setrika',
                    ];
                @endphp
                <div class="space-y-2">
                    @foreach($opsiKategori as $key => $label)
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="radio" name="kategori_layanan" value="{{ $key }}"
                                onchange="this.form.submit()"
                                {{ $kategoriDipilih === $key ? 'checked' : '' }}
                                class="text-blue-600 focus:ring-blue-500 border-gray-300">
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </form>
    </aside>

    <!-- Main Content -->
    <div class="flex-1">
        <!-- Desktop Filter Buttons -->
        <div class="hidden md:flex flex-wrap gap-2 mb-4">
            @php
                $paketDipilih = request('paket_layanan', 'semua');
                $opsiPaket = [
                    'semua' => 'Semua',
                    'Paket Pakaian' => 'Paket Pakaian',
                    'Paket Rumah Tangga & Hotel' => 'Paket Rumah Tangga & Hotel',
                    'Paket Sepatu & Aksesoris' => 'Paket Sepatu & Aksesoris',
                ];
            @endphp
            @foreach($opsiPaket as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['paket_layanan' => $key]) }}"
                    class="px-6 py-2 rounded-xl border text-md {{ $paketDipilih === $key ? 'bg-blue-600 text-white' : 'text-blue-600 border-blue-600' }}">
                   {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Title -->
        <h2 class="text-xl font-semibold text-blue-700 mb-6">Rekomendasi Tempat Laundry</h2>

        <!-- Catalog Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($mitras as $mitra)
                <a href="{{ route('katalog.detail', $mitra->id) }}" class="block bg-white rounded-xl border shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="w-full h-48 object-cover" alt="{{ $mitra->nama_laundry }}">
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
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 15l-5.878 3.09 1.123-6.545L.49 6.91l6.562-.955L10 0l2.948 5.955 6.562.955-4.755 4.635 1.123 6.545z"/>
                            </svg>
                            <span class="text-gray-700">{{ number_format($mitra->rating ?? 4.7, 1) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">Tidak ada mitra ditemukan.</p>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $mitras->withQueryString()->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterToggle = document.getElementById('filter-toggle');
        const sidebarFilter = document.getElementById('sidebar-filter');
        
        if (filterToggle && sidebarFilter) {
            filterToggle.addEventListener('click', function() {
                sidebarFilter.classList.toggle('hidden');
            });
        }
    });
</script>
@endsection
