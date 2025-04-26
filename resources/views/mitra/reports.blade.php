{{-- resources/views/mitra/reports.blade.php --}}

@extends('layouts.mitra')

@section('mitracontent')
<section class="p-6 space-y-6 bg-gray-50 min-h-screen">
    <!-- Judul -->
    <h2 class="text-2xl font-semibold text-gray-800">Rating & Ulasan Pelanggan</h2>

    <!-- Ringkasan Rating -->
    @php
        $jumlahUlasan = $ulasan->count();
        $totalRating = $ulasan->sum('rating');
        $rataRataRating = $jumlahUlasan > 0 ? number_format($totalRating / $jumlahUlasan, 1) : null;
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="text-yellow-400 text-4xl">★</div>
            <div>
                @if ($rataRataRating)
                    <p class="text-3xl font-bold text-gray-800 leading-none">{{ $rataRataRating }} <span class="text-gray-400 text-xl">/5.0</span></p>
                    <p class="text-sm text-gray-500 mt-1">Rating</p>
                @else
                    <p class="text-sm text-gray-500">Belum ada ulasan</p>
                @endif
            </div>
        </div>
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div>
                @if ($jumlahUlasan > 0)
                    <p class="text-3xl font-bold text-gray-800">{{ $jumlahUlasan }}</p>
                    <p class="text-sm text-gray-500">Total Jumlah Ulasan</p>
                @else
                    <p class="text-sm text-gray-500">Belum ada ulasan</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Komentar -->
    <div class="space-y-6">
        <h3 class="text-lg font-semibold text-gray-700">Komentar Pelanggan</h3>

        <div class="space-y-4">
            @forelse ($ulasan as $review)
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-100 rounded-full w-8 h-8 flex items-center justify-center text-blue-600 font-bold text-sm">
                        {{ strtoupper(substr($review->user->nama, 0, 1)) }}
                    </div>
                    <p class="font-semibold text-gray-700">{{ $review->user->nama }}</p>
                </div>
                <div class="text-yellow-400 text-lg">
                    {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                </div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    {{ $review->komentar }}
                </p>
                <p class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow p-6 text-center text-gray-500">
                Belum ada ulasan.
            </div>
            @endforelse
        </div>
    </div>

</section>
@endsection
