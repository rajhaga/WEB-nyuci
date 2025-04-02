@extends('layouts.mitra')

@section('mitracontent')
        <!-- Content -->
        
            <!-- Total Saldo -->
            <div class="bg-blue-100 p-4 rounded-lg">
                <h5 class="font-semibold">Total Saldo</h5>
                <p class="text-lg">Rp{{ number_format($totalSaldo, 0, ',', '.') }}</p>
            </div>

            <!-- Pendapatan Bulanan -->
            <div class="bg-green-100 p-4 rounded-lg">
                <h5 class="font-semibold">Pendapatan Bulanan</h5>
                @foreach($pendapatanBulanan as $pendapatan)
                    <p class="text-lg">{{ $pendapatan->month }} / {{ $pendapatan->year }}: Rp{{ number_format($pendapatan->total, 0, ',', '.') }}</p>
                @endforeach
            </div>

            <!-- Status Pesanan -->
            <h3 class="mt-6 font-semibold">Status Pesanan</h3>
            <div class="grid grid-cols-4 gap-4 mt-2">
                <div class="p-4 bg-yellow-100 rounded-lg">Menunggu: {{ $statusPesanan['Menunggu'] }}</div>
                <div class="p-4 bg-blue-100 rounded-lg">Diterima: {{ $statusPesanan['Diterima'] }}</div>
                <div class="p-4 bg-orange-100 rounded-lg">Diproses: {{ $statusPesanan['diproses'] }}</div>
                <div class="p-4 bg-green-100 rounded-lg">Selesai: {{ $statusPesanan['selesai'] }}</div>
            </div>

            <!-- Grafik Pesanan -->
            <h3 class="mt-6 font-semibold">Grafik Pesanan per Tahun</h3>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <canvas id="orderChart"></canvas>
            </div>
        
    
<script>
    const years = @json($grafikPesanan->pluck('year'));
    const orders = @json($grafikPesanan->pluck('total'));

    const ctx = document.getElementById('orderChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Jumlah Pesanan',
                data: orders,
                borderColor: 'blue',
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

    @endsection
     
