@extends('core::_email.text.layout')
@section('content')
{{ $email }}
{!! $url !!}

@endsection
