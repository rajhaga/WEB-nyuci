@extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content')
    <!-- Hero Section -->
    <section class="text-center py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold">Laundry Pakaian di Nyuci</h1>
            <p class="text-lg text-gray-600">Pakaian Bersih dan Segar!</p>
            <p class="mt-4 text-gray-500">Nikmati layanan laundry cepat, berkualitas, dan terpercaya. Kami siap mencuci, mengeringkan, dan merapikan pakaian Anda dengan hasil terbaik. Pesan sekarang dan rasakan kemudahan tanpa harus repot!</p>
            <a href="/packages" class="mt-6 inline-block bg-blue-500 text-white px-6 py-3 rounded-lg text-lg">Mulai Layanan Kami</a>
        </div>
    </section>
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-washing-machine text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cuci</h3>
                    <p class="text-gray-600">Pakaian Anda dicuci dengan detergen berkualitas dan proses hygienis.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-iron text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Setrika</h3>
                    <p class="text-gray-600">Pakaian disetrika rapi dengan hasil sempurna tanpa merusak bahan.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="300">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-cogs text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cuci & Setrika</h3>
                    <p class="text-gray-600">Paket lengkap mulai dari pencucian hingga penyetrikaan profesional.</p>
                </div>
            </div>
        </div>
    </section>
@include('partials.laundry-recommendations')

    <section class="py-16">
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

    </section>
    
    <!-- Why Choose Nyuci Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-6">Mengapa Nyuci?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <i class="fas fa-wifi text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Pesan Online</h3>
                    <p class="text-gray-600">Mudah dan praktis, pesan kapan saja di aplikasi.</p>
                </div>
                <div>
                    <i class="fas fa-shield-alt text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Terpercaya</h3>
                    <p class="text-gray-600">Detail pesanan tercatat, barang aman tanpa khawatir hilang.</p>
                </div>
                <div>
                    <i class="fas fa-bicycle text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Antar-Jemput</h3>
                    <p class="text-gray-600">Kenyamanan layanan ojek siap antar-jemput cucian Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mitra Registration Section -->
    @include('auth.register_mitra')

@endsection
@include('partials.laundry-recommendations-js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select package and clothing checkboxes
        const paketCheckboxes = document.querySelectorAll(".paket-checkbox");
        const pakaianCheckboxes = document.querySelectorAll(".jenis-pakaian-checkbox");

        paketCheckboxes.forEach(paket => {
            paket.addEventListener("change", function() {
                const paketId = this.value;
                const pakaianDalamPaket = @json($paket_pakaian->mapWithKeys(fn($p) => [$p->id => $p->jenisPakaian->pluck('id')]));

                // Check or uncheck pakaian items based on package selection
                pakaianDalamPaket[paketId].forEach(id => {
                    document.getElementById("jenis_pakaian_" + id).checked = this.checked;
                });
            });
        });
    });
</script>
