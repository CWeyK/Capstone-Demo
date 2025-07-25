@props([
    'title' => null,
    'trigger' => '{default: "click", lg: "hover"}',
    'placement' => 'bottom-start',
])

<div data-kt-menu-trigger="{{ $trigger }}"
     data-kt-menu-placement="{{ $placement }}"
    {{ $attributes->merge(['class' => 'menu-item menu-here-bg menu-lg-down-accordion me-0 me-lg-2']) }}>

    @if($attributes->has('href'))
        <a href="{{ $attributes->get('href') }}" wire:navigate class="menu-link">
            <span class="menu-title">{{ $title }}</span>
        </a>
    @else
        <span class="menu-link">
        <span class="menu-title">{{ $title }}</span>
        <span class="menu-arrow d-lg-none"></span>
    </span>
    @endif

    {{ $slot }}
</div>
