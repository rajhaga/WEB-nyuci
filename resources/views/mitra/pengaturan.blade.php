@extends('layouts.mitra')

@section('mitracontent')
<div class="container mx-auto p-6">

    <!-- Tabs Navigation -->
    <div class="flex space-x-2 bg-gray-100 rounded-full p-2 mb-8 w-max mx-auto">
        <button onclick="changeTab('identitas')" id="tab-identitas" class="px-6 py-2 rounded-full bg-blue-600 text-white text-sm font-semibold focus:outline-none">Identitas</button>
        <button onclick="changeTab('informasi')" id="tab-informasi" class="px-6 py-2 rounded-full text-gray-600 hover:bg-blue-100 text-sm font-semibold focus:outline-none">Informasi Toko</button>
        <button onclick="changeTab('produk')" id="tab-produk" class="px-6 py-2 rounded-full text-gray-600 hover:bg-blue-100 text-sm font-semibold focus:outline-none">Produk</button>
    </div>

    <!-- Tab Contents -->
    <!-- Identitas Tab -->
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
    
        <form method="POST" action="{{ route('mitra.updateIdentitas', $mitra->id) }}">
            @csrf
            @method('PUT')
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $mitra->nama_pemilik) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $mitra->user->email) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $mitra->nomor_hp) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Reset Password</label>
                <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
    
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Ulangi Password</label>
                <input type="password" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-lg">
            </div>
    
            <div class="flex justify-between pt-4">
                <a href="{{ route('mitra.dashboard') }}" class="border border-blue-600 text-blue-600 py-3 px-8 rounded-lg hover:bg-blue-50 transition-all">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-all">Simpan</button>
            </div>
        </form>
    </div>    

    <!-- Informasi Toko Tab -->
    <div id="content-informasi" class="tab-content hidden">
        <form method="POST" action="{{ route('mitra.updateInformasiToko', $mitra->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
    
            <!-- Nama Laundry -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Laundry</label>
                <input type="text" name="nama_laundry" value="{{ old('nama_laundry', $mitra->nama_laundry) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
    
            <!-- Alamat Laundry -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Laundry</label>
                <input type="text" name="alamat_laundry" value="{{ old('alamat_laundry', $mitra->alamat) }}" class="w-full p-3 border border-gray-300 rounded-lg" required>
            </div>
    
            <!-- Lokasi dengan Map -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                <div id="map" class="w-full h-60 bg-gray-100 rounded-lg"></div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $mitra->latitude) }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $mitra->longitude) }}">
            </div>
    
            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tambah Gambar</label>
                <div class="flex space-x-4 overflow-x-auto">
                    <label for="gambar_tempat" class="flex items-center justify-center w-24 h-24 bg-gray-200 rounded-lg cursor-pointer">
                        <span class="text-2xl text-gray-400">+</span>
                    </label>
                    <input id="gambar_tempat" name="gambar_tempat[]" type="file" multiple class="hidden" />
                </div>
            </div>
    
            <!-- Deskripsi Toko -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Toko</label>
                <textarea name="deskripsi" rows="5" class="w-full p-3 border border-gray-300 rounded-lg resize-none" required>{{ old('deskripsi', $mitra->deskripsi) }}</textarea>
            </div>
    
            <div class="flex justify-between pt-4">
                <a href="{{ route('mitra.dashboard') }}" class="border border-blue-600 text-blue-600 py-3 px-8 rounded-lg hover:bg-blue-50 transition-all">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-all">Simpan</button>
            </div>
        </form>
    </div>
    

    <!-- Produk Tab -->
    <div id="content-produk" class="tab-content hidden">
        <form method="POST" action="{{ route('mitra.updateProduk', $mitra->id) }}">
            @csrf
            @method('PUT')
    
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pilih Jenis Laundry -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Pilih Jenis Laundry</label>
                    <div class="space-y-2">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="kategori_layanan" value="cuci" {{ old('kategori_layanan', $mitra->kategori_layanan) == 'cuci' ? 'checked' : '' }}>
                            <span>Cuci</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="kategori_layanan" value="Setrika" {{ old('kategori_layanan', $mitra->kategori_layanan) == 'setrika' ? 'checked' : '' }}>
                            <span>Setrika</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="kategori_layanan" value="cuci & Setrika" {{ old('kategori_layanan', $mitra->kategori_layanan) == 'cuci & setrika' ? 'checked' : '' }}>
                            <span>Cuci & Setrika</span>
                        </label>
                    </div>
                </div>
    
                <!-- Pilih Paket Pakaian -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Paket Pakaian</label>
                    <div class="space-y-2">
                        <!-- Pilih Paket Pakaian -->
                        <select name="paket_laundry" id="paket_laundry" class="w-full p-3 border border-gray-300 rounded-lg">
                            @foreach($paketPakaianOptions as $paket)
                                <option value="{{ $paket->id }}" 
                                        {{ old('paket_laundry', $mitra->paketPakaian->contains($paket) ? 'selected' : '') }}>
                                    {{ $paket->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <!-- Daftar Harga Jenis Pakaian -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Harga Jenis Pakaian</label>
                <div id="jenis-pakaian-list" class="space-y-4">
                    @foreach($mitra->paketPakaian as $paket)
                        <div id="jenis-pakaian-{{ $paket->id }}" class="space-y-2">
                            @foreach($paket->jenisPakaian as $jenis)
                                <div class="flex items-center space-x-3" id="jenis-pakaian-{{ $jenis->id }}">
                                    <input type="hidden" name="jenis_pakaian[{{ $jenis->id }}][id]" value="{{ $jenis->id }}">
                                    <input type="text" value="{{ $jenis->nama }}" class="flex-1 p-3 border border-gray-300 rounded-lg" readonly>
                                    <input type="number" name="jenis_pakaian[{{ $jenis->id }}][price]" value="{{ $jenis->pivot->price }}" class="w-32 p-3 border border-gray-300 rounded-lg">
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <input type="hidden" id="mitra_id" value="{{ $mitra->id }}">

                {{-- <!-- Tombol Tambah Jenis Pakaian -->
                <div class="pt-4">
                    <button type="button" id="add-jenis-pakaian-btn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition-all" onclick="addBarang()">+ Tambah Jenis Pakaian</button>
                </div> --}}
            </div>
    
            <!-- Tombol Batal dan Simpan -->
            <div class="flex flex-col md:flex-row gap-4 pt-4">
                <a href="{{ route('mitra.dashboard') }}" class="w-full md:w-1/2 border border-blue-600 text-blue-600 py-3 px-8 rounded-lg hover:bg-blue-50 transition-all text-center">Batal</a>
                <button type="submit" class="w-full md:w-1/2 bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg transition-all">Simpan</button>
            </div>
        </form>
    </div>    
</div>

<!-- Simple Tab Switch Script -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
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

    // Event listener untuk dropdown paket pakaian
    document.getElementById('paket_laundry').addEventListener('change', function() {
        var paketId = this.value;
        var mitraId = document.getElementById('mitra_id').value; // Pastikan untuk menambahkan mitra_id di form jika diperlukan

        // Kirim AJAX request untuk mendapatkan jenis pakaian berdasarkan paket yang dipilih
        fetch(`/mitra/${mitraId}/jenis-pakaian/${paketId}`)
            .then(response => response.json())
            .then(data => {
                // Perbarui daftar jenis pakaian di DOM
                document.getElementById('jenis-pakaian-list').innerHTML = data.output;
            })
            .catch(error => console.error('Error:', error));
    });


    function addBarang() {
        const list = document.getElementById('jenis-pakaian-list');
        const newId = 'new-' + Date.now();
        
        // HTML untuk input baru
        const newRow = `
        <div class="flex items-center space-x-3" id="jenis-pakaian-${newId}">
            <input type="hidden" name="jenis_pakaian[${newId}][id]" value="${newId}">
            <input type="text" name="jenis_pakaian[${newId}][nama]" placeholder="Nama Pakaian" class="flex-1 p-3 border border-gray-300 rounded-lg">
            <input type="number" name="jenis_pakaian[${newId}][price]" placeholder="0" class="w-32 p-3 border border-gray-300 rounded-lg">
            <button type="button" class="delete-btn bg-red-500 text-white rounded-lg p-2" onclick="removeJenisPakaian('${newId}')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>`;
        
        // Menambahkan elemen baru ke daftar jenis pakaian
        list.insertAdjacentHTML('beforeend', newRow);
    }

    function removeJenisPakaian(id) {
        const element = document.getElementById(`jenis-pakaian-${id}`);
        if (element) {
            element.remove();
        }
    }

// Anggap data latitude dan longitude mitra datang dari variabel PHP
var mitraLat = {{ $mitra->latitude }};   // Latitude mitra
var mitraLng = {{ $mitra->longitude }};
// Initialize Leaflet Map
document.addEventListener("DOMContentLoaded", function () {
    var map = L.map('map').setView([-6.200000, 106.816666], 13); // Jakarta default

    // Add OpenStreetMap Tile Layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([-6.200000, 106.816666], { draggable: true }).addTo(map);
    marker.bindPopup("<b>Lokasi Laundry Anda</b>").openPopup();

    marker.on('dragend', function (event) {
        var position = marker.getLatLng();
        updatePositionInputs(position.lat, position.lng);
    });

    updatePositionInputs(mitraLat, mitraLng); // Set default position dengan data mitra

    function updatePositionInputs(lat, lng) {
        document.getElementById('latitude').value = lat.toFixed(6);
        document.getElementById('longitude').value = lng.toFixed(6);
    }

    document.getElementById('locate-me').addEventListener('click', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var userLocation = [position.coords.latitude, position.coords.longitude];
                map.setView(userLocation, 15);
                marker.setLatLng(userLocation);
                updatePositionInputs(userLocation[0], userLocation[1]);
            }, function (error) {
                alert('Tidak dapat mendapatkan lokasi Anda: ' + error.message);
            });
        } else {
            alert('Geolocation tidak didukung oleh browser Anda.');
        }
    });

    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        updatePositionInputs(e.latlng.lat, e.latlng.lng);
    });
});
</script>
@endsection
