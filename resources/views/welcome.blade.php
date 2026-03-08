@extends('layouts.app')

@section('title', 'Prestige Perfumery — Luxury Fragrances')

@section('content')

{{-- ── SEARCH ── }}--}}
<section class="pp-section pp-section--ivory">
    <div class="pp-section-inner">
        <div class="pp-section-header pp-section-header--centered">
            <span class="pp-section-title">Search Fragrances</span>
        </div>
        
        <form method="GET" action="{{ route('home') }}" class="pp-search-form">
            <div class="pp-search-grid">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search for fragrances..." 
                    value="{{ request('search') }}"
                    class="pp-search-input"
                >
                <select name="category" class="pp-search-select">
                    <option value="">All Categories</option>
                    @foreach(App\Models\Category::all() as $category)
                        <option value="{{ $category->category_id }}" {{ request('category') == $category->category_id ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="pp-btn-ghost">Search</button>
            </div>
        </form>
        
        @if(request('search'))
            <div class="pp-search-results">
                <p class="pp-search-count">
                    Found {{ isset($searchProducts) ? $searchProducts->total() : 0 }} results
                </p>
            </div>
        @endif
    </div>
</section>

{{-- ── HERO ── --}}
<section class="pp-hero pp-hero--home" style="background-image: url('{{ asset('images/home-hero.png') }}');">
    <div class="pp-hero-rule">
        <span></span>
        <em>Est. Since Always</em>
        <span></span>
    </div>
    <h1>The Art of<br><i>Fine Fragrance</i></h1>
    <p>Discover the essence of luxury with our exquisite collection</p>
    <a href="{{ route('products.index') }}" class="pp-btn-ghost pp-btn-ghost--light">Explore Collection</a>
</section>

{{-- ── FEATURED PRODUCTS ── --}}
<section class="pp-section pp-section--ivory">
    <div class="pp-section-inner">

        <div class="pp-section-header pp-section-header--centered">
            <span class="pp-section-title">Featured Fragrances</span>
        </div>

        <div class="pp-featured-grid">
            @if(request('search'))
                {{-- Search Results --}}
                @if(isset($searchProducts) && $searchProducts && $searchProducts->count() > 0)
                    @foreach($searchProducts as $product)
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
                                    <div class="pp-card-overlay"></div>
                                </div>
                            @else
                                <div class="pp-card-no-img"><span>No image</span></div>
                            @endif

                            <div class="pp-card-body">
                                <span class="pp-card-supplier">{{ $product->supplier->supplier_name ?? 'Prestige' }}</span>
                                <a href="{{ route('products.show', $product) }}" class="pp-card-name">{{ $product->product_name }}</a>
                                <p class="pp-card-desc">{{ Str::limit($product->description, 100) }}</p>
                                <div class="pp-card-footer">
                                    <span class="pp-card-price"><sup>₱</sup>{{ $priceWhole }}<sup>.{{ $priceDec }}</sup></span>
                                    <a href="{{ route('products.show', $product) }}" class="pp-btn-view">Discover →</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                    
                    @if($searchProducts->hasPages())
                        <div class="pp-pagination">
                            {{ $searchProducts->links() }}
                        </div>
                    @endif
                @else
                    <div class="pp-no-results">
                        <p>No products found matching your search criteria.</p>
                        <a href="{{ route('home') }}" class="pp-btn-ghost">Clear Search</a>
                    </div>
                @endif
            @else
                {{-- Featured Products --}}
                @foreach($featuredProducts ?? [] as $product)
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
                                <div class="pp-card-overlay"></div>
                            </div>
                        @else
                            <div class="pp-card-no-img"><span>No image</span></div>
                        @endif

                        <div class="pp-card-body">
                            <span class="pp-card-supplier">{{ $product->supplier->supplier_name ?? 'Prestige' }}</span>
                            <a href="{{ route('products.show', $product) }}" class="pp-card-name">{{ $product->product_name }}</a>
                            <p class="pp-card-desc">{{ Str::limit($product->description, 100) }}</p>
                            <div class="pp-card-footer">
                                <span class="pp-card-price"><sup>₱</sup>{{ $priceWhole }}<sup>.{{ $priceDec }}</sup></span>
                                <a href="{{ route('products.show', $product) }}" class="pp-btn-view">Discover →</a>
                            </div>
                        </div>
                    </article>
                @endforeach
            @endif
        </div>

        @if(!request('search'))
            <div class="pp-section-cta">
                <a href="{{ route('products.index') }}" class="pp-btn-ghost">View All Products</a>
            </div>
        @endif

    </div>
</section>

{{-- ── ABOUT ── --}}
<section class="pp-section pp-section--cream">
    <div class="pp-section-inner">
        <div class="pp-about-grid">

            <div class="pp-about-text">
                <span class="pp-eyebrow">Our Maison</span>
                <h2>About Prestige<br>Perfumery</h2>
                <p>For over two decades, Prestige Perfumery has been at the forefront of luxury fragrance creation. We curate an exclusive collection of the world's finest perfumes, bringing you scents that tell stories, evoke memories, and define your unique style.</p>
                <p>Our expert perfumers work tirelessly to source the rarest ingredients from around the globe, crafting fragrances that are not just scents, but works of art.</p>
            </div>

            <div class="pp-about-panel">
                <span class="pp-eyebrow pp-eyebrow--gold">Why Choose Us</span>
                <ul class="pp-why-list">
                    <li>
                        <span class="pp-why-dot"></span>
                        Authentic luxury fragrances
                    </li>
                    <li>
                        <span class="pp-why-dot"></span>
                        Expert curation and advice
                    </li>
                    <li>
                        <span class="pp-why-dot"></span>
                        Discreet worldwide shipping
                    </li>
                    <li>
                        <span class="pp-why-dot"></span>
                        Satisfaction guarantee
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- ── CATEGORIES ── --}}
<section class="pp-section pp-section--ivory">
    <div class="pp-section-inner">

        <div class="pp-section-header pp-section-header--centered">
            <span class="pp-section-title">Explore Categories</span>
        </div>

        <div class="pp-cat-grid">
            @foreach(['Men', 'Women', 'Unisex', 'Designer'] as $category)
                <a href="{{ route('products.index', ['category' => strtolower($category)]) }}" class="pp-cat-card">
                    <span class="pp-cat-icon">◈</span>
                    <span class="pp-cat-name">{{ $category }}</span>
                    <span class="pp-cat-arrow">→</span>
                </a>
            @endforeach
        </div>

    </div>
</section>

{{-- ── NEWSLETTER ── --}}
<section class="pp-section pp-section--dark">
    <div class="pp-section-inner pp-section-inner--centered">
        <div class="pp-hero-rule">
            <span></span>
            <em>Exclusive Access</em>
            <span></span>
        </div>
        <h2 class="pp-newsletter-title">Stay in the Know</h2>
        <p class="pp-newsletter-sub">Subscribe for exclusive offers and new fragrance launches</p>
        <form class="pp-newsletter-form" onsubmit="return false;">
            <input type="email" placeholder="Your email address" class="pp-newsletter-input">
            <button type="submit" class="pp-newsletter-btn">Subscribe</button>
        </form>
    </div>
</section>

@endsection