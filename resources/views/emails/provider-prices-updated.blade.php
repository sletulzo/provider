@component('mail::message')

# Tarifs mis à jour

Le fournisseur **{{ $provider->name }}** a mis à jour ses tarifs pour **{{ $tenantName }}**.

@foreach ($changes as $change)
- **{{ $change['name'] }}** :
@if ($change['old'])
  {{ number_format($change['old'] / 100, 2, ',', ' ') }} € → {{ number_format($change['new'] / 100, 2, ',', ' ') }} €
@else
  (non renseigné) → {{ number_format($change['new'] / 100, 2, ',', ' ') }} €
@endif
@endforeach

@if ($provider->prices_updated_at)
*Dernière mise à jour : {{ $provider->prices_updated_at->format('d/m/Y à H:i') }}*
@endif

@endcomponent
