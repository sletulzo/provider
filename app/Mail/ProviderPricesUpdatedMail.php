<?php

namespace App\Mail;

use App\Models\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProviderPricesUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Provider $provider,
        public array $changes
    ) {}

    public function build()
    {
        $this->provider->loadMissing('tenant');

        return $this->subject('Tarifs mis à jour — '.$this->provider->name)
            ->markdown('emails.provider-prices-updated')
            ->with([
                'provider' => $this->provider,
                'changes' => $this->changes,
                'tenantName' => $this->provider->tenant?->name,
            ]);
    }
}
