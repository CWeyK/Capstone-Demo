<div class="d-flex align-items-center">
    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
        <a href="{{ $url }}" wire:navigate>
            <div class="symbol-label">
                <img src="{{ $row->avatar ?? secure_asset('assets/admin/media/svg/avatars/blank.svg') }}" alt="{{ $row->name }}" class="w-100">
            </div>
        </a>
    </div>
    <div class="d-flex flex-column">
        <a href="{{ $url }}"
           class="text-gray-800 text-hover-primary mb-1"
           wire:navigate
        >
            {{ $row->name }}
        </a>
        <span>{{ $row->email }}</span>
    </div>
</div>
