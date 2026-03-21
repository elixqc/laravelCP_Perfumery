@extends('layouts.admin')

@section('title', 'Order #{{ $order->order_id }} — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Orders</span>
            <h1 class="pa-page-title">Order #{{ $order->order_id }}</h1>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="pa-action-link">
            ← Back to Orders
        </a>
    </div>

    {{-- Pre-compute total once so it's consistent everywhere --}}
    @php
        $orderTotal = $order->orderDetails->sum(fn($d) => $d->quantity * ($d->product->selling_price ?? 0));
    @endphp

    <div class="pa-section">
        <div style="display:grid; grid-template-columns:1fr 380px; gap:2rem; align-items:start;">

            {{-- ══ LEFT COLUMN ══ --}}
            <div style="display:flex; flex-direction:column; gap:2rem;">

                {{-- ── Order Items Table ── --}}
                <div>
                    <p class="pa-section-title" style="color:var(--gold); margin-bottom:1.5rem;">Order Items</p>

                    <div class="pa-table-shell">
                        <table class="pa-products-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                    @php
                                        $unitPrice = $detail->product->selling_price ?? 0;
                                        $subtotal  = $detail->quantity * $unitPrice;
                                    @endphp
                                    <tr>
                                        {{-- Product --}}
                                        <td>
                                            <div class="pa-product-cell">
                                                @php $thumb = $detail->product->productImages->first(); @endphp
                                                @if($thumb)
                                                    <img src="{{ asset('storage/' . $thumb->image_path) }}"
                                                         alt="{{ $detail->product->product_name }}"
                                                         class="pa-product-thumb">
                                                @else
                                                    <div class="pa-product-thumb--empty"><span>N/A</span></div>
                                                @endif
                                                <span class="pa-product-name">{{ $detail->product->product_name }}</span>
                                            </div>
                                        </td>

                                        {{-- Quantity --}}
                                        <td>
                                            <span class="pa-stock">{{ $detail->quantity }}</span>
                                        </td>

                                        {{-- Unit Price — from product selling_price --}}
                                        <td>
                                            <span class="pa-price pa-price--cost">
                                                ₱{{ number_format($unitPrice, 2) }}
                                            </span>
                                        </td>

                                        {{-- Subtotal --}}
                                        <td>
                                            <span class="pa-price pa-price--sell">
                                                ₱{{ number_format($subtotal, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Order total row --}}
                    <div style="border:1px solid #E2DDD5; border-top:none; background:#F5F1EC; padding:1rem 1.4rem; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:0.57rem; letter-spacing:0.28em; text-transform:uppercase; color:#9A9088; font-family:'Jost',sans-serif; font-weight:400;">
                            Order Total
                        </span>
                        <span style="font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:300; color:#1A1714; letter-spacing:0.02em;">
                            ₱{{ number_format($orderTotal, 2) }}
                        </span>
                    </div>
                </div>

                {{-- ── Update Status ── --}}
                <div>
                    <p class="pa-section-title" style="color:var(--gold); margin-bottom:1.5rem;">Update Status</p>

                    <div style="background:#FDFBF8; border:1px solid #E2DDD5; padding:1.8rem;">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}"
                              style="display:flex; align-items:flex-end; gap:1rem; flex-wrap:wrap;">
                            @csrf
                            @method('PATCH')

                            <div style="display:flex; flex-direction:column; gap:0.5rem; flex:1; min-width:180px;">
                                <label for="status" class="pa-auth-label">New Status</label>
                                <select name="status" id="status" required class="pa-select" style="font-size:0.88rem; padding:0.7rem 2rem 0.7rem 0.9rem;">
                                    <option value="pending"    {{ strtolower($order->order_status) === 'pending'    ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ strtolower($order->order_status) === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed"  {{ strtolower($order->order_status) === 'completed'  ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled"  {{ strtolower($order->order_status) === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            <button type="submit" class="pa-btn-primary" style="padding:0.72rem 2rem;">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- ══ RIGHT COLUMN: Order Details ══ --}}
            <div style="position:sticky; top:80px; display:flex; flex-direction:column; gap:0;">

                <p class="pa-section-title" style="color:var(--gold); margin-bottom:1.5rem;">Order Details</p>

                <div style="background:#FDFBF8; border:1px solid #E2DDD5; padding:1.8rem; display:flex; flex-direction:column; gap:1.4rem;">

                    {{-- Status badge --}}
                    <div>
                        <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.4rem;">Status</span>
                        @php
                            $status = strtolower($order->order_status);
                            $statusCls = match($status) {
                                'completed'  => 'pa-status pa-status--success',
                                'processing' => 'pa-status',
                                'cancelled'  => 'pa-status pa-status--danger',
                                default      => 'pa-status',
                            };
                            $statusStyle = match($status) {
                                'processing' => 'background:#EEF2F8; color:#3A5580; border:1px solid rgba(58,85,128,0.15);',
                                'pending'    => 'background:#FEF3CD; color:#856404; border:1px solid rgba(133,100,4,0.15);',
                                default      => '',
                            };
                        @endphp
                        <span class="{{ $statusCls }}" style="{{ $statusStyle }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>

                    <div style="height:1px; background:#EEEBE4;"></div>

                    {{-- Customer --}}
                    <div>
                        <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.35rem;">Customer</span>
                        <span class="u-name" style="display:block;">{{ $order->user->full_name }}</span>
                        <span class="u-email" style="text-decoration:none; border:none;">{{ $order->user->email }}</span>
                    </div>

                    {{-- Date --}}
                    <div>
                        <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.35rem;">Order Date</span>
                        <span class="u-name" style="display:block; font-weight:300;">{{ $order->order_date->format('M d, Y') }}</span>
                        <span style="font-size:0.75rem; color:#9A9088; font-family:'Jost',sans-serif; font-weight:300;">{{ $order->order_date->format('h:i A') }}</span>
                    </div>

                    {{-- Payment --}}
                    <div>
                        <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.35rem;">Payment Method</span>
                        <span class="u-name" style="font-weight:300;">{{ strtoupper($order->payment_method) }}</span>
                    </div>

                    @if($order->payment_reference)
                        <div>
                            <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.35rem;">Payment Reference</span>
                            <span style="font-size:0.82rem; color:#1A1714; font-family:'Courier New',monospace; background:#F0EDE8; padding:0.25rem 0.6rem; display:inline-block;">
                                {{ $order->payment_reference }}
                            </span>
                        </div>
                    @endif

                    {{-- Delivery Address --}}
                    <div>
                        <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.35rem;">Delivery Address</span>
                        <span style="font-size:0.88rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:300; line-height:1.6;">{{ $order->delivery_address }}</span>
                    </div>

                    @if($order->date_received)
                        <div>
                            <span class="pa-stat-tile__label" style="display:block; margin-bottom:0.35rem;">Date Received</span>
                            <span style="font-size:0.88rem; color:#4A6741; font-family:'Jost',sans-serif; font-weight:400;">
                                {{ $order->date_received->format('M d, Y') }}
                            </span>
                        </div>
                    @endif

                </div>

                {{-- Total card --}}
                <div style="background:#1A1714; padding:1.5rem 1.8rem; display:flex; justify-content:space-between; align-items:center; border:1px solid #1A1714; border-top:none;">
                    <span style="font-size:0.57rem; letter-spacing:0.28em; text-transform:uppercase; color:rgba(200,190,178,0.5); font-family:'Jost',sans-serif; font-weight:300;">
                        Order Total
                    </span>
                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.6rem; font-weight:300; color:#B5975A; letter-spacing:0.02em;">
                        ₱{{ number_format($orderTotal, 2) }}
                    </span>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection