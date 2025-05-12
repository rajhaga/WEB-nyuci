@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Detail Mitra - {{ $mitra->nama_laundry }}</h1>

    <!-- Mitra Details Section -->
    <div class="mt-6 bg-white p-6 rounded-lg shadow-md space-y-6">

        <!-- Owner Information Card -->
        <div class="space-y-4">
            <h2 class="text-lg font-medium text-gray-700">Owner Information</h2>
            <p><strong>Name:</strong> {{ $mitra->nama_pemilik }}</p>
            <p><strong>Email:</strong> {{ $mitra->user->email }}</p>
            <p><strong>Phone:</strong> {{ $mitra->nomor_hp }}</p>
            <p><strong>Address:</strong> {{ $mitra->alamat }}</p>
        </div>

        <!-- Business Details Card -->
        <div class="space-y-4">
            <h2 class="text-lg font-medium text-gray-700">Business Details</h2>
            <p><strong>Operational Hours:</strong> {{ $mitra->jam_operasional }}</p>
            <p><strong>Service Category:</strong> {{ $mitra->kategori_layanan }}</p>
            <p><strong>Description:</strong> {{ $mitra->deskripsi }}</p>

            <!-- Optional Images (Place and Proof) -->
            @if($mitra->foto_tempat || $mitra->foto_bukti)
                <div class="mt-4">
                    <h3 class="text-sm font-medium text-gray-600">Photos</h3>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        @if($mitra->foto_tempat)
                            <div>
                                <h4 class="text-md font-medium text-gray-700">Place Photo</h4>
                                <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" alt="Place Photo" class="rounded-lg shadow-md w-full h-auto">
                            </div>
                        @endif
                        @if($mitra->foto_bukti)
                            <div>
                                <h4 class="text-md font-medium text-gray-700">Proof Photo</h4>
                                <img src="{{ asset('storage/' . $mitra->foto_bukti) }}" alt="Proof Photo" class="rounded-lg shadow-md w-full h-auto">
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Verification Action Button -->
        <div class="mt-6 flex justify-start">
            <form action="{{ route('admin.verifikasi', $mitra->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                    Verifikasi Mitra
                </button>
            </form>
        </div>

        <!-- Delete Action Button (Update Status to 'Ditolak') -->
        <div class="mt-6 flex justify-start">
            <form action="{{ route('admin.deleteMitra', $mitra->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition duration-300">
                    Hapus Mitra (Tolak)
                </button>
            </form>
        </div>

        <!-- Success or Error Message -->
        @if(session('success'))
            <div class="mt-4 text-green-600">
                <p>{{ session('success') }}</p>
            </div>
        @elseif(session('error'))
            <div class="mt-4 text-red-600">
                <p>{{ session('error') }}</p>
            </div>
        @endif

    </div>
</div>
@endsection
