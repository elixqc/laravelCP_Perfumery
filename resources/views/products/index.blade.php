@extends('layouts.app')

@section('title', 'Fragrances — Prestige Perfumery')

@section('content')

{{-- ── HERO ── --}}
<section class="pp-hero">
    <div class="pp-hero-rule">
        <span></span>
        <em>Maison de Parfum</em>
        <span></span>
    </div>
    <h1>The Collection</h1>
    <p>Scents that define a moment</p>
</section>

{{-- ── FILTER BAR ── --}}
<section class="pp-filter-wrap">
    <form method="GET" class="pp-filter-inner">
        <div class="pp-field">
            <label class="pp-label">Search</label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search fragrances…"
                class="pp-input"
            >
        </div>
        <div class="pp-field">
            <label class="pp-label">Category</label>
            <div class="pp-select-wrap">
                <select name="category" class="pp-select">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="pp-field">
            <label class="pp-label">&nbsp;</label>
            <button type="submit" class="pp-btn-search">Search</button>
        </div>
    </form>
</section>

{{-- ── PRODUCTS GRID ── --}}
<section class="pp-grid-wrap">
    <div class="pp-grid-inner">

        @if($products->count() > 0)

            <div class="pp-section-header">
                <span class="pp-section-title">Fragrances</span>
                <span class="pp-count">{{ $products->total() }} expressions</span>
            </div>

            <div class="pp-grid">
                @foreach($products as $product)
                    @php
                        $firstImage = $product->productImages->first();
                        $imageUrl   = $firstImage
                            ? asset('storage/' . $firstImage->image_path)
                            : ($product->image_path ? asset('storage/' . $product->image_path) : null);

                        [$priceWhole, $priceDec] = explode('.', number_format($product->selling_price, 2));
                    @endphp

                    <article class="pp-card">

                        @if($imageUrl)
                            <div class="pp-card-img-wrap">
                                <img src="{{ $imageUrl }}" alt="{{ $product->product_name }}" loading="lazy">
                                <div class="pp-card-overlay">
                                    @auth
                                        <form method="POST" action="{{ route('products.addToCart', $product) }}" style="width:100%">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="pp-quick-add">— Add to Cart —</button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        @else
                            <div class="pp-card-no-img">
                                <span>No image</span>
                            </div>
                        @endif

                        <div class="pp-card-body">
                            <span class="pp-card-supplier">{{ $product->supplier->supplier_name ?? 'Prestige' }}</span>
                            <a href="{{ route('products.show', $product) }}" class="pp-card-name">{{ $product->product_name }}</a>
                            <p class="pp-card-desc">{{ Str::limit($product->description, 72) }}</p>
                            <div class="pp-card-footer">
                                <span class="pp-card-price">
                                    <sup>$</sup>{{ $priceWhole }}<sup>.{{ $priceDec }}</sup>
                                </span>
                                <a href="{{ route('products.show', $product) }}" class="pp-btn-view">Discover →</a>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            <div class="pp-pagination">
                {{ $products->appends(request()->query())->links() }}
            </div>

        @else
            <div class="pp-empty">
                <span class="pp-empty-icon">— No results —</span>
                <h3>No fragrances found</h3>
                <p>Try adjusting your search, or explore the full collection.</p>
                <a href="{{ route('products.index') }}" class="pp-btn-ghost">View All</a>
            </div>
        @endif

    </div>
</section>

@endsection