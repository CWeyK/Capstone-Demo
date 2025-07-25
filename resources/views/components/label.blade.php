@props(['name' => null, 'required' => false])

<label {{ $attributes->merge(['class' => 'form-label fs-6']) }} wire:ignore>
    <span @class(['required' => $required])>
        {{ $name }}
        {{ $slot }}
    </span>
</label>
