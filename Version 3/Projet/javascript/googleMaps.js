/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var myLatlng = new google.maps.LatLng(-34.397,150.644);
var rayon=3000;
function include(fileName){
document.write("<script type='text/javascript' src='"+fileName+"'></script>" );
}

include("afficheFontaines.js");

function initialize() {
        var mapOptions = {
          center: myLatlng,
          zoom: 13,
          mapTypeId:google.maps.MapTypeId.HYBRID
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
        var array = recupere_lat_lng();
        

        // Try HTML5 geolocation
        if(navigator.geolocation) {

        
            navigator.geolocation.getCurrentPosition(function(position) {
            var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            initialise_tableau_marker(array, map, rayon, pos);
            var Localisation = new google.maps.Marker({
              map: map,
              position: pos,
              //content: 'Votre position',
              icon: "../../img/Marker.png"

            });
            
            var monCercle = new google.maps.Circle({
                    map: map,
                    center: pos,
                    radius: rayon
                        
            });

              map.setCenter(pos);
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



     
function recupere_lat_lng()
{
    var hidden_nb_items = document.getElementById("nb_items");
    var nb_items = hidden_nb_items.value;
    var array = new Array();
    
    
    for(var i=0;i<nb_items;i++)
    {
        var hidden_items_lat = document.getElementById("lat_" + i);
        var hidden_items_lng = document.getElementById("lng_" + i);
        var lat = hidden_items_lat.value;
        var lng = hidden_items_lng.value;
        
        array[i] = new Array();
        array[i].push(lat);
        array[i].push(lng);
    }
        
    return array;
}
function initialise_tableau_marker(array, map, _rayon, point_localisation)
{
    for(var i =0; i<array.length;i++)
    {
        var latlng = new google.maps.LatLng(array[i][0], array[i][1]);
        
        var distance = google.maps.geometry.spherical.computeDistanceBetween(point_localisation, latlng);
        
        if(distance <= _rayon)
        {
            var myMarker = new google.maps.Marker(
            {
                position    : new google.maps.LatLng(array[i][0],array[i][1]), 
                Map         : map, 
                title	: "Fontaine",
                icon: "../../img/icon.png"
            });
        }
    }
    
    

}
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