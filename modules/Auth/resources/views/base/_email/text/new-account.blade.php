@extends('core::_email.text.layout')
@section('content')
{{ $email }}

{{ route('login') }}
{{ $email }}
{{ $password }}
@endsection