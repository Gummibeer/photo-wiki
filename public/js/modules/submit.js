var App = (function () {
    App.submit = function () {
        'use strict'

        function submitAjax() {
            $body.on('click', '.submit-ajax', function(e) {
                e.preventDefault();
                var $this = jQuery(this);
                var $form = $this.parents('form').first();
                if($form.length == 1) {
                    jQuery.ajax({
                        type: $form.attr('method'),
                        url: $form.attr('action'),
                        data: $form.serialize(),
                        beforeSend: function () {
                            $form.find('.alert').remove();
                        },
                        complete: function(data) {
                            if (typeof data == 'object' && typeof data.responseJSON == 'object') {
                                var $alerts = jQuery('<div/>');
                                jQuery.each(data.responseJSON, function (type, messages) {
                                    jQuery.each(messages, function (i, message) {
                                        var $alert = jQuery('<div/>')
                                            .addClass('alert')
                                            .addClass('alert-'+type)
                                            .text(message);
                                        $alert.appendTo($alerts);
                                    });
                                });
                                $form.prepend($alerts);
                                if(typeof window.LaravelDataTables == 'object') {
                                    jQuery.each(window.LaravelDataTables, function(key, datatable) {
                                        datatable.draw();
                                    });
                                }
                            }
                        }
                    });
                }
            });
        }

        submitAjax();

    };
    return App;
})(App || {});
