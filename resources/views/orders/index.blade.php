@extends('layouts.app')

@section('title', 'My Orders — Prestige Perfumery')

@section('content')

<div class="pp-orders-wrap">

    {{-- Header --}}
    <div class="pp-orders-header">
        <h1 class="pp-orders-title">My Orders</h1>
        <span class="pp-orders-subtitle">Order History</span>
    </div>

    @forelse($orders as $order)
        <div class="pp-orders-grid">
            <div class="pp-order-card">
                {{-- Card Header --}}
                <div class="pp-order-card-header">
                    <div>
                        <span class="pp-order-card-id">Order #{{ $order->order_id }}</span>
                        <h2 class="pp-order-card-title">
                            @if($order->user->username)
                                {{ $order->user->username }}'s Order
                            @else
                                Order Details
                            @endif
                        </h2>
                    </div>
                    <span class="pp-order-status-badge {{ strtolower($order->order_status) }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>

                {{-- Card Body --}}
                <div class="pp-order-card-body">
                    <div class="pp-order-card-detail">
                        <span class="pp-order-card-detail-label">Order Date</span>
                        <span class="pp-order-card-detail-value">
                            {{ $order->order_date->format('M d, Y') }}
                        </span>
                    </div>

                    <div class="pp-order-card-detail">
                        <span class="pp-order-card-detail-label">Items</span>
                        <span class="pp-order-card-detail-value">
                            {{ $order->orderDetails->count() }} {{ $order->orderDetails->count() === 1 ? 'item' : 'items' }}
                        </span>
                    </div>

                    <div class="pp-order-card-detail">
                        <span class="pp-order-card-detail-label">Total</span>
                        <span class="pp-order-card-detail-value price">
                            ₱{{ number_format($order->orderDetails->sum(fn($d) => $d->quantity * ($d->product->selling_price ?? 0)), 2) }}
                        </span>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="pp-order-card-footer">
                    <span class="pp-order-card-items">
                        @php
                            $items = $order->orderDetails->pluck('product.product_name')->join(', ', ' • ');
                        @endphp
                        {{ Str::limit($items, 60) }}
                    </span>
                    <a href="{{ route('orders.show', $order->order_id) }}" class="pp-order-card-link">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    @empty
        {{-- Empty State --}}
        <div class="pp-orders-empty">
            <div class="pp-orders-empty-icon">📦</div>
            <h2 class="pp-orders-empty-title">No Orders Yet</h2>
            <p class="pp-orders-empty-text">You haven't placed any orders. Browse our collection and start shopping!</p>
            <a href="{{ route('products.index') }}" class="pp-btn-primary" style="display: inline-block;">Browse Collection</a>
        </div>
    @endforelse

</div>

@endsection