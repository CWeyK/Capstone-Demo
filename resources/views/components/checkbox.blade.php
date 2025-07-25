@props(['label' => null, 'value' => null, 'name' => $name])

<label {{ $attributes->merge(['class' => 'form-check form-check-custom']) }}>
    <input class="form-check-input"
           type="checkbox"
           value="{{ $value }}"
           name="{{ $name }}"
           @if($attributes->has('disabled')) disabled @endif
           @if($attributes->has('model')) wire:model="{{ $attributes->get('model') }}" @endif>
    <span class="form-check-label">
        {{ $label }}
    </span>
</label>
