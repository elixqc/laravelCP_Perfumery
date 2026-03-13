<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update</title>
</head>
<body style="margin:0; padding:0; background-color:#F8F5F0; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-weight:300; color:#2C2825;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F8F5F0; padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; width:100%;">

                {{-- ── HEADER ── --}}
                <tr>
                    <td align="center" style="background-color:#1A1714; padding:36px 40px 28px;">

                        {{-- Gold rule --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:14px;">
                            <tr>
                                <td style="height:1px; background:linear-gradient(to right, transparent, #B5975A, transparent);"></td>
                            </tr>
                        </table>

                        <p style="margin:0 0 6px; font-size:9px; letter-spacing:4px; text-transform:uppercase; color:#B5975A; font-weight:300;">Maison de Parfum</p>
                        <h1 style="margin:0; font-family:Georgia, 'Times New Roman', serif; font-size:22px; font-weight:300; letter-spacing:6px; color:#F8F5F0; text-transform:uppercase;">PRESTIGE PERFUMERY</h1>

                        {{-- Gold rule --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:14px;">
                            <tr>
                                <td style="height:1px; background:linear-gradient(to right, transparent, #B5975A, transparent);"></td>
                            </tr>
                        </table>

                    </td>
                </tr>

                {{-- ── STATUS BANNER ── --}}
                @php
                    $status = $order->order_status;
                    $bannerBg = match($status) {
                        'processing' => '#EEF2F8',
                        'completed'  => '#F0F5EE',
                        'cancelled'  => '#F8EEEE',
                        default      => '#FEF3CD',
                    };
                    $bannerColor = match($status) {
                        'processing' => '#3A5580',
                        'completed'  => '#4A6741',
                        'cancelled'  => '#8B3A3A',
                        default      => '#856404',
                    };
                    $statusLabel = match($status) {
                        'processing' => 'Order Processing',
                        'completed'  => 'Order Delivered',
                        'cancelled'  => 'Order Cancelled',
                        default      => 'Order Pending',
                    };
                    $statusMessage = match($status) {
                        'processing' => 'Great news — your order is being carefully prepared and will be on its way soon.',
                        'completed'  => 'Your order has been delivered. We hope you love your new fragrance.',
                        'cancelled'  => 'Your order has been cancelled. If you have any questions, please contact us.',
                        default      => 'Your order has been received and is awaiting processing.',
                    };
                @endphp

                <tr>
                    <td style="background-color:{{ $bannerBg }}; padding:24px 40px; text-align:center; border-left:3px solid {{ $bannerColor }};">
                        <p style="margin:0 0 4px; font-size:9px; letter-spacing:3px; text-transform:uppercase; color:{{ $bannerColor }}; font-weight:400;">{{ $statusLabel }}</p>
                        <p style="margin:0; font-size:13px; color:{{ $bannerColor }}; line-height:1.6; font-weight:300;">{{ $statusMessage }}</p>
                    </td>
                </tr>

                {{-- ── BODY ── --}}
                <tr>
                    <td style="background-color:#FDFBF8; padding:36px 40px; border:1px solid #EDE8DF; border-top:none;">

                        {{-- Greeting --}}
                        <p style="margin:0 0 20px; font-size:15px; color:#2C2825; line-height:1.7; font-weight:300;">
                            Dear {{ $order->user->full_name }},
                        </p>
                        <p style="margin:0 0 28px; font-size:14px; color:#5A524A; line-height:1.8; font-weight:300;">
                            Your order <strong style="color:#1A1714; font-weight:400;">#{{ $order->order_id }}</strong>
                            status has been updated from
                            <span style="text-transform:capitalize; color:#8C8078;">{{ $previousStatus }}</span>
                            to
                            <span style="text-transform:capitalize; color:{{ $bannerColor }}; font-weight:400;">{{ $order->order_status }}</span>.
                        </p>

                        {{-- Divider --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                            <tr><td style="height:1px; background-color:#EDE8DF;"></td></tr>
                        </table>

                        {{-- Order Summary --}}
                        <p style="margin:0 0 16px; font-size:9px; letter-spacing:3px; text-transform:uppercase; color:#C8BEB2; font-weight:300;">Order Summary</p>

                        {{-- Order Items --}}
                        @foreach($order->orderDetails as $detail)
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:10px;">
                            <tr>
                                <td style="font-size:13px; color:#2C2825; font-weight:300; padding:10px 0; border-bottom:1px solid #F0ECE7;">
                                    {{ $detail->product->product_name ?? 'Product' }}
                                    <span style="color:#C8BEB2; font-size:12px;"> × {{ $detail->quantity }}</span>
                                </td>
                                <td align="right" style="font-size:13px; color:#1A1714; font-family:Georgia, serif; font-weight:300; padding:10px 0; border-bottom:1px solid #F0ECE7; white-space:nowrap;">
                                    ₱{{ number_format($detail->unit_price * $detail->quantity, 2) }}
                                </td>
                            </tr>
                        </table>
                        @endforeach

                        {{-- Total --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:16px; margin-bottom:28px;">
                            <tr>
                                <td style="font-size:11px; letter-spacing:2px; text-transform:uppercase; color:#8C8078; font-weight:300; padding:12px 0; border-top:1px solid #2C2825;">
                                    Total Amount
                                </td>
                                <td align="right" style="font-family:Georgia, serif; font-size:20px; font-weight:300; color:#B5975A; padding:12px 0; border-top:1px solid #2C2825; white-space:nowrap;">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>
                            </tr>
                        </table>

                        {{-- Order Meta --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#F8F5F0; padding:20px; margin-bottom:28px;">
                            <tr>
                                <td style="font-size:9px; letter-spacing:2px; text-transform:uppercase; color:#C8BEB2; font-weight:300; padding-bottom:6px;">Order Date</td>
                                <td align="right" style="font-size:13px; color:#5A524A; font-weight:300;">{{ $order->order_date->format('F d, Y') }}</td>
                            </tr>
                            <tr>
                                <td style="font-size:9px; letter-spacing:2px; text-transform:uppercase; color:#C8BEB2; font-weight:300; padding-top:10px; padding-bottom:6px;">Delivery Address</td>
                                <td align="right" style="font-size:13px; color:#5A524A; font-weight:300; padding-top:10px;">{{ $order->delivery_address }}</td>
                            </tr>
                            <tr>
                                <td style="font-size:9px; letter-spacing:2px; text-transform:uppercase; color:#C8BEB2; font-weight:300; padding-top:10px;">Payment</td>
                                <td align="right" style="font-size:13px; color:#5A524A; font-weight:300; padding-top:10px; text-transform:capitalize;">{{ $order->payment_method }}</td>
                            </tr>
                        </table>

                        {{-- CTA --}}
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                            <tr>
                                <td align="center">
                                    <a href="{{ url('/orders/' . $order->order_id) }}"
                                       style="display:inline-block; background-color:#1A1714; color:#F8F5F0; text-decoration:none; font-size:9px; letter-spacing:3px; text-transform:uppercase; font-weight:300; padding:14px 36px; border:1px solid #1A1714;">
                                        View Order Details
                                    </a>
                                </td>
                            </tr>
                        </table>

                        <p style="margin:0; font-size:13px; color:#8C8078; line-height:1.8; font-weight:300;">
                            If you have any questions about your order, please don't hesitate to reach out to us.
                            We're here to help.
                        </p>

                    </td>
                </tr>

                {{-- ── FOOTER ── --}}
                <tr>
                    <td align="center" style="background-color:#1A1714; padding:24px 40px;">
                        <p style="margin:0 0 6px; font-family:Georgia, serif; font-size:12px; letter-spacing:4px; text-transform:uppercase; color:#F8F5F0; font-weight:300;">PRESTIGE PERFUMERY</p>
                        <p style="margin:0 0 12px; font-size:9px; letter-spacing:2px; text-transform:uppercase; color:#B5975A; font-weight:300;">Maison de Parfum</p>
                        <p style="margin:0; font-size:10px; color:#5A524A; letter-spacing:1px; font-weight:300;">
                            &copy; {{ date('Y') }} Prestige Perfumery &nbsp;&middot;&nbsp; All rights reserved
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>