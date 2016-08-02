<div class="modal fade-in show" id="modal">
    <div class="modal-dialog modal-center">
        <div class="modal-content @yield('modal-class')">
            @if(array_key_exists('title', View::getSections()))
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">@yield('title')</h4>
                </div>
            @endif
            @yield('alert')
            @yield('ribbon')
            @if(array_key_exists('content', View::getSections()))
                <div class="modal-body">
                    @yield('content')
                </div>
            @endif
            @if(array_key_exists('footer', View::getSections()))
                <div class="modal-footer">
                    @yield('footer')
                </div>
            @endif
        </div>
    </div>
</div>
