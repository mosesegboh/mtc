google.maps.event.addDomListener(window, 'load', initAutocomplete);

function initAutocomplete() {
    const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: -33.8688, lng: 151.2195 },
        zoom: 13,
        mapTypeId: "roadmap",
    });
    // Create the search box and link it to the UI element.
    const input = document.getElementById("addressSearch");
    const searchList = document.getElementById("addressList")
    const searchBox = new google.maps.places.SearchBox(input);
   
    // Bias the SearchBox results towards current map's viewport.
    map.addListener("bounds_changed", () => {
        searchBox.setBounds(map.getBounds());
    });

    let markers = [];

    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener("places_changed", () => {
    const places = searchBox.getPlaces();

    if (places.length == 0) {
    return;
    }

    // Clear out the old markers.
    markers.forEach((marker) => {  
    marker.setMap(null);

    });
    markers = [];

    // For each place, get the icon, name and location.
    const bounds = new google.maps.LatLngBounds();

    places.forEach((place) => {
    if (!place.geometry || !place.geometry.location) {
        console.log("Returned place contains no geometry");
        return;
    }

    const icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25),
    };

    var marker =   new google.maps.Marker({
        map,
        icon,
        title: place.name,
        position: place.geometry.location,
        })

    var infoWindow = new google.maps.InfoWindow({
        content:`<div><h5>${place.name} </h5> <p>${place.geometry.location}</p></div> `
    })
        
    // Create a marker for each place.
    markers.push(
        new google.maps.Marker({
        map,
        icon,
        title: place.name,
        position: place.geometry.location,
        })
    );

    markers[0].addListener('click', function(){
        infoWindow.open(map,markers[0])
    })
            
    if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
    } else {
        bounds.extend(place.geometry.location);
    }
    });

    map.fitBounds(bounds);
    });   
}
