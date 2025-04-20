<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Saldo Card -->
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Saldo</h3>
        <p class="text-2xl font-bold mt-2">Rp{{ number_format($totalSaldo, 0, ',', '.') }}</p>
    </div>

    <!-- Total Mitra Terdaftar Card -->
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Mitra Terdaftar</h3>
        <p class="text-2xl font-bold mt-2">{{ $totalMitra }}</p>
    </div>

    <!-- Mitra Pending Verifikasi Card -->
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-yellow-500">
        <h3 class="text-gray-500 text-sm font-medium">Mitra Pending Verifikasi</h3>
        <p class="text-2xl font-bold mt-2">{{ $pendingMitra }}</p>
    </div>

    <!-- Total Pelanggan Terdaftar Card -->
    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Pelanggan Terdaftar</h3>
        <p class="text-2xl font-bold mt-2">{{ $totalPelanggan }}</p>
    </div>
</div>

<!-- Growth Charts Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Pertumbuhan Pelanggan Baru -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-700 font-medium mb-4">Pertumbuhan Pelanggan Baru</h3>
        <canvas id="customerGrowthChart" height="200"></canvas>
    </div>

    <!-- Digital Metrics -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-gray-700 font-medium mb-4">Metrik Digital</h3>
        <canvas id="digitalMetricsChart" height="200"></canvas>
    </div>
</div>