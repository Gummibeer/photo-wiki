<div class="panel panel-default">
    <div class="panel-heading">
        <div class="tools"></div>
        <span class="title">{{ __('Projekte') }}</span>
    </div>
    <div class="list-group list-group-striped list-group-hover">
        @foreach(\Auth::user()->projects()->orderByName()->get() as $project)
            <a href="{{ route('app.get.project.show', $project->getKey()) }}" class="list-group-item">
                <i class="icon {{ $project->icon }}"></i>
                <strong>{{ $project->display_name }}</strong>
            </a>
        @endforeach
    </div>
</div>