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
<section class="pf-bar">
    <form method="GET" id="filter-form" class="pf-form">

        <div class="pf-fields">

            {{-- Search --}}
            <div class="pf-field pf-field--search">
                <label class="pf-label">Search</label>
                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Fragrance name…"
                       class="pf-input">
            </div>

            {{-- Category --}}
            <div class="pf-field">
                <label class="pf-label">Category</label>
                <div class="pf-select-wrap">
                    <select name="category" class="pf-select">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $cat)
                            <option value="{{ $cat->category_id }}"
                                {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                                {{ $cat->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pf-chevron">▾</span>
                </div>
            </div>

            {{-- Supplier / Maison --}}
            <div class="pf-field">
                <label class="pf-label">Maison</label>
                <div class="pf-select-wrap">
                    <select name="supplier" class="pf-select">
                        <option value="">All Maisons</option>
                        @foreach($suppliers ?? [] as $sup)
                            <option value="{{ $sup->supplier_id }}"
                                {{ request('supplier') == $sup->supplier_id ? 'selected' : '' }}>
                                {{ $sup->supplier_name }}
                            </option>
                        @endforeach
                    </select>
                    <span class="pf-chevron">▾</span>
                </div>
            </div>

            {{-- Sort by price --}}
            <div class="pf-field">
                <label class="pf-label">Price</label>
                <div class="pf-select-wrap">
                    <select name="sort" class="pf-select">
                        <option value=""           {{ !request('sort')                ? 'selected' : '' }}>Default Order</option>
                        <option value="price_asc"  {{ request('sort') === 'price_asc'  ? 'selected' : '' }}>Low to High</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>High to Low</option>
                    </select>
                    <span class="pf-chevron">▾</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="pf-field pf-field--actions">
                <label class="pf-label">&nbsp;</label>
                <div style="display:flex; gap:0.5rem;">
                    <button type="submit" class="pf-btn-submit">Search</button>
                    @if(request()->hasAny(['search','category','supplier','sort']))
                        <a href="{{ route('products.index') }}" class="pf-btn-clear">Clear</a>
                    @endif
                </div>
            </div>

        </div>

        {{-- Active filter tags --}}
        @php
            $activeFilters = array_filter([
                'search'   => request('search'),
                'category' => request('category')
                    ? ($categories->firstWhere('category_id', request('category'))?->category_name ?? null)
                    : null,
                'supplier' => request('supplier')
                    ? ($suppliers->firstWhere('supplier_id', request('supplier'))?->supplier_name ?? null)
                    : null,
                'sort' => match(request('sort')) {
                    'price_asc'  => 'Price: Low → High',
                    'price_desc' => 'Price: High → Low',
                    default      => null,
                },
            ]);
        @endphp

        @if(count($activeFilters))
            <div class="pf-tags">
                <span class="pf-tags-label">Filtering by:</span>
                @foreach($activeFilters as $key => $label)
                    <a href="{{ route('products.index', request()->except($key)) }}" class="pf-tag">
                        {{ $label }}&ensp;✕
                    </a>
                @endforeach
            </div>
        @endif

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

<style>
/* ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
   FILTER BAR
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━ */
.pf-bar {
    background: #F8F5F0;
    border-top: 1px solid #EDE8DF;
    border-bottom: 1px solid #EDE8DF;
    padding: 1.75rem 2.5rem;
}

.pf-form {
    max-width: 1200px;
    margin: 0 auto;
}

.pf-fields {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    align-items: flex-end;
}

/* Field wrapper */
.pf-field {
    display: flex;
    flex-direction: column;
    gap: 0.45rem;
    flex: 1;
    min-width: 140px;
}
.pf-field--search { flex: 2; min-width: 200px; }
.pf-field--actions { flex: 0 0 auto; min-width: unset; }

/* Label */
.pf-label {
    font-family: 'Jost', sans-serif;
    font-size: 0.6rem;
    font-weight: 400;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    color: #B0A898;
}

/* Text input */
.pf-input {
    background: #FFFFFF;
    border: 1.5px solid #D6D0C8;
    color: #1A1714;
    font-family: 'Jost', sans-serif;
    font-size: 0.88rem;
    font-weight: 300;
    padding: 0.72rem 1rem;
    outline: none;
    border-radius: 2px;
    transition: border-color 0.2s;
    width: 100%;
    box-sizing: border-box;
}
.pf-input::placeholder { color: #C8BEB2; }
.pf-input:focus { border-color: #B5975A; }

/* Select wrapper */
.pf-select-wrap {
    position: relative;
    width: 100%;
}
.pf-select {
    background: #FFFFFF;
    border: 1.5px solid #D6D0C8;
    color: #1A1714;
    font-family: 'Jost', sans-serif;
    font-size: 0.88rem;
    font-weight: 300;
    padding: 0.72rem 2.4rem 0.72rem 1rem;
    outline: none;
    width: 100%;
    appearance: none;
    -webkit-appearance: none;
    cursor: pointer;
    border-radius: 2px;
    transition: border-color 0.2s;
    box-sizing: border-box;
}
.pf-select:focus { border-color: #B5975A; }
.pf-chevron {
    position: absolute;
    right: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    color: #B0A898;
    font-size: 0.72rem;
    pointer-events: none;
}

/* Submit button */
.pf-btn-submit {
    background: #1A1714;
    color: #F8F5F0;
    border: 1.5px solid #1A1714;
    font-family: 'Jost', sans-serif;
    font-size: 0.7rem;
    font-weight: 400;
    letter-spacing: 0.22em;
    text-transform: uppercase;
    padding: 0.75rem 1.75rem;
    cursor: pointer;
    border-radius: 2px;
    transition: background 0.25s, border-color 0.25s, color 0.25s;
    white-space: nowrap;
}
.pf-btn-submit:hover {
    background: #B5975A;
    border-color: #B5975A;
    color: #1A1714;
}

/* Clear button */
.pf-btn-clear {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.2rem;
    font-family: 'Jost', sans-serif;
    font-size: 0.7rem;
    font-weight: 400;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: #8C8078;
    border: 1.5px solid #D6D0C8;
    background: transparent;
    text-decoration: none;
    border-radius: 2px;
    transition: border-color 0.2s, color 0.2s;
    white-space: nowrap;
}
.pf-btn-clear:hover { border-color: #C97A7A; color: #C97A7A; }

/* Active filter tags */
.pf-tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1.1rem;
    padding-top: 1.1rem;
    border-top: 1px solid #EDE8DF;
}
.pf-tags-label {
    font-family: 'Jost', sans-serif;
    font-size: 0.6rem;
    font-weight: 400;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: #B0A898;
    margin-right: 0.2rem;
}
.pf-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.3rem 0.8rem;
    background: #FFFFFF;
    border: 1px solid #D6D0C8;
    font-family: 'Jost', sans-serif;
    font-size: 0.75rem;
    font-weight: 300;
    color: #2C2825;
    text-decoration: none;
    border-radius: 2px;
    transition: background 0.2s, border-color 0.2s, color 0.2s;
    letter-spacing: 0.02em;
}
.pf-tag:hover {
    background: #FDF0F0;
    border-color: #C97A7A;
    color: #8B3A3A;
}
</style>

@endsection