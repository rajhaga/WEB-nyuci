{{-- resources/views/mitra/reports.blade.php --}}

@extends('layouts.mitra')

@section('mitracontent')
<div class="min-h-screen bg-[#f5f5f5] text-black flex justify-center px-4 sm:px-6 lg:px-8 py-8">
    <main class="w-full max-w-5xl">
        <h1 class="text-2xl sm:text-3xl font-semibold text-blue-500 mb-6">Laporan Ulasan</h1>

        <!-- Table to display reviews -->
        <div class="overflow-x-auto bg-white p-6 rounded-lg shadow-md">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Nama Pengguna</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Rating</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Komentar</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ulasan as $index => $review)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $review->user->nama }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $review->rating }} ★</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $review->komentar }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $review->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-sm text-gray-500">Tidak ada ulasan ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
