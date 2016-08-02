<nav class="navbar navbar-default navbar-fixed-top am-top-header">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="page-title">
                <span>{{ config('app.name') }}</span>
            </div>
            <a href="#" class="am-toggle-left-sidebar navbar-toggle collapsed">
                <span class="icon-bar"><span></span><span></span><span></span></span>
            </a>
            <a href="{{ url('/') }}" class="navbar-brand text-center">
                <img src="{{ asset('img/brand/white/brand.svg') }}" class="height-50 margin-vertical-10 inline" />
            </a>
        </div>
        <a href="#" data-toggle="collapse" data-target="#am-navbar-collapse" class="am-toggle-top-header-menu collapsed">
            <i class="icon wh-chevron-down"></i>
        </a>

        <div class="collapse navbar-collapse" id="am-navbar-collapse">
            <ul class="nav navbar-nav navbar-right am-user-nav">
                @if(\Auth::check())
                    <li class="dropdown">
                        <a class="dropdown-toggle padding-horizontal-15" aria-expanded="false" role="button" data-toggle="dropdown" href="#">
                            <img src="{{ \Auth::user()->avatar(50) }}" />
                            <span class="user-name">{{ \Auth::user()->display_name }}</span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('auth.get.logout') }}">
                                    <i class="icon wh-off"></i>
                                    {{ __('Abmelden') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route('auth.get.login') }}">
                            {{ __('Anmelden') }}
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="nav navbar-nav am-nav-right">
                <li>
                    <a href="{{ route('app.get.dashboard.show') }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>
                @can('manage', \App\Models\User::class)
                    <li class="dropdown">
                        <a class="dropdown-toggle" aria-expanded="false" role="button" data-toggle="dropdown" href="#">
                            {{ __('Verwaltung') }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('app.management.get.user.index') }}">
                                    {{ __('Benutzer') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
            </ul>

            @if(\Auth::check())
            <ul class="nav navbar-nav navbar-right am-icons-nav">
                @include('partials.notifications')
            </ul>
            @endif
        </div>
    </div>
</nav>