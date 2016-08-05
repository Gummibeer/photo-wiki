@extends('layouts.app')

@section('head-title', $title = __('Termine'))
@section('page-title', __('Termin-Verwaltung'))

@section('content')
    <div class="panel">
        <div class="panel-heading">
            <div class="panel-title">{{ $title }}</div>
        </div>
        {!! $dataTable->table() !!}
    </div>
@endsection

@push('foot-scripts')
    {!! $dataTable->scripts() !!}
@endpush