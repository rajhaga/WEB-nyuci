@extends('layouts.app')

@section('content')
<div class="flex">
    {{-- Sidebar Filter --}}
    <div class="w-1/5 p-6 border-r bg-gray-50">
        <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
            <i class="fas fa-filter text-blue-600"></i> Filter
        </h2>

        {{-- Filter Kategori --}}
        <form method="GET" action="{{ route('catalog') }}">
            <h3 class="text-sm font-semibold text-gray-700 mb-2">Kategori Layanan</h3>
            <select name="kategori_layanan" class="w-full mb-4 text-sm p-2 border rounded-md" onchange="this.form.submit()">
                <option value="semua" {{ request('kategori_layanan') == 'semua' ? 'selected' : '' }}>Semua</option>
                <option value="cuci" {{ request('kategori_layanan') == 'cuci' ? 'selected' : '' }}>Cuci</option>
                <option value="setrika" {{ request('kategori_layanan') == 'setrika' ? 'selected' : '' }}>Setrika</option>
                <option value="cuci dan setrika" {{ request('kategori_layanan') == 'cuci dan setrika' ? 'selected' : '' }}>Cuci dan Setrika</option>
            </select>
        </form>

        {{-- Checkbox (Dummy/Optional Future Feature) --}}
        <h3 class="text-sm font-semibold text-gray-700 mb-2">Tipe Toko</h3>
        <div class="space-y-2 text-sm text-gray-600">
            <label><input type="checkbox" disabled> Semua</label><br>
            <label><input type="checkbox" disabled> Terdekat</label>
        </div>
    </div>

    {{-- Konten Utama --}}
    <div class="w-4/5 p-6">
        {{-- Filter Tab Paket --}}
        <form method="GET" action="{{ route('catalog') }}" class="mb-6">
            <input type="hidden" name="kategori_layanan" value="{{ request('kategori_layanan') }}">
            <div class="flex flex-wrap items-center gap-2">
                <button name="paket_layanan" value="semua" class="px-3 py-1 rounded-md text-sm border {{ request('paket_layanan') == 'semua' ? 'bg-blue-600 text-white' : 'text-gray-700 border-gray-300' }}">
                    Semua
                </button>
                <button name="paket_layanan" value="1" class="px-3 py-1 rounded-md text-sm border {{ request('paket_layanan') == '1' ? 'bg-blue-600 text-white' : 'text-gray-700 border-gray-300' }}">
                    Paket Pakaian
                </button>
                <button name="paket_layanan" value="2" class="px-3 py-1 rounded-md text-sm border {{ request('paket_layanan') == '2' ? 'bg-blue-600 text-white' : 'text-gray-700 border-gray-300' }}">
                    Paket Rumah Tangga & Hotel
                </button>
                <button name="paket_layanan" value="3" class="px-3 py-1 rounded-md text-sm border {{ request('paket_layanan') == '3' ? 'bg-blue-600 text-white' : 'text-gray-700 border-gray-300' }}">
                    Paket Sepatu & Aksesoris
                </button>
            </div>
        </form>

        <h2 class="text-lg font-bold text-blue-700 mb-4">Rekomendasi Tempat Laundry</h2>

        {{-- Daftar Mitra --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($mitras as $mitra)
                <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
                    <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" alt="{{ $mitra->nama_laundry }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800">{{ $mitra->nama_laundry }}</h3>
                        <p class="text-sm text-blue-700 font-semibold">Mulai dari Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
                        <div class="flex flex-wrap mt-2 gap-2 text-xs">
                            @foreach($mitra->paketPakaian as $paket)
                                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded">{{ $paket->nama }}</span>
                            @endforeach
                            @foreach($mitra->paketPakaian as $paket)
                                @foreach($paket->jenisPakaian as $jenis)
                                    <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded">{{ $jenis->nama }}</span>
                                @endforeach
                            @endforeach
                        </div>
                        <div class="flex items-center text-sm text-yellow-500 mt-3">
                            ★ {{ $mitra->rating ?? '4.7' }}
                        </div>
                        <a href="{{ route('katalog.detail', $mitra->id) }}" class="block text-center mt-3 bg-blue-500 text-white text-sm py-2 rounded hover:bg-blue-600 transition">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        {{-- <div class="mt-8 flex justify-center items-center gap-2">
            {{ $mitras->withQueryString()->links() }}
        </div> --}}
    </div>
</div>
@endsection
