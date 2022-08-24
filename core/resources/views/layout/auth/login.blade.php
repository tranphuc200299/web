<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', trans('core::text.Login'))</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/ico/favicon.ico') }}"/>
    <link href="{{ mix('assets/admin/css/vendor.css') }}" rel="stylesheet" type="text/css" class="main-stylesheet" />
    <link href="{{ mix('assets/admin/css/style.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body class="fixed-header ">
{{--<div class="header px-0">--}}
{{--    <div class="header-box">--}}
{{--        <div class="s-title">Project Name</div>--}}
{{--        <div class="header-underline"></div>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="login-wrapper ">
    @yield('body-inside')
</div>
<script src="{{ public_url('assets/admin/js/'.app()->getLocale().'.js') }}"></script>
<script src="{{ mix('assets/admin/js/vendor.bundle.js') }}"></script>
<script src="{{ mix('assets/admin/js/modernizr.custom.js') }}"></script>
<script src="{{ mix('assets/admin/js/template-core.js') }}"></script>
<script src="{{ mix('assets/admin/js/app.js') }}"></script>
</body>
</html>
