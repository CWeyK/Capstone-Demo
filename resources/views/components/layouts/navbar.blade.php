<div class="app-navbar flex-shrink-0 gap-2">
    <!--begin::Quick links-->
    <div class="app-navbar-item me-lg-3">

    </div>
    <!--end::Quick links-->

    <div class="app-navbar-item ms-1">
        <div class="cursor-pointer symbol position-relative symbol-35px"
             data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
             data-kt-menu-attach="parent"
             data-kt-menu-placement="bottom-end">
            <img x-data="{{ json_encode(['imageUrl' => auth()->user()->profileImg()], JSON_THROW_ON_ERROR) }}"
                 x-on:media-uploaded.window="imageUrl = $event.detail.name"
                 alt="User"
                 :src="imageUrl"/>
            <span
                class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle mb-1 bottom-0 start-100"></span>
        </div>
        <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
            data-kt-menu="true">
            <div class="menu-item px-3">
                <div class="menu-content d-flex align-items-center px-3">
                    <!--begin::Avatar-->
                    <div class="symbol symbol-50px me-5">
                        <img x-data="{{ json_encode(['imageUrl' => auth()->user()->profileImg()], JSON_THROW_ON_ERROR) }}"
                             x-on:media-uploaded.window="imageUrl = $event.detail.name"
                             alt="User"
                             :src="imageUrl"/>
                    </div>
                    <!--end::Avatar-->
                    <div class="d-flex flex-column">
                        <div class="fw-bold d-flex align-items-center fs-5"
                             x-data="{{ json_encode(['name' => auth()->user()->name], JSON_THROW_ON_ERROR) }}"
                             x-text="name"
                             x-on:auth-profile-updated.window="name = $event.detail.name">
                            <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Active</span>
                        </div>

                        <div class="fw-semibold text-muted text-hover-primary fs-7"
                             x-data="{{ json_encode(['email' => auth()->user()->email], JSON_THROW_ON_ERROR) }}"
                             x-text="email"
                             x-on:auth-email-updated.window="email = $event.detail.email">
                        </div>
                    </div>
                </div>
            </div>

            <div class="separator my-2"></div>

            <livewire:auth.logout/>
        </div>
    </div>
</div>
