@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-semibold">Verifikasi Mitra</h1>

    <!-- Check if there are any mitra to verify -->
    @if($mitraList->isEmpty())
        <!-- If no mitra, display a message -->
        <p class="text-center text-gray-500">Tidak ada mitra yang perlu diverifikasi.</p>
    @else
        <!-- Mitra List -->
        <div class="mt-6 grid grid-cols-3 gap-4">
            @foreach($mitraList as $mitra)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-medium">{{ $mitra->nama_laundry }}</h2>
                    <p>Owner: {{ $mitra->nama_pemilik }}</p>
                    <p>Status: {{ ucfirst($mitra->status_registration_mitra) }}</p>

                    <!-- Verify Button -->
                    @if($mitra->status_registration_mitra === 'pending')
                        <a href="{{ route('admin.verifikasiMitraDetail', $mitra->id) }}" class="text-blue-500">Verifikasi</a>
                    @else
                        <p class="text-green-500">Verified</p>
                    @endif

                    <!-- Button to View More Details -->
                    <a href="{{ route('admin.verifikasiMitraDetail', $mitra->id) }}" class="text-blue-500 mt-2 block">View Details</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
