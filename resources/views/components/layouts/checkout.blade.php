<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'AdeAzhar Administrator Login') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle-->
    <link href="{{ secure_asset('assets/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ secure_asset('assets/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!--Frame-busting script to prevent click-jacking-->
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <!--end::Frame-busting script to prevent click-jacking-->
    <style>
        .pagination {
            justify-content: start;
        }

        .table:not(.table-bordered) td:first-child {
            padding-left: .75rem;
        }
    </style>
    @stack('styles')
</head>

<body id="kt_app_body" class="app-default">

    <div>
        {{ $slot }}
    </div>
                            
    <!--begin::Global Javascript Bundle-->
    <script src="{{ secure_asset('assets/admin/plugins/global/plugins.bundle.js') }}" data-navigate-once></script>
    <script src="{{ secure_asset('assets/admin/js/scripts.bundle.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@19.1.3/dist/lazyload.min.js"></script>
    <script>
        $(document).ready(function() {
            $(window).on('popstate', function() {
                location.reload(true);
            });
        });
    </script>
    <!--end::Global Javascript Bundle-->
    @stack('scripts')
    <x-alert />
</body>

</html>
