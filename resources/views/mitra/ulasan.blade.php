@extends('layouts.app')

@section('content')
<section class="p-6 space-y-6 bg-gray-50 min-h-screen">
    <!-- Title -->
    <h2 class="text-2xl font-semibold text-gray-800">Rating & Ulasan Pelanggan</h2>

    <!-- Rating Summary Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="text-yellow-400 text-4xl">★</div>
            <div>
                <p class="text-3xl font-bold text-gray-800 leading-none">
                    {{ round($averageRating, 1) }} <span class="text-gray-400 text-xl">/5.0</span>
                </p>
                <p class="text-sm text-gray-500 mt-1">Rating Rata-Rata</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl p-6">
            <p class="text-3xl font-bold text-gray-800">{{ $totalReviews }}</p> <!-- Show Total Reviews -->
            <p class="text-sm text-gray-500">Jumlah Ulasan</p>
        </div>
    </div>

    <!-- Form for Adding Review -->
    <form action="{{ url('/pesanan/' . $pesanan->id . '/ulas') }}" method="POST" class="bg-white p-6 rounded-md shadow-md">
        @csrf
        <div class="mb-6">
            <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
            <select id="rating" name="rating" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Sangat Buruk</option>
                <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Buruk</option>
                <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Cukup</option>
                <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Baik</option>
                <option value="5" {{ old('rating') == 5 ? 'selected' : '' }}>5 - Sangat Baik</option>
            </select>
            @error('rating')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="komentar" class="block text-sm font-medium text-gray-700">Komentar</label>
            <textarea id="komentar" name="komentar" rows="4" class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('komentar') }}</textarea>
            @error('komentar')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-400">
            Kirim Ulasan
        </button>
    </form>
</section>
@endsection
