<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="form-group">
            <label for="pass_input">{{ __('Passwort-Generator') }}</label>
            <div class="input-group">
                <div class="input-group-btn">
                    {!! Form::select('pass_length', [8 => 8, 12 => 12, 16 => 16, 24 => 24, 32 => 32, 64 => 64], null, [
                    'class' => 'form-control width-75 pass-length',
                ]) !!}
                </div>
                {!! Form::text('pass_input', null, [
                    'class' => 'form-control pass-input',
                    'data-character-set' => 'a-z,A-Z,0-9,_,~',
                ]) !!}
                <div class="input-group-btn">
                    {!! Form::button('<i class="icon wh-refresh"></i>', [
                        'class' => 'btn btn-default pass-generate',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
</div>