<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProviderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;
    public Order $order;
    public string $url;
    public Tenant $tenant;

    /**
     * Create a new message instance.
     */
    public function __construct($data, Order $order)
    {
        $this->data = $data;
        $this->order = $order;
        $this->url = $order->generateUrl();
    }

    /**
     * Build email
     */
    public function build()
    {
        return $this->subject($this->data['subject'])
            ->markdown('emails.provider')
            ->with([
                'subject' => $this->data['subject'],
                'content' => nl2br($this->data['content']),
                'url' => $this->url
            ]);
    }
}
