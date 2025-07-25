<div class="app-header-secondary app-header-mobile-drawer" data-kt-drawer="true" data-kt-drawer-name="app-header-secondary"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_secondary_mobile_toggle" data-kt-swapper="true"
    data-kt-swapper-mode="{default: 'append', lg: 'append'}"
    data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header'}">

    <div class="d-flex flex-column flex-grow-1 overflow-hidden">
        <div class="app-header-secondary-menu-sub d-flex align-items-stretch flex-grow-1">
            <div
                class="app-container d-flex flex-column flex-lg-row align-items-stretch justify-content-lg-between container-fluid">
                <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-gray-900 menu-icon-gray-500 menu-arrow-gray-500 menu-state-icon-primary menu-state-bullet-primary fw-semibold fs-base align-items-stretch my-2 my-lg-0 px-2 px-lg-0"
                    id="#kt_app_header_tertiary_menu" data-kt-menu="true">
                    

                    @yield('secondary-menu')
                </div>

                <div class="d-flex align-items-center justify-content-end w-150px">
                    <span class="menu-title">{{ now()->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
