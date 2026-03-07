@extends('layouts.app')

@section('title', 'Checkout — Prestige Perfumery')

@section('content')

<div class="pp-checkout-wrap">

    {{-- Header --}}
    <div class="pp-checkout-header">
        <h1 class="pp-checkout-title">Checkout</h1>
        <span class="pp-checkout-subtitle">Complete Your Purchase</span>
    </div>

    {{-- Checkout Grid --}}
    <div class="pp-checkout-body">

        {{-- Order Review --}}
        <div class="pp-checkout-review">
            <h2 class="pp-checkout-review-title">Order Summary</h2>

            <div class="pp-checkout-items">
                @foreach($cartItems as $item)
                    <div class="pp-checkout-item">
                        <div>
                            <div class="pp-checkout-item-name">{{ $item->product->product_name }}</div>
                            <div class="pp-checkout-item-qty">Quantity: {{ $item->quantity }}</div>
                        </div>
                        <div class="pp-checkout-item-price">
                            ${{ number_format($item->product->selling_price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pp-checkout-summary">
                <div class="pp-checkout-total-row">
                    <span class="pp-checkout-total-label">Subtotal</span>
                    <span class="pp-checkout-total-value">${{ number_format($total, 2) }}</span>
                </div>

                <div class="pp-checkout-total-row">
                    <span class="pp-checkout-total-label">Shipping</span>
                    <span class="pp-checkout-total-value">Free</span>
                </div>

                <div class="pp-checkout-total-row">
                    <span class="pp-checkout-total-label">Tax</span>
                    <span class="pp-checkout-total-value">$0.00</span>
                </div>
            </div>

            <div class="pp-checkout-total-final">
                <span class="pp-checkout-final-label">Total</span>
                <span class="pp-checkout-final-value">${{ number_format($total, 2) }}</span>
            </div>

            <p class="pp-checkout-security">🔒 Secure checkout with SSL encryption</p>
        </div>

        {{-- Shipping & Payment Form --}}
        <div class="pp-checkout-form">
            <h2 class="pp-checkout-form-title">Shipping Information</h2>

            <form method="POST" action="{{ route('orders.store') }}">
                @csrf

                {{-- Delivery Address --}}
                <div class="pp-checkout-field">
                    <label for="delivery_address" class="pp-checkout-label">Delivery Address</label>
                    <textarea
                        id="delivery_address"
                        name="delivery_address"
                        class="pp-checkout-textarea @error('delivery_address') is-invalid @enderror"
                        placeholder="Enter your delivery address"
                        required
                    >{{ old('delivery_address', Auth::user()->address) }}</textarea>
                    @error('delivery_address')
                        <span class="pp-checkout-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Payment Method --}}
                <div class="pp-checkout-field">
                    <label for="payment_method" class="pp-checkout-label">Payment Method</label>
                    <select
                        id="payment_method"
                        name="payment_method"
                        class="pp-checkout-select @error('payment_method') is-invalid @enderror"
                        required
                    >
                        <option value="">-- Select Payment Method --</option>
                        <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Credit Card</option>
                    </select>
                    @error('payment_method')
                        <span class="pp-checkout-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="pp-checkout-submit">
                    Place Order
                </button>
            </form>
        </div>

    </div>

</div>

@endsection