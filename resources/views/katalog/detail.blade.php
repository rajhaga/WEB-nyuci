@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Back Button -->
    <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6 transition-colors duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
        Kembali
    </a>

    <!-- Main Product Section -->
    <div class="flex flex-col lg:flex-row gap-8 mb-12">
        <!-- Left Column - Image Gallery -->
        <div class="lg:w-1/2">
            <!-- Main Image -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-4 transition-all duration-300 hover:shadow-lg">
                <img id="mainImage" src="{{ asset('storage/' . $mitra->foto_tempat) }}" 
                     class="w-full h-96 object-cover cursor-zoom-in transition-transform duration-500 hover:scale-105" 
                     alt="{{ $mitra->nama_laundry }}">
            </div>

            <!-- Thumbnail Gallery -->
            <div class="flex space-x-3 overflow-x-auto pb-2">
                @foreach([$mitra->foto_tempat, 'https://via.placeholder.com/300x200?text=Interior+Laundry', 'https://via.placeholder.com/300x200?text=Proses+Cuci'] as $index => $image)
                <div class="flex-shrink-0">
                    <img src="{{ $index === 0 ? asset('storage/' . $image) : $image }}" 
                         class="thumbnail w-20 h-20 object-cover rounded-md {{ $index === 0 ? 'border-2 border-blue-500' : 'border border-gray-200' }} cursor-pointer hover:opacity-80 transition-all duration-200"
                         onclick="changeMainImage(this.src)"
                         alt="Thumbnail {{ $index + 1 }}">
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Column - Product Info -->
        <div class="lg:w-1/2">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-4 transition-all duration-300 hover:shadow-lg">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $mitra->nama_laundry }}</h1>
                
                <div class="flex items-center mb-4">
                    <div class="flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        <span class="font-medium">{{ $mitra->rating }}</span>
                    </div>
                    <span class="text-gray-600">• {{ $mitra->ulasan_count }} ulasan</span>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-2">Harga Mulai Dari</h3>
                    <p class="text-2xl font-bold text-blue-600">Rp{{ number_format($mitra->harga, 0, ',', '.') }} /kg</p>
                    <button onclick="openUnitModal()" class="text-blue-600 hover:text-blue-800 text-sm mt-1 flex items-center transition-colors duration-200">
                        Lihat detail satuan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Services Offered -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-blue-800 mb-2">Layanan yang Ditawarkan</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach([
                            ['Cuci Reguler', '1-2 hari', 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z'],
                            ['Cuci Kilat', '6-8 jam', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                            ['Cuci + Setrika', 'Paket lengkap', 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z'],
                            ['Dry Cleaning', 'Khusus bahan', 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15']
                        ] as $service)
                        <div class="flex items-center bg-blue-50 p-3 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                            <div class="bg-blue-100 p-2 rounded-full mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $service[2] }}" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">{{ $service[0] }}</p>
                                <p class="text-sm text-blue-600">{{ $service[1] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Store Info -->
                <div class="space-y-4 mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-blue-800 mb-2">Alamat</h3>
                        <div class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-gray-700">{{ $mitra->alamat }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-blue-800 mb-2">Jam Operasional</h3>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-700">{{ $mitra->jam_operasional }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-blue-800 mb-2">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $mitra->deskripsi }}</p>
                    </div>
                </div>

                <button onclick="openOrderModal()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-bold text-lg shadow-md transition-all duration-300 transform hover:scale-[1.02] flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Pesan Laundry
                </button>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="min-h-screen bg-[#f5f5f5] text-black flex justify-center px-4 sm:px-6 lg:px-8 py-8">
        <main class="w-full max-w-5xl">
            <h1 class="text-2xl sm:text-3xl font-semibold text-blue-500 mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                Ulasan Pengguna
            </h1>
    
            <div class="bg-white rounded-xl shadow-md p-6 mb-12 transition-all duration-300 hover:shadow-lg">
                <div class="space-y-6">
                    @foreach($ulasan as $review)
                    <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-center mb-3">
                            <!-- Avatar for the reviewer -->
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-800 font-bold mr-4">
                                {{ strtoupper($review->user->nama[0]) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $review->user->name }}</h4>
                                <div class="flex items-center">
                                    <!-- Rating Stars -->
                                    <div class="flex text-yellow-400 mr-2">
                                        @for($i = 0; $i < 5; $i++)
                                            @if($i < $review->rating) <!-- Filled star -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @else <!-- Empty star -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-gray-500 text-sm">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                                
                            </div>
                        </div>
                        <p class="text-gray-700">{{ $review->komentar }}</p>
                    </div>
                    @endforeach
    
                    <!-- View All Reviews Button -->
                    <button class="w-full bg-blue-50 hover:bg-blue-100 text-blue-600 font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                        Lihat Semua Ulasan
                    </button>
                </div>
            </div>
        </main>
    </div>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="border-b border-gray-200 p-6 sticky top-0 bg-white z-10">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900">Pesan Laundry</h3>
                <button onclick="closeOrderModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 mt-1">{{ $mitra->nama_laundry }}</p>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <form action="{{ route('katalog.storeAndCheckout', $mitra->id) }}" method="POST">
                @csrf
                <div class="space-y-6">
                    @foreach($mitra->paketPakaian as $paket)
                    <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-500 transition-colors duration-200">
                        <h4 class="text-lg font-semibold text-blue-800 mb-3">{{ $paket->nama }}</h4>
                        <p class="text-blue-600 font-bold mb-3">Rp{{ number_format($paket->harga, 0, ',', '.') }}</p>
                        
                        <div class="space-y-3">
                            @foreach($jenisPakaianList as $jenisPakaian)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium">{{ $jenisPakaian->nama }}</p>
                                        <p class="text-sm text-blue-600">Rp{{ number_format($jenisPakaian->pivot->price, 0, ',', '.') }}/item</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" 
                                                class="quantity-btn decrease bg-blue-100 text-blue-800 w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-200 transition-all duration-200"
                                                data-id="{{ $jenisPakaian->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <span class="quantity-{{ $jenisPakaian->id }} w-8 text-center">0</span>
                                        <button type="button" 
                                                class="quantity-btn increase bg-blue-600 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-blue-700 transition-all duration-200"
                                                data-id="{{ $jenisPakaian->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <input type="hidden" name="quantities[{{ $mitra->id }}][{{ $jenisPakaian->id }}]" value="0" class="quantity-input-{{ $jenisPakaian->id }}">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Modal Footer -->
                <div class="mt-8 border-t border-gray-200 pt-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-bold text-lg shadow-md transition-all duration-300 transform hover:scale-[1.02]">
                        Lanjutkan ke Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Unit Information Modal -->
<div id="unitModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="border-b border-gray-200 p-6 sticky top-0 bg-white z-10">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900">Detail Satuan Laundry</h3>
                <button onclick="closeUnitModal()" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 mt-1">Jenis satuan yang kami terima</p>
        </div>

        <!-- Modal Body -->
        <div class="p-6">
            <div class="space-y-4">
                @foreach([
                    ['Satuan Per Item', [
                        'Kemeja - Rp5,000/item',
                        'Celana panjang - Rp7,000/item',
                        'Kaos - Rp3,500/item',
                        'Jaket - Rp10,000/item',
                        'Celana pendek - Rp4,000/item'
                    ]],
                    ['Satuan Kilo', [
                        'Cuci reguler - Rp15,000/kg',
                        'Cuci + setrika - Rp20,000/kg',
                        'Cuci kilat - Rp25,000/kg',
                        'Dry cleaning - Rp30,000/kg'
                    ]],
                    ['Satuan Khusus', [
                        'Bed cover - Rp25,000/item',
                        'Selimut - Rp20,000/item',
                        'Gorden - Rp15,000/lembar',
                        'Tas - Rp15,000/item'
                    ]]
                ] as $unit)
                <div class="border-b border-gray-200 pb-4">
                    <h4 class="font-bold text-blue-800 mb-2">{{ $unit[0] }}</h4>
                    <ul class="list-disc pl-5 space-y-1 text-gray-700">
                        @foreach($unit[1] as $item)
                        <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
                
                <div>
                    <h4 class="font-bold text-blue-800 mb-2">Catatan</h4>
                    <p class="text-gray-700">* Harga dapat berubah untuk bahan khusus seperti wool, sutra, atau leather</p>
                    <p class="text-gray-700">* Minimal order 2kg untuk layanan kiloan</p>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 p-4 bg-gray-50 rounded-b-xl">
            <button onclick="closeUnitModal()" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    // Change main image when thumbnail is clicked
    function changeMainImage(src) {
        const mainImage = document.getElementById('mainImage');
        mainImage.classList.add('opacity-0');
        setTimeout(() => {
            mainImage.src = src;
            mainImage.classList.remove('opacity-0');
        }, 200);
        
        document.querySelectorAll('.thumbnail').forEach(img => {
            img.classList.remove('border-2', 'border-blue-500');
            img.classList.add('border', 'border-gray-200');
        });
        event.target.classList.remove('border', 'border-gray-200');
        event.target.classList.add('border-2', 'border-blue-500');
    }

    // Modal functions
    function openOrderModal() {
        document.getElementById('orderModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeOrderModal() {
        document.getElementById('orderModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openUnitModal() {
        document.getElementById('unitModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeUnitModal() {
        document.getElementById('unitModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Quantity buttons
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const isIncrease = this.classList.contains('increase');
            const id = this.dataset.id;
            const quantityElement = document.querySelector(`.quantity-${id}`);
            const quantityInput = document.querySelector(`.quantity-input-${id}`);
            let currentQuantity = parseInt(quantityElement.textContent);
            
            this.classList.add('animate-ping');
            setTimeout(() => this.classList.remove('animate-ping'), 300);
            
            if (isIncrease) {
                currentQuantity++;
                quantityElement.textContent = currentQuantity;
                quantityInput.value = currentQuantity;
                quantityElement.classList.add('animate-bounce');
                setTimeout(() => quantityElement.classList.remove('animate-bounce'), 300);
            } else if (currentQuantity > 0) {
                currentQuantity--;
                quantityElement.textContent = currentQuantity;
                quantityInput.value = currentQuantity;
            }
        });
    });

    // Close modals when clicking outside
    document.getElementById('orderModal').addEventListener('click', function(e) {
        if (e.target === this) closeOrderModal();
    });
    
    document.getElementById('unitModal').addEventListener('click', function(e) {
        if (e.target === this) closeUnitModal();
    });
</script>

<style>
    @keyframes ping {
        75%, 100% { transform: scale(1.5); opacity: 0; }
    }
    .animate-ping { animation: ping 0.5s cubic-bezier(0, 0, 0.2, 1); }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(-5px); }
        50% { transform: translateY(5px); }
    }
    .animate-bounce { animation: bounce 0.5s; }
    
    #mainImage, .thumbnail, #orderModal, #unitModal {
        transition: all 0.3s ease-in-out;
    }
</style>
@endsection