@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 text-black flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-white text-black p-6 flex flex-col justify-between rounded-r-xl shadow-lg">
        <div>
            <div class="flex items-center space-x-4 mb-8">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/40' }}" class="w-10 h-10 rounded-full object-cover">
                <span class="font-semibold">{{ Auth::user()->name }}</span>
            </div>
            <nav class="flex flex-col space-y-4">
                <button @click="isEditing = !isEditing" class="text-blue-600 font-semibold flex items-center gap-2 focus:outline-none">
                    <i class="fas fa-pen"></i>
                    <span x-text="isEditing ? 'Batal Edit' : 'Edit Profile'"></span>
                </button>
                <a href="{{ route('order.history') }}" class="text-blue-600 font-semibold flex items-center gap-2 focus:outline-none">
                    <i class="fas fa-history"></i>
                    <span>Riwayat Pesanan</span>
                </a>
            </nav>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-red-600 hover:underline flex items-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-blue-500 mb-6">Riwayat Pesanan</h1>

        @if($pesanans->isEmpty())
            <p>Tidak ada riwayat pesanan.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 text-center">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Kode Referral</th>
                            <th class="border px-4 py-2">Harga</th>
                            <th class="border px-4 py-2">Tanggal Pemesanan</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanans as $pesanan)
                            <tr>
                                <td class="border px-4 py-2">{{ $pesanan->midtrans_order_id }}</td>
                                <td class="border px-4 py-2">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                <td class="border px-4 py-2">{{ $pesanan->created_at->format('Y-m-d') }}</td>
                                <td class="border px-4 py-2">
                                    <span class="font-semibold 
                                        @if($pesanan->status == 'Menunggu') text-red-600 
                                        @elseif($pesanan->status == 'Dibayar') text-green-600 
                                        @elseif($pesanan->status == 'Diproses') text-yellow-600 
                                        @else text-gray-600 @endif">
                                        {{ $pesanan->status }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2">
                                    {{-- <a href="{{ route('order.details', $pesanan->id) }}" class="text-blue-600">Lihat Detail</a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <!-- Pagination -->
        <div class="mt-6 flex justify-between items-center">
            <button class="bg-blue-600 text-white px-4 py-2 rounded">←</button>
            <span class="font-semibold">1</span>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">→</button>
        </div>
    </main>
</div>
@endsection