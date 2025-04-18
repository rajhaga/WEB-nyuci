@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center mb-6 text-blue-600">Checkout Pesanan</h1>
    
    <!-- Mitra Info Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6 transition duration-300 hover:shadow-xl">
        <h4 class="text-xl font-semibold text-gray-800 mb-4">Detail Pesanan</h4>
        <h5 class="text-lg font-bold text-gray-900">{{ $mitra->nama_laundry }}</h5>
        <p class="text-gray-700"><strong>Alamat:</strong> {{ $mitra->alamat }}</p>
        <p class="text-blue-600 font-bold"><strong>Harga mulai dari:</strong> Rp{{ number_format($mitra->harga, 0, ',', '.') }}</p>
    </div>

    <!-- Items List Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-6 transition duration-300 hover:shadow-xl">
        <h4 class="text-xl font-semibold text-gray-800 mb-4">Daftar Barang</h4>
        <table class="w-full border-collapse border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-600">Jenis Pakaian</th>
                    <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                    <th class="border border-gray-300 px-6 py-3 text-left text-sm font-medium text-gray-600">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="text-gray-700">
                    <td class="border border-gray-300 px-6 py-4">{{ $item['jenis'] }}</td>
                    <td class="border border-gray-300 px-6 py-4">{{ $item['quantity'] }}</td>
                    <td class="border border-gray-300 px-6 py-4">Rp{{ number_format($item['cost'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Payment Method Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg transition duration-300 hover:shadow-xl">
        <h4 class="text-xl font-semibold text-gray-800 mb-4">Metode Pembayaran</h4>
        <form action="{{ route('katalog.placeOrder', $mitra->id) }}" method="POST">
            @csrf
            <div class="mb-6">
                <label for="payment_method" class="block text-gray-700 font-semibold mb-2">Metode Pembayaran</label>
                <select name="payment_method" id="payment_method" class="w-full px-4 py-3 border rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="qris" {{ old('payment_method') == 'qris' ? 'selected' : '' }}>QRIS</option>
                    <option value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'selected' : '' }}>Bayar di Tempat</option>
                </select>                
            </div>
            <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-md hover:bg-green-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-green-400 relative z-10">
                Pesan Sekarang
            </button>
            
        </form>
    </div>
</div>
@endsection
