<div class="panel panel-default">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ __('Willkommen') }}</span>
    </div>
    <div class="alert alert-info">
        <p>{{ __('Hallo %s, willkommen im Kessel.', [
            \Auth::user()->display_name
        ]) }}</p>
    </div>
</div>