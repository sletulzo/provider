@component('mail::message')

# Mise à jour de vos tarifs

Bonjour **{{ $provider->name }}**,

{{ $tenantName }} vous invite à renseigner ou mettre à jour les tarifs de votre catalogue produits.

Le lien est valable **30 jours**.

@component('mail::button', ['url' => $url])
    Mettre à jour mes tarifs
@endcomponent

Vous pouvez laisser un champ vide si le prix d'un produit n'est pas encore défini.

Généré par **{{ config('app.name') }}**.
@endcomponent
