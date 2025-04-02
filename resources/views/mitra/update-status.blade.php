@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-bold text-center mb-4">Perbarui Status Pesanan</h1>

    <div class="border rounded-lg p-4 mb-6">
        <label class="block text-lg font-semibold mb-2">Status Pesanan</label>
        <form action="{{ route('mitra.updateStatus', $order->id) }}" method="POST">
            @csrf
            <select name="status" class="w-full p-2 border rounded">
                <option value="Menunggu" {{ $order->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button type="submit" class="mt-4 w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                Perbarui Status
            </button>
        </form>
    </div>

    <div class="border rounded-lg p-4">
        <h2 class="text-lg font-semibold">Detail Pesanan</h2>
        <p class="text-xl font-bold">{{ $order->id }}</p>
        <p class="text-sm text-gray-600">Tanggal: {{ \Carbon\Carbon::parse($order->created_at)->format('Y-m-d') }}</p>

        <table class="w-full mt-4 border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2">Jenis</th>
                    <th class="p-2">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->pesananItems as $item)
                    <tr>
                        <td class="p-2">{{ $item->jenisPakaian->nama }}</td>
                        <td class="p-2 text-center">{{ $item->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="mt-4 text-sm text-gray-700"><strong>Catatan Tambahan:</strong> {{ $order->catatan }}</p>
    </div>

    <div class="border rounded-lg p-4 mt-6">
        <h3 class="text-lg font-semibold">Metode Pembayaran</h3>
        <img src="{{ asset('images/qris-payment.png') }}" alt="QRIS" class="w-32 my-2">
        <p><strong>Total Biaya:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
    </div>
</div>
@endsection
