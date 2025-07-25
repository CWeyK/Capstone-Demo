@props(['title' => null, 'search' => false, 'placeholder' => 'Search something...'])

<div {{ $attributes->merge(['class' => 'card-title']) }}>
    @if($title)
        <h3 class="fw-bold mb-0">{{ $title }}</h3>
    @endif

    @if($search && !$title)
        <div class="d-flex align-items-center position-relative my-1">
            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
            <x-input
                class="form-control-solid w-250px ps-13"
                wire:model.live.debounce.300ms="search"
                placeholder="{{ $placeholder }}"
            />
        </div>
    @endif

    {{ $slot }}
</div>
