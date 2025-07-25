@props(['header' => null, 'body' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'card']) }}>
    @if($header)
        {{ $header }}
    @endif

    @if($body)
        {{ $body }}
    @endif

    @if($footer)
        {{ $footer }}
    @endif

    {{ $slot }}
</div>
