@extends('layouts.admin')

@section('admincontent')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Analisis</h1>
    <p class="text-gray-600">Selamat datang kembali, <span class="font-medium">{{ Auth::user()->nama }}</span> (Admin Nyuci)</p>
</div>

@include('admin.partials.analytics')

@endsection

@push('chart-scripts')
<script>
    // Customer Growth Chart
    const customerGrowthCtx = document.getElementById('customerGrowthChart').getContext('2d');
    new Chart(customerGrowthCtx, {
        type: 'line',
        data: {
            labels: ['7 Bulan Lalu', '6 Bulan Lalu', '5 Bulan Lalu', '4 Bulan Lalu', '3 Bulan Lalu', '2 Bulan Lalu', 'Bulan Lalu', 'Bulan Ini'],
            datasets: [{
                label: 'Pertumbuhan Pelanggan',
                data: @json(array_merge($customerGrowth['previous'], [$customerGrowth['current']])),
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Digital Metrics Chart
    const digitalMetricsCtx = document.getElementById('digitalMetricsChart').getContext('2d');
    new Chart(digitalMetricsCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: $digitalMetrics['trend']->count()}, (_, i) => i + 1),
            datasets: [{
                label: 'Metrik Digital',
                data: @json($digitalMetrics['trend']),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush