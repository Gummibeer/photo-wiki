@extends('layouts.auth')

@section('head-title', __('Registrieren'))
@section('page-title', config('app.name'))

@section('content')
    {!! BTForm::open([
        'route' => 'auth.post.register',
    ]) !!}

    {!! BTForm::text('nickname') !!}

    {!! BTForm::email('email') !!}

    {!! BTForm::password('password') !!}

    {!! BTForm::password('password_confirmation') !!}

    <div class="margin-vertical-10">
        {!! app('captcha')->display() !!}
    </div>

    {!! BTForm::submit(__('Registrieren'), [
        'class' => 'btn btn-primary btn-block'
    ]) !!}

    {!!BTForm::close() !!}

    <a href="{{ route('auth.get.login') }}" class="btn btn-link btn-block">
        {{ __('Anmelden') }}
    </a>
@endsection
