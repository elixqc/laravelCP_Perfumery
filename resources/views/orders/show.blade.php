@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Order #{{ $order->order_id }}</h1>

    <div class="mb-6">
        <p><strong>Date:</strong> {{ $order->order_date->format('M d, Y') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
        <p><strong>Total:</strong> ${{ $order->total_amount ?? $order->calculated_total }}</p>
        <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    </div>

    <h2 class="text-2xl font-semibold mb-4">Items</h2>
    <div class="space-y-4">
        @foreach($order->orderDetails as $detail)
            @php
                $firstImage = $detail->product->productImages->first();
                $imageUrl = $firstImage
                    ? asset('storage/' . $firstImage->image_path)
                    : ($detail->product->image_path ? asset('storage/' . $detail->product->image_path) : null);
            @endphp
            <div class="flex items-center border p-4 rounded">
                @if($imageUrl)
                    <img src="{{ $imageUrl }}" alt="{{ $detail->product->product_name }}" class="w-16 h-16 object-cover mr-4">
                @else
                    <div class="w-16 h-16 bg-gray-200 flex items-center justify-center mr-4">
                        <span class="text-gray-500 text-sm">No Image</span>
                    </div>
                @endif
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">{{ $detail->product->product_name }}</h3>
                    <p>Quantity: {{ $detail->quantity }}</p>
                    <p>Unit Price: ${{ $detail->unit_price }}</p>
                    <p>Subtotal: ${{ $detail->subtotal }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('orders.index') }}" class="text-blue-500 mt-4 inline-block">Back to Orders</a>
</div>
@endsection