@extends('core::layout.management.management')
@section('pageTitle', 'Generator Module')
@section('body-inside')
    <div class="container body">
        <div class="main_container">
        @include('r::_partials.sidebar')
        @include('r::_partials.top_nav')
        <!-- page content -->
        @yield('content')
        <!-- /page content -->
            @include('core::_partials.footer')
        </div>
    </div>
@endsection
