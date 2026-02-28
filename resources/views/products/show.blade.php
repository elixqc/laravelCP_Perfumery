@extends('layouts.app')

@section('title', '{{ $product->product_name }} - Prestige Perfumery')

@section('content')
    <!-- Product Hero -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Product Images -->
                <div class="space-y-4">
                    @php
                            $firstImage = $product->productImages->first();
                            $imageUrl = $firstImage
                                ? asset('storage/' . $firstImage->image_path)
                                : ($product->image_path ? asset('storage/' . $product->image_path) : null);
                        @endphp

                        @if($imageUrl)
                            <div class="aspect-square overflow-hidden rounded-lg shadow-lg">
                                <img src="{{ $imageUrl }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover" id="main-image">
                            </div>
                            @if($product->productImages->count() > 1)
                                <div class="grid grid-cols-4 gap-4">
                                    @foreach($product->productImages as $image)
                                        <div class="aspect-square overflow-hidden rounded-lg cursor-pointer border-2 border-transparent hover:border-gold-400 transition duration-300" onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->product_name }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center">
                                <span class="text-gray-500 text-lg">No Image Available</span>
                            </div>
                        @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $product->product_name }}</h1>
                        <p class="text-xl text-gold-400 font-semibold">${{ number_format($product->price, 2) }}</p>
                    </div>

                    <div class="prose text-gray-600">
                        <p class="text-lg">{{ $product->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-semibold text-gray-800">Category:</span>
                            <span class="text-gray-600">{{ $product->category->category_name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">Supplier:</span>
                            <span class="text-gray-600">{{ $product->supplier->supplier_name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">Stock:</span>
                            <span class="text-gray-600">{{ $product->stock_quantity }} available</span>
                        </div>
                        <div>
                            <span class="font-semibold text-gray-800">SKU:</span>
                            <span class="text-gray-600">{{ $product->product_id }}</span>
                        </div>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('products.addToCart', $product) }}" class="space-y-4">
                            @csrf
                            <div class="flex items-center space-x-4">
                                <label for="quantity" class="font-semibold text-gray-800">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-20 border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-gold-400">
                            </div>
                            <button type="submit" class="w-full bg-gold-400 text-black px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gold-300 transition duration-300">
                                Add to Cart - ${{ number_format($product->price, 2) }}
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg">
                            <p class="text-gray-600 mb-4">Please <a href="{{ route('login') }}" class="text-gold-400 hover:text-gold-300 font-semibold">login</a> to add this fragrance to your cart.</p>
                            <a href="{{ route('login') }}" class="bg-gold-400 text-black px-6 py-2 rounded font-semibold hover:bg-gold-300 transition duration-300 inline-block">Login</a>
                        </div>
                    @endauth

                    <div class="flex space-x-4">
                        <a href="{{ route('products.index') }}" class="text-gold-400 hover:text-gold-300 font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Back to Collection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Customer Reviews</h2>

            @if($product->productReviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($product->productReviews as $review)
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                            <div class="flex items-center mb-4">
                                <div class="flex text-gold-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span class="ml-2 text-gray-600">{{ $review->rating }}/5</span>
                            </div>
                            <p class="text-gray-800 font-semibold mb-2">{{ $review->user->full_name ?? 'Anonymous' }}</p>
                            <p class="text-gray-600">{{ $review->review_text }}</p>
                            <p class="text-sm text-gray-500 mt-2">{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-4xl mb-4">💭</div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">No reviews yet</h3>
                    <p class="text-gray-600">Be the first to share your thoughts about this fragrance!</p>
                </div>
            @endif
        </div>
    </section>

    <script>
        function changeImage(src) {
            document.getElementById('main-image').src = src;
        }
    </script>
@endsection