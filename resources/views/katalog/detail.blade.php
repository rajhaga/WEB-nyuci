@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-center mb-6">{{ $mitra->nama_laundry }}</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="w-full h-64 object-cover rounded-lg shadow-lg" alt="{{ $mitra->nama_laundry }}">
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-semibold mb-2">Deskripsi</h3>
            <p class="text-gray-700">{{ $mitra->deskripsi }}</p>
            <p class="text-gray-800 font-semibold mt-2"><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
            <p class="text-blue-600 font-bold mt-2"><strong>Harga mulai dari:</strong> Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
            <p class="text-yellow-500 mt-2"><strong>Rating:</strong> {{ $mitra->rating }}⭐</p>
            <p class="text-gray-800 mt-2"><strong>Jam Operasional:</strong> {{ $mitra->jam_operasional }}</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mt-8 mb-4">Paket Pakaian yang Tersedia</h2>
    <form action="{{ route('katalog.storeAndCheckout', $mitra->id) }}" method="POST">
        @csrf
        @foreach($mitra->paketPakaian as $paket)
        <div class="bg-white p-6 rounded-lg shadow-lg mb-4">
            <h4 class="text-lg font-semibold">{{ $paket->nama }}</h4>
            <p class="text-blue-600 font-bold"><strong>Harga Paket:</strong> Rp{{ number_format($paket->harga, 0, ',', '.') }}</p>
            <h5 class="text-md font-semibold mt-2">Jenis Pakaian:</h5>
            <ul class="list-disc pl-5 text-gray-700">
                @foreach($paket->jenisPakaian as $jenis)
                <li class="flex items-center justify-between">
                    <span>{{ $jenis->nama }} - Rp{{ number_format($jenis->pivot->price, 0, ',', '.') }}/item</span>
                    <div class="flex items-center space-x-2">
                        <button type="button" class="bg-blue-500 text-white px-3 py-1 rounded-md increase" data-id="{{ $jenis->id }}">+</button>
                        <span class="quantity-{{ $jenis->id }}">0</span>
                        <button type="button" class="bg-red-500 text-white px-3 py-1 rounded-md decrease" data-id="{{ $jenis->id }}">-</button>
                    </div>
                    <input type="hidden" name="quantities[{{ $paket->id }}][{{ $jenis->id }}]" value="0" class="quantity-input-{{ $jenis->id }}">
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
        <button type="submit" class="block w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition text-center">Pesan Laundry</button>
    </form>
</div>

<script>
    document.querySelectorAll('.increase').forEach(button => {
        button.addEventListener('click', () => {
            let quantityElement = document.querySelector('.quantity-' + button.dataset.id);
            let quantityInput = document.querySelector('.quantity-input-' + button.dataset.id);
            let currentQuantity = parseInt(quantityElement.textContent);
            quantityElement.textContent = currentQuantity + 1;
            quantityInput.value = currentQuantity + 1;
        });
    });

    document.querySelectorAll('.decrease').forEach(button => {
        button.addEventListener('click', () => {
            let quantityElement = document.querySelector('.quantity-' + button.dataset.id);
            let quantityInput = document.querySelector('.quantity-input-' + button.dataset.id);
            let currentQuantity = parseInt(quantityElement.textContent);
            if (currentQuantity > 0) {
                quantityElement.textContent = currentQuantity - 1;
                quantityInput.value = currentQuantity - 1;
            }
        });
    });
</script>
@endsection
