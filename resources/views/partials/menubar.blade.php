<div class="am-left-sidebar">
    <div class="content">
        <div class="am-logo"></div>
        <ul class="sidebar-elements">
            @foreach(\Auth::user()->projects()->orderByName()->get() as $project)
                @can('view', $project)
                    <li class="@if(is_route(['app.get.project.show', $project->getKey()]) || is_route(['app.get.project.edit', $project->getKey()]) || is_route(['app.get.project.member', $project->getKey()])) active @endif">
                        <a href="{{ route('app.get.project.show', $project->getKey()) }}" class="text-center">
                            <i class="icon {{ $project->icon }}"></i>
                            <span>{{ $project->display_name }}</span>
                        </a>
                    </li>
                @endcan
            @endforeach
        </ul>
    </div>
</div>