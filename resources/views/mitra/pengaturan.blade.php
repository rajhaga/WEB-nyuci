@extends('layouts.mitra')

@section('mitracontent')
<div class="container mx-auto p-6">

    <!-- Tabs -->
    <div class="flex space-x-2 bg-gray-100 rounded-full p-2 mb-8 w-max mx-auto">
        <button onclick="changeTab('identitas')" id="tab-identitas" class="px-6 py-2 rounded-full bg-blue-600 text-white text-sm font-semibold focus:outline-none">Identitas</button>
        <button onclick="changeTab('informasi')" id="tab-informasi" class="px-6 py-2 rounded-full text-gray-600 hover:bg-blue-100 text-sm font-semibold focus:outline-none">Informasi Toko</button>
        <button onclick="changeTab('produk')" id="tab-produk" class="px-6 py-2 rounded-full text-gray-600 hover:bg-blue-100 text-sm font-semibold focus:outline-none">Produk</button>
    </div>

    <!-- Tab Contents -->
    <div id="content-identitas" class="tab-content">
        <div class="flex flex-col items-center mb-8">
            <div class="relative">
                <img src="{{ asset('storage/' . ($mitra->foto_tempat ?? 'default.jpg')) }}" alt="Profile" class="w-32 h-32 rounded-full object-cover">
                <label for="foto_profil" class="absolute bottom-0 right-0 bg-blue-600 p-2 rounded-full cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l9-9a1.5 1.5 0 00-2.121-2.121l-9 9v3z" />
                    </svg>
                </label>
                <input id="foto_profil" name="foto_profil" type="file" class="hidden" />
            </div>
        </div>

        <form  method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username', $mitra->username) }}" class="w-full p-3 border border-gray-300 rounded-lg" readonly>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $mitra->nama_pemilik) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $mitra->email) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $mitra->nomor_hp) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Reset Password</label>
                <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Ulangi Password</label>
                <input type="password" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <div class="flex justify-between pt-4">
                <a href="{{ route('mitra.dashboard') }}" class="border border-blue-600 text-blue-600 py-3 px-8 rounded-lg hover:bg-blue-50 transition-all">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-all">Simpan</button>
            </div>
        </form>
    </div>

    <div id="content-informasi" class="tab-content hidden">
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

            <!-- Nama Laundry -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Laundry</label>
                <input type="text" name="nama_laundry" value="{{ old('nama_laundry', $mitra->nama_tempat) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <!-- Alamat Laundry -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Laundry</label>
                <input type="text" name="alamat_laundry" value="{{ old('alamat_laundry', $mitra->alamat) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>

            <!-- Map Lokasi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <div class="w-full h-60 bg-gray-100 rounded-lg overflow-hidden">
                    <!-- Ganti iframe dengan map dynamic kalau perlu -->
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        src="https://www.google.com/maps/embed/v1/place?key=YOUR_GOOGLE_MAPS_API_KEY&q={{ urlencode($mitra->alamat) }}"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tambah Gambar</label>
                <div class="flex space-x-4 overflow-x-auto">
                    {{-- @if($mitra->foto_tempat)
                        @foreach(json_decode($mitra->foto_tempat) as $foto)
                            <div class="relative w-24 h-24 flex-shrink-0">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Laundry" class="w-full h-full object-cover rounded-lg">
                                <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 transform translate-x-1/2 -translate-y-1/2">
                                 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif --}}
                    <label for="gambar_tempat" class="flex items-center justify-center w-24 h-24 bg-gray-200 rounded-lg cursor-pointer">
                        <span class="text-2xl text-gray-400">+</span>
                    </label>
                    <input id="gambar_tempat" name="gambar_tempat[]" type="file" multiple class="hidden" />
                </div>
            </div>

            <!-- Deskripsi Toko -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Toko</label>
                <textarea name="deskripsi" rows="5" class="w-full p-3 border border-gray-300 rounded-lg resize-none" required>{{ old('deskripsi', $mitra->deskripsi_tempat) }}</textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-between pt-4">
                <a href="{{ route('mitra.dashboard') }}" class="border border-blue-600 text-blue-600 py-3 px-8 rounded-lg hover:bg-blue-50 transition-all">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-all">Simpan</button>
            </div>

        </form>

    </div>

    <div id="content-produk" class="tab-content hidden">
        <form method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pilih Jenis Laundry -->
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">Pilih Jenis Laundry</label>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="jenis_laundry" value="Cuci" {{ old('jenis_laundry', $mitra->jenis_laundry) == 'Cuci' ? 'checked' : '' }}>
                        <span>Cuci</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="jenis_laundry" value="Setrika" {{ old('jenis_laundry', $mitra->jenis_laundry) == 'Setrika' ? 'checked' : '' }}>
                        <span>Setrika</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="jenis_laundry" value="Cuci & Setrika" {{ old('jenis_laundry', $mitra->jenis_laundry) == 'Cuci & Setrika' ? 'checked' : '' }}>
                        <span>Cuci & Setrika</span>
                    </label>
                </div>
            </div>

            <!-- Pilih Paket Laundry -->
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">Pilih Paket Laundry</label>
                <div class="space-y-2">
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="paket_laundry" value="Paket Pakaian" {{ old('paket_laundry', $mitra->paket_laundry) == 'Paket Pakaian' ? 'checked' : '' }}>
                        <span>Paket Pakaian</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="paket_laundry" value="Paket Rumah Tangga & Hotel" {{ old('paket_laundry', $mitra->paket_laundry) == 'Paket Rumah Tangga & Hotel' ? 'checked' : '' }}>
                        <span>Paket Rumah Tangga & Hotel</span>
                    </label>
                    <label class="flex items-center space-x-2">
                        <input type="radio" name="paket_laundry" value="Paket Sepatu & Aksesoris" {{ old('paket_laundry', $mitra->paket_laundry) == 'Paket Sepatu & Aksesoris' ? 'checked' : '' }}>
                        <span>Paket Sepatu & Aksesoris</span>
                    </label>
                </div>
            </div>
        </div>

    <!-- Tambah Detail Jenis -->
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Tambah Detail Jenis</label>

        <div id="detail-jenis-list" class="space-y-4">
            <!-- Template Data Barang -->
            @if($mitra->detail_jenis)
                @foreach($mitra->detail_jenis as $index => $jenis)
                <div class="flex items-center space-x-3">
                    <input type="text" name="detail_nama[]" value="{{ $jenis['nama'] }}" placeholder="Nama Barang" class="flex-1 p-3 border border-gray-300 rounded-lg">
                    <input type="text" name="detail_harga[]" value="{{ number_format($jenis['harga'], 0, ',', '.') }}" placeholder="Rp 0" class="w-32 p-3 border border-gray-300 rounded-lg">
                    <button type="button" class="delete-btn bg-red-500 text-white rounded-lg p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endforeach
            @endif

            <!-- Baris Kosong -->
            <div class="flex items-center space-x-3">
                <input type="text" name="detail_nama[]" placeholder="Masukkan Detail Nama Barang" class="flex-1 p-3 border border-gray-300 rounded-lg">
                <input type="text" name="detail_harga[]" value="Rp 0" class="w-32 p-3 border border-gray-300 rounded-lg">
                <button type="button" class="delete-btn bg-red-500 text-white rounded-lg p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Tombol Tambah Jenis -->
            <div class="pt-4">
                <button type="button" id="add-detail-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition-all">+ Tambah Jenis</button>
            </div>
        </div>

        <!-- Tombol Batal dan Simpan -->
        <div class="flex justify-between pt-4">
            <a href="{{ route('mitra.dashboard') }}" class="border border-blue-600 text-blue-600 py-3 px-8 rounded-lg hover:bg-blue-50 transition-all">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-all">Simpan</button>
        </div>
    </form>
    </div>

</div>

<!-- Simple Tab Switch Script -->
<script>
function changeTab(tab) {
    document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
    document.querySelector('#content-' + tab).classList.remove('hidden');

    document.querySelectorAll('button[id^="tab-"]').forEach(btn => {
        btn.classList.remove('bg-blue-600', 'text-white');
        btn.classList.add('text-gray-600');
    });

    document.getElementById('tab-' + tab).classList.add('bg-blue-600', 'text-white');
    document.getElementById('tab-' + tab).classList.remove('text-gray-600');
}
const addBtn = document.getElementById('add-detail-btn');
    const detailList = document.getElementById('detail-jenis-list');

    addBtn.addEventListener('click', () => {
        const field = `
        <div class="flex items-center space-x-3">
            <input type="text" name="detail_nama[]" placeholder="Masukkan Detail Nama Barang" class="flex-1 p-3 border border-gray-300 rounded-lg">
            <input type="text" name="detail_harga[]" value="Rp 0" class="w-32 p-3 border border-gray-300 rounded-lg">
            <button type="button" class="delete-btn bg-red-500 text-white rounded-lg p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>`;
        detailList.insertAdjacentHTML('beforeend', field);
        attachDeleteEvents();
    });

    function attachDeleteEvents() {
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.onclick = () => btn.parentElement.remove();
        });
    }
    attachDeleteEvents();
</script>
@endsection
