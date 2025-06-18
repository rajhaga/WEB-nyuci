<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section for Favorite Category Recommendations -->
        @auth
            @if(isset($rekomendasiFavorit) && $rekomendasiFavorit->isNotEmpty())
                <h2 class="text-2xl font-bold text-center mb-8">Rekomendasi Berdasarkan Kategori Favorit Anda</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                    @foreach($rekomendasiFavorit as $laundry)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition duration-300 hover:-translate-y-1">
                            <img src="{{ asset('storage/' . $laundry->foto_tempat) }}" 
                                 alt="{{ $laundry->nama_laundry }}" 
                                 class="w-full h-48 object-cover">
                            <div class="p-4">
                                <div class="flex justify-between items-center mb-2">
                                    <h4 class="text-lg font-bold text-gray-800">{{ $laundry->nama_laundry }}</h4>
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-medium flex items-center">
                                        <i class="fas fa-star mr-1 text-yellow-500"></i> {{ $laundry->rating ?? 'Baru' }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-3">
                                    <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> 
                                    {{ Str::limit($laundry->alamat, 50) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-blue-600 font-semibold">Rp {{ number_format($laundry->harga, 0) }}/kg</span>
                                    <a href="/laundry/{{ $laundry->id }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
                                        <i class="fas fa-shopping-cart mr-1"></i> Pesan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endauth

        <!-- Section for Top Rating Recommendations -->
        <h2 class="text-2xl font-bold text-center mb-8">Laundry dengan Rating Tertinggi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($rekomendasiRating) && count($rekomendasiRating) > 0)
                @foreach($rekomendasiRating as $laundry)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-xl overflow-hidden transition duration-300 hover:-translate-y-1">
                        <img src="{{ asset('storage/' . $laundry->foto_tempat) }}" 
                             alt="{{ $laundry->nama_laundry }}" 
                             class="w-full h-48 object-cover">
                        <div class="p-4">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-lg font-bold text-gray-800">{{ $laundry->nama_laundry }}</h4>
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-medium flex items-center">
                                    <i class="fas fa-star mr-1 text-yellow-500"></i> {{ $laundry->rating ?? 'Baru' }}
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm mb-3">
                                <i class="fas fa-map-marker-alt text-blue-500 mr-1"></i> 
                                {{ Str::limit($laundry->alamat, 50) }}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-blue-600 font-semibold">Rp {{ number_format($laundry->harga, 0) }}/kg</span>
                                <a href="/laundry/{{ $laundry->id }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
                                    <i class="fas fa-shopping-cart mr-1"></i> Pesan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-20 col-span-full bg-white rounded-lg shadow">
                    <i class="fas fa-tint-slash text-6xl text-blue-300 mb-4"></i>
                    <h4 class="text-2xl font-semibold text-gray-700 mb-2">Belum ada laundry terdaftar</h4>
                    <p class="text-gray-500 mb-6">Silakan coba lagi nanti</p>
                </div>
            @endif
        </div>

        <!-- Empty state for logged in users with no favorite category -->
        @auth
            @if(!isset($rekomendasiFavorit) || $rekomendasiFavorit->isEmpty())
                <div class="text-center py-20 col-span-full bg-white rounded-lg shadow mt-12">
                    <i class="fas fa-tint-slash text-6xl text-blue-300 mb-4"></i>
                    <h4 class="text-2xl font-semibold text-gray-700 mb-2">Ups, belum ada rekomendasi khusus untuk Anda!</h4>
                    <p class="text-gray-500 mb-6">Mulai pengalaman laundry pertamamu untuk mendapatkan rekomendasi personal!</p>
                    <a href="/laundries" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-600 transition">
                        Cari Laundry Sekarang
                    </a>
                </div>
            @endif
        @endauth

        <!-- Empty state for non-logged in users -->
        @guest
            <div class="text-center py-20 col-span-full bg-white rounded-lg shadow mt-12">
                <i class="fas fa-lock text-6xl text-blue-300 mb-4"></i>
                <h4 class="text-2xl font-semibold text-gray-700 mb-2">Temukan Rekomendasi Terbaik!</h4>
                <p class="text-gray-500 mb-6">Bergabunglah untuk melihat rekomendasi laundry berdasarkan preferensimu</p>
                <div class="flex justify-center gap-4">
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-600 transition">
                        Masuk Sekarang
                    </a>
                </div>
            </div>
        @endguest
    </div>
</section>