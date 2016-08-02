<div class="panel">
    <div class="padding-15 clearfix">
        <div class="pull-left">
            <a href="{{ \URL::previous() }}" class="btn btn-default">{{ __('Abbrechen') }}</a>
        </div>
        {!! BTForm::submit(__('Speichern'), [
            'class' => 'btn btn-primary pull-right'
        ]) !!}
    </div>
</div>