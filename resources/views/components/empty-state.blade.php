@props([
    'icon' => 'fa-regular fa-folder-open',
    'title',
    'description' => null,
    'action' => null,
    'href' => null,
    'modal' => false,
    'compact' => false,
])

<div {{ $attributes->class(['empty-state', 'empty-state--compact' => $compact]) }}>
    <div class="empty-state-icon">
        <i class="{{ $icon }}"></i>
    </div>
    <div class="empty-state-title">{{ $title }}</div>
    @if ($description)
        <div class="empty-state-description">{{ $description }}</div>
    @endif
    @if ($action && $href)
        <a
            wire:navigate
            href="{{ $href }}"
            class="btn-primary empty-state-action"
        >{{ $action }}</a>
    @endif
</div>
