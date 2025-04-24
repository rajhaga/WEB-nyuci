@extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content')
    <!-- Hero Section -->
    <section class="bg-blue-50 py-16">
        <div class="container mx-auto px-6 md:px-12 flex flex-col-reverse md:flex-row items-center gap-10">
          
          <!-- Bagian Kiri - Teks -->
          <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-4xl md:text-5xl font-bold text-blue-500">
              Laundry Pakaian di <span class="text-blue-700">Nyuci</span>
            </h1>
            <h2 class="text-2xl md:text-3xl font-bold mt-2 text-black">
              Pakaian <span class="text-blue-600">Bersih</span> dan Segar!
            </h2>
            <p class="mt-6 text-lg text-gray-700">
              Nikmati layanan laundry cepat, berkualitas, dan terpercaya. Kami siap mencuci, mengeringkan, dan merapikan pakaian Anda dengan hasil terbaik. Pesan sekarang dan rasakan kemudahan tanpa harus repot!
            </p>
            <a href="/packages" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-blue-700 transition">
              Mulai Layanan Kami
            </a>
      
            <!-- Bagian Pengguna -->
            <div class="mt-6 flex items-center justify-center md:justify-start">
              <img src="images\home\man.png" alt="User 1" class="h-10 w-10 rounded-full border-2 border-white -ml-0">
              <img src="images\home\man2.png" alt="User 2" class="h-10 w-10 rounded-full border-2 border-white -ml-3">
              <span class="ml-4 text-gray-600 text-sm">+2000 Pengguna</span>
            </div>
          </div>
      
          <!-- Bagian Kanan - Gambar -->
          <div class="md:w-1/2 relative flex justify-center items-center h-72">
            <div class="flex justify-center items-center">
                <img src="images/home/image.png" alt="Laundry & Wanita Bahagia" class="w-[500px] h-auto">
              </div>              
          </div>
          
      
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
<!-- Mitra Registration Section -->
           
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
        <!-- Main Card Container -->
        <div class="bg-white p-8 md:p-12 rounded-xl shadow-lg text-center">
            <!-- Main Heading -->
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 md:mb-8">
                Daftarkan Dirimu Menjadi <span class="text-blue-600">Bagian Nyuci</span>
            </h1>
            
            <!-- Description -->
            <div class="mb-8 md:mb-10">
                <p class="text-lg text-gray-600 leading-relaxed max-w-2xl mx-auto">
                    Daftarkan dirimu menjadi bagian Nyuci dan bergabunglah dalam jaringan kami untuk meraih peluang baru serta memberikan layanan laundry terbaik kepada pelanggan!
                </p>
            </div>
            
            <!-- Decorative Divider -->
            <div class="border-t border-gray-200 w-16 mx-auto my-6 md:my-8"></div>
            
            <!-- Icon Section -->
            <div class="mb-8 md:mb-10 flex justify-center">
                <div class="bg-blue-100 p-6 rounded-full">
                    <img src="{{ asset('images/icons/partner-icon.png') }}" alt="Mitra Icon" class="w-24 md:w-32 max-w-full h-auto">
                </div>
            </div>
            
            <!-- DAFTAR Heading -->
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-8 tracking-wide">DAFTAR</h2>
            
            <!-- CTA Button -->
            <div class="mt-6 md:mt-8">
                <a href="{{ route('register.mitra') }}" 
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 md:py-4 px-8 md:px-12 rounded-full shadow-md hover:shadow-lg transition-all duration-300">
                        Mulai Pendaftaran
                    </a>
            </div>
        </div>
    </div>
</section>


    <!-- Mitra Registration Section -->
    {{-- @auth
        @include('auth.register_mitra')
    @endauth --}}


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
