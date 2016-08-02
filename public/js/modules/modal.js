var App = (function () {
    App.modal = function () {
        'use strict'

        function loadByHref() {
            $body.on('click', '.load-modal-href', function (e) {
                e.preventDefault();
                var $this = jQuery(this);
                loader().show();
                $modalWindow.load($this.attr('href'), function (response, status, xhr) {
                    if (status == 'error') {
                        $modalWindow.html('ERROR');
                    }
                    loader().hide();
                    $modalWindow.modal({
                        backdrop: 'static',
                        show: true,
                        keyboard: false
                    });
                    App.inputs();
                });
            });
        }

        loadByHref();

    };
    return App;
})(App || {});
