@extends('master')

@section('body-class', 'am-splash-screen auth')

@section('layout')

    <div class="login-container">
        <div class="panel panel-default">
            <div class="panel-heading">
                <img src="{{ asset('img/brand/white/brand.svg') }}" class="brand">
            </div>
            <div class="panel-body bg-white">
                @foreach (\Alert::getMessages() as $type => $messages)
                    @foreach ($messages as $message)
                        <div class="alert alert-{{ $type }}">{!! $message !!}</div>
                    @endforeach
                @endforeach
                @yield('content')
            </div>
        </div>
    <div>

@endsection