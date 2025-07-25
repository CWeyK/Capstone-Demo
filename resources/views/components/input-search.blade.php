@props(['model' => 'search', 'placeholder' => 'Search something...'])

<div class="d-flex align-items-center position-relative my-1">
    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-5"></i>
    <x-input
        class="form-control-solid w-250px ps-13"
        wire:model.live.debounce.300ms="{{ $model }}"
        placeholder="{{ $placeholder }}"
    />
</div>
