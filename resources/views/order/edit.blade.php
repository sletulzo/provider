<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Détail commande') }}</h2>
    </x-slot>

    @php
        $acceptedCount = $order->lines->where('status', \App\Models\OrderLine::STATUS_ACCEPTED)->count();
        $missingCount = $order->lines->where('status', \App\Models\OrderLine::STATUS_MISSING)->count();
    @endphp

    <div class="order-detail">
        <div class="order-detail-top">
            <div class="flex-between">
                <div class="order-detail-top-number">CMD-{{ $order->id }}</div>
                <div class="order-detail-top-status status-badge status-badge--{{ $status['slug'] }}">{{ $status['label'] }}</div>
            </div>
            <div class="order-detail-provider">{{ $order->provider?->name }}</div>
            <div class="order-detail-date">Passée le {{ carbon($order->created_at)->format('d/m/Y à H:i') }}</div>
            @if ($order->responded_at)
                <div class="order-detail-date">Réponse fournisseur le {{ carbon($order->responded_at)->format('d/m/Y à H:i') }}</div>
            @endif
        </div>

        @if ($order->provider_note)
            <div class="order-detail-note">
                <div class="order-detail-note-label"><i class="fa-regular fa-comment"></i> Message du fournisseur</div>
                <p>{{ $order->provider_note }}</p>
            </div>
        @endif

        @if ($order->isResponded() && ($acceptedCount > 0 || $missingCount > 0))
            <div class="order-detail-summary">
                @if ($acceptedCount > 0)
                    <span class="order-detail-summary-item order-detail-summary-item--ok">
                        <i class="fa-solid fa-check"></i> {{ $acceptedCount }} disponible{{ $acceptedCount > 1 ? 's' : '' }}
                    </span>
                @endif
                @if ($missingCount > 0)
                    <span class="order-detail-summary-item order-detail-summary-item--ko">
                        <i class="fa-solid fa-xmark"></i> {{ $missingCount }} manquant{{ $missingCount > 1 ? 's' : '' }}
                    </span>
                @endif
            </div>
        @endif

        <div class="order-detail-title">Produits commandés</div>

        <div class="order-detail-products">
            @foreach($order->lines as $line)
                @php
                    $lineStatus = $line->getStatus();
                    if ($order->is_accepted && ! $order->isResponded() && $line->status === \App\Models\OrderLine::STATUS_PENDING) {
                        $lineStatus = ['slug' => 'accepted', 'label' => 'Disponible'];
                    }
                @endphp
                <div class="order-detail-products-item order-detail-products-item--{{ $lineStatus['slug'] }}">
                    <div class="order-detail-products-item-icon">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div class="order-detail-products-item-content">
                        <div class="order-detail-products-item-content-left">
                            <div class="order-detail-products-item-content-name">{{ $line->product?->name }}</div>
                            <div class="order-detail-products-item-content-subname">Qté : {{ $line->quantity }} {{ $line->unity?->name }}</div>
                        </div>
                        <div class="order-detail-products-item-content-right">
                            @if ($line->product?->price)
                                {{ price($line->getLineTotal(), 2) }} €
                            @endif
                            @if ($order->isResponded() || $order->is_accepted)
                                <span class="status-badge status-badge--{{ $lineStatus['slug'] === 'missing' ? 'missing' : ($lineStatus['slug'] === 'accepted' ? 'accepted' : 'waiting') }}">
                                    {{ $lineStatus['label'] }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($order->getTotal() > 0)
                <div class="order-detail-products-total">
                    @if ($order->isResponded() && $order->getAcceptedTotal() !== $order->getTotal())
                        <div class="order-detail-products-total-row">
                            <span>Total commandé</span>
                            <span>{{ price($order->getTotal(), 2) }} €</span>
                        </div>
                        <div class="order-detail-products-total-row order-detail-products-total-row--accepted">
                            <span>Total confirmé</span>
                            <span>{{ price($order->getAcceptedTotal(), 2) }} €</span>
                        </div>
                    @else
                        <div class="order-detail-products-total-row">
                            <span>Total</span>
                            <span>{{ price($order->getTotal(), 2) }} €</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        @if (auth()->user()->isProvider())
            @if ($order->isPending())
                <a href="{{ route('provider.orders.respond', $order) }}" class="btn-order btn-primary w-100">
                    <i class="fa-solid fa-clipboard-check"></i> Traiter la commande
                </a>
            @else
                <a href="{{ route('provider.orders.respond', $order) }}" class="btn-order btn-secondary w-100 m-t-10">
                    Voir la réponse envoyée
                </a>
            @endif
        @endif
    </div>
</x-app-layout>
