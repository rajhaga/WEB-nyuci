@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Confirmation</h1>
    <p>Thank you for your order! Here are the details of your order:</p>

    <h3>Order #{{ $pesanan->id }}</h3>
    <p><strong>Order Status:</strong> {{ $pesanan->status }}</p>
    <p><strong>Total Price:</strong> Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
    <p><strong>Payment Method:</strong> {{ $pesanan->status === 'Pending' ? 'Pay at Store' : 'Paid' }}</p>

    <!-- Add any other details you want to show -->

    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection
