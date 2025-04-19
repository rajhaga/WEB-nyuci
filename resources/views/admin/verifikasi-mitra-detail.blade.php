@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-semibold">Detail Mitra - {{ $mitra->nama_laundry }}</h1>

    <!-- Mitra Details -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-lg font-medium">Owner Information</h2>
        <p><strong>Name:</strong> {{ $mitra->nama_pemilik }}</p>
        <p><strong>Email:</strong> {{ $mitra->user->email }}</p>
        <p><strong>Phone:</strong> {{ $mitra->nomor_hp }}</p>
        <p><strong>Address:</strong> {{ $mitra->alamat }}</p>

        <h2 class="text-lg font-medium mt-4">Business Details</h2>
        <p><strong>Operational Hours:</strong> {{ $mitra->jam_operasional }}</p>
        <p><strong>Service Category:</strong> {{ $mitra->kategori_layanan }}</p>
        <p><strong>Description:</strong> {{ $mitra->deskripsi }}</p>

        <!-- Action Buttons -->
        <div class="mt-4">
            <form action="{{ route('admin.verifikasiMitra.update', $mitra->id) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition duration-300">
                    Verifikasi Mitra
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
