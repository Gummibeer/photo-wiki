@extends('layouts.app')

@section('head-title', $title = __('Termin anlegen'))
@section('page-title', $title)

@section('content')
    @include('app.event.partials.event_form')
@endsection