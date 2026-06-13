<x-app-layout>
    @php
        $acceptedCount = $order->lines->where('status', \App\Models\OrderLine::STATUS_ACCEPTED)->count();
        $missingCount = $order->lines->where('status', \App\Models\OrderLine::STATUS_MISSING)->count();
        $partyLabel = auth()->user()->isProvider() ? 'Client' : 'Fournisseur';
        $partyName = auth()->user()->isProvider()
            ? ($order->user?->name ?? 'Client')
            : ($order->provider?->name ?? '—');
        $hasSplitTotals = $order->isResponded() && $order->getAcceptedTotal() !== $order->getTotal();
    @endphp

    <div class="order-view">
        <div class="order-view__top">
            <a wire:navigate href="{{ route('orders') }}" class="order-view__back" aria-label="Retour aux commandes">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="order-view__head">
                <div class="order-view__head-row">
                    <h1 class="order-view__title">CMD-{{ $order->id }}</h1>
                    <span class="status-badge status-badge--{{ $status['slug'] }} order-view__status">{{ $status['label'] }}</span>
                </div>
                <p class="order-view__meta">
                    {{ carbon($order->created_at)->format('d/m/Y à H:i') }}
                    · {{ $order->lines->count() }} article{{ $order->lines->count() > 1 ? 's' : '' }}
                </p>
            </div>
        </div>

        <div class="order-view__party">
            <x-avatar :name="$partyName" size="lg" />
            <div class="order-view__party-body">
                <span class="order-view__party-label">{{ $partyLabel }}</span>
                <span class="order-view__party-name">{{ $partyName }}</span>
            </div>
            @if ($order->getTotal() > 0 && ! $hasSplitTotals)
                <div class="order-view__party-amount">
                    <span class="order-view__party-amount-label">Total</span>
                    <span class="order-view__party-amount-value">{{ price($order->getTotal(), 2) }} €</span>
                </div>
            @endif
        </div>

        @if ($order->isResponded() && ($acceptedCount > 0 || $missingCount > 0))
            <div class="order-view__summary">
                <div class="order-view__summary-icon"><i class="fa-solid fa-clipboard-check"></i></div>
                <div>
                    <div class="order-view__summary-title">
                        @if ($acceptedCount > 0)
                            <span class="order-view__summary-ok">{{ $acceptedCount }} disponible{{ $acceptedCount > 1 ? 's' : '' }}</span>
                        @endif
                        @if ($missingCount > 0)
                            <span class="order-view__summary-ko">{{ $missingCount }} manquant{{ $missingCount > 1 ? 's' : '' }}</span>
                        @endif
                    </div>
                    <p class="order-view__summary-sub">Réponse le {{ carbon($order->responded_at)->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
        @elseif ($order->isPending())
            <div class="order-view__summary order-view__summary--waiting">
                <div class="order-view__summary-icon"><i class="fa-regular fa-clock"></i></div>
                <div>
                    <div class="order-view__summary-title">En attente de réponse</div>
                    <p class="order-view__summary-sub">Le fournisseur n'a pas encore traité cette commande.</p>
                </div>
            </div>
        @endif

        @if ($order->provider_note)
            <div class="order-view__note">
                <div class="order-view__note-label"><i class="fa-regular fa-comment-dots"></i> Message du fournisseur</div>
                <p>{{ $order->provider_note }}</p>
            </div>
        @endif

        <div class="order-view__section-head">
            <h2 class="order-view__section-title">Articles</h2>
            <span class="order-view__section-count">{{ $order->lines->count() }} produit{{ $order->lines->count() > 1 ? 's' : '' }}</span>
        </div>

        <div class="order-view__lines">
            @foreach ($order->lines as $line)
                @php
                    $lineStatus = $line->getStatus();
                    if ($order->is_accepted && ! $order->isResponded() && $line->status === \App\Models\OrderLine::STATUS_PENDING) {
                        $lineStatus = ['slug' => 'accepted', 'label' => 'Disponible'];
                    }
                    $showLineStatus = $order->isResponded() || $order->is_accepted;
                    $badgeSlug = match ($lineStatus['slug']) {
                        'missing' => 'missing',
                        'accepted' => 'accepted',
                        default => 'waiting',
                    };
                @endphp
                <article @class(['order-view__line', 'order-view__line--' . $lineStatus['slug']])>
                    <div class="order-view__line-icon"><i class="fa-solid fa-cube"></i></div>
                    <div class="order-view__line-body">
                        <div class="order-view__line-name">{{ $line->product?->name }}</div>
                        <div class="order-view__line-meta">
                            {{ $line->quantity }} {{ $line->unity?->name }}
                        </div>
                    </div>
                    <div class="order-view__line-side">
                        @if ($line->product?->price)
                            <div class="order-view__line-price">{{ price($line->getLineTotal(), 2) }} €</div>
                        @endif
                        @if ($showLineStatus)
                            <span class="status-badge status-badge--{{ $badgeSlug }}">{{ $lineStatus['label'] }}</span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

        @if ($order->getTotal() > 0)
            <div class="order-view__totals">
                @if ($hasSplitTotals)
                    <div class="order-view__totals-row">
                        <span>Total commandé</span>
                        <span>{{ price($order->getTotal(), 2) }} €</span>
                    </div>
                    <div class="order-view__totals-row order-view__totals-row--main">
                        <span>Total confirmé</span>
                        <span>{{ price($order->getAcceptedTotal(), 2) }} €</span>
                    </div>
                @else
                    <div class="order-view__totals-row order-view__totals-row--main">
                        <span>Total</span>
                        <span>{{ price($order->getTotal(), 2) }} €</span>
                    </div>
                @endif
            </div>
        @endif

        @if (auth()->user()->isProvider())
            <div class="order-view__footer">
                @if ($order->isPending())
                    <a href="{{ route('provider.orders.respond', $order) }}" class="btn-primary order-view__cta">
                        <i class="fa-solid fa-clipboard-check"></i> Traiter la commande
                    </a>
                @else
                    <a href="{{ route('provider.orders.respond', $order) }}" class="btn-secondary order-view__cta">
                        Voir la réponse envoyée
                    </a>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
