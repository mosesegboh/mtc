
google.maps.event.addDomListener(window, 'load', initAutocomplete);


function initAutocomplete() {
    var geocoder;
    // var map;
    var location = { lat: -33.8688, lng: 151.2195 }

    const map = new google.maps.Map(document.getElementById("map"), {
        center: location,
        zoom: 9,
        mapTypeId: "roadmap",
      });
     
      geocoder = new google.maps.Geocoder(map);
      
  }

  function codeAddress() {
    var address = document.getElementById('addressSearch').value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
    }

//   function to geocode an address and plot it on a map
