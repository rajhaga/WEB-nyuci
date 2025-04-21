@extends('layouts.app')

@section('content')
<section class="py-10 px-4 bg-blue-50 min-h-screen">
  <div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-bold mb-2">Lacak Pesanan</h2>
    <p class="text-gray-600 mb-6">Lacak pesananmu untuk mengetahui status pesanan laundry-mu secara real-time.</p>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-8">
      <button class="px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium">Semua</button>
      <button class="px-4 py-2 rounded-xl bg-white text-gray-700 border text-sm font-medium">Menunggu</button>
      <button class="px-4 py-2 rounded-xl bg-white text-gray-700 border text-sm font-medium">Diterima</button>
      <button class="px-4 py-2 rounded-xl bg-white text-gray-700 border text-sm font-medium">Diproses</button>
      <button class="px-4 py-2 rounded-xl bg-white text-gray-700 border text-sm font-medium">Selesai</button>
      <button class="px-4 py-2 rounded-xl bg-white text-gray-700 border text-sm font-medium">Dibatalkan</button>
    </div>

    <!-- Card Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      
      <!-- Card 1 -->
      <div class="border border-red-400 rounded-xl p-4 shadow-sm bg-white">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-bold text-lg text-gray-800">Laundry Daisy</h3>
          <span class="text-xs px-2 py-1 rounded-full font-medium bg-red-100 text-red-700">Dibatalkan</span>
        </div>
        <p class="text-sm mb-1"><span class="font-medium">Paket:</span> Cuci</p>
        <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> 112 789</p>
        <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> 2024-10-12</p>
        <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp20.000</p>
        <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> Bayar di tempat</p>
      </div>

      <!-- Card 2 -->
      <div class="border border-green-400 rounded-xl p-4 shadow-sm bg-white">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-bold text-lg text-gray-800">Laundry Amanah</h3>
          <span class="text-xs px-2 py-1 rounded-full font-medium bg-green-100 text-green-700">Selesai</span>
        </div>
        <p class="text-sm mb-1"><span class="font-medium">Paket:</span> Setrika</p>
        <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> 452 789</p>
        <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> 2024-04-12</p>
        <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp25.000</p>
        <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> QRIS</p>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Nilai</button>
      </div>

      <!-- Card 3 -->
      <div class="border border-blue-300 rounded-xl p-4 shadow-sm bg-white">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-bold text-lg text-gray-800">Laundry Ritsuki</h3>
          <span class="text-xs px-2 py-1 rounded-full font-medium bg-yellow-100 text-yellow-700">Diproses</span>
        </div>
        <p class="text-sm mb-1"><span class="font-medium">Paket:</span> Cuci & Setrika</p>
        <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> 452 789</p>
        <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> 2024-04-12</p>
        <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp22.000</p>
        <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> QRIS</p>
      </div>

      <!-- Tambahan 3 Card Lagi (bisa diulang jika perlu) -->
      <div class="border border-red-400 rounded-xl p-4 shadow-sm bg-white">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-bold text-lg text-gray-800">Laundry Daisy</h3>
          <span class="text-xs px-2 py-1 rounded-full font-medium bg-red-100 text-red-700">Dibatalkan</span>
        </div>
        <p class="text-sm mb-1"><span class="font-medium">Paket:</span> Cuci</p>
        <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> 112 789</p>
        <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> 2024-10-12</p>
        <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp20.000</p>
        <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> Bayar di tempat</p>
      </div>

      <div class="border border-orange-300 rounded-xl p-4 shadow-sm bg-white">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-bold text-lg text-gray-800">Laundry Amanah</h3>
          <span class="text-xs px-2 py-1 rounded-full font-medium bg-orange-100 text-orange-700">Menunggu</span>
        </div>
        <p class="text-sm mb-1"><span class="font-medium">Paket:</span> Paket 2</p>
        <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> 452 789</p>
        <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> 2024-09-12</p>
        <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp30.000</p>
        <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> QRIS</p>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Bayar</button>
      </div>

      <div class="border border-blue-300 rounded-xl p-4 shadow-sm bg-white">
        <div class="flex justify-between items-center mb-2">
          <h3 class="font-bold text-lg text-gray-800">Laundry Ritsuki</h3>
          <span class="text-xs px-2 py-1 rounded-full font-medium bg-yellow-100 text-yellow-700">Diproses</span>
        </div>
        <p class="text-sm mb-1"><span class="font-medium">Paket:</span> Paket 3</p>
        <p class="text-sm mb-1"><span class="font-medium">Kode Referal:</span> 452 789</p>
        <p class="text-sm mb-1"><span class="font-medium">Tanggal Pemesanan:</span> 2024-04-12</p>
        <p class="text-sm mb-1"><span class="font-medium">Total Biaya:</span> Rp22.000</p>
        <p class="text-sm mb-4"><span class="font-medium">Metode Pembayaran:</span> QRIS</p>
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">Nilai</button>
      </div>
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
