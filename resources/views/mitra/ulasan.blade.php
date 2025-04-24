{{-- resources/views/mitra/ulasan.blade.php --}}

@extends('layouts.app')

@section('content')
<section class="p-6 space-y-6 bg-gray-50 min-h-screen">
    <!-- Judul -->
    <h2 class="text-2xl font-semibold text-gray-800">Rating & Ulasan Pelanggan</h2>

    <!-- Ringkasan Rating -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4">
            <div class="text-yellow-400 text-4xl">★</div>
            <div>
                <p class="text-3xl font-bold text-gray-800 leading-none">4.8 <span class="text-gray-400 text-xl">/5.0</span></p>
                <p class="text-sm text-gray-500 mt-1">Rating</p>
            </div>
        </div>
        <div class="bg-white shadow rounded-xl p-6">
            <p class="text-3xl font-bold text-gray-800">1,397</p>
            <p class="text-sm text-gray-500">Total Jumlah Ulasan</p>
        </div>
    </div>

    <!-- Komentar -->
    <div class="space-y-6">
        <h3 class="text-lg font-semibold text-gray-700">Komentar Pelanggan</h3>

        <!-- Card Ulasan -->
        <div class="space-y-4">
            <!-- Satu ulasan -->
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-100 rounded-full w-8 h-8 flex items-center justify-center text-blue-600 font-bold text-sm">I</div>
                    <p class="font-semibold text-gray-700">Indah</p>
                </div>
                <div class="text-yellow-400 text-lg">★★★★★</div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Saya sangat puas dengan layanan Laundry Amanah! Paket 1 mereka sangat praktis untuk mencuci berbagai jenis pakaian, termasuk tas dan rok. Pakaian saya selalu bersih dan wangi setelah dicuci. Prosesnya cepat dan efisien, jadi saya tidak perlu menunggu lama. Sangat direkomendasikan!
                </p>
            </div>

            <!-- Duplikat ulasan lainnya -->
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center text-gray-600 font-bold text-sm">R</div>
                    <p class="font-semibold text-gray-700">Rudi</p>
                </div>
                <div class="text-yellow-400 text-lg">★★★★☆</div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Pengalaman pertama saya menggunakan Laundry Amanah sangat memuaskan. Saya memesan Paket 1 untuk mencuci baju dan celana, dan hasilnya luar biasa! Pakaian saya tidak hanya bersih, tetapi juga bebas dari noda. Saya menghargai bahwa mereka tidak menyediakan layanan setrika, karena saya lebih suka menyetrika sendiri. Akan kembali lagi!
                </p>
            </div>

            <!-- Tambahan lainnya -->
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="bg-blue-100 rounded-full w-8 h-8 flex items-center justify-center text-blue-600 font-bold text-sm">I</div>
                    <p class="font-semibold text-gray-700">Indah</p>
                </div>
                <div class="text-yellow-400 text-lg">★★★★★</div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Saya sangat puas dengan layanan Laundry Amanah! Paket 1 mereka sangat praktis untuk mencuci berbagai jenis pakaian, termasuk tas dan rok. Pakaian saya selalu bersih dan wangi setelah dicuci. Prosesnya cepat dan efisien, jadi saya tidak perlu menunggu lama. Sangat direkomendasikan!
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="bg-yellow-100 rounded-full w-8 h-8 flex items-center justify-center text-yellow-600 font-bold text-sm">J</div>
                    <p class="font-semibold text-gray-700">Jihon</p>
                </div>
                <div class="text-yellow-400 text-lg">★★★★☆</div>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Pengalaman pertama saya menggunakan Laundry Amanah sangat memuaskan. Saya memesan Paket 1 untuk mencuci baju dan celana, dan hasilnya luar biasa! Pakaian saya tidak hanya bersih, tetapi juga bebas dari noda. Saya menghargai bahwa mereka tidak menyediakan layanan setrika, karena saya lebih suka menyetrika sendiri. Akan kembali lagi!
                </p>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center gap-2 pt-4">
        <button class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600">&lt;</button>
        <button class="px-3 py-1 rounded bg-blue-600 text-white font-semibold">1</button>
        <button class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">2</button>
        <button class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">3</button>
        <button class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">4</button>
        <button class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600">&gt;</button>
    </div>
</section>

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
