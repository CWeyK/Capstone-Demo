@props(['label', 'message', 'target' => 'store'])

<span class="indicator-label" wire:loading.class="d-none" wire:target="{{ $target }}">
    {{ $label ?? __('Submit') }}
</span>
<span class="indicator-progress" wire:loading.class="d-block" wire:target="{{ $target }}">
    {{ $message ?? __('Please wait...') }}
    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
</span>
