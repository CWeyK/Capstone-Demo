<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Administrator Login') }}</title>
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ secure_asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ secure_asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ secure_asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ secure_asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ secure_asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ secure_asset('assets/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ secure_asset('assets/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Stylesheets Bundle-->

    <!--Frame-busting script to prevent click-jacking-->
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <!--end::Frame-busting script to prevent click-jacking-->
</head>
<body id="kt_body" class="app-blank">

<div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid justify-content-center">
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-100 w-lg-500px p-10">
                    {{ $slot }}
                </div>
            </div>
        </div>

        <div class="d-none d-lg-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
             style="background-image: url({{ secure_asset('assets/admin/media/misc/auth-bg.png') }})">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-20 w-100">
                <img class="d-none d-lg-block mx-auto w-275px w-md-80 w-xl-400px mb-10 mb-lg-20"
                     src="{{ secure_asset('assets/admin/media/auth/agency.png') }}" alt=""/>

                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and Productive</h1>

                <div class="d-none d-lg-block text-white fs-base text-center">
                </div>
            </div>
        </div>
    </div>
</div>

<!--begin::Global Javascript Bundle-->
<script src="{{ secure_asset('assets/admin/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ secure_asset('assets/admin/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

</body>
</html>
