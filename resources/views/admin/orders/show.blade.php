@extends('layouts.admin')

@section('content')
<div class="pa-page">

    {{-- PAGE HEADER --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Orders</span>
            <h1 class="pa-page-title">Order #{{ $order->order_id }}</h1>
        </div>
    </div>

    {{-- ORDER DETAILS --}}
    <div class="pa-section">

    <div class="mb-6">
        <p><strong>Customer:</strong> {{ $order->user->full_name }} ({{ $order->user->email }})</p>
        <p><strong>Date:</strong> {{ $order->order_date->format('M d, Y H:i') }}</p>
        <p><strong>Status:</strong> {{ ucfirst($order->order_status) }}</p>
        <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
        @if($order->payment_reference)
            <p><strong>Payment Reference:</strong> {{ $order->payment_reference }}</p>
        @endif
        @if($order->date_received)
            <p><strong>Date Received:</strong> {{ $order->date_received->format('M d, Y') }}</p>
        @endif
    </div>

    {{-- UPDATE STATUS FORM --}}
    <div class="mb-8 p-4 bg-gray-50 rounded border">
        <h3 class="text-lg font-semibold mb-4">Update Order Status</h3>
        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}" class="flex gap-4 items-end">
            @csrf
            @method('PATCH')
            <div class="flex-1">
                <label for="status" class="block text-sm font-medium mb-2">New Status</label>
                <select name="status" id="status" class="w-full border rounded px-3 py-2" required>
                    <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update Status</button>
        </form>
    </div>

    <h2 class="text-2xl font-semibold mb-4">Order Items</h2>
    <div class="space-y-4">
        @foreach($order->orderDetails as $detail)
            <div class="flex items-center border p-4 rounded">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold">{{ $detail->product->product_name }}</h3>
                    <p>Quantity: {{ $detail->quantity }}</p>
                    <p>Unit Price: ${{ $detail->unit_price }}</p>
                    <p>Subtotal: ${{ $detail->subtotal }}</p>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <p class="text-xl font-bold">Total: ${{ $order->calculated_total }}</p>
    </div>

    <a href="{{ route('admin.orders.index') }}" class="text-blue-500 mt-4 inline-block">Back to Orders</a>
</div>
@endsection