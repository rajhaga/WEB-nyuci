@extends('layouts.app')

@section('title', 'Nyuci - Home')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center py-5 bg-light">
        <div class="container">
            <h1 class="display-4">Laundry Pakaian di Nyuci</h1>
            <p class="lead">Pakaian Bersih dan Segar!</p>
            <p class="mb-4">Nikmati layanan laundry cepat, berkualitas, dan terpercaya. Kami siap mencuci, mengeringkan, dan merapikan pakaian Anda dengan hasil terbaik. Pesan sekarang dan rasakan kemudahan tanpa harus repot!</p>
            <a href="/packages" class="btn btn-primary btn-lg">Mulai Layanan Kami</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-washing-machine fa-3x mb-3"></i>
                    <h3>Cuci</h3>
                    <p>Get your laundry done quickly and efficiently.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-iron fa-3x mb-3"></i>
                    <h3>Setrika</h3>
                    <p>We iron your clothes to perfection.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-cogs fa-3x mb-3"></i>
                    <h3>Cuci & Setrika</h3>
                    <p>Complete laundry services, including washing and ironing.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nearby Laundry Recommendation Section -->
    <section class="nearby-laundry-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Rekomendasi Laundry Terdekat</h2>
            <p class="text-center mb-4">Temukan laundry terdekat yang siap memberikan layanan berkualitas, sehingga pakaian bersih, wangi, dan siap digunakan!</p>
            <div class="d-flex justify-content-center">
                <input type="text" class="form-control w-50" placeholder="Lokasi Saat Ini">
                <button class="btn btn-primary ms-2">Cari</button>
            </div>
        </div>
    </section>

    <!-- Why Choose Nyuci Section -->
    <section class="why-choose-nyuci py-5">
        <div class="container">
            <h2 class="text-center mb-4">Mengapa Nyuci?</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-wifi fa-3x mb-3"></i>
                    <h3>Pesan Online</h3>
                    <p>Mudah dan praktis, pesan kapan saja di aplikasi.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-shield-alt fa-3x mb-3"></i>
                    <h3>Terpercaya</h3>
                    <p>Detail pesanan tercatat, barang aman tanpa khawatir hilang.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-bicycle fa-3x mb-3"></i>
                    <h3>Antar-Jemput</h3>
                    <p>Kenyamanan layanan ojek siap antar-jemput cucian Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mitra Registration Section -->
    @include('auth.register_mitra')

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
@endpush
