{{-- @extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content') --}}
    {{-- <!-- Hero Section -->
    <section class="text-center py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold">Laundry Pakaian di Nyuci</h1>
            <p class="text-lg text-gray-600">Pakaian Bersih dan Segar!</p>
            <p class="mt-4 text-gray-500">Nikmati layanan laundry cepat, berkualitas, dan terpercaya. Kami siap mencuci, mengeringkan, dan merapikan pakaian Anda dengan hasil terbaik. Pesan sekarang dan rasakan kemudahan tanpa harus repot!</p>
            <a href="/packages" class="mt-6 inline-block bg-blue-500 text-white px-6 py-3 rounded-lg text-lg">Mulai Layanan Kami</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16">
        <div class="container mx-auto px-4 text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <i class="fas fa-washing-machine text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Cuci</h3>
                    <p class="text-gray-600">Get your laundry done quickly and efficiently.</p>
                </div>
                <div>
                    <i class="fas fa-iron text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Setrika</h3>
                    <p class="text-gray-600">We iron your clothes to perfection.</p>
                </div>
                <div>
                    <i class="fas fa-cogs text-5xl mb-4"></i>
                    <h3 class="text-xl font-semibold">Cuci & Setrika</h3>
                    <p class="text-gray-600">Complete laundry services, including washing and ironing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nearby Laundry Recommendation Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold">Rekomendasi Laundry Terdekat</h2>
            <p class="text-gray-600 mb-6">Temukan laundry terdekat yang siap memberikan layanan berkualitas!</p>
            <div class="flex justify-center gap-4">
                <input type="text" class="border border-gray-300 rounded-lg px-4 py-2 w-1/2" placeholder="Lokasi Saat Ini">
                <button class="bg-blue-500 text-white px-6 py-2 rounded-lg">Cari</button>
            </div>
        </div>
    </section>

    <section class="py-16">
        @if(isset($rekomendasi) && count($rekomendasi) > 0)
            @foreach ($rekomendasi as $laundry)
                <div class="bg-white p-4 rounded-lg shadow-lg text-center">
                    <img src="{{ asset('storage/' . $laundry->foto_tempat) }}" 
                        alt="{{ $laundry->nama_laundry }}" 
                        class="w-full h-48 object-cover rounded-md">
                    
                    <h3 class="text-xl font-semibold mt-4">{{ $laundry->nama_laundry }}</h3>
                    <p class="text-gray-500">Pemilik: {{ $laundry->nama_pemilik }}</p>
                    <p class="text-gray-500">Kategori: {{ $kategoriFavorit->nama ?? 'Populer' }}</p>
                    <p class="text-yellow-500 text-lg">&#9733; {{ $laundry->rating }}</p>

                    <a href="/laundry/{{ $laundry->id }}" 
                        class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg">
                        Pesan Sekarang
                    </a>
                </div>
            @endforeach
        @else --}}
            <p class="text-center text-gray-500">Belum ada rekomendasi.</p>
        {{-- @endif

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
    @include('auth.register_mitra') --}}
{{-- 
@endsection


@push('scripts')
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
@endpush --}}
