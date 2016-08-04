<div class="am-left-sidebar">
    <div class="content">
        <div class="am-logo"></div>
        <ul class="sidebar-elements">
            <li class="@if(is_route(['app.get.event.index']) || is_route(['app.get.event.show', '*'])) active @endif">
                <a href="{{ route('app.get.event.index') }}" class="text-center">
                    <i class="icon wh-calendarthree"></i>
                    <span>{{ __('Kalender') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>