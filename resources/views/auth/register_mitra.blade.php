@extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content')
<section class="py-20 mt-16 bg-gray-100">
    <div class="max-w-6xl mx-auto">
        <!-- Initial Card -->
        <div id="initial-card" class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold mb-6 text-black">
                <span class="text-blue-500">Daftarkan</span> Dirimu Menjadi <span class="text-blue-500">Bagian Nyuci</span>
            </h2>
            <p class="text-gray-600 mb-8">Dapatkan lebih banyak pelanggan dan kelola bisnis laundry Anda dengan lebih mudah bersama kami.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="bg-blue-100 w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-medium mb-1">Lebih Banyak Pelanggan</h3>
                    <p class="text-sm text-gray-600">Jangkau ribuan calon pelanggan potensial</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="bg-blue-100 w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="font-medium mb-1">Manajemen Mudah</h3>
                    <p class="text-sm text-gray-600">Kelola pesanan dan transaksi dengan sistem kami</p>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="bg-blue-100 w-12 h-12 mx-auto rounded-full flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-medium mb-1">Pendapatan Lebih</h3>
                    <p class="text-sm text-gray-600">Tingkatkan omzet bisnis laundry Anda</p>
                </div>
            </div>
            
            <button id="start-registration" class="bg-blue-600 text-white py-3 px-8 rounded-md hover:bg-blue-700 transition font-medium">
                Daftar Sekarang
            </button>
        </div>
        
        <!-- Registration Form (Initially Hidden) -->
        <div id="registration-form" class="hidden">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Guide Panel -->
                <div class="lg:w-1/3">
                    <div class="bg-white p-6 rounded-lg shadow-md sticky top-6 hidden lg:block">
                        <h3 class="text-lg font-semibold mb-4">Panduan Pengisian</h3>
                        
                        <div class="space-y-4">
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <h4 class="font-medium text-blue-700">1. Informasi Pemilik</h4>
                                <p class="text-sm text-gray-600 mt-1">Isi data diri Anda sebagai pemilik usaha laundry</p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-700">2. Informasi Usaha</h4>
                                <p class="text-sm text-gray-600 mt-1">Lengkapi data usaha laundry Anda</p>
                            </div>
                            
                            <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-medium text-gray-700">3. Dokumen</h4>
                                    <p class="text-sm text-gray-600 mt-1">Upload dokumen pendukung</p>
                                </div>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-medium text-gray-700">4. Layanan</h4>
                                <p class="text-sm text-gray-600 mt-1">Tentukan jenis layanan dan harga</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 border-t pt-4">
                            <h4 class="font-medium mb-2">Persyaratan:</h4>
                            <ul class="text-sm space-y-2 text-gray-600">
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Memiliki usaha laundry yang beroperasi</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Bersedia mengikuti ketentuan platform</span>
                                </li>
                                <li class="flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>Menyediakan dokumen yang diperlukan</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Mobile Guide Toggle -->
                    <button id="guide-toggle" class="lg:hidden fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg z-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                    
                    <!-- Mobile Guide Panel -->
                    <div id="mobile-guide" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden lg:hidden">
                        <div class="absolute bottom-0 left-0 right-0 bg-white rounded-t-2xl p-6 max-h-[70vh] overflow-y-auto">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold">Panduan Pengisian</h3>
                                <button id="close-guide" class="text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-blue-50 rounded-lg">
                                    <h4 class="font-medium text-blue-700">1. Informasi Pemilik</h4>
                                    <p class="text-sm text-gray-600 mt-1">Isi data diri Anda sebagai pemilik usaha laundry</p>
                                </div>
                                
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-medium text-gray-700">2. Informasi Usaha</h4>
                                    <p class="text-sm text-gray-600 mt-1">Lengkapi data usaha laundry Anda</p>
                                </div>
                                
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-medium text-gray-700">3. Dokumen</h4>
                                    <p class="text-sm text-gray-600 mt-1">Upload dokumen pendukung</p>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-medium text-gray-700">4. Layanan</h4>
                                    <p class="text-sm text-gray-600 mt-1">Tentukan jenis layanan dan harga</p>
                                </div>
                            </div>
                            
                            <div class="mt-6 border-t pt-4">
                                <h4 class="font-medium mb-2">Persyaratan:</h4>
                                <ul class="text-sm space-y-2 text-gray-600">
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Memiliki usaha laundry yang beroperasi</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Bersedia mengikuti ketentuan platform</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Menyediakan dokumen yang diperlukan</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Form Panel -->
                <div class="lg:w-2/3">
                    <div class="bg-white p-8 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-center mb-6">Daftar Menjadi Mitra Laundry</h2>
                        
                        <!-- Progress Steps -->
                        <div class="flex justify-between mb-8">
                            <div class="step flex-1 text-center" data-step="1">
                                <div class="step-number mx-auto w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center mb-2">1</div>
                                <div class="step-title font-medium">Informasi Pemilik</div>
                            </div>
                            <div class="step flex-1 text-center" data-step="2">
                                <div class="step-number mx-auto w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center mb-2">2</div>
                                <div class="step-title font-medium text-gray-500">Informasi Usaha</div>
                            </div>
                            <div class="step flex-1 text-center" data-step="3">
                                <div class="step-number mx-auto w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center mb-2">3</div>
                                <div class="step-title font-medium text-gray-500">Dokumen</div>
                            </div>
                            <div class="step flex-1 text-center" data-step="4">
                                <div class="step-number mx-auto w-10 h-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center mb-2">4</div>
                                <div class="step-title font-medium text-gray-500">Layanan</div>
                            </div>
                        </div>

                        <form action="{{ route('register.mitra') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            
                            <!-- Section 1: Informasi Pemilik -->
                            <div id="section-1" class="form-section">
                                <h3 class="text-lg font-semibold mb-4">Informasi Pemilik</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nama_pemilik" class="block font-medium">Nama Pemilik</label>
                                        <input type="text" name="nama_pemilik" class="w-full p-2 border rounded-md" 
                                               value="{{ Auth::check() ? Auth::user()->nama : '' }}" required>
                                        @error('nama_pemilik')
                                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="nomor_hp" class="block font-medium">Nomor HP/WhatsApp</label>
                                        <input type="tel" name="nomor_hp" class="w-full p-2 border rounded-md" 
                                               value="{{ Auth::check() ? Auth::user()->phone : '' }}" 
                                               pattern="[0-9]{10,15}" required>
                                               @error('nomor_hp')
                                               <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                           @enderror
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex justify-end">
                                    <button type="button" class="next-section bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition" data-next="2">Selanjutnya</button>
                                </div>
                            </div>
                            
                            <!-- Section 2: Informasi Usaha -->
                            <div id="section-2" class="form-section hidden">
                                <h3 class="text-lg font-semibold mb-4">Informasi Usaha Laundry</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nama_laundry" class="block font-medium">Nama Laundry</label>
                                        <input type="text" name="nama_laundry" class="w-full p-2 border rounded-md" required>
                                        @error('nama_laundry')
                                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="alamat" class="block font-medium">Alamat Lengkap</label>
                                        <input type="text" name="alamat" class="w-full p-2 border rounded-md" required>
                                    </div>
                                    @error('alamat')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="jam_operasional" class="block font-medium">Jam Operasional</label>
                                        <input type="text" name="jam_operasional" class="w-full p-2 border rounded-md" placeholder="08:00 - 21:00" required>
                                    </div>
                                    <div>
                                        <label for="harga" class="block font-medium">Harga per Kg (Rp)</label>
                                        <input type="number" name="harga" class="w-full p-2 border rounded-md" min="1000" required>
                                    </div>
                                </div>
                        
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                    <div>
                                        <label for="nomor_rekening" class="block font-medium">Nomor Rekening</label>
                                        <input type="text" name="nomor_rekening" class="w-full p-2 border rounded-md" required>
                                    </div>
                                    <div>
                                        <label for="kategori_layanan" class="block font-medium">Kategori Layanan</label>
                                        <select name="kategori_layanan" class="w-full p-2 border rounded-md" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="cuci">Cuci Saja</option>
                                            <option value="setrika">Setrika Saja</option>
                                            <option value="cuci dan setrika">Cuci dan Setrika</option>
                                        </select>
                                    </div>
                                </div>
                        
                                <div class="mt-4">
                                    <label for="deskripsi" class="block font-medium">Deskripsi Singkat</label>
                                    <textarea name="deskripsi" class="w-full p-2 border rounded-md" rows="3" required></textarea>
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
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">
                                </div>
                                
                                <div class="mt-6 flex justify-between">
                                    <button type="button" class="prev-section bg-gray-300 text-gray-700 py-2 px-6 rounded-md hover:bg-gray-400 transition" data-prev="1">Kembali</button>
                                    <button type="button" class="next-section bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition" data-next="3">Selanjutnya</button>
                                </div>
                            </div>
                            
                            <!-- Section 3: Dokumen -->
                            <div id="section-3" class="form-section hidden">
                                <h3 class="text-lg font-semibold mb-4">Dokumen Pendukung</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label for="foto_tempat" class="block font-medium mb-2">Foto Tempat Usaha</label>
                                        <input type="file" name="foto_tempat" class="w-full p-2 border rounded-md" accept="image/*" required>
                                        <p class="text-sm text-gray-500 mt-1">Format: JPG/PNG (Max 2MB)</p>
                                    </div>
                                    
                                    <div>
                                        <label for="foto_bukti" class="block font-medium mb-2">Foto Bukti Kepemilikan Usaha</label>
                                        <input type="file" name="foto_bukti" class="w-full p-2 border rounded-md" accept="image/*" required>
                                        <p class="text-sm text-gray-500 mt-1">Format: JPG/PNG (Max 2MB)</p>
                                    </div>
                                </div>
                                
                                <div class="mt-6 flex justify-between">
                                    <button type="button" class="prev-section bg-gray-300 text-gray-700 py-2 px-6 rounded-md hover:bg-gray-400 transition" data-prev="2">Kembali</button>
                                    <button type="button" class="next-section bg-blue-600 text-white py-2 px-6 rounded-md hover:bg-blue-700 transition" data-next="4">Selanjutnya</button>
                                </div>
                            </div>
                            
                            <!-- Section 4: Layanan -->
                            <div id="section-4" class="form-section hidden">
                                <h3 class="text-lg font-semibold mb-4">Pilih Paket Layanan</h3>
                                <div class="space-y-4">
                                    @foreach ($paket_pakaian as $paket)
                                        <div class="flex items-center">
                                            <input class="mr-2 paket-checkbox" type="checkbox" 
                                                   name="paket_pakaian[]" value="{{ $paket->id }}" 
                                                   id="paket_{{ $paket->id }}">
                                            <label for="paket_{{ $paket->id }}">
                                                {{ $paket->nama }} ({{ $paket->jenisPakaian->pluck('nama')->join(', ') }})
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                <button type="button" id="tambah-jenis" class="mt-4 text-blue-600 hover:text-blue-800 flex items-center">
                                <div class="mt-6 flex justify-between">
                                    <button type="button" class="prev-section bg-gray-300 text-gray-700 py-2 px-6 rounded-md hover:bg-gray-400 transition" data-prev="3">Kembali</button>
                                    <button type="submit" class="bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-700 transition">
                                        Daftar sebagai Mitra
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection()
<!-- Leaflet.js for Maps -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    .step-number {
        transition: all 0.3s ease;
    }
    
    .step.active .step-number {
        background-color: #2563eb;
        color: white;
    }
    
    .step.active .step-title {
        color: #111827;
    }
    
    .form-section {
        transition: all 0.3s ease;
    }
    
    #map {
        z-index: 0;
        height: 400px; /* or any value to ensure proper display */

    }
    
    #locate-me {
        background-color: #fff;
        border: 1px solid #ddd;
        cursor: pointer;
    }
    
    #locate-me:hover {
        background-color: #f8f9fa;
    }
    
    /* Guide panel animation */
    #mobile-guide {
        transition: all 0.3s ease;
    }
    
    #mobile-guide.show {
        display: block;
        opacity: 1;
    }
</style>

<script>
    
    document.addEventListener("DOMContentLoaded", function () {
        // Show/hide registration form
        const initialCard = document.getElementById('initial-card');
        const registrationForm = document.getElementById('registration-form');
        const startRegistrationBtn = document.getElementById('start-registration');
        
        startRegistrationBtn.addEventListener('click', function() {
            initialCard.classList.add('hidden');
            registrationForm.classList.remove('hidden');
        });
          // Dynamic Jenis Layanan
          let jenisIndex = 1;
        const jenisContainer = document.getElementById('jenis-container');
        const initialJenisItem = document.querySelector('.jenis-item');

        document.getElementById('tambah-jenis').addEventListener('click', function() {
            const newItem = initialJenisItem.cloneNode(true);
            const inputs = newItem.querySelectorAll('input');
            
            // Update input names
            inputs[0].name = `jenis_pakaian[${jenisIndex}][nama]`;
            inputs[1].name = `jenis_pakaian[${jenisIndex}][harga]`;
            
            // Reset values
            inputs[0].value = '';
            inputs[1].value = '';
            
            // Show remove button
            newItem.querySelector('.remove-jenis').classList.remove('hidden');
            
            jenisContainer.appendChild(newItem);
            jenisIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-jenis')) {
                if (document.querySelectorAll('.jenis-item').length > 1) {
                    e.target.closest('.jenis-item').remove();
                } else {
                    alert('Minimal harus ada satu jenis layanan');
                }
            }
        });
        // Mobile guide toggle
        const guideToggle = document.getElementById('guide-toggle');
        const mobileGuide = document.getElementById('mobile-guide');
        const closeGuide = document.getElementById('close-guide');
        
        guideToggle.addEventListener('click', function() {
            mobileGuide.classList.remove('hidden');
            setTimeout(() => {
                mobileGuide.classList.add('show');
            }, 10);
        });
        
        closeGuide.addEventListener('click', function() {
            mobileGuide.classList.remove('show');
            setTimeout(() => {
                mobileGuide.classList.add('hidden');
            }, 300);
        });
        
        // Navigation between sections
        const nextButtons = document.querySelectorAll('.next-section');
        const prevButtons = document.querySelectorAll('.prev-section');
        
        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentSection = this.closest('.form-section');
                const nextSectionId = this.getAttribute('data-next');
                
                currentSection.classList.add('hidden');
                document.getElementById(`section-${nextSectionId}`).classList.remove('hidden');
                
                // Update progress steps
                updateProgressSteps(nextSectionId);
                
                // Update guide highlights
                updateGuideHighlights(nextSectionId);
            });
        });
        
        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                const currentSection = this.closest('.form-section');
                const prevSectionId = this.getAttribute('data-prev');
                
                currentSection.classList.add('hidden');
                document.getElementById(`section-${prevSectionId}`).classList.remove('hidden');
                
                // Update progress steps
                updateProgressSteps(prevSectionId);
                
                // Update guide highlights
                updateGuideHighlights(prevSectionId);
            });
        });
        
        function updateProgressSteps(activeStep) {
            document.querySelectorAll('.step').forEach(step => {
                const stepNumber = step.getAttribute('data-step');
                
                // Reset all steps
                step.querySelector('.step-number').classList.remove('bg-blue-600', 'text-white');
                step.querySelector('.step-number').classList.add('bg-gray-300', 'text-gray-600');
                step.querySelector('.step-title').classList.add('text-gray-500');
                step.querySelector('.step-title').classList.remove('text-gray-800');
                
                // Active step and completed steps
                if (stepNumber <= activeStep) {
                    step.querySelector('.step-number').classList.remove('bg-gray-300', 'text-gray-600');
                    step.querySelector('.step-number').classList.add('bg-blue-600', 'text-white');
                    step.querySelector('.step-title').classList.remove('text-gray-500');
                    step.querySelector('.step-title').classList.add('text-gray-800');
                }
            });
        }
        
        function updateGuideHighlights(activeStep) {
            const guideItems = document.querySelectorAll('.lg\\:w-1\\/3 .bg-blue-50, .lg\\:w-1\\/3 .bg-gray-50');
            const mobileGuideItems = document.querySelectorAll('#mobile-guide .bg-blue-50, #mobile-guide .bg-gray-50');
            
            // Reset all guide items
            guideItems.forEach(item => {
                item.classList.remove('bg-blue-50');
                item.classList.add('bg-gray-50');
                const title = item.querySelector('h4');
                title.classList.remove('text-blue-700');
                title.classList.add('text-gray-700');
            });
            
            mobileGuideItems.forEach(item => {
                item.classList.remove('bg-blue-50');
                item.classList.add('bg-gray-50');
                const title = item.querySelector('h4');
                title.classList.remove('text-blue-700');
                title.classList.add('text-gray-700');
            });
            
            // Highlight current step
            if (activeStep === '1') {
                guideItems[0].classList.remove('bg-gray-50');
                guideItems[0].classList.add('bg-blue-50');
                const title1 = guideItems[0].querySelector('h4');
                title1.classList.remove('text-gray-700');
                title1.classList.add('text-blue-700');
                
                mobileGuideItems[0].classList.remove('bg-gray-50');
                mobileGuideItems[0].classList.add('bg-blue-50');
                const mobileTitle1 = mobileGuideItems[0].querySelector('h4');
                mobileTitle1.classList.remove('text-gray-700');
                mobileTitle1.classList.add('text-blue-700');
            } else if (activeStep === '2') {
                guideItems[1].classList.remove('bg-gray-50');
                guideItems[1].classList.add('bg-blue-50');
                const title2 = guideItems[1].querySelector('h4');
                title2.classList.remove('text-gray-700');
                title2.classList.add('text-blue-700');
                
                mobileGuideItems[1].classList.remove('bg-gray-50');
                mobileGuideItems[1].classList.add('bg-blue-50');
                const mobileTitle2 = mobileGuideItems[1].querySelector('h4');
                mobileTitle2.classList.remove('text-gray-700');
                mobileTitle2.classList.add('text-blue-700');
            } else if (activeStep === '3') {
                guideItems[2].classList.remove('bg-gray-50');
                guideItems[2].classList.add('bg-blue-50');
                const title3 = guideItems[2].querySelector('h4');
                title3.classList.remove('text-gray-700');
                title3.classList.add('text-blue-700');
                
                mobileGuideItems[2].classList.remove('bg-gray-50');
                mobileGuideItems[2].classList.add('bg-blue-50');
                const mobileTitle3 = mobileGuideItems[2].querySelector('h4');
                mobileTitle3.classList.remove('text-gray-700');
                mobileTitle3.classList.add('text-blue-700');
            }
        }
        
        // Initialize map
        var defaultLocation = [-6.200000, 106.816666]; // Jakarta default
        var map = L.map('map').setView([defaultLocation[0], defaultLocation[1]], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker = L.marker(defaultLocation, { 
            draggable: true,
            autoPan: true
        }).addTo(map);

        marker.on('dragend', function (event) {
            var position = marker.getLatLng();
            updatePositionInputs(position.lat, position.lng);
        });

        updatePositionInputs(defaultLocation[0], defaultLocation[1]);

        function updatePositionInputs(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        }

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

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updatePositionInputs(e.latlng.lat, e.latlng.lng);
        });
        
        // Package checkbox functionality
        const paketCheckboxes = document.querySelectorAll('.paket-checkbox');
        const pakaianCheckboxes = document.querySelectorAll('.jenis-pakaian-checkbox');

        // Initialize progress steps
        updateProgressSteps(1);
        updateGuideHighlights(1);
    });
</script>