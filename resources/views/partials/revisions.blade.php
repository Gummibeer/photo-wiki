<div class="panel panel-alt4">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ __('Änderungen') }}</span>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-fw-widget">
            <thead>
            <tr>
                <th>{{ __('Benutzer') }}</th>
                <th>{{ __('Aktion') }}</th>
                <th>{{ __('Feld') }}</th>
                <th>{{ __('alter Wert') }}</th>
                <th>{{ __('neuer Wert') }}</th>
                <th>{{ __('Datum')  }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($model->getRevisions() as $history)
                <tr>
                    <td>
                        {{ mixed_get($history->user, 'display_name', __('System')) }}
                    </td>
                    <td>
                        @if($history->key == 'created_at' && is_null($history->old_value))
                            <span class="label label-success text-uppercase">{{ __('erstellt') }}</span>
                        @else
                            <span class="label label-warning text-uppercase">{{ __('geändert') }}</span>
                        @endif
                    </td>
                    <td>
                        @if(!($history->key == 'created_at' && !$history->user))
                            {{ $history->key }}
                        @endif
                    </td>
                    <td>
                        @if(!($history->key == 'created_at' && !$history->user))
                            @if($history->key != 'secret')
                                {{ $history->old_value }}
                            @endif
                        @endif
                    </td>
                    <td>
                        @if(!($history->key == 'created_at' && !$history->user))
                            @if($history->key != 'secret')
                                {{ $history->new_value }}
                            @endif
                        @endif
                    </td>
                    <td>{{ $history->created_at->format(trans('helpers.datetimetzformat.php')) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>