@extends('layouts.app')

@section('title', '{{ $product->product_name }} — Prestige Perfumery')

@section('content')

{{-- ── HERO ── --}}
<section class="pp-hero" style="padding:3.5rem 2.5rem 2.8rem; text-align:center;">
    <div class="pp-section-inner">
        {{-- Breadcrumb --}}
        <div style="display:flex; align-items:center; justify-content:center; gap:0.6rem; margin-bottom:1.2rem;">
            <a href="{{ route('products.index') }}"
               style="font-size:0.72rem; letter-spacing:0.15em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; text-decoration:none; transition:color 0.2s;"
               onmouseover="this.style.color='var(--gold)'"
               onmouseout="this.style.color='var(--stone)'">Collection</a>
            <span style="color:var(--stone); font-size:0.6rem; opacity:0.5;">›</span>
            <span style="font-size:0.72rem; letter-spacing:0.15em; text-transform:uppercase; color:var(--ivory); opacity:0.65; font-family:'Jost',sans-serif; font-weight:300;">
                {{ Str::limit($product->product_name, 40) }}
            </span>
        </div>

        <div class="pp-hero-rule" style="margin-bottom:1rem;">
            <span></span>
            <em style="font-size:0.78rem;">{{ $product->supplier->supplier_name ?? 'Prestige' }}</em>
            <span></span>
        </div>

        <h1 style="font-family:'Cormorant Garamond',serif; font-size:clamp(2.2rem,5vw,3.8rem); font-weight:300; font-style:italic; color:var(--ivory); letter-spacing:0.04em; line-height:1.05; margin:0;">
            {{ $product->product_name }}
        </h1>

        @if($product->variant)
            <p style="font-size:0.72rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; margin-top:0.75rem;">
                {{ $product->variant }}
            </p>
        @endif
    </div>
</section>

{{-- ── PRODUCT DETAIL ── --}}
<section style="background:var(--white); padding:5rem 2.5rem;">
    <div style="max-width:1200px; margin:0 auto;">
        <div style="display:grid; grid-template-columns:55% 1fr; gap:6rem; align-items:start;">

            {{-- ══ LEFT: Image Gallery ══ --}}
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                @php
                    $images   = $product->productImages;
                    $firstImg = $images->first();
                    $imageUrl = $firstImg
                        ? asset('storage/' . $firstImg->image_path)
                        : null;
                @endphp

                @if($imageUrl)
                    {{-- Main image --}}
                    <div style="aspect-ratio:4/5; overflow:hidden; background:var(--cream); position:relative;">
                        <img src="{{ $imageUrl }}"
                             alt="{{ $product->product_name }}"
                             id="main-image"
                             style="width:100%; height:100%; object-fit:cover; display:block;
                                    transition:opacity 0.35s ease, transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94);"
                             onmouseover="this.style.transform='scale(1.04)'"
                             onmouseout="this.style.transform='scale(1)'">

                        @if($images->count() > 1)
                            <div id="image-counter"
                                 style="position:absolute; bottom:1.25rem; right:1.25rem;
                                        background:rgba(26,23,20,0.7); backdrop-filter:blur(8px);
                                        color:var(--ivory); font-family:'Jost',sans-serif;
                                        font-size:0.6rem; letter-spacing:0.2em; text-transform:uppercase;
                                        font-weight:300; padding:0.35rem 0.85rem;">
                                1 / {{ $images->count() }}
                            </div>
                        @endif

                        @if($product->stock_quantity <= 5 && $product->stock_quantity > 0)
                            <div style="position:absolute; top:1.25rem; left:1.25rem; background:var(--gold); color:var(--ink); font-family:'Jost',sans-serif; font-size:0.6rem; letter-spacing:0.18em; text-transform:uppercase; font-weight:400; padding:0.3rem 0.8rem;">
                                Only {{ $product->stock_quantity }} Left
                            </div>
                        @elseif($product->stock_quantity === 0)
                            <div style="position:absolute; top:1.25rem; left:1.25rem; background:#8B3A3A; color:#F8F5F0; font-family:'Jost',sans-serif; font-size:0.6rem; letter-spacing:0.18em; text-transform:uppercase; font-weight:400; padding:0.3rem 0.8rem;">
                                Sold Out
                            </div>
                        @endif
                    </div>

                    @if($images->count() > 1)
                        <div style="display:grid; grid-template-columns:repeat({{ min($images->count(), 6) }}, 1fr); gap:5px;">
                            @foreach($images as $index => $image)
                                @php $thumbUrl = asset('storage/' . $image->image_path); @endphp
                                <div class="pp-thumb"
                                     data-index="{{ $index + 1 }}"
                                     data-total="{{ $images->count() }}"
                                     onclick="changeImage('{{ $thumbUrl }}', this)"
                                     style="aspect-ratio:1/1; overflow:hidden; background:var(--cream);
                                            border:2px solid {{ $index === 0 ? 'var(--gold)' : 'transparent' }};
                                            cursor:pointer; transition:border-color 0.2s; position:relative;">
                                    <img src="{{ $thumbUrl }}"
                                         alt="{{ $product->product_name }} view {{ $index + 1 }}"
                                         style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.4s ease;"
                                         onmouseover="this.style.transform='scale(1.1)'"
                                         onmouseout="this.style.transform='scale(1)'">
                                    <div class="pp-thumb-line"
                                         style="position:absolute; bottom:0; left:0; right:0; height:2px; background:var(--gold);
                                                transform:scaleX({{ $index === 0 ? 1 : 0 }}); transform-origin:left; transition:transform 0.25s ease;"></div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                @else
                    <div style="aspect-ratio:4/5; background:var(--cream); display:flex; align-items:center; justify-content:center;">
                        <span style="font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">No Image Available</span>
                    </div>
                @endif
            </div>

            {{-- ══ RIGHT: Product Info ══ --}}
            <div style="display:flex; flex-direction:column; gap:0; position:sticky; top:90px;">

                {{-- Price --}}
                <div style="padding-bottom:2rem; border-bottom:1px solid var(--cream);">
                    @if($product->initial_price && $product->selling_price && $product->initial_price > $product->selling_price)
                        <div style="display:flex; align-items:baseline; gap:1rem;">
                            <span style="font-family:'Cormorant Garamond',serif; font-size:2.8rem; font-weight:300; color:var(--gold); line-height:1; letter-spacing:0.02em;">
                                <sup style="font-size:0.7rem; vertical-align:super;">$</sup>{{ number_format($product->selling_price, 2) }}
                            </span>
                            <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:var(--stone); text-decoration:line-through;">
                                ${{ number_format($product->initial_price, 2) }}
                            </span>
                        </div>
                    @else
                        <span style="font-family:'Cormorant Garamond',serif; font-size:2.8rem; font-weight:300; color:var(--gold); line-height:1; letter-spacing:0.02em;">
                            <sup style="font-size:0.7rem; vertical-align:super;">$</sup>{{ number_format($product->selling_price ?? $product->price, 2) }}
                        </span>
                    @endif

                    @if($product->productReviews->count() > 0)
                        @php $avgRating = round($product->productReviews->avg('rating'), 1); @endphp
                        <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.75rem;">
                            <div style="display:flex; gap:1px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="12" height="12" viewBox="0 0 20 20"
                                         style="fill:{{ $i <= round($avgRating) ? 'var(--gold)' : 'var(--cream)' }}; flex-shrink:0;">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span style="font-size:0.72rem; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; letter-spacing:0.06em;">
                                {{ $avgRating }} · {{ $product->productReviews->count() }} {{ Str::plural('review', $product->productReviews->count()) }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                @if($product->description)
                    <div style="padding:2rem 0; border-bottom:1px solid var(--cream);">
                        <p style="font-size:0.9rem; color:var(--charcoal); line-height:1.9; font-family:'Jost',sans-serif; font-weight:300; letter-spacing:0.025em;">
                            {{ $product->description }}
                        </p>
                    </div>
                @endif

                {{-- Meta grid --}}
                <div style="padding:2rem 0; border-bottom:1px solid var(--cream); display:grid; grid-template-columns:1fr 1fr; gap:1.5rem 1rem;">
                    <div>
                        <span style="font-size:0.58rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.4rem;">Category</span>
                        <span style="font-size:0.88rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">{{ $product->category->category_name ?? '—' }}</span>
                    </div>
                    <div>
                        <span style="font-size:0.58rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.4rem;">Maison</span>
                        <span style="font-size:0.88rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">{{ $product->supplier->supplier_name ?? '—' }}</span>
                    </div>
                    <div>
                        <span style="font-size:0.58rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.4rem;">Availability</span>
                        @if($product->stock_quantity > 10)
                            <span style="font-size:0.88rem; color:#4A6741; font-family:'Jost',sans-serif; font-weight:300;">In Stock</span>
                        @elseif($product->stock_quantity > 0)
                            <span style="font-size:0.88rem; color:#856404; font-family:'Jost',sans-serif; font-weight:300;">{{ $product->stock_quantity }} remaining</span>
                        @else
                            <span style="font-size:0.88rem; color:#8B3A3A; font-family:'Jost',sans-serif; font-weight:300;">Sold Out</span>
                        @endif
                    </div>
                    <div>
                        <span style="font-size:0.58rem; letter-spacing:0.22em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.4rem;">Reference</span>
                        <span style="font-size:0.85rem; color:var(--charcoal); font-family:'Courier New',monospace;">#{{ str_pad($product->product_id, 5, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>

                {{-- Add to Cart / Login prompt --}}
                <div style="padding:2rem 0; border-bottom:1px solid var(--cream);">
                    @auth
                        @if($product->stock_quantity > 0)
                            <form method="POST" action="{{ route('products.addToCart', $product) }}" style="display:flex; flex-direction:column; gap:1.2rem;">
                                @csrf
                                <div style="display:flex; align-items:center; gap:0;">
                                    <button type="button" onclick="stepQty(-1)"
                                            style="width:42px; height:48px; background:var(--cream); border:1px solid var(--stone); border-right:none; color:var(--charcoal); font-size:1.2rem; cursor:pointer; font-family:'Jost',sans-serif; transition:background 0.2s;"
                                            onmouseover="this.style.background='var(--stone)'"
                                            onmouseout="this.style.background='var(--cream)'">−</button>
                                    <input type="number" id="quantity" name="quantity"
                                           value="1" min="1" max="{{ $product->stock_quantity }}"
                                           style="width:60px; height:48px; background:var(--ivory); border:1px solid var(--stone); color:var(--ink); font-family:'Jost',sans-serif; font-size:0.95rem; font-weight:300; padding:0; outline:none; text-align:center; -webkit-appearance:none; appearance:none; border-radius:0;">
                                    <button type="button" onclick="stepQty(1)"
                                            style="width:42px; height:48px; background:var(--cream); border:1px solid var(--stone); border-left:none; color:var(--charcoal); font-size:1.2rem; cursor:pointer; font-family:'Jost',sans-serif; transition:background 0.2s;"
                                            onmouseover="this.style.background='var(--stone)'"
                                            onmouseout="this.style.background='var(--cream)'">+</button>
                                </div>
                                <button type="submit"
                                        style="background:var(--ink); color:var(--ivory); border:1px solid var(--ink); font-family:'Jost',sans-serif; font-size:0.72rem; font-weight:400; letter-spacing:0.25em; text-transform:uppercase; padding:1.1rem 2rem; cursor:pointer; transition:background 0.25s, color 0.25s, border-color 0.25s; width:100%;"
                                        onmouseover="this.style.background='var(--gold)'; this.style.borderColor='var(--gold)'; this.style.color='var(--ink)'"
                                        onmouseout="this.style.background='var(--ink)'; this.style.borderColor='var(--ink)'; this.style.color='var(--ivory)'">
                                    Add to Cart
                                </button>
                            </form>
                        @else
                            <button disabled
                                    style="background:var(--cream); color:var(--stone); border:1px solid var(--stone); font-family:'Jost',sans-serif; font-size:0.72rem; letter-spacing:0.25em; text-transform:uppercase; padding:1.1rem 2rem; width:100%; cursor:not-allowed;">
                                Sold Out
                            </button>
                        @endif
                    @else
                        <div style="background:var(--cream); padding:1.75rem; border-left:2px solid var(--gold);">
                            <p style="font-size:0.82rem; color:var(--charcoal); letter-spacing:0.04em; font-family:'Jost',sans-serif; font-weight:300; margin-bottom:1.2rem; line-height:1.75;">
                                Please sign in to add this fragrance to your collection.
                            </p>
                            <a href="{{ route('login') }}"
                               style="display:inline-block; background:var(--ink); color:var(--ivory); border:1px solid var(--ink); padding:0.75rem 2rem; font-family:'Jost',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; font-weight:300; text-decoration:none; transition:all 0.25s;"
                               onmouseover="this.style.background='var(--gold)'; this.style.borderColor='var(--gold)'; this.style.color='var(--ink)'"
                               onmouseout="this.style.background='var(--ink)'; this.style.borderColor='var(--ink)'; this.style.color='var(--ivory)'">
                                Sign In
                            </a>
                        </div>
                    @endauth
                </div>

                {{-- Back link --}}
                <div style="padding-top:1.75rem;">
                    <a href="{{ route('products.index') }}"
                       style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:var(--stone); text-decoration:none; font-family:'Jost',sans-serif; font-weight:300; display:inline-flex; align-items:center; gap:0.5rem; border-bottom:1px solid transparent; padding-bottom:2px; transition:color 0.2s, border-color 0.2s;"
                       onmouseover="this.style.color='var(--charcoal)'; this.style.borderBottomColor='var(--charcoal)'"
                       onmouseout="this.style.color='var(--stone)'; this.style.borderBottomColor='transparent'">
                        ← Back to Collection
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ── REVIEWS ── --}}
<section style="background:var(--cream); padding:5rem 2.5rem;">
    <div style="max-width:1200px; margin:0 auto;">

        {{-- Section header --}}
        <div style="text-align:center; margin-bottom:4rem;">
            <div class="pp-hero-rule" style="margin-bottom:1.2rem;">
                <span></span>
                <em style="font-size:0.78rem;">From Our Clientele</em>
                <span></span>
            </div>
            <h2 style="font-family:'Cormorant Garamond',serif; font-size:clamp(1.8rem,4vw,2.6rem); font-weight:300; color:var(--ink); font-style:italic; line-height:1.1; letter-spacing:0.06em; margin:0;">
                Client Reviews
            </h2>
            @if($product->productReviews->count() > 0)
                @php $avgRating = round($product->productReviews->avg('rating'), 1); @endphp
                <div style="display:flex; align-items:center; justify-content:center; gap:0.6rem; margin-top:1rem;">
                    <div style="display:flex; gap:2px;">
                        @for($i = 1; $i <= 5; $i++)
                            <svg width="14" height="14" viewBox="0 0 20 20"
                                 style="fill:{{ $i <= round($avgRating) ? 'var(--gold)' : '#D6D0C8' }};">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span style="font-size:0.78rem; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; letter-spacing:0.08em;">
                        {{ $avgRating }} out of 5 &nbsp;·&nbsp; {{ $product->productReviews->count() }} {{ Str::plural('review', $product->productReviews->count()) }}
                    </span>
                </div>
            @endif
        </div>

        {{-- Reviews grid --}}
        @if($product->productReviews->count() > 0)
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:2px; background:var(--stone); border:1px solid var(--stone); margin-bottom:4rem;">
                @foreach($product->productReviews as $review)
                    <div style="background:var(--ivory); padding:2.5rem 2rem; display:flex; flex-direction:column; gap:1.2rem;">

                        <div style="display:flex; align-items:center; justify-content:space-between;">
                            <div style="display:flex; gap:2px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="13" height="13" viewBox="0 0 20 20"
                                         style="fill:{{ $i <= $review->rating ? 'var(--gold)' : '#E8E2D9' }}; flex-shrink:0;">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:var(--gold); font-style:italic; line-height:1;">
                                {{ $review->rating }}.0
                            </span>
                        </div>

                        <p style="font-size:0.88rem; color:var(--charcoal); line-height:1.8; font-family:'Jost',sans-serif; font-weight:300; font-style:italic; flex:1; border-left:2px solid var(--gold); padding-left:1rem; margin:0;">
                            "{{ $review->review_text }}"
                        </p>

                        <div style="border-top:1px solid var(--cream); padding-top:1rem; display:flex; align-items:center; justify-content:space-between;">
                            <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300;">
                                {{ $review->user->full_name ?? 'Anonymous' }}
                            </span>
                            <span style="font-size:0.65rem; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                                {{ $review->created_at?->format('M d, Y') ?? '—' }}
                            </span>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align:center; padding:4rem 2rem; margin-bottom:4rem;">
                <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:var(--stone); font-style:italic; display:block; margin-bottom:0.5rem;">No reviews yet</span>
                <span style="font-size:0.72rem; letter-spacing:0.12em; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">Be the first to share your experience</span>
            </div>
        @endif

        {{-- ── Review Form ── --}}
        @auth
            @php
                $userReview   = $product->productReviews->where('user_id', auth()->id())->first();
                $hasPurchased = \App\Models\OrderDetail::where('product_id', $product->product_id)
                    ->whereHas('order', fn($q) => $q->where('user_id', auth()->id()))->exists();
            @endphp
            @if($hasPurchased)
                <div style="max-width:560px; margin:0 auto;">
                    <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid #D6D0C8; margin-bottom:1.75rem;">
                        {{ $userReview ? 'Update Your Review' : 'Leave a Review' }}
                    </p>

                    <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:2rem 2.5rem;">
                        <form method="POST" action="{{ route('products.review', $product->product_id) }}">
                            @csrf

                            {{-- Interactive star selector --}}
                            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.5rem;">
                                <label style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                    Rating <span style="color:#C97A7A;">*</span>
                                </label>
                                <div style="display:flex; align-items:center; gap:0.3rem;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button"
                                                class="star-btn"
                                                data-value="{{ $i }}"
                                                onclick="setRating({{ $i }})"
                                                onmouseover="hoverRating({{ $i }})"
                                                onmouseout="resetHover()"
                                                style="background:none; border:none; cursor:pointer; padding:2px; line-height:0;">
                                            <svg width="28" height="28" viewBox="0 0 20 20"
                                                 class="star-icon"
                                                 style="fill:{{ old('rating', $userReview->rating ?? 0) >= $i ? 'var(--gold)' : '#D6D0C8' }}; transition:fill 0.15s, transform 0.15s; display:block;">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </button>
                                    @endfor
                                    <span id="rating-label" style="font-size:0.75rem; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; margin-left:0.6rem; letter-spacing:0.06em;">
                                        {{ old('rating', $userReview->rating ?? '') ? old('rating', $userReview->rating) . ' / 5' : 'Select a rating' }}
                                    </span>
                                </div>
                                <input type="hidden" id="rating-input" name="rating" value="{{ old('rating', $userReview->rating ?? '') }}" required>
                                @error('rating')
                                    <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Comment textarea --}}
                            <div style="display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1.75rem;">
                                <label for="review_text" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                    Your Experience
                                </label>
                                <textarea name="review_text" id="review_text" rows="4"
                                          placeholder="Share how this fragrance made you feel…"
                                          style="background:#fff; border:1.5px solid #B0A898; color:#1A1714; font-family:'Jost',sans-serif; font-weight:300; font-size:0.92rem; padding:0.85rem 1rem; outline:none; width:100%; resize:vertical; min-height:110px; transition:border-color 0.2s; line-height:1.65;"
                                          onfocus="this.style.borderColor='#B5975A'"
                                          onblur="this.style.borderColor='#B0A898'">{{ old('review_text', $userReview->review_text ?? '') }}</textarea>
                                @error('review_text')
                                    <span style="font-size:0.78rem; color:#8B3A3A; font-family:'Jost',sans-serif;">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                    style="background:#2C2825; color:#F8F5F0; border:none; font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:500; letter-spacing:0.15em; text-transform:uppercase; padding:0.9rem 2.5rem; cursor:pointer; transition:background 0.25s, color 0.25s; border-radius:2px;"
                                    onmouseover="this.style.background='#B5975A'; this.style.color='#1A1714'"
                                    onmouseout="this.style.background='#2C2825'; this.style.color='#F8F5F0'">
                                {{ $userReview ? 'Update Review' : 'Submit Review' }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        @endauth

    </div>
</section>

<script>
    // ── Image gallery ──────────────────────────────────────────
    function changeImage(src, thumbEl) {
        const mainImg = document.getElementById('main-image');
        mainImg.style.opacity = '0';
        mainImg.style.transform = 'scale(1.02)';
        setTimeout(() => {
            mainImg.src = src;
            mainImg.style.transition = 'opacity 0.35s ease, transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94)';
            mainImg.style.opacity = '1';
            mainImg.style.transform = 'scale(1)';
        }, 180);

        document.querySelectorAll('.pp-thumb').forEach(el => {
            el.style.borderColor = 'transparent';
            const line = el.querySelector('.pp-thumb-line');
            if (line) line.style.transform = 'scaleX(0)';
        });

        if (thumbEl) {
            thumbEl.style.borderColor = 'var(--gold)';
            const line = thumbEl.querySelector('.pp-thumb-line');
            if (line) line.style.transform = 'scaleX(1)';
            const counter = document.getElementById('image-counter');
            if (counter) counter.textContent = thumbEl.dataset.index + ' / ' + thumbEl.dataset.total;
        }
    }

    // ── Quantity stepper ───────────────────────────────────────
    function stepQty(delta) {
        const input = document.getElementById('quantity');
        if (!input) return;
        const newVal = Math.max(1, Math.min(parseInt(input.max) || 99, parseInt(input.value) + delta));
        input.value = newVal;
    }

    // ── Star rating selector ───────────────────────────────────
    let selectedRating = parseInt(document.getElementById('rating-input')?.value) || 0;
    const ratingLabels = { 1:'Poor', 2:'Fair', 3:'Good', 4:'Very Good', 5:'Excellent' };

    function setRating(value) {
        selectedRating = value;
        document.getElementById('rating-input').value = value;
        document.getElementById('rating-label').textContent = ratingLabels[value] + '  ·  ' + value + ' / 5';
        paintStars(value, true);
    }

    function hoverRating(value) {
        paintStars(value, false);
        document.getElementById('rating-label').textContent = ratingLabels[value] + '  ·  ' + value + ' / 5';
    }

    function resetHover() {
        paintStars(selectedRating, true);
        document.getElementById('rating-label').textContent =
            selectedRating ? ratingLabels[selectedRating] + '  ·  ' + selectedRating + ' / 5' : 'Select a rating';
    }

    function paintStars(upTo, selected) {
        document.querySelectorAll('.star-icon').forEach((icon, idx) => {
            const filled = idx < upTo;
            icon.style.fill = filled ? 'var(--gold)' : '#D6D0C8';
            icon.parentElement.style.transform = (filled && selected) ? 'scale(1.2)' : 'scale(1)';
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (selectedRating) paintStars(selectedRating, true);
    });
</script>

@endsection