@php
use App\Models\enrollmentToggle;
@endphp

<div class="app-header-primary">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
         id="kt_app_header_primary_container">
        <div class="d-flex flex-stack flex-grow-1">
            <div class="d-flex">
                <!--begin::Logo-->
                <div class="app-header-logo d-flex flex-center gap-2 me-lg-6">
                    <button class="btn btn-icon btn-sm btn-custom d-flex d-lg-none ms-n2"
                            id="kt_app_header_menu_toggle">
                        <i class="ki-outline ki-abstract-14 fs-2"></i>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" wire:navigate>
                        <strong>SunSched</strong>
                    </a>
                </div>
                <!--end::Logo-->

                <div class="d-flex align-items-stretch" id="kt_app_header_menu_wrapper">
                    <div class="app-header-menu app-header-mobile-drawer align-items-stretch"
                         data-kt-drawer="true"
                         data-kt-drawer-name="app-header-menu"
                         data-kt-drawer-activate="{default: true, lg: false}"
                         data-kt-drawer-overlay="true"
                         data-kt-drawer-width="{default:'200px', '300px': '250px'}"
                         data-kt-drawer-direction="start"
                         data-kt-drawer-toggle="#kt_app_header_menu_toggle"
                         data-kt-swapper="true"
                         data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                         data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_menu_wrapper'}">

                        <div
                            class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-gray-900 menu-icon-gray-500 menu-arrow-gray-500 menu-state-icon-primary menu-state-bullet-primary fw-semibold fs-6 align-items-stretch my-5 my-lg-0 px-2 px-lg-0"
                            id="#kt_app_header_menu"
                            data-kt-menu="true">

                            <x-menu :title="__('Dashboard')"
                                    :class="Route::is('admin.dashboard') ? 'here show' : null"
                                    :href="route('admin.dashboard')"
                            >
                            </x-menu>

                            @role('Super-Admin')
                            <x-menu :title="__('Users')"
                                    :class="Route::is('admin.users.index') ? 'here show' : null"
                                    :href="route('admin.users.index')"
                            >
                            </x-menu>
                            @endrole

                            @hasanyrole('Super-Admin|Lecturer')
                            <x-menu :title="__('Programmes')"
                                    :class="Route::is('admin.programmes.index') ? 'here show' : null"
                                    :href="route('admin.programmes.index')"
                            >
                            </x-menu>
                            
                            <x-menu :title="__('Rooms')"
                                    :class="Route::is('admin.rooms.index') ? 'here show' : null"
                                    :href="route('admin.rooms.index')"
                            >
                            </x-menu>
                            @endhasanyrole

                            <x-menu :title="__('Subjects')"
                                    :class="Route::is('admin.subjects.index') ? 'here show' : null"
                                    :href="route('admin.subjects.index')"
                            >
                            </x-menu>

                            @role('Student')
                            @if(enrollmentToggle::first() && enrollmentToggle::first()->enrollment === "Enrollment")
                            <x-menu :title="__('Enrollment')"
                                    :class="Route::is('admin.enrollments.index') ? 'here show' : null"
                                    :href="route('admin.enrollments.index')"
                            >
                            </x-menu>
                            @endif
                            @endrole
                            
                        </div>
                    </div>
                </div>
            </div>

            <x-layouts.navbar/>
        </div>
    </div>
</div>
