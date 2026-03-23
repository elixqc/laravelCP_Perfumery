<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Order $order,
        public string $previousStatus
    ) {
    }

    public function envelope(): Envelope
    {
        $subject = match ($this->order->order_status) {
            'processing' => 'Your Order is Being Processed — Prestige Perfumery',
            'completed' => 'Your Order Has Been Delivered — Prestige Perfumery',
            'cancelled' => 'Your Order Has Been Cancelled — Prestige Perfumery',
            default => 'Order Update — Prestige Perfumery',
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-status');
    }

    public function attachments(): array
    {
        if ($this->order->order_status !== 'completed') {
            return [];
        }

        // Ensure product relation is loaded so selling_price is available
        $this->order->loadMissing('orderDetails.product', 'user');

        $pdf = Pdf::loadView('emails.receipt', ['order' => $this->order])
            ->setPaper('a4', 'portrait');

        return [
            \Illuminate\Mail\Attachment::fromData(
                fn () => $pdf->output(),
                "receipt-order-{$this->order->order_id}.pdf"
            )->withMime('application/pdf'),
        ];
    }
}
