@extends('layouts.app')

@section('title', 'Order #{{ $order->order_id }} — Prestige Perfumery')

@section('content')

{{-- ── HERO ── --}}
<section class="pp-hero" style="padding: 4rem 2.5rem 3rem; text-align: left;">
    <div style="max-width: 1280px; margin: 0 auto;">

        {{-- Breadcrumb --}}
        <nav style="margin-bottom: 2rem;">
            <a href="{{ route('orders.index') }}"
               style="font-size:0.6rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--stone); text-decoration:none; font-family:'Jost',sans-serif; font-weight:300; transition:color 0.2s ease;"
               onmouseover="this.style.color='var(--gold)'"
               onmouseout="this.style.color='var(--stone)'">
                My Orders
            </a>
            <span style="color:var(--stone); opacity:0.4; margin:0 0.8rem; font-size:0.6rem;">—</span>
            <span style="font-size:0.6rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--ivory); font-family:'Jost',sans-serif; font-weight:300; opacity:0.7;">
                Order #{{ $order->order_id }}
            </span>
        </nav>

        <div class="pp-hero-rule" style="justify-content:flex-start; margin-bottom:1.2rem;">
            <span></span>
            <em>Order Details</em>
        </div>

        <h1 style="font-style:italic; line-height:1.05; margin-bottom:0;">
            Order #{{ $order->order_id }}
        </h1>
    </div>
</section>

{{-- ── MAIN CONTENT ── --}}
<section class="pp-section pp-section--ivory">
    <div class="pp-section-inner">
        <div style="display:grid; grid-template-columns:2fr 1fr; gap:3rem; align-items:start;">

            {{-- ── LEFT: Order Items ── --}}
            <div style="display:flex; flex-direction:column; gap:1.5rem;">

                {{-- Section label --}}
                <div style="display:flex; align-items:center; justify-content:space-between; padding-bottom:1rem; border-bottom:1px solid var(--cream);">
                    <span style="font-size:0.62rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                        {{ $order->orderDetails->count() }} {{ Str::plural('Item', $order->orderDetails->count()) }}
                    </span>
                    <span style="font-size:0.62rem; letter-spacing:0.25em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:300;
                        @if($order->order_status === 'completed') color:#4A6741;
                        @elseif($order->order_status === 'processing') color:#3A5580;
                        @elseif($order->order_status === 'cancelled') color:#8B3A3A;
                        @else color:#856404; @endif">
                        ● {{ ucfirst($order->order_status) }}
                    </span>
                </div>

                {{-- Items list --}}
                @foreach($order->orderDetails as $detail)
                    @php
                        $firstImage = $detail->product->productImages->first();
                        $imageUrl = $firstImage
                            ? asset('storage/' . $firstImage->image_path)
                            : ($detail->product->image_path ? asset('storage/' . $detail->product->image_path) : null);
                    @endphp

                    <div style="display:grid; grid-template-columns:100px 1fr auto; gap:1.5rem; align-items:start; background:#FDFBF8; border:1px solid var(--cream); padding:1.5rem; transition:border-color 0.25s ease;"
                         onmouseover="this.style.borderColor='var(--gold)'"
                         onmouseout="this.style.borderColor='var(--cream)'">

                        {{-- Product image --}}
                        @if($imageUrl)
                            <div style="aspect-ratio:3/4; overflow:hidden; background:var(--cream); border:1px solid var(--cream);">
                                <img src="{{ $imageUrl }}"
                                     alt="{{ $detail->product->product_name }}"
                                     style="width:100%; height:100%; object-fit:cover; display:block; transition:transform 0.5s ease;"
                                     onmouseover="this.style.transform='scale(1.06)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            </div>
                        @else
                            <div style="aspect-ratio:3/4; background:var(--cream); border:1px solid var(--stone); display:flex; align-items:center; justify-content:center;">
                                <span style="font-size:0.52rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">No Image</span>
                            </div>
                        @endif

                        {{-- Product details --}}
                        <div style="display:flex; flex-direction:column; gap:0.6rem; padding-top:0.25rem;">
                            <span style="font-size:0.55rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300;">
                                {{ $detail->product->supplier->supplier_name ?? 'Prestige' }}
                            </span>
                            <span style="font-family:'Cormorant Garamond',serif; font-size:1.15rem; font-weight:300; color:var(--ink); letter-spacing:0.04em; line-height:1.2;">
                                {{ $detail->product->product_name }}
                            </span>
                            <div style="display:flex; gap:1.5rem; margin-top:0.5rem;">
                                <div>
                                    <span style="font-size:0.55rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.2rem;">Qty</span>
                                    <span style="font-size:0.85rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">{{ $detail->quantity }}</span>
                                </div>
                                <div>
                                    <span style="font-size:0.55rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.2rem;">Unit Price</span>
                                    <span style="font-size:0.85rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">${{ number_format($detail->unit_price, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Subtotal --}}
                        <div style="text-align:right; padding-top:0.25rem;">
                            <span style="font-size:0.55rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Subtotal</span>
                            <span style="font-family:'Cormorant Garamond',serif; font-size:1.3rem; font-weight:300; color:var(--gold); letter-spacing:0.02em;">
                                <sup style="font-size:0.6rem; vertical-align:super;">$</sup>{{ number_format($detail->subtotal, 2) }}
                            </span>
                        </div>

                    </div>
                @endforeach

                {{-- Back link --}}
                <div style="padding-top:1rem;">
                    <a href="{{ route('orders.index') }}"
                       style="font-size:0.6rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--stone); text-decoration:none; font-family:'Jost',sans-serif; font-weight:300; border-bottom:1px solid transparent; padding-bottom:2px; transition:color 0.2s ease, border-color 0.2s ease; display:inline-flex; align-items:center; gap:0.5rem;"
                       onmouseover="this.style.color='var(--ink)'; this.style.borderBottomColor='var(--ink)'"
                       onmouseout="this.style.color='var(--stone)'; this.style.borderBottomColor='transparent'">
                        ← Back to Orders
                    </a>
                </div>

            </div>

            {{-- ── RIGHT: Order Summary ── --}}
            <div style="display:flex; flex-direction:column; gap:1px; position:sticky; top:90px;">

                {{-- Summary card --}}
                <div style="background:#FDFBF8; border:1px solid var(--cream); padding:2rem;">

                    <h2 style="font-family:'Cormorant Garamond',serif; font-size:1.2rem; font-weight:300; color:var(--ink); letter-spacing:0.06em; font-style:italic; padding-bottom:1.2rem; border-bottom:1px solid var(--cream); margin-bottom:1.8rem;">
                        Order Summary
                    </h2>

                    {{-- Meta rows --}}
                    <div style="display:flex; flex-direction:column; gap:1.4rem;">

                        <div>
                            <span style="font-size:0.55rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Order Date</span>
                            <span style="font-size:0.85rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">{{ $order->order_date->format('M d, Y') }}</span>
                        </div>

                        <div>
                            <span style="font-size:0.55rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Status</span>
                            <span class="pp-order-status-badge {{ $order->order_status }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </div>

                        <div>
                            <span style="font-size:0.55rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Payment Method</span>
                            <span style="font-size:0.85rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300;">{{ ucfirst($order->payment_method) }}</span>
                        </div>

                        <div>
                            <span style="font-size:0.55rem; letter-spacing:0.25em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Delivery Address</span>
                            <span style="font-size:0.85rem; color:var(--charcoal); font-family:'Jost',sans-serif; font-weight:300; line-height:1.6;">{{ $order->delivery_address }}</span>
                        </div>

                    </div>

                    {{-- Divider --}}
                    <div style="height:1px; background:var(--cream); margin:1.8rem 0;"></div>

                    {{-- Order total --}}
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-family:'Cormorant Garamond',serif; font-size:1rem; font-weight:300; color:var(--ink); letter-spacing:0.04em; font-style:italic;">
                            Order Total
                        </span>
                        <span style="font-family:'Cormorant Garamond',serif; font-size:1.6rem; font-weight:300; color:var(--gold); letter-spacing:0.02em;">
                            <sup style="font-size:0.65rem; vertical-align:super;">$</sup>{{ number_format($order->total_amount ?? $order->calculated_total, 2) }}
                        </span>
                    </div>

                </div>

                {{-- Security note --}}
                <div style="background:var(--cream); padding:1rem 1.5rem; text-align:center;">
                    <span style="font-size:0.58rem; letter-spacing:0.18em; text-transform:uppercase; color:var(--stone); font-family:'Jost',sans-serif; font-weight:300;">
                        🔒 &nbsp; Secured Transaction
                    </span>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection