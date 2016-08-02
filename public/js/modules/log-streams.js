var App = (function () {
    App.logStreams = function () {
        'use strict'

        var $logs = jQuery('.stream-log');
        $logs.each(function() {
            var $log = jQuery(this);
            var $container = $log.parents('.scroll-container');
            $container.animate({scrollTop: $container[0].scrollHeight}, 1000);
            setInterval(function() {
                if (!$log.is(':hover')) {
                    $log.load(APP_URL+'/project/log-stream/'+$log.data('project-id')+'/'+$log.data('server'), function() {
                        $container.animate({scrollTop: $container[0].scrollHeight}, 1000);
                    });
                }
            }, 2000);
        });
    };
    return App;
})(App || {});
