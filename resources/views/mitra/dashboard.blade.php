@extends('layouts.mitra')

@section('mitracontent')
<section class="p-2 min-h-screen space-y-6">
    <div class="mb-4 flex justify-between items-center">
        <form method="GET" action="{{ route('mitra.dashboard') }}">
            <div class="flex space-x-4">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-4 py-2 border rounded" />
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-4 py-2 border rounded" />
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    🔍 Filter Tanggal
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-md text-blue-600 font-semibold">Total Saldo</h2>
                <p class="text-2xl font-bold text-gray-800 mt-2">Rp{{ number_format($totalSaldoBulanIni, 0, ',', '.') }}</p>
                <div class="mt-4">
                    <h3 class="text-lg font-bold" 
                        @if($persenPerubahan > 0)
                            style="color: green;"  
                        @elseif($persenPerubahan < 0)
                            style="color: red;"  
                        @else
                            style="color: gray;"  
                        @endif
                    >
                        @if($persenPerubahan > 0)
                            +{{ number_format($persenPerubahan, 2) }}% dari bulan sebelumnya
                        @elseif($persenPerubahan < 0)
                            {{ number_format($persenPerubahan, 2) }}% dari bulan sebelumnya
                        @else
                            Tidak ada perubahan
                        @endif
                    </h3>
                </div>
            </div>
            

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="font-medium text-md text-gray-700">Pesanan Menunggu</p>
                    <p class="text-blue-600 font-bold text-lg">{{ $totalPesananMenunggu }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="font-medium text-gray-700">Pesanan Diterima</p>
                    <p class="text-green-600 font-bold text-lg">{{ $totalPesananDiterima }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="font-medium text-gray-700">Pesanan Diproses</p>
                    <p class="text-yellow-500 font-bold text-lg">{{ $totalPesananDiproses }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-4 text-center">
                    <p class="font-medium text-gray-700">Pesanan Selesai</p>
                    <p class="text-blue-600 font-bold text-lg">{{ $totalPesananSelesai }}</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-2">Banyak Jenis Pakaian by Bulan</h3>
            <div class="h-60">
                <canvas id="jenisPakaianChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-2">Grafik Pesanan per Tahun</h3>
            <div class="h-48">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow p-4 text-center">
                <p class="text-gray-600 font-medium">Pendapatan Terbanyak</p>
                <p class="text-xl font-bold">{{ 'Rp' . number_format($pendapatanTerbesar, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4 text-center">
                <p class="text-gray-600 font-medium">Pendapatan Terkecil</p>
                <p class="text-xl font-bold">{{ 'Rp' . number_format($pendapatanTerkecil, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow p-4 text-center">
                <p class="text-gray-600 font-medium">Bulan Terbaik</p>
                <p class="text-xl font-bold">{{ $bulanTerbaik }}</p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const pakaianCtx = document.getElementById('jenisPakaianChart');
    new Chart(pakaianCtx, {
        type: 'bar',
        data: {
            labels: @json($jenisPakaianLabels), // Menampilkan jenis pakaian
            datasets: [{
                label: 'Jumlah Pakaian',
                data: @json($jenisPakaianData), // Menampilkan jumlah pakaian
                backgroundColor: 'rgba(37, 99, 235, 0.7)',
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const pendapatanCtx = document.getElementById('pendapatanChart');
    new Chart(pendapatanCtx, {
        type: 'line',
        data: {
            labels: @json(array_values($pesananBulan->keys()->toArray())), // Mengambil bulan (nama bulan) yang diurutkan dengan benar
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($pesananBulan->values()), // Menampilkan total pendapatan per bulan
                borderColor: 'rgba(37, 99, 235, 1)',
                borderWidth: 2,
                fill: false,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

</script>
@endpush

@endsection
