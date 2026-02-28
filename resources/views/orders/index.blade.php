@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">My Orders</h1>

    @forelse($orders as $order)
        <div class="border rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-xl font-semibold">Order #{{ $order->order_id }}</h2>
                <span class="px-2 py-1 rounded {{ $order->order_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                    {{ ucfirst($order->order_status) }}
                </span>
            </div>
            <p>Date: {{ $order->order_date->format('M d, Y') }}</p>
            <p>Total: ${{ $order->calculated_total }}</p>
            <a href="{{ route('orders.show', $order->order_id) }}" class="text-blue-500">View Details</a>
        </div>
    @empty
        <p>You have no orders yet.</p>
    @endforelse
</div>
@endsection