<a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
    Actions
    <i class="ki-outline ki-down fs-5 ms-1"></i>
</a>

<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
    @foreach($links as $link)
        <div class="menu-item px-3">
            <a 
            @if(isset($link['url'])) href="{{ $link['url'] }}" @endif
            class="menu-link px-3 {{ $link['class'] }}" 
            target="{{ $link['target'] }}"
            wire:navigate
            @if(isset($link['click']))wire:click="{{ $link['click'] }}" @endif>

                {{ $link['title'] }}
            </a>
        </div>
    @endforeach
</div>
