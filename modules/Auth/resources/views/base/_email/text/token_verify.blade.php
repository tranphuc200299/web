@extends('core::_email.text.layout')
@section('content')
{{ $user->name }}
{{ $token->token }}

@endsection