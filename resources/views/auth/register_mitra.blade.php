<form action="{{ route('register.mitra') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <h2>Register Mitra Laundry</h2>
    <!-- Informasi Pemilik -->
    <h3>Informasi Pemilik</h3>
    <label for="name">Username:</label>
    <input type="text" name="name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" name="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" name="password_confirmation" required>

    <label for="nama_pemilik">Nama Pemilik:</label>
    <input type="text" name="nama_pemilik" required>

    <label for="nomor_hp">Nomor HP/WhatsApp:</label>
    <input type="text" name="nomor_hp" required>

    <!-- Informasi Usaha -->
    <h3>Informasi Usaha Laundry</h3>
    <label for="nama_laundry">Nama Laundry:</label>
    <input type="text" name="nama_laundry" required>

    <label for="alamat">Alamat Lengkap:</label>
    <input type="text" name="alamat" required>

    <label for="jam_operasional">Jam Operasional:</label>
    <input type="text" name="jam_operasional" required>

    <label for="layanan">Layanan yang Disediakan:</label>
    <textarea name="layanan" required></textarea>

    <label for="harga">Harga per Kg atau per Item:</label>
    <input type="text" name="harga" required>

    <label for="metode_pembayaran">Metode Pembayaran:</label>
    <input type="text" name="metode_pembayaran" required>

    <label for="deskripsi">Deskripsi Singkat:</label>
    <textarea name="deskripsi" required></textarea>

    <!-- Dokumen Pendukung -->
    <h3>Dokumen Pendukung</h3>
    <label for="foto_tempat">Foto Tempat Usaha:</label>
    <input type="file" name="foto_tempat">

    <label for="foto_bukti">Foto Bukti Kepemilikan:</label>
    <input type="file" name="foto_bukti">

    <!-- Peta Lokasi -->
    <h3>Peta Lokasi</h3>
    <label for="lokasi">Lokasi Usaha:</label>
    <input type="text" name="lokasi" placeholder="Cari lokasi usaha...">

    <button type="submit">Daftar sebagai Mitra</button>
</form>