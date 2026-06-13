@props([
    'placeholder' => 'Rechercher…',
    'name' => 'search',
    'value' => '',
])

<label {{ $attributes->class(['ui-search']) }}>
    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
    <input type="search" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" autocomplete="off">
</label>
