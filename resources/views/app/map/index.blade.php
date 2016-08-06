@extends('layouts.app')

@section('head-title', $title = __('Karte'))
@section('page-title', $title)

@section('content')
    <div class="panel panel-default">
        <div id="gmap-collection" class="height-750" data-events="{{ $events->toJson() }}"></div>
    </div>
@endsection