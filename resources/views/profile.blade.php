@extends('layouts.app')

@section('content')
<div x-data="{ isEditing: {{ $errors->any() ? 'true' : 'false' }} }" class="min-h-screen bg-gray-100 text-white flex flex-col md:flex-row gap-4 px-4 py-6">
    <!-- Sidebar -->
    <aside class="md:w-64 w-full bg-white text-black p-6 flex flex-col justify-between rounded-xl shadow-lg">
        <div class="space-y-4">
            <!-- Navigation Menu -->
            <nav class="flex flex-col space-y-4">
                <button @click="isEditing = !isEditing" class="text-blue-600 font-semibold flex items-center gap-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6-6m2 2L9 21H3v-6l10-10z"/>
                    </svg>
                    <span x-text="isEditing ? 'Batal Edit' : 'Edit Profile'"></span>
                </button>

                <a href="{{ route('profile.historyprofile') }}" class="text-blue-600 font-semibold flex items-center gap-2 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Riwayat Pesanan</span>
                </a>

            </nav>
        </div>

        <!-- Logout -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6">
            @csrf
            <button type="submit" class="text-red-600 hover:underline flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 11-6 0v-1m6-4V9a3 3 0 00-6 0v1" />
                </svg>
                Logout
            </button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 bg-white rounded-xl p-6 md:p-10 shadow-md">
        <h1 class="text-3xl font-bold text-blue-500 mb-6">Profil</h1>

        <!-- Foto Profil -->
        <div class="flex justify-center mb-6">
            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/120' }}" class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover shadow">
        </div>

        <!-- View Mode -->
        <div x-show="!isEditing" x-transition class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 max-w-5xl mx-auto text-black">
            <!-- Card Nama -->
            <div class="bg-white border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500">Nama</div>
                        <div class="text-lg font-semibold">{{ Auth::user()->nama }}</div>
                    </div>
                </div>
            </div>

            <!-- Card Email -->
            <div class="bg-white border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                        <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="text-lg font-semibold">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Card No HP -->
            <div class="bg-white border border-blue-200 rounded-lg p-4 shadow hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-blue-500"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500">No. HP</div>
                        <div class="text-lg font-semibold">{{ Auth::user()->phone }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menampilkan Data Mitra jika status Pending -->
        @if($mitra && Auth::user()->status == 'pending')
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6">
                <h3 class="text-xl font-semibold text-blue-600 mb-4">Data Mitra Anda</h3>

                <div class="flex items-center space-x-6">
                    <!-- Gambar Tempat -->
                    <div class="w-32 h-32 flex-shrink-0">
                        <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" class="w-full h-full rounded-lg object-cover shadow-md">
                    </div>

                    <!-- Data Mitra -->
                    <div class="space-y-2">
                        <p class="text-sm text-gray-500"><strong>Nama Laundry:</strong> <span class="font-medium text-gray-800">{{ $mitra->nama_laundry }}</span></p>
                        <p class="text-sm text-gray-500"><strong>Alamat:</strong> <span class="font-medium text-gray-800">{{ $mitra->alamat }}</span></p>
                        <p class="text-sm text-gray-500"><strong>Rating:</strong> <span class="font-medium text-gray-800">{{ $mitra->rating }}</span></p>
                        <p class="text-sm text-gray-500"><strong>Harga:</strong> <span class="font-medium text-gray-800">{{ $mitra->harga }}</span></p>
                        <p class="text-sm text-gray-500"><strong>Status:</strong> <span class="font-medium text-gray-800">{{ $mitra->user->status }}</span></p>
                    </div>
                </div>

                <!-- Pesan Peringatan -->
                <div class="mt-4 text-sm text-red-600">
                    <p><strong>Perhatian:</strong> Jika data ini hilang atau tidak lengkap, Anda akan ditolak untuk menjadi mitra kami. Pastikan semua informasi Anda sudah terisi dengan benar.</p>
                </div>
            </div>
        @endif

        <!-- Edit Mode -->
        <form x-show="isEditing" x-transition action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid gap-6 max-w-3xl mx-auto mt-6">
            @csrf
            @method('PUT')

            <div class="grid gap-4">
                <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" placeholder="Nama Lengkap"
                    class="w-full p-3 bg-white text-black border border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Email"
                    class="w-full p-3 bg-white text-black border border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Nomor Telepon"
                    class="w-full p-3 bg-white text-black border border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="grid md:grid-cols-2 gap-4">
                <input type="password" name="password" placeholder="Password (isi jika ingin ubah)"
                    class="w-full p-3 bg-white text-black border border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                    class="w-full p-3 bg-white text-black border border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block mb-2 text-sm font-medium text-black">Ganti Foto Profil</label>
                <input type="file" name="photo"
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-500 file:text-white hover:file:bg-blue-600">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    SIMPAN
                </button>
            </div>
        </form>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
