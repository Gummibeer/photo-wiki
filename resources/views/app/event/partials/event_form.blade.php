{!! BTForm::open([
    'model' => $event,
    'store' => 'app.post.event.create',
    'update' => 'app.post.event.edit',
]) !!}

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">{{ __('Stammdaten') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-8">
                {!! BTForm::text('display_name') !!}
            </div>
            <div class="col-md-4">
                {!! BTForm::select('calendar', null, $calendars) !!}
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4">
                {!! BTForm::text('starting_at', null, carbon_datetime($event->starting_at), [
                    'class' => 'datetimepicker',
                ]) !!}
            </div>
            <div class="col-md-4">
                {!! BTForm::text('ending_at', null, carbon_datetime($event->ending_at), [
                    'class' => 'datetimepicker',
                ]) !!}
            </div>
            <div class="col-md-4">
                {!! BTForm::hidden('all_day', 0) !!}
                {!! BTForm::checkbox('all_day') !!}
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                {!! BTForm::text('location', null, null, [
                    'class' => 'place-search',
                ]) !!}
            </div>
            <div class="col-md-12">
                {!! BTForm::textarea('description', null, null, [
                    'rows' => 3,
                ]) !!}
            </div>
        </div>
        @if(\Auth::guest())
            <div class="margin-vertical-10">
                {!! app('captcha')->display() !!}
            </div>
        @endif
    </div>
    <div class="panel-footer clearfix padding-top-15">
        {!! Form::submit(trans('forms.save'), [
            'class' => 'btn btn-primary pull-right',
        ]) !!}
    </div>
</div>

{!! BTForm::close() !!}