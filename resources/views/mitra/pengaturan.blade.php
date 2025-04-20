@extends('layouts.mitra')

@section('mitracontent')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-semibold mb-6">Pengaturan Mitra</h2>

        <!-- Form Edit Pengaturan Mitra -->
        <form action="{{ route('mitra.update', $mitra->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Pemilik -->
            <div class="mb-4">
                <label for="nama_pemilik" class="block text-sm font-medium text-gray-700">Nama Pemilik</label>
                <input type="text" id="nama_pemilik" name="nama_pemilik" value="{{ old('nama_pemilik', $mitra->nama_pemilik) }}" class="mt-1 p-2 border rounded w-full" required>
            </div>

            <!-- Nomor HP -->
            <div class="mb-4">
                <label for="nomor_hp" class="block text-sm font-medium text-gray-700">Nomor HP</label>
                <input type="text" id="nomor_hp" name="nomor_hp" value="{{ old('nomor_hp', $mitra->nomor_hp) }}" class="mt-1 p-2 border rounded w-full" required>
            </div>

            <!-- Nama Laundry -->
            <div class="mb-4">
                <label for="nama_laundry" class="block text-sm font-medium text-gray-700">Nama Laundry</label>
                <input type="text" id="nama_laundry" name="nama_laundry" value="{{ old('nama_laundry', $mitra->nama_laundry) }}" class="mt-1 p-2 border rounded w-full" required>
            </div>

            <!-- Alamat -->
            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea id="alamat" name="alamat" class="mt-1 p-2 border rounded w-full" rows="4" required>{{ old('alamat', $mitra->alamat) }}</textarea>
            </div>

            <!-- Foto Tempat -->
            <div class="mb-4">
                <label for="foto_tempat" class="block text-sm font-medium text-gray-700">Foto Tempat</label>
                <input type="file" id="foto_tempat" name="foto_tempat" class="mt-1 p-2 border rounded w-full">
                @if ($mitra->foto_tempat)
                    <img src="{{ asset('storage/' . $mitra->foto_tempat) }}" alt="Foto Tempat" class="mt-2 w-24">
                @endif
            </div>

            <!-- Paket Pakaian -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Paket Pakaian</label>
                @foreach($mitra->paketPakaian as $paket)
                    <div class="flex items-center mb-2">
                        <input type="text" name="paket[{{ $paket->id }}][nama]" value="{{ $paket->nama }}" class="p-2 border rounded w-full" required>
                        <input type="number" name="paket[{{ $paket->id }}][harga]" value="{{ $paket->harga }}" class="ml-2 p-2 border rounded w-24" required>
                    </div>
                @endforeach
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-4">
                <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="metode_pembayaran" id="metode_pembayaran" class="mt-1 p-2 border rounded w-full" required>
                    <option value="cash" {{ old('metode_pembayaran', $mitra->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="transfer" {{ old('metode_pembayaran', $mitra->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                    <option value="gopay" {{ old('metode_pembayaran', $mitra->metode_pembayaran) == 'gopay' ? 'selected' : '' }}>Gopay</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Pengaturan</button>
        </form>

        <form action="{{ route('mitra.updatePrice', $mitra->id) }}" method="POST">
            @csrf
            @method('PUT')
        
            @foreach($mitra->jenisPakaian as $jenisPakaian)
                <div class="mb-4">
                    <label for="price_{{ $jenisPakaian->id }}" class="block">{{ $jenisPakaian->nama }}</label>
                    <input type="number" id="price_{{ $jenisPakaian->id }}" name="jenis_pakaian[{{ $jenisPakaian->id }}][price]" value="{{ old('jenis_pakaian.' . $jenisPakaian->id . '.price', $jenisPakaian->pivot->price) }}" class="p-2 border rounded" required>
                    <input type="hidden" name="jenis_pakaian[{{ $jenisPakaian->id }}][id]" value="{{ $jenisPakaian->id }}">
                </div>
            @endforeach

        
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Update Harga</button>
        </form>
        
    </div>
@endsection
