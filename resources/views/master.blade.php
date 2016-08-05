<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">

    <title>@yield('head-title') | {{ config('app.name') }}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/whhg.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/nanoscroller.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/fullcalendar.min.css') }}"/>
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet" />
    @stack('head-styles')

    @stack('head-scripts')
    <script type="application/javascript">
        var BASE_URL = "{{ url('/') }}";
        var APP_URL = "{{ url('app') }}";
        var DATEPICKER_DEFAULT_OPTIONS = {
            weekStart: {{ trans('helpers.weekstart') }},
            cancelText: "{{ __('schließen') }}",
            okText: "{{ __('ok') }}",
            clearText: "{{ __('zurücksetzen') }}",
            nowText: "{{ __('jetzt') }}",
            lang: "{{ getUserLanguage() }}"
        };
        var DATEPICKER_OPTIONS = DATEPICKER_DEFAULT_OPTIONS;
        DATEPICKER_OPTIONS.format = "{{ trans('helpers.dateformat.js') }}";
        var DATETIMEPICKER_OPTIONS = DATEPICKER_DEFAULT_OPTIONS;
        DATETIMEPICKER_OPTIONS.format = "{{ trans('helpers.datetimeformat.js') }}";
    </script>
    <!--[if lt IE 9]>
        <script src="{{ asset('js/libs/html5shiv.min.js') }}"></script>
        <script src="{{ asset('js/libs/respond.min.js') }}"></script>
    <![endif]-->
</head>
<body class="@yield('body-class')">
    @include('google_analytics')

    @yield('layout')

    <div id="modal-window"></div>

    <script src="{{ asset('js/libs/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery.nanoscroller.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery.masonry.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery.datetimepicker.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/typeahead.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/bootstrap-tokenfield.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/clipboard.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/jquery.matchHeight.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/fullcalendar.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/fullcalendar.de.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/gmaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/algoliasearchLite.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/autocomplete.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/algolia-places.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/libs/ace/ace.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/ace/theme-monokai.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/ace/mode-php.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/libs/ace/mode-yaml.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modules/masonry.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modules/inputs.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modules/gmaps.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/modules/algolia.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.main.js') }}" type="text/javascript"></script>

    @stack('foot-scripts')

    <script type="text/javascript">
        jQuery(window).on('load', function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
            });
            App.init();
            App.masonry();
            App.inputs();
            App.gmaps();
            App.algolia();
        });
    </script>
</body>
</html>