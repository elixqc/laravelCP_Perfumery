@extends('layouts.admin')

@section('title', 'Orders — Prestige Admin')

@section('content')
<div class="pa-page">

    {{-- ── Page Header ── --}}
    <div class="pa-page-header">
        <div>
            <span class="pa-page-eyebrow">Orders</span>
            <h1 class="pa-page-title">Orders</h1>
        </div>
    </div>

    <div class="pa-section">

        {{-- ── Stats Bar ── --}}
        <div style="display:flex; gap:1px; background:#D6D0C8; border:1px solid #D6D0C8; margin-bottom:2rem;">
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Total Orders</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#1A1714; line-height:1;">{{ $orders->total() }}</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Pending</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#856404; line-height:1;">{{ $orders->where('order_status', 'pending')->count() }}</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Processing</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#3A5580; line-height:1;">{{ $orders->where('order_status', 'processing')->count() }}</span>
            </div>
            <div style="background:#FDFBF8; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Completed</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#4A6741; line-height:1;">{{ $orders->where('order_status', 'completed')->count() }}</span>
            </div>
            <div style="background:#1A1714; padding:1.2rem 1.8rem; flex:1;">
                <span style="font-size:0.68rem; letter-spacing:0.18em; text-transform:uppercase; color:rgba(200,190,178,0.6); font-family:'Jost',sans-serif; font-weight:300; display:block; margin-bottom:0.3rem;">Cancelled</span>
                <span style="font-family:'Cormorant Garamond',serif; font-size:2rem; font-weight:300; color:#B5975A; line-height:1;">{{ $orders->where('order_status', 'cancelled')->count() }}</span>
            </div>
        </div>

        {{-- ── Table ── --}}
        <div style="border:1px solid #D6D0C8; overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; background:#FDFBF8;">

                <thead>
                    <tr style="border-bottom:2px solid #D6D0C8; background:#F5F1EC;">
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Order ID</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Customer</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Date</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Items</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Total</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Status</th>
                        <th style="font-size:0.68rem; letter-spacing:0.2em; text-transform:uppercase; color:#8C8078; font-family:'Jost',sans-serif; font-weight:400; padding:1rem 1.2rem; text-align:left; white-space:nowrap;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        @php
                            $status = strtolower($order->order_status);
                            $statusStyles = match($status) {
                                'completed'  => ['bg' => '#F0F5EE', 'color' => '#4A6741'],
                                'processing' => ['bg' => '#EEF2F8', 'color' => '#3A5580'],
                                'cancelled'  => ['bg' => '#F8EEEE', 'color' => '#8B3A3A'],
                                default      => ['bg' => '#FEF3CD', 'color' => '#856404'], // pending
                            };
                        @endphp

                        <tr style="border-bottom:1px solid #EDE8DF; transition:background 0.15s;"
                            onmouseover="this.style.background='#F5F1EC'"
                            onmouseout="this.style.background='transparent'">

                            {{-- Order ID --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1rem; font-weight:300; color:#B5975A; letter-spacing:0.04em;">
                                    #{{ $order->order_id }}
                                </span>
                            </td>

                            {{-- Customer --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-size:0.92rem; color:#1A1714; font-family:'Jost',sans-serif; font-weight:400; display:block;">
                                    {{ $order->user->full_name }}
                                </span>
                                @if($order->user->email)
                                    <span style="font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">
                                        {{ $order->user->email }}
                                    </span>
                                @endif
                            </td>

                            {{-- Date --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400; display:block;">
                                    {{ $order->order_date->format('M d, Y') }}
                                </span>
                                <span style="font-size:0.72rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300;">
                                    {{ $order->order_date->format('h:i A') }}
                                </span>
                            </td>

                            {{-- Items count --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-size:0.88rem; color:#5A524A; font-family:'Jost',sans-serif; font-weight:400;">
                                    {{ $order->orderDetails->count() }}
                                    {{ Str::plural('item', $order->orderDetails->count()) }}
                                </span>
                            </td>

                            {{-- Total --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1.1rem; font-weight:300; color:#1A1714; letter-spacing:0.02em;">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </span>
                            </td>

                            {{-- Status badge --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <span style="display:inline-block; font-size:0.68rem; letter-spacing:0.15em; text-transform:uppercase; font-family:'Jost',sans-serif; font-weight:400; padding:0.28rem 0.75rem; border-radius:2px; background:{{ $statusStyles['bg'] }}; color:{{ $statusStyles['color'] }};">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td style="padding:1rem 1.2rem; vertical-align:middle;">
                                <a href="{{ route('admin.orders.show', $order->order_id) }}"
                                   style="font-family:'Jost',sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:0.08em; color:#2C2825; text-decoration:none; border-bottom:1px solid transparent; padding-bottom:1px; transition:color 0.2s, border-color 0.2s;"
                                   onmouseover="this.style.color='#B5975A'; this.style.borderBottomColor='#B5975A'"
                                   onmouseout="this.style.color='#2C2825'; this.style.borderBottomColor='transparent'">
                                    View →
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:4rem 1.2rem; text-align:center;">
                                <span style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:#C8BEB2; font-style:italic; display:block; margin-bottom:0.5rem;">
                                    No orders yet
                                </span>
                                <span style="font-size:0.78rem; color:#8C8078; font-family:'Jost',sans-serif; font-weight:300; letter-spacing:0.08em;">
                                    Orders will appear here once customers start purchasing
                                </span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- ── Pagination ── --}}
        @if($orders->hasPages())
            <div class="pp-pagination" style="margin-top:2rem;">
                {{ $orders->links() }}
            </div>
        @endif

    </div>
</div>
@endsection