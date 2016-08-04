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