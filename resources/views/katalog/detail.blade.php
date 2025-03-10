@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $mitra->nama_laundry }}</h1>
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="img-fluid" alt="{{ $mitra->nama_laundry }}">
        </div>
        <div class="col-md-6">
            <h3>Deskripsi</h3>
            <p>{{ $mitra->deskripsi }}</p>
            <p><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
            <p><strong>Harga mulai dari:</strong> Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
            <p><strong>Rating:</strong> {{ $mitra->rating }}⭐</p>
            <p><strong>Jam Operasional:</strong> {{ $mitra->jam_operasional }}</p>
        </div>
    </div>

    <h2 class="my-4">Paket Pakaian yang Tersedia</h2>
    <form action="{{ route('katalog.storeAndCheckout', $mitra->id) }}" method="POST">
        @csrf
        @foreach($mitra->paketPakaian as $paket)
        <div class="card mb-3">
            <div class="card-header">
                <h4>{{ $paket->nama }}</h4>
                <p><strong>Harga Paket:</strong> Rp{{ number_format($paket->harga, 0, ',', '.') }}</p>
            </div>
            <div class="card-body">
                <h5>Jenis Pakaian:</h5>
                <ul>
                    @foreach($paket->jenisPakaian as $jenis)
                    <li>
                        {{ $jenis->nama }} - Rp{{ number_format($jenis->pivot->price, 0, ',', '.') }}/item
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="button" class="btn btn-primary increase" data-id="{{ $jenis->id }}">+</button>
                            <span class="quantity-{{ $jenis->id }}">0</span>
                            <button type="button" class="btn btn-danger decrease" data-id="{{ $jenis->id }}">-</button>
                        </div>
                        <input type="hidden" name="quantities[{{ $paket->id }}][{{ $jenis->id }}]" value="0" class="quantity-input-{{ $jenis->id }}">
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endforeach
        <button type="submit" class="btn btn-success">Pesan Laundry</button>
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
