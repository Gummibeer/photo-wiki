var $body = jQuery('body');
var $modalWindow = jQuery('#modal-window');

jQuery(window).on('load', function () {
    loader().hide();
    $body.trigger('site.init');
});

function loader() {
    return jQuery('#site-loader');
}

$body.on('site.init', function() {
    $body.on('click', '[data-toggle-target]', function() {
        var $btn = jQuery(this);
        var $input = jQuery($btn.data('toggle-target'));
        if($input.length == 1) {
            var type = $input.attr('type');
            if (type == 'password') {
                $input.attr('type', 'text');
            } else {
                $input.attr('type', 'password');
            }
        }
    });

    var clipboard = new Clipboard('[data-clipboard-target]');
    clipboard.on('success', function(e) {
        var $trigger = jQuery(e.trigger);
        var $input = jQuery($trigger.data('clipboard-target'));
        var type = $input.attr('type');
        if(type == 'password') {
            clipboardFeedback($trigger, 'error', 'hidden');
        } else if(e.text == '') {
            clipboardFeedback($trigger, 'error', 'empty');
        } else {
            clipboardFeedback($trigger, 'success', 'copied');
        }

    });
    clipboard.on('error', function(e) {
        var $trigger = jQuery(e.trigger);
        clipboardFeedback($trigger, 'error', 'error');
    });

    function clipboardFeedback($trigger, type, text) {
        if(type == 'success') {
            $trigger.addClass('btn-success');
            $trigger.removeClass('btn-default');
            $trigger.removeClass('btn-danger');
        } else {
            $trigger.addClass('btn-danger');
            $trigger.removeClass('btn-default');
            $trigger.removeClass('btn-success');
        }
        $trigger.popover({
            content: text,
            placement: 'top'
        });
        $trigger.popover('show');
        setTimeout(function() {
            $trigger.popover('destroy');
            $trigger.addClass('btn-default');
            $trigger.removeClass('btn-danger');
            $trigger.removeClass('btn-success');
        }, 3000);
    }
});