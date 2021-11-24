<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gallops') }}</title>
    @include('layouts.css-links')

    <script>
        var APP_NAME = "{{ env('APP_NAME') }}";
        var APP_URL = "{{ env('APP_URL') }}";
    </script>
</head>
<body class="font-sans antialiased hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            @include('layouts.side-navbar')
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    @include('layouts.scripts')
    @yield('page-footer-script')

</body>

</html>