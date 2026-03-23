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
                            ₱{{ number_format($item->product->selling_price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pp-checkout-summary">
                <div class="pp-checkout-total-row">
                    <span class="pp-checkout-total-label">Subtotal</span>
                    <span class="pp-checkout-total-value">₱{{ number_format($total, 2) }}</span>
                </div>
                <div class="pp-checkout-total-row">
                    <span class="pp-checkout-total-label">Shipping</span>
                    <span class="pp-checkout-total-value">Free</span>
                </div>
                <div class="pp-checkout-total-row">
                    <span class="pp-checkout-total-label">Tax</span>
                    <span class="pp-checkout-total-value">₱0.00</span>
                </div>
            </div>

            <div class="pp-checkout-total-final">
                <span class="pp-checkout-final-label">Total</span>
                <span class="pp-checkout-final-value">₱{{ number_format($total, 2) }}</span>
            </div>

            <p class="pp-checkout-security">🔒 Secure checkout with SSL encryption</p>
        </div>

        {{-- Shipping & Payment Form --}}
        <div class="pp-checkout-form">
            <h2 class="pp-checkout-form-title">Shipping Information</h2>

            <form method="POST" action="{{ route('orders.store') }}" id="checkout-form">
                @csrf

                {{-- Delivery Address --}}
                <div class="pp-checkout-field">
                    <label for="address" class="pp-checkout-label">Delivery Address</label>
                    <textarea
                        id="address"
                        name="address"
                        class="pp-checkout-textarea @error('address') is-invalid @enderror"
                        placeholder="Enter your delivery address"
                        required
                    >{{ old('address', Auth::user()->address) }}</textarea>
                    @error('address')
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
                        onchange="toggleGcashField(this.value)"
                    >
                        <option value="">— Select Payment Method —</option>
                        <option value="cod"   {{ old('payment_method') === 'cod'   ? 'selected' : '' }}>Cash on Delivery</option>
                        <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                        <option value="card"  {{ old('payment_method') === 'card'  ? 'selected' : '' }}>Credit Card</option>
                    </select>
                    @error('payment_method')
                        <span class="pp-checkout-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- GCash Reference — shown only when GCash is selected --}}
                <div class="pp-checkout-field" id="gcash-field"
                     style="display:{{ old('payment_method') === 'gcash' ? 'flex' : 'none' }}; flex-direction:column; gap:0.45rem;">

                    {{-- GCash info banner --}}
                    <div style="background:#F0F7EE; border:1px solid rgba(74,103,65,0.2); border-left:3px solid #7FA872; padding:0.9rem 1.1rem; margin-bottom:0.5rem;">
                        <p style="font-family:'Jost',sans-serif; font-size:0.75rem; font-weight:400; color:#4A6741; letter-spacing:0.04em; margin-bottom:0.3rem;">
                            GCash Payment Instructions
                        </p>
                        <p style="font-family:'Jost',sans-serif; font-size:0.72rem; font-weight:300; color:#5A7A52; line-height:1.6; margin:0;">
                            Send payment to <strong style="font-weight:500;">0993-053-6452</strong> (Prestige Perfumery).<br>
                            Enter the 13-digit reference number from your GCash receipt below.
                        </p>
                    </div>

                    <label for="payment_reference" class="pp-checkout-label">
                        GCash Reference Number <span style="color:#C97A7A;">*</span>
                    </label>
                    <input
                        type="text"
                        id="payment_reference"
                        name="payment_reference"
                        class="pp-checkout-input @error('payment_reference') is-invalid @enderror"
                        placeholder="e.g. 1234567890123"
                        maxlength="30"
                        value="{{ old('payment_reference') }}"
                    >
                    @error('payment_reference')
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

<script>
function toggleGcashField(value) {
    const field = document.getElementById('gcash-field');
    const input = document.getElementById('payment_reference');

    if (value === 'gcash') {
        field.style.display = 'flex';
        input.required = true;
    } else {
        field.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}

// Re-apply on page load in case of old() repopulation
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('payment_method');
    if (select.value) toggleGcashField(select.value);
});
</script>

@endsection