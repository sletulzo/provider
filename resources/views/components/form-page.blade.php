@props([
    'back',
    'title',
    'subtitle' => null,
    'icon' => null,
    'eyebrow' => null,
])

<x-app-layout>
    <div class="form-page">
        <div class="form-page__top">
            <a wire:navigate href="{{ $back }}" class="form-page__back" aria-label="Retour">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div class="form-page__heading">
                @if ($eyebrow)
                    <span class="form-page__eyebrow">{{ $eyebrow }}</span>
                @endif
                <h1 class="form-page__title">
                    @if ($icon)
                        <i class="{{ $icon }}"></i>
                    @endif
                    {{ $title }}
                </h1>
                @if ($subtitle)
                    <p class="form-page__subtitle">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        {{ $slot }}
    </div>
</x-app-layout>
