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
        $this->order->loadMissing(['lines.product', 'lines.unity', 'provider', 'user', 'tenant']);

        return $this->subject($this->data['subject'])
            ->view('emails.provider')
            ->with([
                'subject' => $this->data['subject'],
                'content' => $this->data['content'] ?? '',
                'footer'  => $this->data['footer'] ?? '',
                'url'     => $this->url,
                'order'   => $this->order,
            ]);
    }
}
