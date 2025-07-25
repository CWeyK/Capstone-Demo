<div id="kt_app_toolbar" class="app-toolbar pt-10 mb-0">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                {{-- <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0"> --}}
                    {{-- <li class="breadcrumb-item text-muted">
                        <a href="" class="text-muted text-hover-primary">Dashboard</a>
                    </li>

                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>

                    <li class="breadcrumb-item text-muted">toolbar.blade.php</li> --}}
                    @yield('breadcrumbs')
                {{-- </ul> --}}
            </div>

            <div class="d-flex align-items-center gap-2 gap-lg-3">
                @yield('toolbar')
            </div>
        </div>
    </div>
</div>
