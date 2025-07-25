@props(['name' => '', 'modal' => '', 'class' => 'btn-secondary', 'dispatch' => '', 'data' => ''])

<button class="btn btn-sm {{ $class }}"
        data-bs-toggle="modal"
        data-bs-target="#{{ $modal }}"
        @if($dispatch) @click="$dispatch('{{ $dispatch }}', { id: '{{ $data }}' })" @endif>
    {{ $name }}
</button>
