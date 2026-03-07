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
        <a href="{{ route('admin.orders.index') }}"
           style="font-size:0.85rem; letter-spacing:0.05em; text-transform:none; font-family:'Jost',sans-serif; font-weight:400; color:#5A524A; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
           onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
           onmouseout="this.style.color='#5A524A'; this.style.borderBottomColor='transparent'">
            ← Back to Orders
        </a>
    </div>

    <div class="pa-section">
        <div style="display:grid; grid-template-columns:1fr 380px; gap:2rem; align-items:start;">

            {{-- ══ LEFT COLUMN ══ --}}
            <div style="display:flex; flex-direction:column; gap:2rem;">

                {{-- ── Order Items Table ── --}}
                <div>
                    <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                        Order Items
                    </p>

                    <div style="border:1px solid #D6D0C8; overflow-x:auto;">
                        <table style="width:100%; border-collapse:collapse; background:#FDFBF8;">
                            <thead>
                                <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                                    <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:0.9rem 1.2rem; text-align:left; white-space:nowrap;">Product</th>
                                    <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:0.9rem 1.2rem; text-align:left; white-space:nowrap;">Qty</th>
                                    <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:0.9rem 1.2rem; text-align:left; white-space:nowrap;">Unit Price</th>
                                    <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:0.9rem 1.2rem; text-align:left; white-space:nowrap;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                    <tr style="border-bottom:1px solid #EDE8DF; transition:background 0.15s;"
                                        onmouseover="this.style.background='#F5F1EC'"
                                        onmouseout="this.style.background='transparent'">

                                        {{-- Product --}}
                                        <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                            <div style="display:flex; align-items:center; gap:0.85rem;">
                                                @php
                                                    $thumb = $detail->product->productImages->first();
                                                    $thumbUrl = $thumb ? asset('storage/' . $thumb->image_path) : null;
                                                @endphp
                                                @if($thumbUrl)
                                                    <div style="width:42px; height:42px; overflow:hidden; background:#EDE8DF; border:1px solid #D6D0C8; flex-shrink:0;">
                                                        <img src="{{ $thumbUrl }}" alt="{{ $detail->product->product_name }}"
                                                             style="width:100%; height:100%; object-fit:cover; display:block;">
                                                    </div>
                                                @else
                                                    <div style="width:42px; height:42px; background:#EDE8DF; border:1px solid #D6D0C8; flex-shrink:0; display:flex; align-items:center; justify-content:center;">
                                                        <span style="font-size:0.5rem; color:#B0A898; font-family:'Jost',sans-serif;">N/A</span>
                                                    </div>
                                                @endif
                                                <span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400;">
                                                    {{ $detail->product->product_name }}
                                                </span>
                                            </div>
                                        </td>

                                        {{-- Quantity --}}
                                        <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                            <span style="display:inline-block; background:#F0EDE8; color:#2C2825; font-family:'Jost',sans-serif; font-size:0.82rem; font-weight:500; padding:0.2rem 0.65rem; border-radius:2px; min-width:32px; text-align:center;">
                                                {{ $detail->quantity }}
                                            </span>
                                        </td>

                                        {{-- Unit Price --}}
                                        <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                            <span style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400;">
                                                ₱{{ number_format($detail->unit_price, 2) }}
                                            </span>
                                        </td>

                                        {{-- Subtotal --}}
                                        <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                            <span style="font-family:'Cormorant Garamond',serif; font-size:1.05rem; font-weight:300; color:#B5975A; letter-spacing:0.02em;">
                                                ₱{{ number_format($detail->subtotal, 2) }}
                                            </span>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Order total row --}}
                    <div style="border:1px solid #D6D0C8; border-top:none; background:#F5F1EC; padding:1rem 1.2rem; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400;">
                            Order Total
                        </span>
                        <span style="font-family:'Cormorant Garamond',serif; font-size:1.5rem; font-weight:300; color:#1A1714; letter-spacing:0.02em;">
                            ₱{{ number_format($order->calculated_total, 2) }}
                        </span>
                    </div>
                </div>

                {{-- ── Update Status ── --}}
                <div>
                    <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                        Update Status
                    </p>

                    <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:1.8rem;">
                        <form method="POST" action="{{ route('admin.orders.updateStatus', $order->order_id) }}"
                              style="display:flex; align-items:flex-end; gap:1rem; flex-wrap:wrap;">
                            @csrf
                            @method('PATCH')

                            <div style="display:flex; flex-direction:column; gap:0.5rem; flex:1; min-width:180px;">
                                <label for="status" style="font-size:0.8rem; font-weight:500; color:#2C2825; font-family:'Jost',sans-serif;">
                                    New Status
                                </label>
                                <div style="position:relative;">
                                    <select name="status" id="status" required
                                            style="background:#fff; border:1.5px solid #B0A898; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; font-size:0.95rem; padding:0.75rem 2.5rem 0.75rem 1rem; outline:none; width:100%; appearance:none; -webkit-appearance:none; cursor:pointer; transition:border-color 0.2s; border-radius:2px;"
                                            onfocus="this.style.borderColor='#B5975A'"
                                            onblur="this.style.borderColor='#B0A898'">
                                        <option value="pending"    {{ $order->order_status === 'pending'    ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed"  {{ $order->order_status === 'completed'  ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled"  {{ $order->order_status === 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <span style="position:absolute; right:1rem; top:50%; transform:translateY(-50%); color:#8C8078; font-size:0.8rem; pointer-events:none;">▾</span>
                                </div>
                            </div>

                            <button type="submit"
                                    style="background:#2C2825; color:#F8F5F0; border:none; font-family:'Jost',sans-serif; font-size:0.85rem; font-weight:500; letter-spacing:0.08em; text-transform:uppercase; padding:0.78rem 2rem; cursor:pointer; transition:background 0.25s, color 0.25s; border-radius:2px; flex-shrink:0;"
                                    onmouseover="this.style.background='#B5975A'; this.style.color='#1A1714'"
                                    onmouseout="this.style.background='#2C2825'; this.style.color='#F8F5F0'">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- ══ RIGHT COLUMN: Order Details ══ --}}
            <div style="position:sticky; top:80px; display:flex; flex-direction:column; gap:1px;">

                <p style="font-size:0.7rem; letter-spacing:0.2em; text-transform:uppercase; color:var(--gold); font-family:'Jost',sans-serif; font-weight:400; padding-bottom:0.6rem; border-bottom:1px solid var(--cream); margin-bottom:1.5rem;">
                    Order Details
                </p>

                <div style="background:#FDFBF8; border:1px solid #D6D0C8; padding:1.8rem; display:flex; flex-direction:column; gap:1.4rem;">

                    {{-- Current status badge --}}
                    <div>
                        <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.4rem;">Status</span>
                        @php
                            $status = strtolower($order->order_status);
                            $statusStyles = match($status) {
                                'completed'  => ['bg' => '#F0F5EE', 'color' => '#4A6741'],
                                'processing' => ['bg' => '#EEF2F8', 'color' => '#3A5580'],
                                'cancelled'  => ['bg' => '#F8EEEE', 'color' => '#8B3A3A'],
                                default      => ['bg' => '#FEF3CD', 'color' => '#856404'],
                            };
                        @endphp
                        <span style="display:inline-block; font-size:0.72rem; letter-spacing:0.18em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:500; padding:0.35rem 0.85rem; border-radius:2px; background:{{ $statusStyles['bg'] }}; color:{{ $statusStyles['color'] }};">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>

                    <div style="height:1px; background:#EDE8DF;"></div>

                    {{-- Customer --}}
                    <div>
                        <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.35rem;">Customer</span>
                        <span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; display:block;">{{ $order->user->full_name }}</span>
                        <span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">{{ $order->user->email }}</span>
                    </div>

                    {{-- Date --}}
                    <div>
                        <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.35rem;">Order Date</span>
                        <span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400;">
                            {{ $order->order_date->format('M d, Y') }}
                        </span>
                        <span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block;">
                            {{ $order->order_date->format('h:i A') }}
                        </span>
                    </div>

                    {{-- Payment --}}
                    <div>
                        <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.35rem;">Payment Method</span>
                        <span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400;">{{ ucfirst($order->payment_method) }}</span>
                    </div>

                    @if($order->payment_reference)
                        <div>
                            <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.35rem;">Payment Reference</span>
                            <span style="font-size:0.85rem; color:#1A1714; font-family:'Courier New',monospace; background:#F0EDE8; padding:0.25rem 0.6rem; border-radius:2px; display:inline-block;">
                                {{ $order->payment_reference }}
                            </span>
                        </div>
                    @endif

                    {{-- Delivery Address --}}
                    <div>
                        <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.35rem;">Delivery Address</span>
                        <span style="font-size:0.88rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; line-height:1.6;">{{ $order->delivery_address }}</span>
                    </div>

                    @if($order->date_received)
                        <div>
                            <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.35rem;">Date Received</span>
                            <span style="font-size:0.92rem; color:#4A6741; font-family:'Jost',sans-serif; font-weight:400;">
                                {{ $order->date_received->format('M d, Y') }}
                            </span>
                        </div>
                    @endif

                </div>

                {{-- Total card --}}
                <div style="background:#1A1714; border:1px solid #1A1714; padding:1.5rem 1.8rem; display:flex; justify-content:space-between; align-items:center; margin-top:1px;">
                    <span style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300;">
                        Order Total
                    </span>
                    <span style="font-family:'Cormorant Garamond',serif; font-size:1.6rem; font-weight:300; color:#B5975A; letter-spacing:0.02em;">
                        ${{ number_format($order->calculated_total, 2) }}
                    </span>
                </div>

            </div>

        </div>
    </div>

</div>
@endsection