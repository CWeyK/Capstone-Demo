<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn', 'disabled' => false]) }}>
    {{ $slot }}
</button>
