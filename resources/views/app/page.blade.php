@extends('layouts.app')

@section('head-title', $title)
@section('page-title', $title)

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            {!! $content !!}
        </div>
    </div>
@endsection