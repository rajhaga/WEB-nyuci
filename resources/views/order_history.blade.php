@extends('layouts.app')

@section('content')
<section class="py-10 px-4 bg-blue-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold mb-2">Lacak Pesanan</h2>
    <p class="text-gray-600 mb-6">Lacak pesananmu untuk mengetahui status pesanan laundry-mu secara real-time.</p>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-8">
      @php
        $statuses = ['' => 'Semua', 'Menunggu' => 'Menunggu', 'Diterima' => 'Diterima', 'Diproses' => 'Diproses', 'Selesai' => 'Selesai', 'Dibatalkan' => 'Dibatalkan'];
        $currentStatus = request('status');
      @endphp

      @foreach($statuses as $key => $label)
      <a href="{{ url()->current() }}{{ $key !== '' ? '?status=' . $key : '' }}" 
        class="px-4 py-2 rounded-xl text-sm font-medium
        {{ $currentStatus === $key || ($key === '' && $currentStatus === null) ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border text-gray-700 hover:bg-gray-100' }}">
         {{ $label }}
     </a>
     
      @endforeach
    </div>

    <!-- Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($pesanans as $pesanan)
        <div class="border rounded-xl p-4 shadow-sm bg-white">
          <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold text-lg text-gray-800">{{ $pesanan->laundry_name }}</h3>
            <span class="text-xs px-2 py-1 rounded-full font-medium
              @if($pesanan->status == 'Dibatalkan') bg-red-100 text-red-700
              @elseif($pesanan->status == 'Selesai') bg-green-100 text-green-700
              @elseif($pesanan->status == 'Diproses') bg-yellow-100 text-yellow-700
              @elseif($pesanan->status == 'Menunggu') bg-blue-100 text-blue-700
              @else bg-gray-100 text-gray-700
              @endif">
              {{ $pesanan->status }}
            </span>
          </div>
          <p class="text-sm mb-1"><span class="font-medium">Paket:</span> {{ $pesanan->paket }}</p>
          <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> {{ $pesanan->kode_referral }}</p>
          <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> {{ $pesanan->created_at->format('Y-m-d') }}</p>
          <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
          <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> {{ $pesanan->metode_pembayaran }}</p>

          @if($pesanan->status === 'Selesai')
            
          <div class="flex justify-center mt-4">
            <a href="{{ route('pesanan.ulasan', $pesanan->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg font-semibold inline-block text-center">
                Nilai
            </a>
        </div>
        
            
          @elseif($pesanan->status === 'Menunggu' || $pesanan->status === 'Dibatalkan')
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Bayar</button>
          @endif
        </div>
      @empty
        <p class="text-center text-gray-500">Tidak ada pesanan ditemukan.</p>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-10 flex justify-center items-center space-x-2">
      <button class="px-3 py-2 bg-white border rounded hover:bg-gray-100">&lt;</button>
      <button class="px-3 py-2 rounded bg-blue-600 text-white">1</button>
      <button class="px-3 py-2 rounded border bg-white text-gray-700 hover:bg-gray-100">2</button>
      <button class="px-3 py-2 rounded border bg-white text-gray-700 hover:bg-gray-100">3</button>
      <button class="px-3 py-2 rounded border bg-white text-gray-700 hover:bg-gray-100">4</button>
      <button class="px-3 py-2 rounded border bg-white text-gray-700 hover:bg-gray-100">5</button>
      <button class="px-3 py-2 bg-white border rounded hover:bg-gray-100">&gt;</button>
    </div>
  </div>
</section>
@endsection
