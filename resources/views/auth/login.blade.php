@extends('layouts.auth')

@section('head-title', __('Anmelden'))
@section('page-title', config('app.name'))

@section('content')

    {!! BTForm::open([
        'route' => 'auth.post.login',
    ]) !!}

    {!! BTForm::email('email') !!}

    {!! BTForm::password('password') !!}

    {!! BTForm::checkbox('remember') !!}

    {!! BTForm::submit(__('Anmelden'), [
        'class' => 'btn btn-primary btn-block'
    ]) !!}

    {!!BTForm::close() !!}
@endsection
