@extends('layouts.mitra')

@section('mitracontent')
<div class="min-h-screen p-6 animate-fade-in">
    <!-- Header Section -->
    <div class="mb-8 animate-fade-in-down">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Kelola Pesanan
                </h1>
                <p class="text-gray-600 mt-1">Kelola semua pesanan pelanggan Anda</p>
            </div>
            <div class="relative">
                <input type="text" placeholder="Cari pesanan..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <div class="mb-6 animate-fade-in-down animation-delay-100">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('mitra.kelolaPesanan') }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === null ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
               </svg>
               Semua
            </a>
            
            <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Diproses']) }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === 'Diproses' ? 'bg-orange-600 text-white shadow-md' : 'bg-orange-100 text-orange-700 hover:bg-orange-200' }}">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
               </svg>
               Diproses
            </a>
            
            <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Selesai']) }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === 'Selesai' ? 'bg-green-600 text-white shadow-md' : 'bg-green-100 text-green-700 hover:bg-green-200' }}">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
               </svg>
               Selesai
            </a>
            
            <a href="{{ route('mitra.kelolaPesanan', ['status' => 'Dibatalkan']) }}" 
               class="px-4 py-2 rounded-xl flex items-center transition-all duration-300 
                      {{ request()->status === 'Dibatalkan' ? 'bg-red-600 text-white shadow-md' : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
               </svg>
               Dibatalkan
            </a>
        </div>
    </div>

    <!-- Orders Grid -->
    @if($orders->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($orders as $order)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all hover:scale-105 animate-fade-in animation-delay-{{ ($loop->index % 4) * 100 + 200 }}">
                    <!-- Order Header -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <span class="text-xs font-semibold text-gray-500">ORDER #{{ $order->kode_referral }}</span>
                            {{-- <h3 class="text-lg font-bold text-gray-800">{{ $order->user->nama }}</h3> --}}
                        </div>
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($order->status === 'Selesai') bg-green-100 text-green-800
                            @elseif($order->status === 'Diproses') bg-orange-100 text-orange-800
                            @elseif($order->status === 'Dibatalkan') bg-red-100 text-red-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                    
                    <!-- Order Details -->
                    <div class="px-6 py-4">
                        <div class="flex justify-between mb-3">
                            <span class="text-sm text-gray-500">Tanggal</span>
                            <span class="text-sm font-medium">{{ $order->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between mb-3">
                            <span class="text-sm text-gray-500">Total</span>
                            <span class="text-sm font-bold">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500">Pembayaran</span>
                            <span class="text-sm font-medium">{{ $order->metode_pembayaran }}</span>
                        </div>
                    </div>
                    
                    <!-- Order Actions -->
                    <div class="px-6 py-4 bg-gray-50 flex justify-between items-center">
                        <a href="" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail
                        </a>
                        <a href="{{ route('mitra.editStatus', $order->id) }}" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded-full hover:bg-indigo-700 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Update
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-12 text-center animate-fade-in animation-delay-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada pesanan</h3>
            <p class="mt-1 text-sm text-gray-500">
                @if(request()->status)
                    Tidak ada pesanan dengan status "{{ request()->status }}"
                @else
                    Belum ada pesanan yang diterima
                @endif
            </p>
        </div>
    @endif

    <!-- Enhanced Pagination -->
    @if($orders->count() > 0)
        <div class="flex items-center justify-between border-t border-gray-200 pt-4 animate-fade-in animation-delay-600">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="{{ $orders->nextPageUrl() }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-medium">{{ $orders->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $orders->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $orders->total() }}</span>
                        hasil
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <!-- Previous Page Link -->
                        <a href="{{ $orders->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ $orders->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>

                        <!-- Page Numbers -->
                        @foreach(range(1, $orders->lastPage()) as $i)
                            @if($i == 1 || $i == $orders->lastPage() || ($i >= $orders->currentPage() - 2 && $i <= $orders->currentPage() + 2))
                                <a href="{{ $orders->url($i) }}" class="{{ $orders->currentPage() == $i ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' }} relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                    {{ $i }}
                                </a>
                            @elseif(($i == $orders->currentPage() - 3 || $i == $orders->currentPage() + 3) && $i != 1 && $i != $orders->lastPage())
                                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                    ...
                                </span>
                            @endif
                        @endforeach

                        <!-- Next Page Link -->
                        <a href="{{ $orders->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 {{ !$orders->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    /* Animation classes */
    .animate-fade-in {
        opacity: 0;
        animation: fadeIn 0.6s ease-out forwards;
    }
    
    .animate-fade-in-down {
        opacity: 0;
        transform: translateY(-20px);
        animation: fadeInDown 0.6s ease-out forwards;
    }
    
    .animation-delay-100 { animation-delay: 0.1s; }
    .animation-delay-200 { animation-delay: 0.2s; }
    .animation-delay-300 { animation-delay: 0.3s; }
    .animation-delay-400 { animation-delay: 0.4s; }
    .animation-delay-500 { animation-delay: 0.5s; }
    .animation-delay-600 { animation-delay: 0.6s; }
    
    @keyframes fadeIn {
        to { opacity: 1; }
    }
    
    @keyframes fadeInDown {
        to { 
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Hover effects */
    .transform { transition: transform 0.3s ease; }
    .hover\:scale-105:hover { transform: scale(1.05); }
    
    /* Transition colors */
    .transition-colors { transition: background-color 0.3s ease, color 0.3s ease; }
</style>

<script>
    // Animation on scroll
    document.addEventListener('DOMContentLoaded', function() {
        const animateElements = document.querySelectorAll('[class*="animate-"]');
        
        animateElements.forEach(el => {
            const delay = el.classList.contains('animation-delay-100') ? 100 :
                         el.classList.contains('animation-delay-200') ? 200 :
                         el.classList.contains('animation-delay-300') ? 300 :
                         el.classList.contains('animation-delay-400') ? 400 :
                         el.classList.contains('animation-delay-500') ? 500 :
                         el.classList.contains('animation-delay-600') ? 600 : 0;
            
            setTimeout(() => {
                if (el.classList.contains('animate-fade-in')) {
                    el.style.opacity = '1';
                }
                if (el.classList.contains('animate-fade-in-down')) {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }
            }, delay);
        });
    });
</script>
@endsection