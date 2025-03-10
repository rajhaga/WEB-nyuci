@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout Pesanan</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h4>Detail Pesanan</h4>
        </div>
        <div class="card-body">
            <h5>{{ $mitra->nama_laundry }}</h5>
            <div>
                <p><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
                <p><strong>Harga mulai dari:</strong> Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
            </div>

            <h5>Daftar Barang</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Jenis Pakaian</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item['jenis'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>Rp{{ number_format($item['cost'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4>Metode Pembayaran</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('katalog.placeOrder', $mitra->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="payment_method">Metode Pembayaran</label>
                    <select name="payment_method" id="payment_method" class="form-control" required>
                        <option value="qris">QRIS</option>
                        <option value="cod">Bayar di Tempat</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
