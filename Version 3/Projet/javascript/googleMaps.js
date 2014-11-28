/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var myLatlng = new google.maps.LatLng(-34.397,150.644);

function initialize() {
        var mapOptions = {
          center: myLatlng,
          zoom: 13,
          mapTypeId:google.maps.MapTypeId.HYBRID
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);

        // Try HTML5 geolocation
          if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              var pos = new google.maps.LatLng(position.coords.latitude,
                                               position.coords.longitude);

              var infowindow = new google.maps.InfoWindow({
                map: map,
                position: pos,
                content: 'Votre position'
              });

              map.setCenter(pos);
              place_marker(pos, 'test', map);
            }, function(err) {
                console.log( err.code + " " + err.message);
              handleNoGeolocation(true);
            });
          } else {
            // Browser doesn't support Geolocation
            handleNoGeolocation(false);
          }
        }

        function handleNoGeolocation(errorFlag) {
          if (errorFlag) {
            var content = 'Error: Le service de geolocation a échoué.';
          } else {
            var content = 'Error: Votre navigateur ne sfonctionne pas avec la geolocation.';
          }

};
      
      
   google.maps.event.addDomListener(window, 'load', initialize);

function place_marker(pos, title, map) {
    // Placement du marqueur 
    var marker = new google.maps.Marker({
        position: pos,
        map: map,
        title: title,
        icon: "../../img/icon.png"
    });
} 