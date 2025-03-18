@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 max-w-2xl">
    <div class="bg-white p-8 rounded-xl shadow-xl border border-gray-200 text-center">
        <h1 class="text-4xl font-bold text-green-600 mb-4">Order Confirmation</h1>
        <p class="text-gray-700 text-lg">Thank you for your order! Here are the details of your order:</p>
        
        <div class="mt-6 p-6 bg-gray-50 rounded-lg shadow">
            <h3 class="text-2xl font-semibold text-gray-800">Order #{{ $pesanan->id }}</h3>
            <p class="text-lg text-gray-700"><strong>Order Status:</strong> <span class="text-blue-500">{{ $pesanan->status }}</span></p>
            <p class="text-lg text-gray-700"><strong>Total Price:</strong> <span class="text-green-500">Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</span></p>
            <p class="text-lg text-gray-700"><strong>Payment Method:</strong> <span class="text-gray-800">{{ $pesanan->status === 'Pending' ? 'Pay at Store' : 'Paid' }}</span></p>
            <p class="text-lg text-gray-700"><strong>Kode Referral:</strong> <span class="text-purple-500">{{ $pesanan->kode_referral }}</span></p>
        </div>
        
        <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 transition-all duration-300">Back to Home</a>
    </div>
</div>
@endsection
