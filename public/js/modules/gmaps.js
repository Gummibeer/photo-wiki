var App = (function () {
    App.gmaps = function () {
        'use strict'
        
        function singleMap() {
            var $singleMaps = jQuery('.gmap-single');
            if($singleMaps.length > 0) {
                $singleMaps.each(function(i) {
                    var $gmap = jQuery(this);
                    $gmap.attr('id', 'gmaps-single-'+i);
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
        }

        function collectionMap() {
            var $gmap = jQuery('#gmap-collection');
            if($gmap.length == 1) {
                var gmap = new GMaps({
                    div: '#'+$gmap.attr('id'),
                    lat: 0,
                    lng: 0
                });
                var markers = {};
                var markerBounds = [];

                var events = $gmap.data('events');
                jQuery.each(events, function(i, event) {
                    var coordinates = new google.maps.LatLng(event.lat, event.lng);
                    var key = coordinates.toString();
                    var content = '<p><strong>'+event.display_name+'</strong><br/><span>'+event.location+'</span></p>';
                    if(markers[key] === undefined) {
                        markers[key] = {};
                        markers[key].coordinates = coordinates;
                        markers[key].content = content;
                        markers[key].calendar = event.calendar.name;
                    } else {
                        markers[key].content += content;
                    }
                });

                jQuery.each(markers, function(i, marker) {
                    var icon = {
                        url: BASE_URL + '/img/icons/map/'+marker.calendar+'.png',
                        size: new google.maps.Size(32, 37),
                        anchor: new google.maps.Point(16, 37)
                    };

                    gmap.addMarker({
                        position: marker.coordinates,
                        icon: icon,
                        infoWindow: {
                            content: marker.content
                        }
                    });
                    markerBounds.push(marker.coordinates);
                });

                gmap.fitLatLngBounds(markerBounds);
            }
        }

        singleMap();
        collectionMap();

    };
    return App;
})(App || {});