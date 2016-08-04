<div class="panel panel-default">
    <div class="panel-heading">
        <div class="tools">
            <a href="{{ route('app.get.event.index') }}">
                <i class="icon wh-calendarthree"></i>
            </a>
        </div>
        <span class="title">{{ __('Kalender') }}</span>
    </div>
    <div class="list-group">
        @foreach($events as $event)
            <div class="list-group-item">
                <div class="clearfix">
                    <strong class="list-group-item-heading pull-left">
                        <a href="{{ route('app.get.event.show', $event->getKey()) }}">
                            {{ $event->display_name }}
                        </a>
                    </strong>
                    <span class="label pull-right" style="background: {{ $event->calendar['color']['hex'] }};">
                        {{ $event->calendar['display_name'] }}
                    </span>
                </div>
                <p class="list-group-item-text">
                    {{ trans('forms.starting_at') }}: {{ carbon_datetime($event->starting_at) }}
                    @if(!empty($event->location))
                    <br/>
                    {{ trans('forms.location') }}: {{ $event->location }}
                    @endif
                </p>
            </div>
        @endforeach
    </div>
</div>