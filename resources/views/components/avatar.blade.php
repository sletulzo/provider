@props(['name', 'size' => 'md'])

@php
    $words = preg_split('/\s+/u', trim($name), -1, PREG_SPLIT_NO_EMPTY);
    $initials = mb_strtoupper(
        mb_substr($words[0] ?? '?', 0, 1) .
        (isset($words[1]) ? mb_substr($words[1], 0, 1) : mb_substr($words[0] ?? '?', 1, 1))
    );
@endphp

<div {{ $attributes->class(['ui-avatar', "ui-avatar--{$size}"]) }} aria-hidden="true">{{ $initials }}</div>
