<section class="py-20 mt-16 bg-gray-100"> <!-- Ditambahkan mt-16 untuk memberi jarak dari navbar -->
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Daftar Menjadi Mitra Laundry</h2>

        <form action="{{ route('register.mitra') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Informasi Pemilik -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Informasi Pemilik</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_pemilik" class="block font-medium">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="w-full p-2 border rounded-md" value="{{ Auth::check() ? Auth::user()->nama : '' }}" required>
                    </div>
                    <div>
                        <label for="nomor_hp" class="block font-medium">Nomor HP/WhatsApp</label>
                        <input type="tel" name="nomor_hp" class="w-full p-2 border rounded-md" value="{{ Auth::check() ? Auth::user()->phone : '' }}" pattern="[0-9]{10,15}" required>
                    </div>
                </div>
            </div>

            <!-- Informasi Usaha Laundry -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Informasi Usaha Laundry</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_laundry" class="block font-medium">Nama Laundry</label>
                        <input type="text" name="nama_laundry" class="w-full p-2 border rounded-md" required>
                    </div>
                    <div>
                        <label for="alamat" class="block font-medium">Alamat Lengkap</label>
                        <input type="text" name="alamat" class="w-full p-2 border rounded-md" required>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="block font-medium mb-2">Tentukan Lokasi Usaha</label>
                    <div class="relative">
                        <div id="map" class="w-full h-64 rounded-md border border-gray-300"></div>
                        <div class="absolute top-2 right-2 bg-white p-1 rounded shadow-md z-10">
                            <button type="button" id="locate-me" class="text-sm px-2 py-1 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lokasi Saya
                            </button>
                        </div>
                    </div>
                    {{-- <div class="grid grid-cols-2 gap-2 mt-2">
                        <div>
                            <label for="latitude" class="block text-sm font-medium">Latitude</label>
                            <input type="text" name="latitude" id="latitude" class="w-full p-2 border rounded-md text-sm" readonly>
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-medium">Longitude</label>
                            <input type="text" name="longitude" id="longitude" class="w-full p-2 border rounded-md text-sm" readonly>
                        </div>
                    </div> --}}
                    <!-- Input hidden untuk latitude dan longitude -->
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label for="jam_operasional" class="block font-medium">Jam Operasional</label>
                        <input type="text" name="jam_operasional" class="w-full p-2 border rounded-md" placeholder="08:00 - 21:00" required>
                    </div>
                </div>
            </div>

            <!-- Paket Layanan -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Pilih Paket Layanan</h3>
                <select name="kategori_layanan" class="w-full p-2 border rounded-md" required>
                    <option value="cuci">Cuci</option>
                    <option value="setrika">Setrika</option>
                    <option value="cuci dan setrika">Cuci dan Setrika</option>
                </select>
            </div>

            <!-- Pilihan Jenis Pakaian -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Pilih Paket</h3>
                <div class="space-y-2">
                    @foreach ($paket_pakaian as $paket)
                        <div class="flex items-center">
                            <input class="mr-2" type="checkbox" name="paket_pakaian[]" value="{{ $paket->id }}" id="paket_{{ $paket->id }}">
                            <label for="paket_{{ $paket->id }}">{{ $paket->nama }} ({{ $paket->jenisPakaian->pluck('nama')->join(', ') }})</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Harga dan Metode Pembayaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="harga" class="block font-medium">Harga per Kg atau per Item</label>
                    <input type="number" name="harga" class="w-full p-2 border rounded-md" min="1000" required>
                </div>
                <div>
                    <label for="metode_pembayaran" class="block font-medium">Nomor Rekening:</label>
                    <input type="text" name="nomor_rekening" class="w-full p-2 border rounded-md" required>
                </div>
            </div>

            <!-- Deskripsi Usaha -->
            <div>
                <label for="deskripsi" class="block font-medium">Deskripsi Singkat</label>
                <textarea name="deskripsi" class="w-full p-2 border rounded-md" rows="3" required></textarea>
            </div>

            <!-- Dokumen Pendukung -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Dokumen Pendukung</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="foto_tempat" class="block font-medium">Foto Tempat Usaha</label>
                        <input type="file" name="foto_tempat" class="w-full p-2 border rounded-md" accept="image/*" required>
                    </div>
                    <div>
                        <label for="foto_bukti" class="block font-medium">Foto Bukti Kepemilikan</label>
                        <input type="file" name="foto_bukti" class="w-full p-2 border rounded-md" accept="image/*" required>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="text-center">
                <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition">Daftar sebagai Mitra</button>
            </div>
        </form>
    </div>
</section>

<!-- Tambahkan Script Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    /* Pastikan map tidak tertutup oleh navbar */
    #map {
        z-index: 0 !important;
    }
    
    /* Tombol locate me */
    #locate-me {
        background-color: #fff;
        border: 1px solid #ddd;
        cursor: pointer;
    }
    
    #locate-me:hover {
        background-color: #f8f9fa;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var defaultLocation = [-6.200000, 106.816666]; // Jakarta sebagai lokasi default
        var map = L.map('map').setView(defaultLocation, 13);

        // Gunakan tile OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker yang bisa digeser (draggable)
        var marker = L.marker(defaultLocation, { 
            draggable: true,
            autoPan: true
        }).addTo(map);

        // Update input saat marker dipindahkan
        marker.on('dragend', function (event) {
            var position = marker.getLatLng();
            updatePositionInputs(position.lat, position.lng);
        });

        // Isi input dengan nilai default
        updatePositionInputs(defaultLocation[0], defaultLocation[1]);

        // Fungsi untuk update input fields
        function updatePositionInputs(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        }

        // Fitur "Lokasi Saya"
        document.getElementById('locate-me').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLocation = [position.coords.latitude, position.coords.longitude];
                    map.setView(userLocation, 15);
                    marker.setLatLng(userLocation);
                    updatePositionInputs(userLocation[0], userLocation[1]);
                }, function(error) {
                    alert('Tidak dapat mendapatkan lokasi Anda: ' + error.message);
                });
            } else {
                alert('Geolocation tidak didukung oleh browser Anda.');
            }
        });

        // Klik pada map untuk memindahkan marker
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updatePositionInputs(e.latlng.lat, e.latlng.lng);
        });
    });
    
</script>