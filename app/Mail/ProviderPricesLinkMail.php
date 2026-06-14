<?php

namespace App\Mail;

use App\Models\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProviderPricesLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $url;

    public function __construct(public Provider $provider)
    {
        $this->url = $provider->generatePricesUrl();
    }

    public function build()
    {
        $this->provider->loadMissing('tenant');

        return $this->subject('Mise à jour de vos tarifs — '.$this->provider->tenant?->name)
            ->markdown('emails.provider-prices-link')
            ->with([
                'provider' => $this->provider,
                'url' => $this->url,
                'tenantName' => $this->provider->tenant?->name,
            ]);
    }
}
