/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var myLatlng = new google.maps.LatLng(46.797671, 8.236301);
var geocoder;
var marker;
var rayon= 500;
var nb_fontaines = 0;
var pos;
var map;
var monCercle;
var mode = 0;
function initialize(mode) 
{
    
//    // Try HTML5 geolocation
    if(navigator.geolocation) 
    {
//       
        navigator.geolocation.getCurrentPosition(function(position) 
        {
            var mapOptions = {
        center: myLatlng,
        zoom: 13,
        mapTypeId:google.maps.MapTypeId.HYBRID
    };
    
    map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
    geocoder = new google.maps.Geocoder();
    
    
    if(mode == 0)
    {
        rayon = document.getElementById("hidden_rayon").value;
        var array = recupere_lat_lng();
    }
            pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);

            map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
            geocoder = new google.maps.Geocoder();

            
            
            if(mode == 0)
            {
                rayon = document.getElementById("hidden_rayon").value;
                var array = recupere_lat_lng();
            }
            var pos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            
            var Localisation = new google.maps.Marker({
                map: map,
                position: pos,
                icon: "../../img/Marker.png"
            });
            
            map.setCenter(pos);
            
            if(mode == 0)
            {
                    monCercle = new google.maps.Circle({
                    map: map,
                    center: pos,
                    radius: parseInt(rayon)
                }); 
                
                initialise_tableau_marker(array, map, rayon, pos);
            }
            else if(mode == 1)
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
            else if(mode == 2)
            {
                var latlng_str = document.getElementById('hidden_latlng').value;
                
                var fontaine = new google.maps.LatLng(latlng_str.split(',')[0], latlng_str.split(',')[1]);
                
                marker = new google.maps.Marker({
                        position: fontaine,
                        map: map,
                        title	: "Fontaine a activer",
                        icon: "../../img/icon.png"
                    });
                    
                map.setCenter(fontaine);  
            }
                
            
            codeLatLng(pos, map, 1);
        
            
            
          
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
}
function handleNoGeolocation(errorFlag) {
    if (errorFlag) {
        var content = 'Error: Le service de geolocation a échoué.';
    } else {
        var content = 'Error: Votre navigateur ne sfonctionne pas avec la geolocation.';
    }
};
//
function codeLatLng(latlng, map, mode) 
{
    var infowindow = new google.maps.InfoWindow();

    geocoder.geocode({'latLng': latlng}, function(results, status) 
    {
        if (status == google.maps.GeocoderStatus.OK) 
        {
            if (results[1]) 
            {
                if(mode == 0)
                {
                    map.setZoom(11);
                    marker = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title	: "Fontaine",
                        icon: "../../img/icon.png"
                    });
                    infowindow.setContent(results[1].formatted_address);
                    infowindow.open(map, marker);
                }
                else
                {
                    map.setZoom(11);
                    var nom_rue = document.getElementById("nom_rue");
                    nom_rue.innerHTML = "Vous êtes à : " + results[1].formatted_address;
                }
            }
            else 
            {
                alert('No results found');
            }
        }
        else 
        {
            alert('Geocoder failed due to: ' + status);
        }
    });
}
