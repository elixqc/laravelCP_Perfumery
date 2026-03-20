<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt #{{ $order->order_id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-weight: 300;
            font-size: 12px;
            color: #2C2825;
            background: #FFFFFF;
            padding: 40px;
        }

        /* ── Header ── */
        .header {
            text-align: center;
            border-bottom: 1px solid #EDE8DF;
            padding-bottom: 24px;
            margin-bottom: 28px;
        }

        .header-rule {
            height: 1px;
            background: #B5975A;
            width: 80px;
            margin: 0 auto 10px;
        }

        .brand-eyebrow {
            font-size: 7px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #B5975A;
            margin-bottom: 5px;
        }

        .brand-name {
            font-size: 18px;
            letter-spacing: 6px;
            text-transform: uppercase;
            color: #1A1714;
            font-weight: 300;
            margin-bottom: 4px;
        }

        .brand-tag {
            font-size: 7px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #C8BEB2;
        }

        /* ── Receipt Title ── */
        .receipt-title {
            text-align: center;
            margin-bottom: 28px;
        }

        .receipt-title h2 {
            font-size: 9px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #8C8078;
            font-weight: 300;
            margin-bottom: 4px;
        }

        .receipt-number {
            font-size: 22px;
            font-weight: 300;
            color: #B5975A;
            letter-spacing: 2px;
        }

        /* ── Meta grid ── */
        .meta-grid {
            display: table;
            width: 100%;
            margin-bottom: 28px;
            border: 1px solid #EDE8DF;
        }

        .meta-col {
            display: table-cell;
            width: 50%;
            padding: 14px 16px;
            vertical-align: top;
        }

        .meta-col + .meta-col {
            border-left: 1px solid #EDE8DF;
        }

        .meta-label {
            font-size: 7px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #C8BEB2;
            margin-bottom: 4px;
        }

        .meta-value {
            font-size: 11px;
            color: #1A1714;
            line-height: 1.5;
        }

        /* ── Status badge ── */
        .status-badge {
            display: inline-block;
            font-size: 7px;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 3px 8px;
            background: #F0F5EE;
            color: #4A6741;
        }

        /* ── Items table ── */
        .items-section {
            margin-bottom: 24px;
        }

        .section-label {
            font-size: 7px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #C8BEB2;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #EDE8DF;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
        }

        table.items th {
            font-size: 7px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8C8078;
            font-weight: 400;
            padding: 8px 10px;
            text-align: left;
            background: #F8F5F0;
            border-bottom: 1px solid #EDE8DF;
        }

        table.items th:last-child { text-align: right; }

        table.items td {
            padding: 10px 10px;
            font-size: 11px;
            color: #2C2825;
            border-bottom: 1px solid #F5F1EC;
            vertical-align: middle;
        }

        table.items td:last-child {
            text-align: right;
            color: #1A1714;
        }

        table.items .product-name {
            font-size: 11px;
            color: #1A1714;
        }

        table.items .product-variant {
            font-size: 9px;
            color: #8C8078;
            margin-top: 2px;
        }

        /* ── Totals ── */
        .totals {
            margin-left: auto;
            width: 240px;
            margin-bottom: 28px;
        }

        .totals-row {
            display: table;
            width: 100%;
            padding: 6px 0;
            border-bottom: 1px solid #F5F1EC;
        }

        .totals-label {
            display: table-cell;
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #8C8078;
        }

        .totals-value {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            color: #1A1714;
        }

        .totals-final {
            display: table;
            width: 100%;
            padding: 10px 0 6px;
            border-top: 1px solid #2C2825;
            margin-top: 4px;
        }

        .totals-final .totals-label {
            font-size: 9px;
            letter-spacing: 2px;
            color: #1A1714;
        }

        .totals-final .totals-value {
            font-size: 18px;
            color: #B5975A;
            font-weight: 300;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            border-top: 1px solid #EDE8DF;
            padding-top: 20px;
            margin-top: 28px;
        }

        .footer p {
            font-size: 8px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #C8BEB2;
            line-height: 1.8;
        }

        .footer .thank-you {
            font-size: 11px;
            color: #8C8078;
            letter-spacing: 1px;
            margin-bottom: 6px;
            font-style: italic;
        }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-rule"></div>
        <p class="brand-eyebrow">Maison de Parfum</p>
        <h1 class="brand-name">Prestige Perfumery</h1>
        <p class="brand-tag">Official Receipt</p>
    </div>

    {{-- ── Receipt Title ── --}}
    <div class="receipt-title">
        <h2>Order Receipt</h2>
        <div class="receipt-number">#{{ $order->order_id }}</div>
    </div>

    {{-- ── Meta ── --}}
    <div class="meta-grid">
        <div class="meta-col">
            <p class="meta-label">Billed To</p>
            <p class="meta-value">
                {{ $order->user->full_name }}<br>
                {{ $order->user->email }}<br>
                @if($order->user->contact_number)
                    {{ $order->user->contact_number }}
                @endif
            </p>
        </div>
        <div class="meta-col">
            <p class="meta-label">Order Details</p>
            <p class="meta-value">
                Date: {{ $order->order_date->format('F d, Y') }}<br>
                Payment: {{ ucfirst($order->payment_method) }}<br>
                Status: <span class="status-badge">Completed</span>
            </p>
        </div>
    </div>

    {{-- ── Items ── --}}
    <div class="items-section">
        <p class="section-label">Items Ordered</p>
        <table class="items">
            <thead>
                <tr>
                    <th style="width:50%;">Product</th>
                    <th style="width:15%; text-align:center;">Qty</th>
                    <th style="width:17.5%; text-align:right;">Unit Price</th>
                    <th style="width:17.5%; text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderDetails as $detail)
                <tr>
                    <td>
                        <div class="product-name">{{ $detail->product->product_name ?? 'Product' }}</div>
                        @if($detail->product->variant)
                            <div class="product-variant">{{ $detail->product->variant }}</div>
                        @endif
                    </td>
                    <td style="text-align:center; color:#8C8078;">{{ $detail->quantity }}</td>
                    <td style="text-align:right;">PHP {{ number_format($detail->unit_price, 2) }}</td>
                    <td style="text-align:right; font-weight:400;">PHP {{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ── Totals ── --}}
    <div class="totals">
        <div class="totals-row">
            <span class="totals-label">Subtotal</span>
            <span class="totals-value">PHP {{ number_format($order->calculated_total, 2) }}</span>
        </div>
        <div class="totals-row">
            <span class="totals-label">Shipping</span>
            <span class="totals-value">Free</span>
        </div>
        <div class="totals-final">
            <span class="totals-label">Total Paid</span>
            <span class="totals-value">PHP {{ number_format($order->calculated_total, 2) }}</span>
        </div>
    </div>

    {{-- ── Delivery Address ── --}}
    @if($order->delivery_address)
    <div style="margin-bottom:24px; padding:14px 16px; border:1px solid #EDE8DF;">
        <p class="meta-label" style="margin-bottom:4px;">Delivery Address</p>
        <p style="font-size:11px; color:#1A1714; line-height:1.6;">{{ $order->delivery_address }}</p>
    </div>
    @endif

    {{-- ── Footer ── --}}
    <div class="footer">
        <p class="thank-you">Thank you for your purchase</p>
        <p>Prestige Perfumery &nbsp;&middot;&nbsp; Maison de Parfum</p>
        <p>&copy; {{ date('Y') }} All rights reserved &nbsp;&middot;&nbsp; This is an official receipt</p>
    </div>

</body>
</html>