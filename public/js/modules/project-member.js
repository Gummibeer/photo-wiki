var App = (function () {
    App.projectMember = function () {
        'use strict'

        var $dropzones = jQuery('.droppable');
        if($dropzones.length > 0) {
            $.fn.matchHeight._maintainScroll = true;
            $dropzones.matchHeight();

            jQuery('.list-group-item', $dropzones).draggable({
                revert: 'invalid',
                containment: 'document',
                helper: 'clone',
                cursor: 'move'
            });

            $dropzones.droppable({
                accept: '.droppable .list-group-item',
                drop: function (event, ui) {
                    var $element = ui.draggable;
                    var $target = jQuery(event.target);

                    var $row = $element.parents('.row').first();

                    var updateIcon = function ($icon, newClasses) {
                        $icon
                            .removeClass('icon-spin')
                            .removeClass(function (index, css) {
                                return (css.match(/(^|\s)wh-\S+/g) || []).join(' ');
                            })
                            .removeClass(function (index, css) {
                                return (css.match(/(^|\s)text-\S+/g) || []).join(' ');
                            })
                            .addClass(newClasses);
                    };

                    jQuery.ajax({
                        type: "POST",
                        url: APP_URL + '/project/member/' + $row.data('project-id'),
                        data: {
                            role_id: $target.data('role-id'),
                            user_id: $element.data('user-id')
                        },
                        beforeSend: function () {
                            updateIcon($element.find('.icon'), 'wh-loadingflowcw icon-spin text-info');
                        }
                    })
                        .done(function () {
                            $element.prependTo($target);
                            updateIcon($element.find('.icon'), 'wh-ok text-success');
                        })
                        .fail(function () {
                            updateIcon($element.find('.icon'), 'wh-remove text-danger');
                        })
                        .always(function () {
                            setTimeout(function () {
                                updateIcon($element.find('.icon'), 'wh-save-floppy text-muted');
                            }, 3000);
                            $.fn.matchHeight._update()
                        });
                }
            });
        }

    };
    return App;
})(App || {});
