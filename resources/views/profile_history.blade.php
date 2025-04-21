@extends('layouts.app')

@section('content')
<div x-data="{ isEditing: {{ $errors->any() ? 'true' : 'false' }} }" class="min-h-screen bg-gray-100 text-white flex flex-col md:flex-row gap-4 px-4 py-6">
    <!-- Sidebar -->
    <aside class="md:w-64 w-full bg-white text-black p-6 flex flex-col justify-between rounded-xl shadow-lg">
        <div class="space-y-4">
            <nav class="flex flex-col space-y-4">
                <a href="{{ route('profile.historyprofile') }}" 
                   class="text-blue-600 font-semibold flex items-center gap-2 focus:outline-none">
                    Riwayat Pesanan
                </a>
            </nav>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="text-red-600 hover:underline flex items-center gap-2">
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <section class="py-10 px-4 bg-blue-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-bold mb-6 text-blue-600">Riwayat Pesanan</h2>

            <!-- Order Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($pesanans as $pesanan)
                    <div class="border rounded-xl p-6 bg-white shadow-md flex flex-col space-y-4">
                        <div class="flex justify-between">
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Kode Referral:</span> {{ $pesanan->kode_referral }}
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Harga:</span> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="flex justify-between">
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Tanggal Selesai:</span> {{ $pesanan->created_at->format('Y-m-d') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-semibold">Status:</span>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block 
                                    @if($pesanan->status == 'Selesai') bg-green-100 text-green-600 
                                    @elseif($pesanan->status == 'Diproses') bg-yellow-100 text-yellow-600
                                    @elseif($pesanan->status == 'Menunggu') bg-blue-100 text-blue-600
                                    @else bg-red-100 text-red-600
                                    @endif">
                                    {{ $pesanan->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        @if($pesanan->status === 'Selesai')
                            <a href="{{ route('pesanan.ulasan', $pesanan->id) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-center font-semibold">
                                Nilai Produk
                            </a>
                        @elseif($pesanan->status === 'Menunggu' || $pesanan->status === 'Dibatalkan')
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg text-center font-semibold">
                                Bayar
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            {{-- <div class="mt-10 flex justify-center items-center space-x-2">
                {{ $pesanans->links() }}
            </div> --}}
        </div>
    </section>
</div>
@endsection
