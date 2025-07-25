@props(['pics' => null])

<div class="symbol-group symbol-hover mb-1">
    @php
        $colorClasses = [
            'bg-success text-inverse-success',
            'bg-info text-inverse-info',
            'bg-danger text-inverse-danger',
            'bg-warning text-inverse-warning',
        ];
        $colorCount = count($colorClasses);
        $colorIndex = 0;
    @endphp
    @foreach($pics as $pic)
        @php
            $currentColorClass = $colorClasses[$colorIndex];
            $colorIndex = ($colorIndex + 1) % $colorCount;
        @endphp
        <div class="symbol symbol-circle symbol-35px"
             data-bs-toggle="tooltip"
             aria-label="{{ $pic->name }}"
             data-bs-original-title="{{ $pic->name }}"
        >
            <div class="symbol-label fw-bold {{ $currentColorClass }}">
                <span class="fs-7">{{ ucfirst($pic->name[0]) }}</span>
            </div>
        </div>
    @endforeach
</div>
