<div class="table-wrapper">

    <div class="orders-filters">

        <div class="orders-filters-title">
            Filtrer les commandes

            <div class="orders-filters-bottom">
                <select wire:change="setYear($event.target.value)" class="orders-select">
                    @foreach(range(date('Y'), date('Y') - 4) as $y)
                        <option value="{{ $y }}" @selected($year == $y)>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="orders-months">
            @foreach(range(1,12) as $m)
                @php
                    $label = \Carbon\Carbon::create()->month($m)->locale('fr')->translatedFormat('F');
                @endphp

                <button
                    type="button"
                    wire:click="setMonth({{ $m }})"
                    class="orders-month-item {{ $month == $m ? 'active' : '' }}"
                    data-month="{{ $m }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- TABLE --}}
    <div class="hidden sm:block overflow-x-auto">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Articles</th>
                    <th>Date</th>
                    <th>Fournisseur</th>
                    <th>Créateur</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition line">
                        <td>{{ $order->id }}</td>
                        <td>Commande</td>
                        <td>{{ $order->lines_count }}</td>
                        <td>{{ carbon($order->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $order->provider?->name }}</td>
                        <td>{{ $order->user?->name }}</td>

                        <td class="text-right">
                            <a href="{{ route('orders.products', $order) }}">
                                <i class="fa-solid fa-table-cells-large"></i>
                            </a>

                            <a href="{{ route('orders.delete', $order) }}" class="confirm-delete">
                                <i class="fa-regular fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE --}}
    <div class="block sm:hidden">
        <div class="space-y-3">
            @foreach($orders as $order)
                @include(Auth::user()->isProvider() ? 'order.provider-card' : 'order.card', ['order' => $order])
            @endforeach
        </div>
    </div>

</div>


<script>
function centerMonth(month = null) {
    const container = document.querySelector('.orders-months');

    const button = month
        ? document.querySelector(`[data-month="${month}"]`)
        : document.querySelector('.orders-month-item.active');

    if (!container || !button) return;

    container.scrollTo({
        left: button.offsetLeft - (container.offsetWidth / 2) + (button.offsetWidth / 2),
        behavior: 'smooth'
    });
}

// Arrivée sur la page via wire:navigate
document.addEventListener('livewire:navigated', () => {
    setTimeout(() => centerMonth(), 100);
});

// Après un update Livewire (clic sur un mois)
document.addEventListener('livewire:init', () => {
    Livewire.on('scroll-month', ({ month }) => {
        centerMonth(month);
    });
});
</script>