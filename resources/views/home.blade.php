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
        <div class="container mx-auto px-4 text-center text-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Cuci Card -->
                <div class="bg-blue-700 p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-xl flex items-center justify-center mb-4">
                        <div class="w-[52px] h-[52px] flex items-center justify-center overflow-hidden">
                            @include("components.icon-cuci")
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cuci</h3>
                    <p class="">Pakaian Anda dicuci dengan detergen berkualitas dan proses hygienis.</p>
                </div>
                
                <!-- Setrika Card -->
                <div class="bg-blue-700  p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-xl flex items-center justify-center mb-4">
                        <div class="w-[52px] h-[52px] flex items-center justify-center overflow-hidden">
                            @include("components.icon-setrika")
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Setrika</h3>
                    <p class="">Pakaian disetrika rapi dengan hasil sempurna tanpa merusak bahan.</p>
                </div>
                
                <!-- Cuci & Setrika Card -->
                <div class="bg-blue-700 p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-blue-100 w-20 h-20 mx-auto rounded-xl flex items-center justify-center mb-4">
                        <div class="w-[52px] h-[52px] flex items-center justify-center overflow-hidden">
                            @include("components.icon-cucisetrika")
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Cuci & Setrika</h3>
                    <p class="">Paket lengkap mulai dari pencucian hingga penyetrikaan profesional.</p>
                </div>
            </div>
        </div>
    </section>
    @include('partials.laundry-recommendations')
    @include('partials.laundry-best-recomendation')
   

    <section class="py-16">
    <div class="container mx-auto px-4 text-center">
        
        <h2 class="text-2xl font-bold mb-8">Mengapa Nyuci?</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                    <div class="w-[52px] h-[52px] flex items-center justify-center overflow-hidden">
                        @include("components.icon-pesanonline")
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-2">Pesan Online</h3>
                <p class="">Mudah dan praktis, pesan kapan saja di aplikasi.</p>
            </div>
            
            <div class="bg-white  p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                    <div class="w-[52px] h-[52px] flex items-center justify-center overflow-hidden">
                        @include("components.icon-terpercaya")
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-2">Terpercaya</h3>
                <p class="">Detail pesanan tercatat, barang aman tanpa khawatir hilang.</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="100">
                <div class="bg-blue-100 w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4">
                    <div class="w-[52px] h-[52px] flex items-center justify-center overflow-hidden">
                        @include("components.icon-diantar")
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-2">Antar-Jemput</h3>
                <p class="">Kenyamanan layanan ojek siap antar-jemput cucian Anda.</p>
            </div>
        </div>
        </div>
    </section>
  

    <!-- Mitra Registration Section -->
    @auth
        @include('auth.register_mitra')
    @endauth


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
