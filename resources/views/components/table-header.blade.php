@props(['title' => null, 'toolbar' => null])

<div class="card-header border-0 pt-6">
    @if($title)
        {{ $title }}
    @endif

    @if($toolbar)
        {{ $toolbar }}
    @endif
</div>
