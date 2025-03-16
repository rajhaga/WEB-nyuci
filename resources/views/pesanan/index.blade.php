@extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-3">Lacak Pesanan</h1>
        <p>Lacak pesananmu untuk mengetahui status pesanan laundry-mu secara real-time.</p>
        
        <!-- Status Filter Form -->
        <div class="mb-3">
            <form action="{{ route('lacak.pesanan') }}" method="GET">
                <button type="submit" class="btn btn-primary">Semua</button>
                <button type="submit" name="status" value="Pending" class="btn btn-outline-secondary">Pending</button>
                <button type="submit" name="status" value="Dibayar" class="btn btn-outline-secondary">Dibayar</button>
                <button type="submit" name="status" value="Diproses" class="btn btn-outline-secondary">Diproses</button>
                <button type="submit" name="status" value="Selesai" class="btn btn-outline-secondary">Selesai</button>
                <button type="submit" name="status" value="Dibatalkan" class="btn btn-outline-secondary">Dibatalkan</button>
            </form>
        </div>

        <!-- Orders List -->
        <div class="row">
            @foreach($pesanan as $order)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $order->mitra->nama }}</h5>
                            @foreach($order->pesananItems as $item)
                                <span class="badge bg-primary">{{ $item->jenisPakaian->nama }}</span>
                            @endforeach
                            <p class="mt-2"><strong>Status:</strong> <span class="text-danger">{{ $order->status }}</span></p>
                            <p><strong>Kode Referral:</strong> {{ $order->kode_referral }}</p>
                            <p><strong>Tanggal Pemesanan:</strong> {{ $order->created_at->format('Y-m-d') }}</p>
                            <p><strong>Total Biaya:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                            <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran ?? 'Bayar ditempat' }}</p>
                            @if($order->status == 'Dibayar')
                                <button class="btn btn-primary">Bayar</button>
                            @elseif($order->status == 'Selesai')
                                <button class="btn btn-primary">Nilai</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection

