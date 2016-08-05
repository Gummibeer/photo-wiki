var App = (function () {
    App.inputs = function () {
        'use strict'

        function datepicker() {
            jQuery('input.datepicker')
                .bootstrapMaterialDatePicker(
                    jQuery.extend(DATEPICKER_OPTIONS, {
                        date: true,
                        time: false
                    })
                );
        }

        function datetimepicker() {
            jQuery('input.datetimepicker')
                .bootstrapMaterialDatePicker(
                    jQuery.extend(DATEPICKER_OPTIONS, {
                        date: true,
                        time: true
                    })
                );
        }

        function tokenfield() {
            jQuery('input.tokenfield').each(function() {
                var $this = jQuery(this);
                var engine = new Bloodhound({
                    local: $this.data('source'),
                    datumTokenizer: Bloodhound.tokenizers.whitespace,
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });

                engine.initialize();

                $this.tokenfield({
                    typeahead: [null, { source: engine.ttAdapter() }]
                });
            });
        }

        function clipboard() {
            var $inputs = jQuery('input.copyable');
            $inputs.each(function() {
                var $input = jQuery(this);
                var $container = $input.parent('div');
                if($container.length == 1) {
                    $container.addClass('input-group');
                    var $addon = jQuery('<span/>')
                        .addClass('input-group-btn');
                    var $btn = jQuery('<span/>')
                        .addClass('btn')
                        .addClass('btn-default')
                        .attr('data-clipboard-target', '#'+$input.attr('id'));
                    var $icon = jQuery('<i/>')
                        .addClass('icon')
                        .addClass('wh-copy');
                    $addon.append($btn.append($icon));
                    $addon.insertAfter($input);
                    $input.removeClass('copyable');
                }
            });
        }

        function hideable()
        {
            var $inputs = jQuery('input.hideable');
            $inputs.each(function() {
                var $input = jQuery(this);
                var $container = $input.parent('div');
                if($container.length == 1) {
                    $container.addClass('input-group');
                    var $addon = jQuery('<span/>')
                        .addClass('input-group-btn');
                    var $btn = jQuery('<span/>')
                        .addClass('btn')
                        .addClass('btn-default')
                        .attr('data-toggle-target', '#'+$input.attr('id'));
                    var $icon = jQuery('<i/>')
                        .addClass('icon')
                        .addClass('wh-eye-view');
                    $addon.append($btn.append($icon));
                    $addon.insertBefore($input);
                    $input.removeClass('hideable');
                    $input.attr('type', 'password');
                }
            });
        }

        function generatePass() {
            jQuery('input[data-character-set]').each(function(){
                var $input = jQuery(this);
                $input.val(randString($input));
                $input.on('focus', function () {
                    $input.select();
                });
                $input.parent('.input-group').find('.pass-generate').click(function(){
                    var $input = $(this).parents('.input-group').find('.pass-input');
                    $input.val(randString($input));
                });
            });
        }

        function randString($input){
            var dataSet = $input.data('character-set').split(',');
            var length = $input.parent('.input-group').find('.pass-length').val();
            var possible = '';
            if($.inArray('a-z', dataSet) >= 0){
                possible += 'abcdefghijklmnopqrstuvwxyz';
            }
            if($.inArray('A-Z', dataSet) >= 0){
                possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }
            if($.inArray('0-9', dataSet) >= 0){
                possible += '0123456789';
            }
            if($.inArray('_', dataSet) >= 0){
                possible += '_-@#=$!.:+*';
            }
            if($.inArray('~', dataSet) >= 0){
                possible += '[]{}()%&^<>~|';
            }
            var text = '';
            for(var i=0; i < length; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            return text;
        }

        function writable() {
            jQuery('input.writable').on('click', function() {
                jQuery(this).prop('readonly', false);
            });
        }

        function codeEditor() {
            var $codeEditors = jQuery('textarea.code-editor');
            if($codeEditors.length > 0) {
                $codeEditors.each(function () {
                    var $this = jQuery(this);
                    var $form = $this.parents('form');
                    var name = $this.attr('name');
                    var mode = 'ace/mode/php';
                    if ( $this.data( 'mode' ) == 'php-inline' ) {
                        mode = {path:'ace/mode/php', inline:true};
                    } else {
                        mode = 'ace/mode/' + $this.data( 'mode' );
                    }
                    var aceeditor = ace.edit(this);
                    aceeditor.setTheme('ace/theme/monokai');
                    aceeditor.getSession().setMode(mode);
                    aceeditor.setOptions({
                        maxLines: 100
                    });
                    aceeditor.getSession().setValue($this.val());

                    var $input = jQuery('<input/>');
                    $input
                        .attr('type', 'hidden')
                        .attr('name', name)
                        .val($this.val());

                    console.log($input);
                    $input = $input.appendTo($form);
                    console.log($input, $form);

                    aceeditor.getSession().on('change', function () {
                        $input.val(aceeditor.getSession().getValue());
                    });
                    $form.on('submit', function() {
                        $input.val(aceeditor.getSession().getValue());
                    });
                });
            }
        }

        function placesearch() {
            var $placeSearches = jQuery('input.place-search');
            if($placeSearches.length > 0) {
                $placeSearches.each(function(i) {
                    var $placeSearch = jQuery(this);
                    $placeSearch.attr('id', 'place-search-'+i);
                    places({
                        container: document.querySelector('#'+$placeSearch.attr('id'))
                    });
                });
            }
        }

        datepicker();
        datetimepicker();
        tokenfield();
        clipboard();
        hideable();
        generatePass();
        writable();
        codeEditor();
        placesearch();

    };
    return App;
})(App || {});
