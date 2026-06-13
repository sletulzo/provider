<div class="orders-list">
    @php
        $periodLabel = \Carbon\Carbon::create($year, $month, 1)->locale('fr')->translatedFormat('F Y');
    @endphp

    <div class="orders-list__filters">
        <div class="orders-list__months">
            @foreach (range(1, 12) as $m)
                @php
                    $label = \Carbon\Carbon::create()->month($m)->locale('fr')->translatedFormat('F');
                @endphp
                <button
                    type="button"
                    wire:click="setMonth({{ $m }})"
                    @class(['orders-list__month', 'orders-list__month--active' => $month == $m])
                    data-month="{{ $m }}"
                >
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="orders-list__year-row">
            <select wire:change="setYear($event.target.value)" class="orders-list__year" aria-label="Année">
                @foreach (range(date('Y'), date('Y') - 4) as $y)
                    <option value="{{ $y }}" @selected($year == $y)>{{ $y }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="orders-list__summary">
        {{ $orders->count() }} commande{{ $orders->count() !== 1 ? 's' : '' }}
        · {{ $periodLabel }}
    </div>

    @if ($orders->isEmpty())
        <x-empty-state
            icon="fa-solid fa-cart-shopping"
            title="Aucune commande"
            description="Aucune commande pour cette période."
            :action="Auth::user()->isCustomer() ? 'Passer une commande' : null"
            :href="Auth::user()->isCustomer() ? route('indents') : null"
        />
    @else
        <div class="orders-list__items">
            @foreach ($orders as $order)
                @include('order.list-item', ['order' => $order])
            @endforeach
        </div>
    @endif
</div>

<script>
function centerOrdersMonth(month = null) {
    const container = document.querySelector('.orders-list__months');
    const button = month
        ? document.querySelector(`.orders-list__month[data-month="${month}"]`)
        : document.querySelector('.orders-list__month--active');

    if (!container || !button) return;

    container.scrollTo({
        left: button.offsetLeft - (container.offsetWidth / 2) + (button.offsetWidth / 2),
        behavior: 'smooth',
    });
}

document.addEventListener('livewire:navigated', () => {
    setTimeout(() => centerOrdersMonth(), 100);
});

document.addEventListener('livewire:init', () => {
    Livewire.on('scroll-month', ({ month }) => {
        centerOrdersMonth(month);
    });
});
</script>
