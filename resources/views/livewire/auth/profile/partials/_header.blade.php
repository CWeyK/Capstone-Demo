<ul wire:ignore class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <li class="nav-item mt-2">
        <a @class([
            'nav-link text-active-primary ms-0 me-10 py-5',
            'active' => Route::is([
                'admin.account.overview',
                'admin.users.show'
            ])
        ])
           href="{{ $userId ? route('admin.users.show', $userId) : route('admin.account.overview') }}"
           wire:navigate
        >
            Overview
        </a>
    </li>

    <li class="nav-item mt-2">
        <a @class([
            'nav-link text-active-primary ms-0 me-10 py-5',
            'active' => Route::is([
                'admin.account.settings',
                'admin.users.settings'
            ])
        ])
           href="{{ $userId ? route('admin.users.settings', $userId) : route('admin.account.settings') }}"
           wire:navigate
        >
            Settings
        </a>
    </li>

    <li class="nav-item mt-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="">Activity</a>
    </li>
</ul>
