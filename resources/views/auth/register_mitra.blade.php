<section class="mitra-registration py-5">
    <div class="container">
        <h2 class="text-center mb-4">Daftar Menjadi Mitra Laundry</h2>

        <form action="{{ route('register.mitra') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Informasi Pemilik -->
            <div class="mb-4">
                <h3>Informasi Pemilik</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nama_pemilik" class="form-label">Nama Pemilik</label>
                        <input type="text" name="nama_pemilik" class="form-control"
                            value="{{ Auth::check() ? Auth::user()->nama : '' }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nomor_hp" class="form-label">Nomor HP/WhatsApp</label>
                        <input type="tel" name="nomor_hp" class="form-control"
                            value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                            pattern="[0-9]{10,15}" required title="Masukkan nomor HP yang valid (10-15 digit angka)">
                    </div>
                </div>
            </div>

            <!-- Informasi Usaha Laundry -->
            <div class="mb-4">
                <h3>Informasi Usaha Laundry</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label for="nama_laundry" class="form-label">Nama Laundry</label>
                        <input type="text" name="nama_laundry" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="jam_operasional" class="form-label">Jam Operasional</label>
                        <input type="text" name="jam_operasional" class="form-control" placeholder="08:00 - 21:00" required>
                    </div>
                    <div class="col-md-6">
                        <label for="layanan" class="form-label">Layanan yang Disediakan</label>
                        <input type="text" name="layanan" class="form-control" required>
                    </div>
                </div>

                <div class="mb-4">
                    <h3>Pilih Paket Layanan</h3>
                    <select name="kategori_layanan" class="form-select" required>
                        <option value="cuci">Cuci</option>
                        <option value="setrika">Setrika</option>
                        <option value="cuci dan setrika">Cuci dan Setrika</option>
                    </select>                        
                </div>

                <!-- Pilihan Jenis Pakaian (Checkbox) -->
                <div class="mb-4">
                    <label for="paket_pakaian" class="form-label">Pilih Paket</label>
                    <div>
                        @foreach ($paket_pakaian as $paket)
                            <div class="form-check">
                                <input class="form-check-input paket-checkbox" type="checkbox" name="paket_pakaian[]" value="{{ $paket->id }}" id="paket_{{ $paket->id }}">
                                <label class="form-check-label" for="paket_{{ $paket->id }}">
                                    {{ $paket->nama }} ({{ $paket->jenisPakaian->pluck('nama')->join(', ') }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Harga dan Metode Pembayaran -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="harga" class="form-label">Harga per Kg atau per Item</label>
                        <input type="number" name="harga" class="form-control" min="1000" required>
                    </div>
                    <div class="col-md-6">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <input type="text" name="metode_pembayaran" class="form-control" required>
                    </div>
                </div>

                <!-- Deskripsi Usaha -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                        <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            <div class="mb-4">
                <h3>Dokumen Pendukung</h3>
                <div class="row">
                    <div class="col-md-6">
                        <label for="foto_tempat" class="form-label">Foto Tempat Usaha</label>
                        <input type="file" name="foto_tempat" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-6">
                        <label for="foto_bukti" class="form-label">Foto Bukti Kepemilikan</label>
                        <input type="file" name="foto_bukti" class="form-control" accept="image/*" required>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg">Daftar sebagai Mitra</button>
            </div>
        </form>
    </div>
</section>


