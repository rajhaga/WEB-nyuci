{{-- resources/views/mitra/ulasan.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f5f5f5] text-black flex justify-center px-4 sm:px-6 lg:px-8 py-8">
    <main class="w-full max-w-5xl">
        <h1 class="text-2xl sm:text-3xl font-semibold text-blue-500 mb-6">Ulasan Pesanan</h1>

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
    </main>
</div>
@endsection
