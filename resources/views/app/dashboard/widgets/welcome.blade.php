<div class="panel panel-default">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ __('Willkommen') }}</span>
    </div>
    <div class="alert alert-info">
        <p>{{ __('Hallo %s, willkommen auf der "%s" Seite.', [
            \Auth::check() ? \Auth::user()->display_name : 'Gast',
            config('app.name'),
        ]) }}</p>
    </div>
</div>