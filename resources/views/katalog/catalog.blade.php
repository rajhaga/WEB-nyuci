@extends('layouts.app')

@section('content')
<div class="flex">
    {{-- Sidebar Filter --}}
    <div class="w-1/5 p-6 border-r bg-gray-50">
    <h2 class="text-lg font-semibold mb-4 flex items-center gap-2">
        <i class="fas fa-filter text-blue-600"></i> Filter
    </h2>
    <h3 class="text-sm font-semibold text-gray-700 mb-2">Kategori Layanan</h3>
    <form method="GET" action="{{ route('catalog') }}" class="space-y-4 mb-6">
        <div>
            <div class="space-y-2">
                @php
                    $selectedKategori = request()->get('kategori_layanan', []);
                    if (!is_array($selectedKategori)) {
                        $selectedKategori = [$selectedKategori];
                    }
                @endphp

                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="kategori_layanan[]" value="cuci"
                        {{ in_array('cuci', $selectedKategori) ? 'checked' : '' }}
                        onchange="this.form.submit()" />
                    <span>Cuci</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="kategori_layanan[]" value="setrika"
                        {{ in_array('setrika', $selectedKategori) ? 'checked' : '' }}
                        onchange="this.form.submit()" />
                    <span>Setrika</span>
                </label>
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="kategori_layanan[]" value="cuci dan setrika"
                        {{ in_array('cuci dan setrika', $selectedKategori) ? 'checked' : '' }}
                        onchange="this.form.submit()" />
                    <span>Cuci dan Setrika</span>
                </label>
            </div>
        </div>
    </form>
</div>

    {{-- Konten Utama --}}
    <div class="w-4/5 p-6">
        {{-- Filter Tab --}}
        <form method="GET" action="{{ route('catalog') }}" class="mb-6">
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

        {{-- Judul --}}
        <h2 class="text-lg font-bold text-blue-700 mb-4">Rekomendasi Tempat Laundry</h2>

        {{-- Daftar Katalog --}}
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

        {{-- Pagination Custom 
        <div class="mt-8 flex justify-center items-center gap-2">
            @if ($mitras->onFirstPage())
                <button class="text-white bg-gray-300 px-3 py-1 rounded" disabled><i class="fas fa-chevron-left"></i></button>
            @else
                <a href="{{ $mitras->previousPageUrl() }}" class="text-white bg-blue-500 px-3 py-1 rounded hover:bg-blue-600"><i class="fas fa-chevron-left"></i></a>
            @endif

            @for ($i = 1; $i <= $mitras->lastPage(); $i++)
                <a href="{{ $mitras->url($i) }}" class="px-3 py-1 rounded text-sm {{ $i == $mitras->currentPage() ? 'bg-blue-200 text-blue-800' : 'text-gray-600 hover:bg-gray-100' }}">
                    {{ $i }}
                </a>
            @endfor

            @if ($mitras->hasMorePages())
                <a href="{{ $mitras->nextPageUrl() }}" class="text-white bg-blue-500 px-3 py-1 rounded hover:bg-blue-600"><i class="fas fa-chevron-right"></i></a>
            @else
                <button class="text-white bg-gray-300 px-3 py-1 rounded" disabled><i class="fas fa-chevron-right"></i></button>
            @endif
        </div>--}}
    </div>
</div>
@endsection
