var App = (function () {
    App.algolia = function () {
        'use strict'

        var client = algoliasearch('PE5V9II3FP', 'c6f70ed1d53656559ae308fe4e5e4690');

        var $eventSearch = jQuery('#autocomplete-events');

        function events() {
            var index = client.initIndex('events');
            var dataset = {
                source: $.fn.autocomplete.sources.hits(index, {hitsPerPage: 5}),
                displayKey: 'display_name',
                name: 'events',
                templates: {
                    header: '<div class="ad-header">Events</div>',
                    suggestion: function(suggestion) {
                        var template =  '<div class="ad-suggestion"><div>';
                        template += suggestion._highlightResult.display_name.value;
                        if(suggestion._highlightResult.location != undefined) {
                            template += '<br /><small>' + suggestion._highlightResult.location.value + '</small>';
                        }
                        template += '</div></div>';
                        return template;
                    },
                    footer: '<div class="ap-footer">Built by <a href="https://www.algolia.com/places" title="Search by Algolia" class="ap-footer-algolia"><svg xmlns="http://www.w3.org/2000/svg" width="38" height="12" viewBox="0 0 38 12"><g fill="none" fill-rule="evenodd"><path fill="#00B7E5" d="M22.76 4.317l-.5 1.794 1.607-.89c-.234-.43-.63-.76-1.107-.9zM18.825 6.15c0 1.92 1.53 3.48 3.423 3.48 1.89 0 3.424-1.563 3.424-3.485s-1.533-3.478-3.424-3.478c-1.892 0-3.424 1.556-3.424 3.478v.004zm3.423-2.487c1.348 0 2.446 1.115 2.446 2.484 0 1.37-1.1 2.487-2.448 2.487-1.347 0-2.444-1.116-2.444-2.485 0-1.38 1.097-2.49 2.448-2.49h-.002zm1.18-1.427c0-.02.004-.032.004-.045v-.31c0-.34-.275-.63-.614-.63h-1.075c-.34 0-.614.28-.614.63v.31c.34-.1.7-.15 1.07-.15.43 0 .84.07 1.22.21v.01zm-3.754.61c-.24-.244-.63-.244-.868 0l-.11.11c-.24.243-.24.64 0 .885l.115.12c.25-.4.57-.75.93-1.05l-.06-.06v.01z"></path><path fill="#2B395C" d="M6.687 9.28c-.142-.362-.274-.72-.397-1.07l-.385-1.07H2.03l-.78 2.14H0c.33-.886.64-1.706.927-2.46.29-.753.57-1.468.846-2.145.278-.68.554-1.322.824-1.938.273-.616.556-1.227.855-1.837h1.1c.294.604.58 1.213.85 1.83.273.616.546 1.26.823 1.94.275.67.558 1.387.847 2.14.288.753.597 1.57.927 2.455H6.68l-.002-.007v.023zM5.56 6.176c-.265-.702-.525-1.38-.784-2.036-.258-.66-.527-1.29-.81-1.894-.29.608-.558 1.238-.822 1.895-.255.66-.513 1.34-.77 2.04H5.56zM11.266 9.7c-.705-.018-1.205-.17-1.5-.454-.295-.285-.442-.733-.442-1.336V.266L10.47.07v7.657c0 .187.014.342.046.465.033.122.086.22.16.295.076.072.18.13.3.164.125.04.28.07.46.1l-.16.96h-.01zm5.273-.92c-.1.067-.29.15-.57.25-.28.103-.61.152-.99.152s-.75-.058-1.09-.18c-.34-.123-.64-.312-.89-.57-.25-.255-.45-.577-.6-.957-.15-.38-.22-.84-.22-1.366 0-.47.07-.9.203-1.28.14-.39.345-.73.61-1 .26-.29.582-.51.97-.66.38-.16.81-.24 1.292-.24.525 0 .985.03 1.39.11.39.07.723.15.993.22v5.67c0 .97-.26 1.69-.76 2.12-.51.44-1.275.66-2.3.66-.4 0-.777-.04-1.13-.1-.36-.06-.66-.14-.925-.23l.207-.99c.223.09.504.17.833.23.33.07.676.11 1.03.11.67 0 1.16-.13 1.457-.4.3-.27.45-.7.45-1.29v-.28h.006zm-.47-4.805c-.19-.03-.45-.043-.78-.043-.61 0-1.08.2-1.41.6-.33.397-.49.927-.49 1.585 0 .367.04.68.14.942.09.26.22.48.38.64.16.17.34.3.54.38.21.08.42.12.64.12.3 0 .57-.04.83-.13.25-.08.45-.18.59-.29V4.07c-.11-.032-.26-.062-.46-.09l-.01-.005zM28.45 9.7c-.702-.018-1.206-.17-1.498-.454-.296-.285-.44-.733-.44-1.336V.266l1.15-.196v7.657c0 .187.013.342.05.465.036.122.087.22.153.292.074.078.177.13.3.168.125.04.28.07.46.092l-.16.956h-.014zm2.265-8.173c-.234 0-.43-.07-.59-.207-.17-.14-.25-.324-.25-.557 0-.234.08-.42.25-.558.16-.13.36-.204.593-.204.235 0 .43.08.6.21.16.14.25.33.25.57 0 .24-.08.43-.247.56-.16.14-.36.21-.59.21v-.01zm-.636 1.175h1.3v6.51h-1.3V2.7zm5.3-.19c.47 0 .85.063 1.18.19.32.126.57.304.77.535.19.225.33.5.41.822.08.31.12.66.12 1.05v4.25l-.42.07c-.18.03-.39.06-.61.09-.216.03-.465.05-.73.07-.26.02-.52.03-.78.03-.365 0-.7-.04-1.01-.12-.31-.08-.57-.21-.797-.37-.22-.17-.394-.4-.52-.68s-.19-.62-.19-1.01c0-.38.074-.7.22-.97.145-.27.34-.49.59-.65.253-.16.543-.29.876-.37.33-.07.68-.12 1.043-.12.12 0 .24.01.37.02l.35.05.292.06.17.04v-.34c0-.2-.02-.4-.06-.6-.05-.2-.12-.37-.23-.53-.11-.15-.26-.27-.44-.363-.198-.09-.44-.14-.737-.14-.38 0-.72.032-1 .09-.288.055-.507.114-.646.18l-.122-1c.15-.074.4-.14.75-.205.344-.07.724-.11 1.133-.11h.002v-.01zm.1 6.098c.28 0 .52-.01.73-.02.21-.01.39-.036.52-.07V6.49c-.08-.045-.22-.08-.41-.112-.19-.03-.42-.046-.68-.046-.17 0-.36.013-.55.04-.19.026-.37.08-.54.163-.16.084-.3.196-.4.34-.11.144-.17.334-.17.57 0 .436.14.738.4.908.265.168.63.256 1.09.256h-.006z"></path></g></svg></a></div>'
                }
            };
            $eventSearch.autocomplete({
                hint: false,
                debug: false,
                cssClasses: {prefix: 'ad'}
            }, [
                dataset
            ]).on('autocomplete:selected', function(event, suggestion, datasetName) {
                if(suggestion != undefined) {
                    calendar.fn.loadEventModal(suggestion.id);
                }
            });
        }

        if($eventSearch.length == 1) {
            events();
        }

    };
    return App;
})(App || {});