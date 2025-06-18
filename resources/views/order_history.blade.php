@extends('layouts.app')

@section('content')
<section class="py-10 px-4 bg-blue-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <!-- ... (bagian atas tetap sama) ... -->

    <!-- Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @forelse($pesanans as $pesanan)
        <div class="border rounded-xl p-4 shadow-sm bg-white">
          <div class="flex justify-between items-center mb-2">
            <h3 class="font-bold text-lg text-gray-800">
              {{ $pesanan->mitra->nama_laundry ?? 'Mitra Tidak Diketahui' }}
            </h3>
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
          
          <!-- Paket dan Detail Pesanan -->
          <div class="mb-4">
            {{-- <p class="text-sm mb-1"><span class="font-medium">Paket:</span> 
              @foreach($pesanan->mitra->paketPakaian as $paket)
                {{ $paket->nama_paket }}@if(!$loop->last), @endif
              @endforeach
            </p> --}}
            
            <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> {{ $pesanan->kode_referral }}</p>
            <p class="text-sm mb-1"><span class="font-medium">Tanggal:</span> {{ $pesanan->created_at->format('d M Y') }}</p>
            <p class="text-sm mb-1"><span class="font-medium">Total:</span> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            <p class="text-sm mb-3"><span class="font-medium">Pembayaran:</span> {{ $pesanan->metode_pembayaran }}</p>
            
            <!-- Tombol Detail -->
            <button onclick="toggleDetail({{ $pesanan->id }})" 
              class="text-blue-600 text-sm font-medium flex items-center">
              Lihat Detail Pesanan
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            
            <!-- Detail Items (Awalnya tersembunyi) -->
            <div id="detail-{{ $pesanan->id }}" class="hidden mt-3 border-t pt-3">
              <h4 class="font-medium text-gray-800 mb-2">Detail Barang:</h4>
              <ul class="space-y-2">
                @foreach($pesanan->pesananItems as $item)
                  @php
                      $jenis = $item->jenisPakaian;
                      $pivot = \App\Models\MitraJenisPakaian::where('mitra_id', $pesanan->mitra_id)
                                ->where('jenis_pakaian_id', $jenis->id)
                                ->with('paketPakaian')
                                ->first();
                  @endphp

                  <p class="text-sm">
                      - {{ $jenis->nama }} ({{ $pivot?->paketPakaian?->nama ?? 'Paket Tidak Diketahui' }}) x {{ $item->jumlah }}
                  </p>
              @endforeach
              </ul>
            </div>
          </div>

          @if($pesanan->status === 'Selesai')
            <div class="flex justify-center mt-4">
              <a href="{{ route('pesanan.ulasan', $pesanan->id) }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg font-semibold">
                Beri Ulasan
              </a>
            </div>
          @elseif($pesanan->status === 'Menunggu')
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
              Bayar Sekarang
            </button>
          @endif
        </div>
      @empty
        <p class="text-center text-gray-500 col-span-full">Tidak ada pesanan ditemukan.</p>
      @endforelse
    </div>

    <!-- Pagination dan JavaScript -->
    <div class="mt-10">
      {{ $pesanans->links() }}
    </div>
  </div>
</section>

<script>
  function toggleDetail(pesananId) {
    const detailElement = document.getElementById(`detail-${pesananId}`);
    detailElement.classList.toggle('hidden');
  }
</script>
@endsection