@extends('master')

@hasSection('aside')
    @section('body-class', 'app am-aside')
@else
    @section('body-class', 'app')
@endif


@section('layout')
    <div class="am-wrapper am-fixed-sidebar @yield('body-class')">
        @include('partials.navbar')
        @include('partials.menubar')
        @yield('pre-content')
        <div class="am-content @yield('content-class')">
            @hasSection('aside')
            <aside class="page-aside">
                <div class="am-scroller nano">
                    <div class="content nano-content">
                        @yield('aside')
                    </div>
                </div>
            </aside>
            @endif
            <div class="main-content padding-0">
                @yield('page-head')
                <div class="page-head clearfix">
                    <h2 class="pull-left margin-0">@yield('page-title')</h2>
                    <div class="pull-right">
                        <div class="btn-group">
                            @yield('page-actions')
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    @hasSection('page-description')
                        <p class="margin-0 margin-top-10">
                            @yield('page-description')
                        </p>
                    @endif
                </div>
                <div class="padding-35">
                    @foreach (\Alert::getMessages() as $type => $messages)
                        @foreach ($messages as $message)
                            <div class="alert alert-{{ $type }}">{!! $message !!}</div>
                        @endforeach
                    @endforeach
                    @yield('content')
                </div>
            </div>
        </div>
        @yield('post-content')
    </div>
@endsection
