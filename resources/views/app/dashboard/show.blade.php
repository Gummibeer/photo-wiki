@extends('layouts.app')

@section('head-title', $title = __('Dashboard'))
@section('page-title', $title)

@section('content')
    <div class="row masonry-container">
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.welcome')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.events')
        </div>
        <div class="col-md-3 col-xs-12 masonry-item masonry-sizer">
            @include('app.dashboard.widgets.facebook')
        </div>
    </div>
@endsection