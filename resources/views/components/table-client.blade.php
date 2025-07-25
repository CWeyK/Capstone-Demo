<div class="d-flex align-items-center">
    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
        <a href="{{ route('admin.clients.show', $client->id) }}" wire:navigate>
            <div class="symbol-label">
                <img src="{{ secure_asset('assets/admin/media/avatars/blank.png') }}" alt="{{ $client->business_name }}" class="w-100">
            </div>
        </a>
    </div>
    <div class="d-flex flex-column">
        <a href="{{ route('admin.clients.show', $client->id) }}" wire:navigate
           class="text-gray-800 text-hover-primary mb-1">{{ $client->business_name }}</a>
        <span>{{ $client->businessCategory->name }}</span>
    </div>
</div>
