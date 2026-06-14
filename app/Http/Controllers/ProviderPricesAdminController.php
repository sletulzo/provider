<?php

namespace App\Http\Controllers;

use App\Mail\ProviderPricesLinkMail;
use App\Models\Provider;
use App\Services\TenantMailer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProviderPricesAdminController extends Controller
{
    public function sendLink(Provider $provider): RedirectResponse
    {
        if (! $provider->email) {
            return Redirect::route('providers')->with('error', 'Ajoutez une adresse e-mail au fournisseur avant d\'envoyer le lien.');
        }

        $provider->load('tenant');

        try {
            TenantMailer::send(
                $provider->tenant,
                $provider->email,
                new ProviderPricesLinkMail($provider)
            );
        } catch (\Exception $e) {
            return Redirect::route('providers')->with('error', 'Erreur lors de l\'envoi : '.$e->getMessage());
        }

        return Redirect::route('providers')->with('success', 'Lien de mise à jour des tarifs envoyé au fournisseur.');
    }
}
