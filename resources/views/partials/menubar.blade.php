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
            <li class="@if(is_route(['app.get.map.index'])) active @endif">
                <a href="{{ route('app.get.map.index') }}" class="text-center">
                    <i class="icon wh-map"></i>
                    <span>{{ __('Karte') }}</span>
                </a>
            </li>

            <li>
                <a href="https://facebook.com/Photo-Wiki-1215946231803146/" class="text-center social-facebook">
                    <i class="icon wh-circlefacebook"></i>
                    <span>{{ __('Facebook') }}</span>
                </a>
            </li>
            <li>
                <a href="https://github.com/Gummibeer/photo-wiki" class="text-center social-github">
                    <i class="icon wh-circlegithub"></i>
                    <span>{{ __('Github') }}</span>
                </a>
            </li>
            <li class="@if(is_route(['page', 'impressum'])) active @endif">
                <a href="{{ route('page', 'impressum') }}" class="text-center">
                    <span>{{ __('Impressum') }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>