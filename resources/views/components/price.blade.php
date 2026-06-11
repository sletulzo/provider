@props(['amount' => 0, 'decimals' => null])

@php
    if ($decimals === null) {
        $decimals = ((int) $amount) % 100 === 0 ? 0 : 2;
    }
@endphp

<span {{ $attributes->class(['price-display']) }}>
    <span class="price-display__amount">{{ price($amount, $decimals) }}</span><span class="price-display__currency">€</span>
</span>
