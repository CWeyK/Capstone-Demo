<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-5">
        @if($headers)
            <thead>
            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                @foreach ($headers as $header)
                    <th class="{{ $header['classes'] }}">{{ $header['name'] }}</th>
                @endforeach
            </tr>
            </thead>
        @endisset
        <tbody class="text-gray-600 fw-semibold">
        {{ $slot }}
        </tbody>
    </table>
</div>

<div class="row">
    @if ($paginator)
        {{ $paginator->links() }}
    @endif
</div>
