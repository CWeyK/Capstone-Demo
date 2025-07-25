@props([
    'title' => null,
    'subMenu' => false,
    'icon' => null,
    'bullet' => false,
    'show' => true,
    'navigate' => true,
])

@php
    use Illuminate\Support\Str;

    $tag = $subMenu ? 'span' : 'a';
    $isHere = Str::startsWith(url()->current(), $attributes->get('href'));
@endphp

@if (!$subMenu)
    <div @class(['menu-item', 'here' => $isHere && $show])>
@endif

<{{ $tag }} {{ $attributes->merge(['class' => 'menu-link']) }}
    @if (!$subMenu && $attributes->get('href')) href="{{ $attributes->get('href') }}" {{ $navigate ? 'wire:navigate' : null }} @endif>

    @if ($icon)
        <span class="menu-icon">
            <i class="ki-outline {{ $icon }}"></i>
        </span>
    @elseif($bullet)
        <span class="menu-bullet">
            <span class="bullet bullet-dot"></span>
        </span>
    @endif

    <span class="menu-title">{{ $title }}</span>

    @if ($subMenu)
        <span class="menu-arrow"></span>
    @endif

    </{{ $tag }}>

    @if (!$subMenu)
        </div>
    @endif
