<!-- Nearby Laundry Recommendation Section -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Rekomendasi Laundry Terdekat</h2>
            <p class="text-lg text-gray-600 mt-2">Temukan laundry berkualitas di sekitar lokasi Anda</p>
        </div>

        <!-- Search Section -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Map -->
                <div class="w-full md:w-1/2">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
                
                <!-- Location Input -->
                <div class="w-full md:w-1/2 flex flex-col">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Cari Berdasarkan Lokasi</h3>
                    <div class="relative mb-4">
                        <input type="text" id="locationInput" 
                               class="w-full p-3 border-2 border-blue-300 rounded-lg focus:border-blue-500 focus:outline-none"
                               placeholder="Masukkan lokasi Anda">
                        <button id="editLocation" class="absolute right-3 top-3 text-blue-500">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                    <button id="searchBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-medium transition">
                        <i class="fas fa-search mr-2"></i> Cari Laundry Terdekat
                    </button>
                    
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <h4 class="font-medium text-blue-800 mb-2">Petunjuk:</h4>
                        <p class="text-sm text-blue-600">
                            1. Klik tombol "Cari" untuk menemukan laundry terdekat<br>
                            2. Geser pin pada peta untuk mengubah lokasi pencarian<br>
                            3. Klik laundry untuk melihat detail
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold mb-6 text-gray-800 flex items-center justify-center">
                <i class="fas fa-store mr-3 text-blue-500"></i> Hasil Pencarian
            </h3>
            
            <!-- Loading Indicator -->
            <div id="loading" class="text-center py-8 hidden">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500 mb-4"></div>
                <p class="text-gray-600">Mencari laundry terdekat...</p>
            </div>
            
            <!-- Results Container -->
            <div id="resultsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if(isset($rekomendasi) && count($rekomendasi) > 0)
                    @foreach($rekomendasi as $laundry)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg">
                            <img src="{{ asset('storage/' . $laundry->foto_tempat) }}" 
                                 alt="{{ $laundry->nama_laundry }}" 
                                 class="w-full h-48 object-cover">
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $laundry->nama_laundry }}</h4>
                                    <span class="flex items-center bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">
                                        <i class="fas fa-star mr-1"></i> {{ $laundry->rating ?? 'Baru' }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i> 
                                    {{ Str::limit($laundry->alamat, 50) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-600 font-medium">Rp {{ number_format($laundry->harga, 0) }}/kg</span>
                                    <a href="/laundry/{{ $laundry->id }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
                                        <i class="fas fa-shopping-cart mr-1"></i> Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Initial empty state -->
                    <div id="emptyStateInitial" class="text-center py-12 col-span-3">
                        <i class="fas fa-tshirt text-5xl text-gray-300 mb-4"></i>
                        <h4 class="text-xl font-medium text-gray-500">Belum ada pencarian</h4>
                        <p class="text-gray-400 mb-4">Silakan cari laundry di sekitar lokasi Anda</p>
                    </div>
                @endif
            </div>
            
            <!-- Empty State (for dynamic search) -->
            <div id="emptyState" class="text-center py-12 hidden col-span-3">
                <i class="fas fa-tshirt text-5xl text-gray-300 mb-4"></i>
                <h4 class="text-xl font-medium text-gray-500">Tidak ada laundry ditemukan</h4>
                <p class="text-gray-400 mb-4">Coba cari di lokasi yang berbeda</p>
                <button id="tryAgainBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg">
                    Coba Lagi
                </button>
            </div>
        </div>
    </div>
</section>