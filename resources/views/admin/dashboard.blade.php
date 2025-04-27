@extends('layouts.admin')

@section('admincontent')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
    <h2 class="text-xl font-semibold text-gray-700">Dashboard Analisis</h2>
    <p class="text-gray-600">Selamat datang kembali, <span class="font-medium">{{ Auth::user()->nama }}</span> (Admin Nyuci)</p>
</div>

{{-- Cards Row --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Saldo (Admin)</h3>
        <p class="text-2xl font-bold mt-2">Rp{{ number_format($totalSaldo, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Mitra Terdaftar</h3>
        <p class="text-2xl font-bold mt-2">{{ $totalMitra }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-medium">Mitra Pending Verifikasi</h3>
        <p class="text-2xl font-bold mt-2">{{ $pendingMitra }}</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Pelanggan Terdaftar</h3>
        <p class="text-2xl font-bold mt-2">{{ $totalPelanggan }}</p>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow-md h-64">
        <h3 class="text-gray-700 font-medium mb-4">Pertumbuhan Pelanggan Baru</h3>
        <canvas id="customerGrowthChart" class="w-full h-full"></canvas>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-md h-64">
        <h3 class="text-gray-700 font-medium mb-4">Metrik Digital</h3>
        <canvas id="digitalMetricsChart" class="w-full h-full"></canvas>
    </div>
</div>
@endsection

@push('scripts')
    {{-- Chart.js Library --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pertumbuhan Pelanggan Baru
            new Chart(document.getElementById('customerGrowthChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($customerGrowthLabels) !!},
                    datasets: [{
                        label: 'Pelanggan Baru',
                        data: {!! json_encode($customerGrowthData) !!},
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Metrik Digital
            new Chart(document.getElementById('digitalMetricsChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($digitalMetricsLabels) !!},
                    datasets: [{
                        label: 'Pesanan Harian',
                        data: {!! json_encode($digitalMetricsData) !!}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endpush