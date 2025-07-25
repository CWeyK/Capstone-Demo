@php
    use App\Models\enrollmentToggle;
@endphp
<div id="kt_app_sidebar"
     class="app-sidebar"
     data-kt-drawer="true"
     data-kt-drawer-name="app-sidebar"
     data-kt-drawer-activate="{default: true, lg: false}"
     data-kt-drawer-overlay="true"
     data-kt-drawer-width="225px"
     data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

    <div id="kt_app_sidebar_wrapper"
         class="flex-grow-1 hover-scroll-y mt-9 mb-5 px-2 mx-3 ms-lg-7 me-lg-5"
         data-kt-scroll="true"
         data-kt-scroll-activate="true"
         data-kt-scroll-height="auto"
         data-kt-scroll-dependencies="{default: false, lg: '#kt_app_header'}"
         data-kt-scroll-offset="5px"
    >
        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.dashboard') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-calendar fs-4 me-2 text-danger"></i>
                        Dashboard
                    </span>
                </a>
            </div>
        </div>

        @role('Super-Admin')
        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.users.index') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-user fs-4 me-2 text-danger"></i>
                        Users
                    </span>
                </a>
            </div>
        </div>
        @endrole

        @hasanyrole('Super-Admin|Lecturer')
        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.programmes.index') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-teacher fs-4 me-2 text-danger"></i>
                        Programmes
                    </span>
                </a>
            </div>
        </div>

        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.rooms.index') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-focus fs-4 me-2 text-danger"></i>
                        Rooms
                    </span>
                </a>
            </div>
        </div>
        @endhasanyrole

        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.subjects.index') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-book fs-4 me-2 text-danger"></i>
                        Subjects
                    </span>
                </a>
            </div>
        </div>

        {{-- @role("Super-Admin")
        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.scheduling.index') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-user fs-4 me-2 text-danger"></i>
                        Scheduling
                    </span>
                </a>
            </div>
        </div>
        @endrole --}}

        @role('Student')
        @if(enrollmentToggle::first() && enrollmentToggle::first()->enrollment === "Enrollment")
        <div class="mb-4">
            <div class="m-0">
                <a href="{{ route('admin.enrollments.index') }}"
                   @class(['btn btn-sm px-3 border btn-color-gray-700 btn-active-color-gray-900 w-100'])
                   wire:navigate
                >
                    <span class="d-flex align-item-center">
                        <i class="ki-outline ki-clipboard fs-4 me-2 text-danger"></i>
                        Enrollment
                    </span>
                </a>
            </div>
        </div> 
        @endif
        @endrole

    </div>
</div>
