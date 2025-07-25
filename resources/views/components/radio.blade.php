@props(['name' => '', 'options' => []])

<div {{ $attributes->merge(['class' => '']) }}>
    @foreach($options as $key => $option)
    <div class="form-check form-check-custom form-check-solid mb-2">
        <input
            type="radio"
            id="flexRadioDefault"
            class="form-check-input"
            name="{{ $name }}"
            value="{{ $key }}"
            @if($attributes->has('model')) wire:model.live="{{ $attributes->get('model') }}" @endif
        />
        <label class="form-check-label" for="flexRadioDefault">
            {{ $option }}
        </label>
    </div>
    @endforeach
</div>
