@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-center mb-6">Checkout Pesanan</h1>
    
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h4 class="text-xl font-semibold mb-4">Detail Pesanan</h4>
        <h5 class="text-lg font-bold">{{ $mitra->nama_laundry }}</h5>
        <p class="text-gray-700"><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
        <p class="text-blue-600 font-bold"><strong>Harga mulai dari:</strong> Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
        <h4 class="text-xl font-semibold mb-4">Daftar Barang</h4>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">Jenis Pakaian</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="text-gray-700">
                    <td class="border border-gray-300 px-4 py-2">{{ $item['jenis'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $item['quantity'] }}</td>
                    <td class="border border-gray-300 px-4 py-2">Rp{{ number_format($item['cost'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h4 class="text-xl font-semibold mb-4">Metode Pembayaran</h4>
        <form action="{{ route('katalog.placeOrder', $mitra->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 font-semibold">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="qris">QRIS</option>
                    <option value="cod">Bayar di Tempat</option>
                </select>
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition">Pesan Sekarang</button>
        </form>
    </div>
</div>
@endsection
