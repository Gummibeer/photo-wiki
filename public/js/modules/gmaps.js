var App = (function () {
    App.gmaps = function () {
        'use strict'

        var $gmaps = jQuery('.gmap');
        if($gmaps.length > 0) {
            $gmaps.each(function(i) {
                var $gmap = jQuery(this);
                $gmap.attr('id', 'gmaps-'+i);
                var gmap = new GMaps({
                    div: '#'+$gmap.attr('id'),
                    lat: $gmap.data('lat'),
                    lng: $gmap.data('lng')
                });

                gmap.addMarker({
                    lat: $gmap.data('lat'),
                    lng: $gmap.data('lng'),
                    title: $gmap.data('name'),
                    infoWindow: {
                        content: '<p><strong>'+$gmap.data('name')+'</strong><br/><span>'+$gmap.data('location')+'</span></p>'
                    }
                });
            });
        }

    };
    return App;
})(App || {});