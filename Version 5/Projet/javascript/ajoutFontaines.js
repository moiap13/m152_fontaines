/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function set_lat_lng_input(latlng)
{
    var _lat = latlng.lat();
    var _lng = latlng.lng();
    
    var tbx_tmp_lat = document.getElementById("tbx_tmp_lat");
    var tbx_tmp_lng = document.getElementById("tbx_tmp_lng");
    var tbx_lat = document.getElementById("tbx_lat");
    var tbx_lng = document.getElementById("tbx_lng");
    
    tbx_tmp_lat.value = _lat;
    tbx_lat.value = _lat;
    
    tbx_tmp_lng.value = _lng;
    tbx_lng.value = _lng;
}

function tbx_changed_value()
{
    var _lat;
    var _lng;
    
    var tbx_tmp_lat = document.getElementById("tbx_tmp_lat");
    var tbx_tmp_lng = document.getElementById("tbx_tmp_lng");
    var tbx_lat = document.getElementById("tbx_lat");
    var tbx_lng = document.getElementById("tbx_lng");
    
    _lat = tbx_tmp_lat.value;
    _lng = tbx_tmp_lng.value;
    var pos = new google.maps.LatLng(_lat,_lng);
    
    var mapOptions = {
        center: pos,
        zoom: 13,
        mapTypeId:google.maps.MapTypeId.HYBRID
    };
    var map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
    
    
    
    var fontaine_tmp = new google.maps.Marker({
        map: map,
        position: pos,
        title	: "Fontaine",
        icon: "../../img/icon.png"
    });
    
    tbx_lat.value = _lat;
    tbx_lng.value = _lng;
}

$(window).load(function(){
    initialize(1);
});