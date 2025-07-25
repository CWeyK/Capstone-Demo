@props(['title' => null, 'icon' => null, 'href' => null])

<div class="menu-item">
    <a class="menu-link active" href="{{ $href }}" wire:navigate>
        @if($icon)
        <span class="menu-icon">
            <i class="ki-outline {{ $icon }} fs-4"></i>
        </span>
        @endif
        <span class="menu-title">{{ $title }}</span>
    </a>
</div>
