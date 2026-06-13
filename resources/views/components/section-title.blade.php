@props(['href' => null, 'action' => null])

<div {{ $attributes->class(['ui-section-title']) }}>
    <span>{{ $slot }}</span>
    @if ($href && $action)
        <a href="{{ $href }}" wire:navigate>{{ $action }}</a>
    @endif
</div>
