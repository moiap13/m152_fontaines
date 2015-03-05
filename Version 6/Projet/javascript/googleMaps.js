/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var myLatlng = new google.maps.LatLng(76.797671, 48.236301);

var markerArray = new Array();
var infoWinArray = new Array();
var rayon= 500;
var nb_fontaines = 0;
var pos = new google.maps.LatLng();
var map;
var monCercle;
var mode = 0;
var DEF_ZOOM = 13;
/**
 * Instancie une nouvelle map en positionnant un marker sur la position courante du user
 * @param {type} position
 * @returns {google.maps.Map}
 */
function instantiateMapWithCurrentPos(position)  {
    
    pos =  new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
    var mapOptions = {
        center: pos,
        zoom: DEF_ZOOM,
        mapTypeId:google.maps.MapTypeId.HYBRID
        };

    //instanciation de la map
    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

    //marker sur notre position
     var markerCurrentPosition = new google.maps.Marker({
        map: map,
        position: pos,
        icon: "../../img/Marker.png"
    });
    return map;
}


function initialize(mode) 
{

    // Try HTML5 geolocation
    if(navigator.geolocation) 
    {
        navigator.geolocation.getCurrentPosition(function(position) 
        {          
            map = instantiateMapWithCurrentPos(position) ;
         
            if(mode === 0)
            {
                rayon = document.getElementById("hidden_rayon").value;
                array = recupere_lat_lng();
         
                monCercle = new google.maps.Circle({
                    map: map,
                    center: pos,
                    radius: parseInt(rayon)
                }); 
                
                affiche_tableau_marker(array, map, rayon, pos);
               
            }
            else if(mode === 1)
            {
                set_lat_lng_input(pos);
                
                google.maps.event.addListener(map, 'click', function(event) {
                    var click_latlng = event.latLng;
                    set_lat_lng_input(click_latlng);
                    fontaine_tmp.setMap(null);
                    tbx_changed_value();
                    
                });
                
                
                tbx_changed_value();
            }
            else if(mode === 2)
            {
                var latlng_str = document.getElementById('hidden_latlng').value;
                
                var fontaine = new google.maps.LatLng(latlng_str.split(',')[0], latlng_str.split(',')[1]);
                
                var selectedMarker = new google.maps.Marker({
                        position: fontaine,
                        map: map,
                        title	: "Fontaine a activer",
                        icon: "../../img/icon.png"
                    });
                    
                map.setCenter(fontaine);  
            }
            
            
           // codeLatLng(pos, map, 1);
            getAdressFromLatLngAndCreateMarker(pos,1);
            
            
          
        }, function(err) 
        {
            console.log( err.code + " " + err.message);
            handleNoGeolocation(true);
        });
//        
//        
    }
    else 
    {
        // Browser doesn't support Geolocation
        handleNoGeolocation(false);
    }
//    
}

function changeRayon(){
    rayon = document.getElementById("rayon_range").value;
    monCercle.setMap(null);
    monCercle = new google.maps.Circle({
                    map: map,
                    center: pos,
                    radius: parseInt(rayon)
                }); 
   removeMarkersFromMap();
   nb_fontaines = 0;
   affiche_tableau_marker(array, map, rayon, pos);             
}
function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: Le service de geolocation a échoué.';
    } else {
        var content = 'Error: Votre navigateur ne sfonctionne pas avec la geolocation.';
    }
};
/**
 * 
 * @param {type} latlng
 * @param {type} mode si 0 alors on place les markers de la fontaine
 * @returns {undefined}
 */
function getAdressFromLatLngAndCreateMarker(latlng,id_fontaine, photo, nom_photo, mode){
        var geocoder = new google.maps.Geocoder();
        var adresse = "Adresse inconnue";
        geocoder.geocode({'latLng': latlng}, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) 
        {
            if (results[1]) 
            {
                adresse = results[1].formatted_address;
            }
        } else 
        {
            adresse = 'Geocoder failed due to: ' + status;
        }
     
        
        //si on place les markers de fontaine sur la map, alors on set leur infowindow avec l'adresse
        //TODO : code à repenser!
        if(mode==0){
            showFontaineMarker(latlng, adresse, id_fontaine, photo, nom_photo);
        } else {
               //montre notre adresse courante dans la div sous la map
            var nom_rue = document.getElementById("nom_rue");
            nom_rue.innerHTML = "Vous êtes à : " + adresse;
        }
        
    });
    
}

function showFontaineMarker(latlng, adresse, id_fontaine, photo, nom_photo){
    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
            position: latlng,
            map: map,
            title	: "Fontaine",
            icon: "../../img/icon.png"
        });
        
    console.log(nom_photo);
    
    if(photo == 1)
    {
        var image = '<img src="../../img/Fontaines/' + id_fontaine + '/' + nom_photo + '" width="100" height="100" />';
    }
    else
    {
        var image = '';
    }
    
    console.log(image);
    
    
    
    google.maps.event.addListener(marker, 'click', function () {
        // where I have added .html to the marker object.
        infowindow.setContent(image + adresse);
        infowindow.open(map, marker);
        calcRoute(latlng);
        });

     
    markerArray.push(marker);
    infoWinArray.push(infowindow);
}


function calcRoute(destination) {
   directionsDisplay = new google.maps.DirectionsRenderer();
   directionsDisplay.setMap(map);
   directionsService = new google.maps.DirectionsService();
    
   current_pos = pos;
   end_pos = destination;
   var request = {
      origin:current_pos,
      destination:end_pos,
      travelMode: google.maps.TravelMode.WALKING
   };
   directionsService.route(request, function(result, status) {
    
      if (status == google.maps.DirectionsStatus.OK) {
         directionsDisplay.setDirections(result);
      }
   });
}