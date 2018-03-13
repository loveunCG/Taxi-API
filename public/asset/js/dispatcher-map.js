var destination_latitude=0, destination_longitude=0, source_latitude=0, source_longitude=0;

var map, mapMarkers = [];
var source, destination;

var s_input, d_input;
var s_latitude, s_longitude;
var d_latitude, d_longitude;
var distance;

function initMap() {
    window.Tranxit.map = true;
}

function createRideInitialize() {

    console.log('createRideInitialize');

    s_input = document.getElementById('s_address');
    d_input = document.getElementById('d_address');

    s_latitude = document.getElementById('s_latitude');
    s_longitude = document.getElementById('s_longitude');

    d_latitude = document.getElementById('d_latitude');
    d_longitude = document.getElementById('d_longitude');
    
    distance = document.getElementById('distance');

    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 2,
    });

    var autocomplete_source = new google.maps.places.Autocomplete(s_input);
    autocomplete_source.bindTo('bounds', map);

    var autocomplete_destination = new google.maps.places.Autocomplete(d_input);
    autocomplete_destination.bindTo('bounds', map);

    var service = new google.maps.places.PlacesService(map);
    var des_service = new google.maps.places.PlacesService(map);

    var marker = new google.maps.Marker({
        map: map,
        draggable: true,
        anchorPoint: new google.maps.Point(0, -29),
        icon: '/asset/img/marker-start.png'
    });

    var markerSecond = new google.maps.Marker({
        map: map,
        draggable: true,
        anchorPoint: new google.maps.Point(0, -29),
        icon: '/asset/img/marker-end.png'
    });

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});

    google.maps.event.addListener(map, 'click', updateMarker);
    google.maps.event.addListener(map, 'click', updateMarkerSecond);
    
    google.maps.event.addListener(marker, 'dragend', updateMarker);
    google.maps.event.addListener(markerSecond, 'dragend', updateMarkerSecond);

    autocomplete_source.addListener('place_changed', function(event) {
        marker.setVisible(false);
        var place = autocomplete_source.getPlace();

        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            updateSource(place.geometry.location);
        } else {
            service.textSearch({
                query: place.name
            }, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    console.log('Autocomplete Has No Property');
                    updateSource(results[0].geometry.location);
                    s_input.value = results[0].formatted_address;
                }
            });
        }
    });

    autocomplete_destination.addListener('place_changed', function(event) {
        markerSecond.setVisible(false);
        var place = autocomplete_destination.getPlace();

        if (place.hasOwnProperty('place_id')) {
            if (!place.geometry) {
                window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            updateDestination(place.geometry.location);
        } else {
            des_service.textSearch({
                query: place.name
            }, function(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    updateDestination(results[0].geometry.location);

                    console.log('destination', results[0]);
                    d_input.value = results[0].formatted_address;
                }
            });
        }
    });

    function updateSource(location) {
        map.panTo(location);
        marker.setPosition(location);
        marker.setVisible(true);
        map.setZoom(15);
        updateSourceForm(location.lat(), location.lng());
        if(destination != undefined) {
            updateRoute();
        }
    }

    function updateDestination(location) {
        map.panTo(location);
        markerSecond.setPosition(location);
        markerSecond.setVisible(true);
        updateDestinationForm(location.lat(), location.lng());
        updateRoute();
    }

    function updateRoute() {
        directionsDisplay.setMap(null);
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING,
            // unitSystem: google.maps.UnitSystem.IMPERIAL,
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);

                distance.value = result.routes[0].legs[0].distance.value / 1000;
            }
        });
    }

    function updateSourceForm(lat, lng) {
        s_latitude.value = lat;
        s_longitude.value = lng;

        source = new google.maps.LatLng(lat, lng);
    }

    function updateDestinationForm(lat, lng) {
        d_latitude.value = lat;
        d_longitude.value = lng;
        destination = new google.maps.LatLng(lat, lng);
    }

    function updateMarker(event) {

        marker.setVisible(true);
        marker.setPosition(event.latLng);

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': event.latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    s_input.value = results[0].formatted_address;
                    s_state.value = '';
                    s_country.value = '';
                    s_city.value = '';
                    s_pin.value = '';
                } else {
                    alert('No Address Found');
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });

        updateSource(event.latLng);
    }

    function updateMarkerSecond(event) {

        markerSecond.setVisible(true);
        markerSecond.setPosition(event.latLng);

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': event.latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    d_input.value = results[0].formatted_address;
                    d_state.value = '';
                    d_country.value = '';
                    d_city.value = '';
                    d_pin.value = '';
                } else {
                    alert('No Address Found');
                }
            } else {
                alert('Geocoder failed due to: ' + status);
            }
        });

        updateDestination(event.latLng);
    }
}

function ongoingInitialize(trip) {
    console.log('ongoingRidesInitialize', trip);
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 2,
    });

    var bounds = new google.maps.LatLngBounds();

    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        icon: '/asset/img/marker-start.png'
    });

    var markerSecond = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        icon: '/asset/img/marker-end.png'
    });

    source = new google.maps.LatLng(trip.s_latitude, trip.s_longitude);
    destination = new google.maps.LatLng(trip.d_latitude, trip.d_longitude);

    marker.setPosition(source);
    markerSecond.setPosition(destination);

    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
    directionsDisplay.setMap(map);

    directionsService.route({
        origin: source,
        destination: destination,
        travelMode: google.maps.TravelMode.DRIVING
    }, function(result, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(result);

            marker.setPosition(result.routes[0].legs[0].start_location);
            markerSecond.setPosition(result.routes[0].legs[0].end_location);
        }
    });

    if(trip.provider) {
        var markerProvider = new google.maps.Marker({
            map: map,
            icon: "/asset/img/marker-car.png",
            anchorPoint: new google.maps.Point(0, -29)
        });

        provider = new google.maps.LatLng(trip.provider.latitude, trip.provider.longitude);
        markerProvider.setVisible(true);
        markerProvider.setPosition(provider);
        console.log('Provider Bounds', markerProvider.getPosition());
        bounds.extend(markerProvider.getPosition());
    }
    bounds.extend(marker.getPosition());
    bounds.extend(markerSecond.getPosition());
    map.fitBounds(bounds);
}

function assignProviderShow(providers, trip) {
    console.log('assignProviderShow', trip, providers)

    var bounds = new google.maps.LatLngBounds();
    bounds.extend({lat: trip.s_latitude, lng: trip.s_longitude});
    bounds.extend({lat: trip.d_latitude, lng: trip.d_longitude});

    providers.forEach(function(provider) {
        var marker = new google.maps.Marker({
            position: {lat: provider.latitude, lng: provider.longitude},
            map: map,
            provider_id: provider.id,
            title: provider.first_name + " " + provider.last_name,
            icon: '/asset/img/marker-car.png'
        });

        var content = "<p>Name : "+provider.first_name+" "+provider.last_name+"</p>"+
                "<p>Rating : "+provider.rating+"</p>"+
                "<p>Service Type : "+provider.service.service_type.name+"</p>"+
                "<p>Car Model  : "+provider.service.service_type.name+"</p>"+
                "<a href='/dispatcher/dispatch/trips/"+trip.id+'/'+provider.id+"' class='btn btn-success'>Assign this Provider</a>";

        marker.infowindow = new google.maps.InfoWindow({
            content: content
        });

        marker.addListener('click', function(){ 
            marker.infowindow.open(map, marker);
        });

        bounds.extend(marker.getPosition());
        mapMarkers.push(marker);
        
    });

    map.fitBounds(bounds);
}

function assignProviderPopPicked(provider) {
    var index;
    for (var i = mapMarkers.length - 1; i >= 0; i--) {
        if(mapMarkers[i].provider_id == provider.id) {
            index = i;
        }
        mapMarkers[i].infowindow.close();
    }
    console.log('index', index);
    // mapMarkers[index].setPosition({lat: provider.latitude, lng: provider.longitude});
    mapMarkers[index].infowindow.open(map, mapMarkers[index]);
}

function worldMapInitialize(argument) {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 2,
    });
}