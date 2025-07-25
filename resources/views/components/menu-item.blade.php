@props([
    'title' => null,
    'icon' => null,
    'subMenu' => false,
    'subMenuSize' => 'w-150px w-lg-200px',
    'trigger' => '{default: "click", lg: "hover"}',
    'placement' => 'right-start'
])

<div {{ $attributes->merge(['class' => 'menu-item']) }}
     @if($subMenu)
     data-kt-menu-trigger="{{ $trigger }}"
     data-kt-menu-placement="{{ $placement }}"
     @endif>

    <x-menu-link :title="$title" :subMenu="$subMenu" :icon="$icon"/>

    @if($subMenu)
    <div class="menu-sub menu-sub-dropdown px-lg-2 py-lg-4 px-lg-2 py-lg-4 {{ $subMenuSize }}">
        {{ $slot }}
    </div>
    @endif
</div>
