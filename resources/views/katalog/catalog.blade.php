@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 flex">
    <!-- Sidebar Filter -->
    <div class="w-1/4 pr-4">
        <h2 class="text-lg font-bold mb-4">Filter</h2>
        <form method="GET" action="{{ route('catalog') }}" class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold mb-2">Tipe Toko</h3>
                <label class="flex items-center">
                    <input type="checkbox" name="tipe_toko" value="semua" {{ request('tipe_toko') == 'semua' ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="ml-2">Semua</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="tipe_toko" value="terdekat" {{ request('tipe_toko') == 'terdekat' ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="ml-2">Terdekat</span>
                </label>
            </div>
        </form>
    </div>
    
    <!-- Main Content -->
    <div class="w-3/4">
        <!-- Filter Kategori -->
        <form method="GET" action="{{ route('catalog') }}" class="flex space-x-4 mb-6">
            <button type="submit" name="kategori" value="semua" class="px-4 py-2 rounded-md {{ request('kategori') == 'semua' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}">Semua</button>
            <button type="submit" name="kategori" value="paket_pakaian" class="px-4 py-2 rounded-md {{ request('kategori') == 'paket_pakaian' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}">Paket Pakaian</button>
            <button type="submit" name="kategori" value="paket_rumah_tangga" class="px-4 py-2 rounded-md {{ request('kategori') == 'paket_rumah_tangga' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}">Paket Rumah Tangga & Hotel</button>
            <button type="submit" name="kategori" value="paket_sepatu" class="px-4 py-2 rounded-md {{ request('kategori') == 'paket_sepatu' ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-700' }}">Paket Sepatu & Aksesoris</button>
        </form>

        <!-- Main Content -->
        <div class="w-3/4">
            <h1 class="text-2xl font-bold mb-6">Rekomendasi Tempat Laundry</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($mitras as $mitra)
                    @if((request('kategori_layanan') == 'semua' || request('kategori_layanan') == null || $mitra->kategori == request('kategori_layanan')) && (request('tipe_toko') == 'semua' || request('tipe_toko') == null || $mitra->tipe == request('tipe_toko')))
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="w-full h-48 object-cover" alt="{{ $mitra->nama_laundry }}">
                            <div class="p-4">
                                <h5 class="text-lg font-semibold">{{ $mitra->nama_laundry }}</h5>
                                <p class="text-blue-600 font-bold mt-2">Mulai dari Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($mitra->paketPakaian as $paket)
                                        <span class="bg-blue-100 text-blue-700 px-2 py-1 text-xs rounded-md">{{ $paket->nama }}</span>
                                    @endforeach
                                </div>
                                <div class="flex items-center mt-3">
                                    <span class="text-yellow-500 text-lg">&#9733;</span>
                                    <span class="ml-2 text-gray-600 text-sm">{{ $mitra->rating }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-6 space-x-2">
        <!-- Tombol Previous -->
        <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            &#9664;
        </button>

        <!-- Nomor Halaman -->
        <button class="px-4 py-2 bg-blue-600 text-white rounded-md">1</button>
        <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">2</button>
        <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">3</button>
        <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">4</button>
        <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">5</button>

        <!-- Tombol Next -->
        <button class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            &#9654;
        </button>
    </div>
        </div>
    </div>
</div>
@endsection
