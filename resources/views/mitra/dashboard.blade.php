@extends('layouts.mitra')

@section('mitracontent')
<div class="min-h-screen p-6">
    <!-- Header -->
    <div class="mb-8 animate-fade-in-down">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Mitra</h1>
        <p class="text-gray-600">Ringkasan aktivitas dan performa bisnis Anda</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Saldo Card -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-xl shadow-lg text-white transform transition-all hover:scale-105 animate-fade-in">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-light">Total Saldo</p>
                    <h3 class="text-2xl font-bold mt-2">Rp{{ number_format($totalSaldo, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-blue-400 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-blue-200 text-sm">+2.5% dari bulan lalu</span>
            </div>
        </div>

        <!-- Monthly Income Card -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 rounded-xl shadow-lg text-white transform transition-all hover:scale-105 animate-fade-in animation-delay-100">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-light">Pendapatan Bulan Ini</p>
                    @if(count($pendapatanBulanan) > 0)
                        @php $latest = $pendapatanBulanan[0]; @endphp
                        <h3 class="text-2xl font-bold mt-2">Rp{{ number_format($latest->total, 0, ',', '.') }}</h3>
                    @else
                        <h3 class="text-2xl font-bold mt-2">Rp0</h3>
                    @endif
                    {{-- @if(isset($mitra) && $mitra->id)
                        <p>ID Mitra: {{ $mitra->id }}</p>
                    @else
                        <p>Mitra tidak ditemukan</p>
                    @endif --}}

                </div>
                <div class="bg-green-400 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-200 text-sm">
                    @if(count($pendapatanBulanan) > 1)
                        @php $prev = $pendapatanBulanan[1]; @endphp
                        @if($prev->total > 0)
                            {{ round(($latest->total - $prev->total)/$prev->total * 100, 2) }}%
                        @else
                            +100%
                        @endif
                        dari bulan sebelumnya
                    @else
                        Data belum tersedia
                    @endif
                </span>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-xl shadow-lg text-white transform transition-all hover:scale-105 animate-fade-in animation-delay-200">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-light">Total Pesanan</p>
                    <h3 class="text-2xl font-bold mt-2">{{ array_sum($statusPesanan) }}</h3>
                </div>
                <div class="bg-purple-400 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-purple-200 text-sm">{{ $statusPesanan['selesai'] }} pesanan selesai</span>
            </div>
        </div>

        <!-- Active Customers Card -->
        <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-6 rounded-xl shadow-lg text-white transform transition-all hover:scale-105 animate-fade-in animation-delay-300">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-light">Pelanggan Aktif</p>
                    <h3 class="text-2xl font-bold mt-2">1,248</h3>
                </div>
                <div class="bg-amber-400 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-amber-200 text-sm">+12% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <!-- Order Status Section -->
    <div class="mb-8 animate-fade-in-down animation-delay-400">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <span class="bg-blue-100 p-2 rounded-full mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </span>
            Status Pesanan
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Menunggu -->
            <div class="bg-white p-4 rounded-xl shadow-md border-l-4 border-yellow-500 transform transition-all hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Menunggu</p>
                        <h4 class="font-bold text-lg">{{ $statusPesanan['Menunggu'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Diterima -->
            <div class="bg-white p-4 rounded-xl shadow-md border-l-4 border-blue-500 transform transition-all hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Diterima</p>
                        <h4 class="font-bold text-lg">{{ $statusPesanan['Diterima'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Diproses -->
            <div class="bg-white p-4 rounded-xl shadow-md border-l-4 border-orange-500 transform transition-all hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-orange-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Diproses</p>
                        <h4 class="font-bold text-lg">{{ $statusPesanan['diproses'] }}</h4>
                    </div>
                </div>
            </div>

            <!-- Selesai -->
            <div class="bg-white p-4 rounded-xl shadow-md border-l-4 border-green-500 transform transition-all hover:scale-102">
                <div class="flex items-center">
                    <div class="bg-green-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Selesai</p>
                        <h4 class="font-bold text-lg">{{ $statusPesanan['selesai'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Order Chart -->
        <div class="bg-white p-6 rounded-xl shadow-md animate-fade-in-down animation-delay-500">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <span class="bg-indigo-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </span>
                    Grafik Pesanan per Tahun
                </h2>
                <div class="relative">
                    <select class="appearance-none bg-gray-100 border border-gray-300 rounded-lg px-3 py-1 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option>Tahun</option>
                        @foreach($grafikPesanan as $item)
                            <option>{{ $item->year }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <canvas id="orderChart" class="w-full h-64"></canvas>
        </div>

        <!-- Monthly Income Chart -->
        <div class="bg-white p-6 rounded-xl shadow-md animate-fade-in-down animation-delay-600">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <span class="bg-green-100 p-2 rounded-full mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </span>
                    Pendapatan Bulanan
                </h2>
                <div class="relative">
                    <select class="appearance-none bg-gray-100 border border-gray-300 rounded-lg px-3 py-1 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option>2023</option>
                        <option>2022</option>
                        <option>2021</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <canvas id="incomeChart" class="w-full h-64"></canvas>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white p-6 rounded-xl shadow-md animate-fade-in-down animation-delay-700">
        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
            <span class="bg-purple-100 p-2 rounded-full mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </span>
            Pesanan Terbaru
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Example rows - replace with actual data -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-2023-001</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Doe</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15 Jan 2023</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp250.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-2023-002</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Jane Smith</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">14 Jan 2023</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp175.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Diproses</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#ORD-2023-003</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Robert Johnson</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">13 Jan 2023</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp320.000</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diterima</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-right">
            <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Lihat Semua Pesanan →</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Animation on scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('[class*="animate-"]');
        elements.forEach(el => {
            const rect = el.getBoundingClientRect();
            const isVisible = (rect.top <= window.innerHeight * 0.75);
            
            if (isVisible) {
                const animationType = Array.from(el.classList).find(cls => cls.startsWith('animate-'));
                el.classList.add('opacity-100', 'translate-y-0', 'scale-100');
                el.classList.remove('opacity-0', 'translate-y-6', 'scale-95');
            }
        });
    };

    // Run on load and scroll
    window.addEventListener('load', animateOnScroll);
    window.addEventListener('scroll', animateOnScroll);

    // Order Chart
    const years = @json($grafikPesanan->pluck('year'));
    const orders = @json($grafikPesanan->pluck('total'));

    const orderCtx = document.getElementById('orderChart').getContext('2d');
    new Chart(orderCtx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: orders,
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#6366F1',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: '#E5E7EB'
                    },
                    ticks: {
                        padding: 12
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 12
                    }
                }
            }
        }
    });

    // Income Chart (example data)
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const incomeData = [6500000, 5900000, 8000000, 8100000, 5600000, 7500000, 9200000, 8800000, 7700000, 8500000, 7300000, 9500000];
    
    const incomeCtx = document.getElementById('incomeChart').getContext('2d');
    new Chart(incomeCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Pendapatan',
                data: incomeData,
                backgroundColor: 'rgba(16, 185, 129, 0.6)',
                borderColor: '#10B981',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return 'Rp' + context.raw.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: '#E5E7EB'
                    },
                    ticks: {
                        padding: 12,
                        callback: function(value) {
                            return 'Rp' + (value / 1000000).toLocaleString('id-ID') + 'jt';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 12
                    }
                }
            }
        }
    });
</script>

<style>
    /* Animation classes */
    .animate-fade-in {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .animate-fade-in-down {
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .animation-delay-100 { transition-delay: 0.1s; }
    .animation-delay-200 { transition-delay: 0.2s; }
    .animation-delay-300 { transition-delay: 0.3s; }
    .animation-delay-400 { transition-delay: 0.4s; }
    .animation-delay-500 { transition-delay: 0.5s; }
    .animation-delay-600 { transition-delay: 0.6s; }
    .animation-delay-700 { transition-delay: 0.7s; }
    
    .opacity-100 { opacity: 1; }
    .translate-y-0 { transform: translateY(0); }
    .scale-100 { transform: scale(1); }
    
    /* Hover effects */
    .transform { transition: transform 0.3s ease; }
    .hover\:scale-105:hover { transform: scale(1.05); }
    .hover\:scale-102:hover { transform: scale(1.02); }
    
    /* Transition colors */
    .transition-colors { transition: background-color 0.3s ease, color 0.3s ease; }
</style>
@endsection