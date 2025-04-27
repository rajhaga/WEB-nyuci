<!-- resources/views/invoices/invoice.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pesanan->id }}</title>
    <style>
        /* Tailwind CSS internal styles for DomPDF */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .bg-gray-100 {
            background-color: #f7fafc;
        }
        .text-gray-900 {
            color: #1a202c;
        }
        .text-gray-600 {
            color: #718096;
        }
        .text-sm {
            font-size: 0.875rem;
        }
        .text-xl {
            font-size: 1.25rem;
        }
        .font-semibold {
            font-weight: 600;
        }
        .font-bold {
            font-weight: 700;
        }
        .border {
            border-width: 1px;
        }
        .border-gray-300 {
            border-color: #e2e8f0;
        }
        .rounded-lg {
            border-radius: 0.5rem;
        }
        .p-4 {
            padding: 1rem;
        }
        .py-6 {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }
        .mb-6 {
            margin-bottom: 1.5rem;
        }
        .w-full {
            width: 100%;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .bg-blue-600 {
            background-color: #3182ce;
        }
        .text-white {
            color: white;
        }
        .uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Nyuci Logo" class="h-14 mr-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Invoice #{{ $pesanan->id }}</h1>
                    <p class="text-sm text-gray-600">Pesanan yang dilakukan pada {{ $pesanan->created_at->format('d-m-Y') }}</p>
                </div>
            </div>
            <div class="text-gray-500 text-sm">
                <p><strong>Invoice Date:</strong> {{ $pesanan->created_at->format('d-m-Y') }}</p>
                <p><strong>Due Date:</strong> {{ \Carbon\Carbon::now()->addDays(7)->format('d-m-Y') }}</p> <!-- Due date example -->
            </div>
        </div>

        <!-- Invoice Details Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Pesanan Details</h2>
            <table class="w-full border border-gray-300 rounded-lg">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Detail</th>
                        <th class="text-left p-4 text-sm font-semibold text-gray-600">Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="p-4 text-sm text-gray-600">Nomor Pesanan</td>
                        <td class="p-4 text-sm text-gray-900">#{{ $pesanan->id }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-600">Total Pembayaran</td>
                        <td class="p-4 text-sm text-blue-600">Rp{{ number_format($pesanan->total_harga + 8000, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-600">Status Pesanan</td>
                        <td class="p-4 text-sm font-semibold {{ $pesanan->status == 'Selesai' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $pesanan->status }}
                        </td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-600">Metode Pembayaran</td>
                        <td class="p-4 text-sm text-gray-900">{{ $pesanan->metode_pembayaran }}</td>
                    </tr>
                    <tr>
                        <td class="p-4 text-sm text-gray-600">Kode Referral</td>
                        <td class="p-4 text-sm text-purple-600">{{ $pesanan->kode_referral }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer Section -->
        <div class="mt-8 text-center text-sm text-gray-600">
            <p>&copy; {{ date('Y') }} Nyuci. All rights reserved.</p>
            <p>Contact us: support@nyuci.com</p>
        </div>

    </div>

</body>

</html>
