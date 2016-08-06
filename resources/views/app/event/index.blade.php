@extends('layouts.app')

@section('head-title', $title)
@section('page-title', $title)

@section('page-actions')
    <a href="{{ route('app.get.event.create') }}" class="btn btn-default">
        {{ __('Termin erstellen') }}
    </a>
@endsection

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="form-group">
                <label for="autocomplete-events">{{ __('Kalender-Suche') }}</label>
                <input type="search" id="autocomplete-events" class="form-control" />
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-body calendar">
            {!! $calendar->calendar() !!}
        </div>
    </div>

    <div id="calendar-event-modal" class="modal fade in">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <strong class="list-group-item-heading">
                                {{ trans('forms.display_name') }}
                            </strong>
                            <p>
                                [<span class="calendar-name"></span>]
                                <span class="event-name"></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong class="list-group-item-heading">
                                {{ trans('forms.starting_at') }}
                            </strong>
                            <p class="event-start"></p>
                        </div>
                        <div class="col-md-6">
                            <strong class="list-group-item-heading">
                                {{ trans('forms.ending_at') }}
                            </strong>
                            <p class="event-end"></p>
                        </div>
                        <div class="col-md-12">
                            <strong class="list-group-item-heading">
                                {{ trans('forms.location') }}
                            </strong>
                            <p class="event-location"></p>
                        </div>
                        <div class="col-md-12">
                            <strong class="list-group-item-heading">
                                {{ trans('forms.description') }}
                            </strong>
                            <p class="event-description"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <a href="#" class="btn btn-default pull-left event-link" data-href="{{ route('app.get.event.show', '%id%') }}">{{ __('Detailseite') }}</a>
                    <button type="button" data-dismiss="modal" class="btn btn-default">{{ __('schließen') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('foot-scripts')
    <script type="text/javascript">
        var calendar = {
            fn: {}
        };
        calendar.fn.loadEventModal = function (eventId) {
            $.ajax({
                method: 'GET',
                url: APP_URL + '/event/' + eventId,
                success: function (event) {
                    var start = moment(event.starting_at.date, 'YYYY-MM-DD HH:mm');
                    var end = moment(event.ending_at.date, 'YYYY-MM-DD HH:mm');

                    var $modal = jQuery('#calendar-event-modal');
                    var contents = {};
                    contents.calendar = $modal.find('.calendar-name');
                    contents.name = $modal.find('.event-name');
                    contents.start = $modal.find('.event-start');
                    contents.end = $modal.find('.event-end');
                    contents.description = $modal.find('.event-description');
                    contents.location = $modal.find('.event-location');
                    contents.link = $modal.find('.event-link');

                    $.each(contents, function() {
                        var $this = $(this);
                        $this.parent().show();
                    });

                    contents.calendar.text(event.calendar.display_name);
                    contents.name.text(event.display_name);
                    if(event.all_day) {
                        contents.start.text(start.format('DD.MM.YYYY'));
                        contents.end.text(end.format('DD.MM.YYYY'));
                        if(start.isSame(end, 'day')) {
                            contents.end.parent().hide();
                        }
                    } else {
                        contents.start.text(start.format('DD.MM.YYYY HH:mm'));
                        contents.end.text(end.format('DD.MM.YYYY HH:mm'));
                    }

                    contents.description.text(event.description);
                    if(event.description == null) {
                        contents.description.parent().hide();
                    }
                    contents.location.text(event.location);
                    if(event.location == null) {
                        contents.location.parent().hide();
                    }
                    contents.link.attr('href', contents.link.data('href').replace('%id%', event.id));

                    $modal.find('.modal-header')
                            .css({background: event.calendar.color.hex});
                    $modal.find('.modal-title')
                            .css({color: '#ffffff'})
                            .text(event.display_name);
                    $modal.modal('show');
                }
            });
        };
        calendar.fn.eventClick = function (calEvent, jsEvent, view) {
            var eventId = calEvent.id;
            calendar.fn.loadEventModal(eventId);
            return false;
        };
    </script>
    {!! $calendar->script() !!}
@endpush