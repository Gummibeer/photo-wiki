@extends('layouts.app')

@section('head-title', $title)
@section('page-title', $title)
@section('page-actions')
    <a href="{{ route('app.management.get.user.index') }}" class="btn btn-default">{{ __('Übersicht') }}</a>
@endsection

@section('content')
    {!! BTForm::open([
        'model' => $model,
        'update' => 'app.management.put.user.edit',
    ]) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>{{ __('Basis-Daten') }}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    {!! BTForm::text('email', null, null, [
                        'readonly' => true,
                    ]) !!}
                    {!! BTForm::text('nickname', null, null, [
                        'readonly' => true,
                    ]) !!}
                    {!! BTForm::text('first_name') !!}
                    {!! BTForm::text('last_name') !!}
                </div>
                <div class="col-md-6">
                    {!! BTForm::select('language', null, \Datamap::getLanguages()->pluck('display_name', 'locale')) !!}
                </div>
            </div>
        </div>
    </div>

    @include('helpers.form_save_panel')
    {!!BTForm::close() !!}
@endsection