@extends('master')

@section('body-class', 'error am-splash-screen')

@section('layout')

    <div class="am-wrapper am-error am-error-404">
        <div class="am-content">
            <div class="main-content">
                <div class="error-container">
                    <div class="error-image">
                    </div>
                    <div class="error-number">@yield('error-code')</div>
                    <p class="error-description">@yield('error-message')</p>
                </div>
            </div>
        </div>
    </div>

@endsection