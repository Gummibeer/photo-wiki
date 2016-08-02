@extends('layouts.app')

@section('head-title', $title = __('Benutzer'))
@section('page-title', __('Benutzer-Verwaltung'))

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">{{ __('Benutzer') }}</div>
        </div>
        {!! $dataTable->table() !!}
    </div>
@endsection

@push('foot-scripts')
    {!! $dataTable->scripts() !!}
@endpush