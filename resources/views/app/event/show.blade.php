@extends('layouts.app')

@section('head-title', $title = __('%s | Kalender', [$event->display_name]))
@section('page-title', $event->display_name)

@section('page-actions')
    @can('edit', $event)
        @if($event->hasGoogleEvent())
            <a href="{{ route('app.get.event.reload', $event->getKey()) }}" class="btn btn-warning">
                {{ __('von Google aktualisieren') }}
            </a>
        @endif
        <a href="{{ route('app.get.event.edit', $event->getKey()) }}" class="btn btn-warning">
            {{ __('bearbeiten') }}
        </a>
    @endcan
    @can('approve', $event)
        @if(!$event->approved)
            <a href="{{ route('app.get.event.approve', $event->getKey()) }}" class="btn btn-success">
                {{ __('bestätigen') }}
            </a>
        @endif
    @endcan
@endsection

@section('content')
<div class="panel panel-default" itemscope itemtype="http://schema.org/Event">
    <meta itemprop="url" content="{{ route('app.get.event.show', $event->getKey()) }}" />
    <div class="panel-heading">
        <h3 class="panel-title">
            <span itemprop="name">{{ $event->display_name }}</span>
            <span class="label pull-right" style="background: {{ $event->calendar['color']['hex'] }};">
                {{ $event->calendar['display_name'] }}
            </span>
        </h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <strong class="list-group-item-heading">
                    {{ trans('forms.starting_at') }}
                </strong>
                <p>
                    <meta itemprop="startDate" content="{{ $event->starting_at->toIso8601String() }}" />
                    {{ carbon_datetime($event->starting_at) }}
                </p>
            </div>
            <div class="col-md-6">
                <strong class="list-group-item-heading">
                    {{ trans('forms.ending_at') }}
                </strong>
                <p>
                    <meta itemprop="endDate" content="{{ $event->ending_at->toIso8601String() }}" />
                    {{ carbon_datetime($event->ending_at) }}
                </p>
            </div>
            @if(!empty($event->location))
            <div class="col-md-12">
                <strong class="list-group-item-heading">
                    {{ trans('forms.location') }}
                </strong>
                <p class="clearfix" itemprop="location" itemscope itemtype="http://schema.org/PostalAddress">
                    <span itemprop="name">{{ $event->location }}</span>
                    <meta itemprop="address" content="{{ $event->location }}" />
                </p>
            </div>
            @endif
            @if(!empty($event->description))
            <div class="col-md-12">
                <strong class="list-group-item-heading">
                    {{ trans('forms.description') }}
                </strong>
                <p itemprop="description">{!! nl2br(htmlentities($event->description)) !!}</p>
            </div>
            @endif
            @can('debug', $event)
            <div class="col-md-6">
                <strong class="list-group-item-heading">
                    Google-Calendar-ID
                </strong>
                <p>{{ $event->google_calendar_id }}</p>
            </div>
            <div class="col-md-6">
                <strong class="list-group-item-heading">
                    Google-Event-ID
                </strong>
                <p>{{ $event->google_event_id }}</p>
            </div>
            @endcan
        </div>
    </div>
    <div class="panel-footer clearfix padding-top-15">
        <div class="btn-group pull-left">
            @if(\Auth::check())
                @if($event->isAttendee(\Auth::user()))
                    <a href="{{ route('app.get.event.leave', $event->getKey()) }}" class="btn btn-default">
                        {{ __('absagen') }}
                    </a>
                @else
                    <a href="{{ route('app.get.event.join', $event->getKey()) }}" class="btn btn-default">
                        {{ __('teilnehmen') }}
                    </a>
                @endif
            @endif
        </div>
        <div class="btn-group pull-right">
            <a href="https://www.google.de/maps/place/{{ urlencode($event->location) }}" class="btn btn-default" target="_blank">
                {{ __('Google Maps') }}
            </a>
            @if($event->hasGoogleEvent())
            <a href="{{ $event->getGoogleEvent()->htmlLink }}" class="btn btn-default" target="_blank">
                {{ __('Google Kalender') }}
            </a>
            @endif
        </div>
        <div class="btn-group pull-right margin-right-15">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ Request::url() }}" class="btn btn-default social-facebook" target="_blank">
                <i class="wh-facebook"></i>
            </a>
        </div>
    </div>
</div>

@include('partials.disqus', [
    'url' => route('app.get.event.show', $event->getKey()),
    'slug' => 'event-'.$event->getKey(),
])

@if($event->attendees->count() > 0)
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ __('Teilnehmer') }}</h3>
        </div>
        <div class="panel-body">
            <ul class="list-inline">
            @foreach($event->attendees->sortBy('display_name') as $attendee)
                <li>
                    <span class="label label-info">{{ $attendee->display_name }}</span>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
@endif

@if(!empty($event->geoloc))
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">{{ __('Karte') }}</h3>
        </div>
        <div class="gmap-single height-500" data-lat="{{ $event->lat }}" data-lng="{{ $event->lng }}" data-name="{{ $event->display_name }}" data-location="{{ $event->location }}"></div>
    </div>
@endif
@endsection