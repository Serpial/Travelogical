function initMap() {
    // Place is set as global in the DOM
    var livingstoneTower = {lat:55.860983, lng: -4.243554};
    var bounds = new google.maps.LatLngBounds();
    var directionsRenderer = new google.maps.DirectionsRenderer;
    var directionsService = new google.maps.DirectionsService;
    var map = new google.maps.Map(document.getElementById("map-view"), {
        center: livingstoneTower,
        disableDefaultUI: true,
        gestureHandling: "none"
    });


    if (place1 != null && place2 != null && distance[1] > 0) {
        // Set the center of the map based off of the two marks
        map.setCenter(findNewCenter(place1, place2));

        // Resize the map to include markers
        bounds.extend(new google.maps.LatLng(place1.lat, place1.lng));
        bounds.extend(new google.maps.LatLng(place2.lat, place2.lng));
        map.fitBounds(bounds);

        // Use directions API to draw a route between the two places.
        directionsRenderer.setMap(map);
        addRouteToMap(directionsService, directionsRenderer);
    } else {
        map.setZoom(12);
    }
}

function addRouteToMap(directionsService, directionsRenderer) {
    directionsService.route({
        origin: place1,
        destination: place2,
        travelMode: google.maps.TravelMode["DRIVING"]
    }, function(response, status) {
        if (status == 'OK') {
            console.log(status);
            directionsRenderer.setDirections(response);
        } else {
            console.log(status);
        }
    });
}

function findNewCenter(place1, place2) {
    var newLat, newLng;

    newLat = (place1.lat + place2.lat)/2;
    newLng = (place1.lng + place2.lng)/2;

    return {lat:newLat, lng:newLng};
}