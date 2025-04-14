@extends('layouts.app')

@section('content')
<div x-data="{ isEditing: false }" class="min-h-screen bg-gray-100 text-white flex">
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
            <button type="submit" class="text-red-600 hover:underline flex items-center gap-2"><i class="fas fa-sign-out-alt"></i> Logout</button>
        </form>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold text-blue-500 mb-6">Profil</h1>

        <!-- Foto Profil -->
        <div class="flex justify-center mb-6 relative">
            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : 'https://via.placeholder.com/120' }}" class="w-32 h-32 rounded-full border-4 border-blue-500 object-cover">
        </div>

        <!-- View Mode -->
        <div x-show="!isEditing" x-transition class="space-y-5 max-w-xl mx-auto bg-white p-6 rounded-lg shadow text-black">
            <div><strong>Nama:</strong> {{ Auth::user()->nama }}</div>
            <div><strong>Email:</strong> {{ Auth::user()->email }}</div>
            <div><strong>No HP:</strong> {{ Auth::user()->phone }}</div>
        </div>

        <!-- Edit Mode -->
        <form x-show="isEditing" x-transition action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5 max-w-xl mx-auto">
            @csrf
            @method('PUT')

            <input type="text" name="nama" value="{{ old('nama', Auth::user()->nama) }}" placeholder="Nama Lengkap" class="w-full p-3 bg-white text-black border border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">

            <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" placeholder="Email" class="w-full p-3 bg-white text-black border border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">

            <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Nomor Telepon" class="w-full p-3 bg-white text-black border border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">

            <input type="password" name="password" placeholder="Password (isi jika ingin ubah)" class="w-full p-3 bg-white text-black border border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">

            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="w-full p-3 bg-white text-black border border-blue-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">

            <div>
                <label class="block mb-2 text-sm font-medium text-black">Ganti Foto Profil</label>
                <input type="file" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-500 file:text-white hover:file:bg-blue-600">
            </div>

            <div class="flex justify-end gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">SIMPAN</button>
            </div>
        </form>
    </main>
</div>

<!-- Tambahkan di bawah atau di layout -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
