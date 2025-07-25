@props(['name' => '', 'bindDisabled' => '', 'options' => [], 'subclass' => '', 'subtext' => []])

<div {{ $attributes->merge(['class' => '']) }}>
    @foreach($options as $key => $option)
    <div class="form-check form-check-custom form-check-solid mb-2 {{ $subclass }} d-flex justify-content-between align-items-center">
        <div>
            <input
                type="radio"
                id="flexRadioDefault{{ $key }}"
                class="form-check-input"
                name="{{ $name }}"
                value="{{ $key }}"
                @if($attributes->has('model')) wire:model.live="{{ $attributes->get('model') }}" @endif
                @if($bindDisabled) x-bind:disabled ="{{ $bindDisabled }}" @endif
            />
            <label class="form-check-label" for="flexRadioDefault{{ $key }}">
                {{ $option }}
            </label>
        </div>
        <label class="form-check-label p-1" for="flexRadioDefault{{ $key }}">
            {{ $subtext[$key] ?? '' }}
        </label>
    </div>
    @endforeach
</div>

