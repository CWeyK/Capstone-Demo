@props(['title' => null, 'description' => null, 'currentStep' => 1, 'step' => 1, 'line' => true])

<div @class(['stepper-item', 'current' => $currentStep === $step]) data-kt-stepper-element="nav">
    <a href="javascript:void(0)" class="stepper-wrapper" wire:click="$set('currentStep', '{{ $step }}')">
        <div class="stepper-icon w-40px h-40px">
            <i class="ki-outline ki-check stepper-check fs-2"></i>
            <span class="stepper-number">{{ $step }}</span>
        </div>

        <div class="stepper-label">
            <h3 class="stepper-title">{{ $title }}</h3>
            <div class="stepper-desc">{{ $description }}</div>
        </div>
    </a>

    @if($line)
        <div class="stepper-line h-40px"></div>
    @endif
</div>

@push('styles')
    <style>
        .stepper.stepper-pills .stepper-item.current .stepper-label .stepper-title {
            color: var(--bs-primary) !important;
        }
    </style>
@endpush
