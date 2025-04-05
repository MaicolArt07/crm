function initialize() {
    var newMarker = null;
    

    var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: -17.7833722, lng: -63.1822618},
        scrollwheel: false,
        zoom: 16
    });

    if ($('#direccion_m').length > 0) {
        newMarker = new google.maps.Marker({
            position: new google.maps.LatLng(40.6984237, -73.9890044),
            map: map,
            icon: new google.maps.MarkerImage(
                '../../../public/build/images/marker-blue.png',
                null,
                null,
                // new google.maps.Point(0,0),i
                null,
                new google.maps.Size(36, 36)
            ),
            draggable: true,
            animation: google.maps.Animation.DROP,
        });

        google.maps.event.addListener(newMarker, "mouseup", function (event) {
            var latitude = this.position.lat();
            var longitude = this.position.lng();
            $('#Coordenadas_m').text(this.position.lat() + ';' + this.position.lng());
        });

        google.maps.event.addListener(map, "click", function (e) {
            var latLng = e.latLng;

            $('#Coordenadas_m').val(latLng);
            newMarker.setMap(null);
            newMarker = new google.maps.Marker({
                position: new google.maps.LatLng(latLng.lat(), latLng.lng()),
                map: map,
                icon: new google.maps.MarkerImage(
                    '../../../public/build/images/marker-blue.png',
                    null,
                    null,
                    // new google.maps.Point(0,0),
                    null,
                    new google.maps.Size(36, 36)
                ),
                draggable: true,
                animation: google.maps.Animation.DROP,
            });

        });
    }
    if ($('#direccion_m').length > 0) {
        var address = document.getElementById('direccion_m');
        var addressAuto = new google.maps.places.Autocomplete(address);

        google.maps.event.addListener(addressAuto, 'place_changed', function () {
            var place = addressAuto.getPlace();

            if (!place.geometry) {
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
            }
            newMarker.setPosition(place.geometry.location);
            newMarker.setVisible(true);

            $('#Coordenadas_m').val(newMarker.getPosition().lat() + ';' + newMarker.getPosition().lng());
            return false;
        });
    }
}