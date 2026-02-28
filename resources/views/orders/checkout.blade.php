@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Checkout</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
            @foreach($cartItems as $item)
                <div class="flex justify-between mb-2">
                    <span>{{ $item->product->product_name }} (x{{ $item->quantity }})</span>
                    <span>${{ $item->product->price * $item->quantity }}</span>
                </div>
            @endforeach
            <div class="border-t pt-2 mt-4">
                <div class="flex justify-between font-bold">
                    <span>Total</span>
                    <span>${{ $total }}</span>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
            <form method="POST" action="{{ route('orders.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="delivery_address" class="block text-sm font-medium">Delivery Address</label>
                    <textarea name="delivery_address" id="delivery_address" class="w-full border px-3 py-2" required>{{ old('delivery_address', Auth::user()->address) }}</textarea>
                    @error('delivery_address')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="payment_method" class="block text-sm font-medium">Payment Method</label>
                    <select name="payment_method" id="payment_method" class="w-full border px-3 py-2" required>
                        <option value="cash">Cash on Delivery</option>
                        <option value="card">Credit Card</option>
                    </select>
                    @error('payment_method')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded">Place Order</button>
            </form>
        </div>
    </div>
</div>
@endsection