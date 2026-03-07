@extends('layouts.app')

@section('title', 'Shopping Cart — Prestige Perfumery')

@section('content')

<div class="pp-cart-wrap">

    {{-- Header --}}
    <div class="pp-cart-header">
        <h1 class="pp-cart-title">Your Cart</h1>
        <span class="pp-cart-subtitle">{{ $cartItems->count() }} {{ $cartItems->count() === 1 ? 'item' : 'items' }}</span>
    </div>

    @if($cartItems->isEmpty())
        {{-- Empty Cart --}}
        <div class="pp-cart-empty">
            <div class="pp-cart-empty-icon">🛒</div>
            <h2 class="pp-cart-empty-title">Cart is Empty</h2>
            <p class="pp-cart-empty-text">Discover our exquisite collection of fragrances</p>
            <a href="{{ route('products.index') }}" class="pp-btn-primary" style="display: inline-block;">Browse Collection</a>
        </div>
    @else
        {{-- Cart Items & Summary --}}
        <div class="pp-cart-body">

            {{-- Cart Items --}}
            <div class="pp-cart-items">
                @foreach($cartItems as $item)
                    @php
                        $firstImage = $item->product->productImages->first();
                        $imageUrl = $firstImage
                            ? asset('storage/' . $firstImage->image_path)
                            : ($item->product->image_path ? asset('storage/' . $item->product->image_path) : null);
                    @endphp

                    <div class="pp-cart-item">
                        {{-- Product Image --}}
                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $item->product->product_name }}" class="pp-cart-item-image">
                        @else
                            <div class="pp-cart-item-no-image">No Image</div>
                        @endif

                        {{-- Product Details --}}
                        <div class="pp-cart-item-details">
                            <h3 class="pp-cart-item-name">{{ $item->product->product_name }}</h3>
                            <p class="pp-cart-item-desc">{{ Str::limit($item->product->description, 80) }}</p>
                            <span class="pp-cart-item-price">₱{{ number_format($item->product->selling_price, 2) }}</span>
                        </div>

                        {{-- Quantity & Actions --}}
                        <div class="pp-cart-item-controls">
                            <form method="POST" action="{{ route('cart.update', $item->product) }}" class="pp-cart-quantity">
                                @csrf
                                @method('PATCH')
                                <label for="quantity-{{ $item->product_id }}" class="pp-cart-quantity-label">Qty</label>
                                <input 
                                    type="number" 
                                    id="quantity-{{ $item->product_id }}" 
                                    name="quantity" 
                                    value="{{ $item->quantity }}" 
                                    min="1" 
                                    max="{{ $item->product->stock_quantity }}" 
                                    class="pp-cart-quantity-input"
                                >
                                <button type="submit" class="pp-cart-update-btn">Update</button>
                            </form>

                            <form method="POST" action="{{ route('cart.remove', $item->product) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pp-cart-remove-btn" onclick="return confirm('Remove this item?')">Remove</button>
                            </form>
                        </div>

                        {{-- Subtotal --}}
                        <div class="pp-cart-subtotal" style="grid-column: 2 / -1;">
                            <span>Subtotal</span>
                            <span class="pp-cart-subtotal-amount">₱{{ number_format($item->product->selling_price * $item->quantity, 2) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Order Summary Sidebar --}}
            <div class="pp-cart-summary">
                <h3 class="pp-cart-summary-title">Order Summary</h3>

                <div class="pp-cart-summary-rows">
                    <div class="pp-cart-summary-row">
                        <span class="pp-cart-summary-label">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                        <span class="pp-cart-summary-value">₱{{ number_format($cartItems->sum(function($item) { return $item->product->selling_price * $item->quantity; }), 2) }}</span>
                    </div>

                    <div class="pp-cart-summary-row">
                        <span class="pp-cart-summary-label">Shipping</span>
                        <span class="pp-cart-summary-value">Free</span>
                    </div>

                    <div class="pp-cart-summary-row">
                        <span class="pp-cart-summary-label">Tax</span>
                        <span class="pp-cart-summary-value">₱0.00</span>
                    </div>
                </div>

                <div class="pp-cart-summary-divider"></div>

                <div class="pp-cart-total">
                    <span class="pp-cart-total-label">Total</span>
                    <span class="pp-cart-total-value">₱{{ number_format($cartItems->sum(function($item) { return $item->product->selling_price * $item->quantity; }), 2) }}</span>
                </div>

                <div class="pp-cart-actions">
                    <a href="{{ route('checkout') }}" class="pp-cart-checkout-btn">Proceed to Checkout</a>
                    <a href="{{ route('products.index') }}" class="pp-cart-continue-btn">Continue Shopping</a>
                </div>

                <p class="pp-cart-security">🔒 Secure checkout with SSL encryption</p>
            </div>

        </div>
    @endif

</div>

@endsection