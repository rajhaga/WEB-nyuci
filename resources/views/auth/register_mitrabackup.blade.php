<section class="py-10 bg-gray-100">
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
                    <label class="block font-medium">Tentukan Lokasi Usaha</label>
                    <div id="map" class="w-full h-64 bg-gray-200 rounded-md"></div>
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var defaultLocation = [-6.200000, 106.816666]; // Jakarta sebagai lokasi default
        var map = L.map('map').setView(defaultLocation, 13);

        // Gunakan tile OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan marker yang bisa digeser (draggable)
        var marker = L.marker(defaultLocation, { draggable: true }).addTo(map);

        // Update input saat marker dipindahkan
        marker.on('dragend', function (event) {
            var position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat;
            document.getElementById('longitude').value = position.lng;
        });

        // Isi input dengan nilai default
        document.getElementById('latitude').value = defaultLocation[0];
        document.getElementById('longitude').value = defaultLocation[1];
    });
</script>
