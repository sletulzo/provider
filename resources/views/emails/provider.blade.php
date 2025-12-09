@component('mail::message')

# {{ $subject }}

{!! $content !!}

@component('mail::button', ['url' => $url ?? '#'])
    Cliquer pour accepter la commande
@endcomponent

Généré par <b>{{ config('app.name') }}</b>, le logiciel de commande fournisseur.
@endcomponent