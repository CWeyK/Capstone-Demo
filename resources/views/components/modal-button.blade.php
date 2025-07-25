@props(['name' => 'Add', 'icon' => ' ki-plus', 'modal' => ''])

<a href="#" {{ $attributes->merge(['class' => 'btn btn-sm btn-flex btn-primary']) }}
   data-bs-toggle="modal"
   data-bs-target="#{{ $modal }}">
    <i class="fs-4 ki-outline {{ $icon }}"></i>
    {{ $name }}
</a>
