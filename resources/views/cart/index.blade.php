@extends('layouts.app')

@section('title', 'Shopping Cart - Prestige Perfumery')

@section('content')
    <!-- Cart Header -->
    <section class="bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center text-gray-800">Your Shopping Cart</h1>
        </div>
    </section>

    @if($cartItems->isEmpty())
        <!-- Empty Cart -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 text-center">
                <div class="text-6xl mb-6">🛒</div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Your cart is empty</h2>
                <p class="text-xl text-gray-600 mb-8">Discover our exquisite collection of fragrances</p>
                <a href="{{ route('products.index') }}" class="bg-gold-400 text-black px-8 py-4 rounded-full text-lg font-semibold hover:bg-gold-300 transition duration-300 inline-block">Start Shopping</a>
            </div>
        </section>
    @else
        <!-- Cart Items -->
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items List -->
                    <div class="lg:col-span-2 space-y-6">
                        @foreach($cartItems as $item)
                            <div class="bg-gray-50 rounded-lg p-6 shadow-md">
                                <div class="flex items-center space-x-6">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @php
                                            $firstImage = $item->product->productImages->first();
                                            $imageUrl = $firstImage
                                                ? asset('storage/' . $firstImage->image_path)
                                                : ($item->product->image_path ? asset('storage/' . $item->product->image_path) : null);
                                        @endphp
                                        @if($imageUrl)
                                            <img src="{{ $imageUrl }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded-lg">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <span class="text-gray-500 text-sm">No Image</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Details -->
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $item->product->name }}</h3>
                                        <p class="text-gray-600 mb-2">{{ Str::limit($item->product->description, 100) }}</p>
                                        <p class="text-lg font-bold text-gold-400">${{ number_format($item->product->price, 2) }}</p>
                                    </div>

                                    <!-- Quantity and Actions -->
                                    <div class="flex flex-col items-end space-y-4">
                                        <form method="POST" action="{{ route('cart.update', $item->product) }}" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PATCH')
                                            <label for="quantity-{{ $item->product_id }}" class="text-sm font-medium text-gray-700">Qty:</label>
                                            <input type="number" id="quantity-{{ $item->product_id }}" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock_quantity }}" class="w-16 border border-gray-300 px-2 py-1 rounded focus:outline-none focus:ring-2 focus:ring-gold-400">
                                            <button type="submit" class="bg-gold-400 text-black px-3 py-1 rounded text-sm font-semibold hover:bg-gold-300 transition duration-300">Update</button>
                                        </form>

                                        <form method="POST" action="{{ route('cart.remove', $item->product) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium" onclick="return confirm('Remove this item from cart?')">Remove</button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-600">Subtotal:</span>
                                        <span class="text-lg font-semibold text-gray-800">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6 shadow-md sticky top-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Order Summary</h3>

                            <div class="space-y-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                    <span class="font-semibold">${{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-semibold">Free</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="font-semibold">$0.00</span>
                                </div>

                                <hr class="border-gray-300">

                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total</span>
                                    <span class="text-gold-400">${{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span>
                                </div>
                            </div>

                            <div class="mt-8 space-y-4">
                                <a href="{{ route('checkout') }}" class="w-full bg-gold-400 text-black px-6 py-3 rounded-lg font-semibold text-center hover:bg-gold-300 transition duration-300 block">
                                    Proceed to Checkout
                                </a>

                                <a href="{{ route('products.index') }}" class="w-full bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold text-center hover:bg-gray-700 transition duration-300 block">
                                    Continue Shopping
                                </a>
                            </div>

                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-600">Secure checkout powered by SSL encryption</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection