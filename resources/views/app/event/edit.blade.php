@extends('layouts.app')

@section('head-title', $title = __('Termin bearbeiten'))
@section('page-title', $title)

@section('content')
    @include('app.event.partials.event_form')
@endsection