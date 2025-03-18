@extends('layouts.app')

@section('content')
{{-- <form method="GET" action="{{ route('catalog') }}">
    <div class="container">
        <h1 class="my-4">Katalog Laundry Mitra</h1>

        <!-- Filter Kategori -->
        <div class="mb-4">
            <label for="filterKategori">Filter Kategori:</label>
            <select name="kategori_layanan" id="filterKategori" class="form-control" onchange="this.form.submit()">
                <option value="semua" {{ request('kategori_layanan') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                <option value="cuci" {{ request('kategori_layanan') == 'cuci' ? 'selected' : '' }}>Cuci</option>
                <option value="setrika" {{ request('kategori_layanan') == 'setrika' ? 'selected' : '' }}>Setrika</option>
                <option value="cuci dan setrika" {{ request('kategori_layanan') == 'cuci dan setrika' ? 'selected' : '' }}>Cuci dan Setrika</option>
            </select>
        </div>

        <!-- Filter Paket Layanan -->
        <div class="mb-4">
            <label for="filterPaket">Filter Paket Layanan:</label>
            <select name="paket_layanan" id="filterPaket" class="form-control" onchange="this.form.submit()">
                <option value="semua" {{ request('paket_layanan') == 'semua' ? 'selected' : '' }}>Semua Paket</option>
                <option value="1" {{ request('paket_layanan') == '1' ? 'selected' : '' }}>Paket Pakaian</option>
                <option value="2" {{ request('paket_layanan') == '2' ? 'selected' : '' }}>Paket Rumah Tangga</option>
                <option value="3" {{ request('paket_layanan') == '3' ? 'selected' : '' }}>Paket Sepatu & Aksesoris</option>
            </select>
        </div>

        <!-- Daftar Laundry Mitra -->
        <div class="row">
            @foreach($mitras as $mitra)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="card-img-top" alt="{{ $mitra->nama_laundry }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $mitra->nama_laundry }}</h5>
                            <p class="card-text">{{ $mitra->deskripsi }}</p>
                            <p class="card-text"><strong>Harga mulai dari: Rp{{ number_format($mitra->harga, 0, ',', '.') }}</strong></p>

                            <!-- Daftar Paket Pakaian dan Jenis Pakaian -->
                            <h6>Paket Pakaian dan Jenis Pakaian:</h6>
                            @foreach($mitra->paketPakaian as $paket)
                                <div>
                                    <h6>{{ $paket->nama }}</h6>
                                    <ul>
                                        @foreach($paket->jenisPakaian as $jenis)
                                            <li>{{ $jenis->nama }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach

                            <a href="{{ route('katalog.detail', $mitra->id) }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</form> --}}

<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold text-center mb-6">Katalog Laundry Mitra</h1>
    
    <form method="GET" action="{{ route('catalog') }}" class="space-y-4 mb-6">
        <div>
            <label for="filterKategori" class="block text-sm font-medium text-gray-700">Filter Kategori:</label>
            <select name="kategori_layanan" id="filterKategori" class="w-full p-2 border rounded-md" onchange="this.form.submit()">
                <option value="semua" {{ request('kategori_layanan') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                <option value="cuci" {{ request('kategori_layanan') == 'cuci' ? 'selected' : '' }}>Cuci</option>
                <option value="setrika" {{ request('kategori_layanan') == 'setrika' ? 'selected' : '' }}>Setrika</option>
                <option value="cuci dan setrika" {{ request('kategori_layanan') == 'cuci dan setrika' ? 'selected' : '' }}>Cuci dan Setrika</option>
            </select>
        </div>
        <div>
            <label for="filterPaket" class="block text-sm font-medium text-gray-700">Filter Paket Layanan:</label>
            <select name="paket_layanan" id="filterPaket" class="w-full p-2 border rounded-md" onchange="this.form.submit()">
                <option value="semua" {{ request('paket_layanan') == 'semua' ? 'selected' : '' }}>Semua Paket</option>
                <option value="1" {{ request('paket_layanan') == '1' ? 'selected' : '' }}>Paket Pakaian</option>
                <option value="2" {{ request('paket_layanan') == '2' ? 'selected' : '' }}>Paket Rumah Tangga</option>
                <option value="3" {{ request('paket_layanan') == '3' ? 'selected' : '' }}>Paket Sepatu & Aksesoris</option>
            </select>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($mitras as $mitra)
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="w-full h-48 object-cover" alt="{{ $mitra->nama_laundry }}">
                <div class="p-4">
                    <h5 class="text-lg font-semibold">{{ $mitra->nama_laundry }}</h5>
                    <p class="text-gray-600 text-sm">{{ $mitra->deskripsi }}</p>
                    <p class="text-blue-600 font-bold mt-2">Harga mulai dari: Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
                    
                    <h6 class="text-sm font-semibold mt-3">Paket Pakaian dan Jenis Pakaian:</h6>
                    @foreach($mitra->paketPakaian as $paket)
                        <div class="mt-2">
                            <h6 class="text-sm font-medium">{{ $paket->nama }}</h6>
                            <ul class="list-disc pl-5 text-sm text-gray-600">
                                @foreach($paket->jenisPakaian as $jenis)
                                    <li>{{ $jenis->nama }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                    
                    <a href="{{ route('katalog.detail', $mitra->id) }}" class="block text-center mt-4 bg-blue-500 text-white py-2 rounded-md hover:bg-blue-600 transition">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
