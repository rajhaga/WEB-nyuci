@extends('layouts.admin')

@section('admincontent')
<div class="container mx-auto p-6">
    <h1 class="text-xl font-semibold">Verifikasi Mitra</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($mitraList->isEmpty())
        <p class="text-center text-gray-500">Tidak ada mitra yang perlu diverifikasi.</p>
    @else
        <div class="mt-6 grid grid-cols-3 gap-4">
            @foreach($mitraList as $mitra)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-medium">{{ $mitra->nama_laundry }}</h2>
                    <p>Owner: {{ $mitra->nama_pemilik }}</p>
                    <p>Status: {{ ucfirst($mitra->user->status) }}</p>

                    <div class="mt-4 flex space-x-2">
                        <a href="{{ route('admin.verifikasiMitraDetail', $mitra->id) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded">Detail</a>

                        <form action="{{ route('admin.verifikasiMitraVerify', $mitra->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-1 bg-green-500 text-white rounded"
                                    @if($mitra->status_registration_mitra !== 'pending') disabled @endif>
                                Verifikasi
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
