<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="/assets/base/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/base/favicon/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/base/favicon/favicon-32x32.png">
    <title>@yield('pageTitle', 'Master Data System')</title>

    <!-- Bootstrap -->
    <link href="{{ mix('assets/base/css/vendor.css') }}" rel="stylesheet" type="text/css" class="main-stylesheet"/>
    <link href="{{ mix('assets/base/css/app.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Font Awesome -->
    @yield('styles')
    @stack('custom-styles')
</head>

<body class="nav-md">
@yield('body-inside')
<!-- jQuery -->
<script src="{{ mix('assets/base/js/vendor.js') }}"></script>
<script src="{{ mix('assets/base/js/app.js') }}"></script>
@yield('scripts')
@stack('custom-scripts')
</body>
</html>
