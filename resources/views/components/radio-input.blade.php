@props(['name' => null, 'label' => null, 'value' => null])

<div class="form-check form-check-custom form-check-solid me-5">
    <input class="form-check-input"
           type="radio"
           name="{{ $name }}"
           value="{{ $value }}"
          @if($attributes->has('model')) wire:model="{{ $attributes->get('model') }}" @endif
    />
    <label class="form-check-label fw-semibold">
        {{ $label }}
    </label>
</div>
