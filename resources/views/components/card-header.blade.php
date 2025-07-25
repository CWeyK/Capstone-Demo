@props(['title' => null])

<div {{ $attributes->merge(['class' => 'card-header']) }} role="button">
    <x-card-title class="m-0">
        <h3 class="fw-bold m-0">{{ $title }}</h3>
    </x-card-title>
    {{ $slot }}
</div>
