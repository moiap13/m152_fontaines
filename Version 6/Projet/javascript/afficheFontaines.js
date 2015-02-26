/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function recupere_lat_lng()
{
    var hidden_nb_items = document.getElementById("nb_items");
    var nb_items = hidden_nb_items.value;
    var array = new Array();
    
    
    for(var i=0;i<nb_items;i++)
    {
        var hidden_items_id = document.getElementById("id_fontaine_" + i);
        var hidden_items_lng = document.getElementById("lng_" + i);
        var hidden_items_lat = document.getElementById("lat_" + i);
        var hidden_items_photo = document.getElementById("photo_fontaine_" + i);
        var hidden_items_nom_photo = document.getElementById("nom_photo_" + i);
        
        var id = hidden_items_id.value;
        var lng = hidden_items_lng.value;
        var lat = hidden_items_lat.value;
        var photo = hidden_items_photo.value;
        var nom_photo = hidden_items_nom_photo.value;
        
        array[i] = new Array();
        
        array[i].push(id);
        array[i].push(lng);
        array[i].push(lat);
        array[i].push(photo);
        array[i].push(nom_photo);
    }
      
    console.log(array);
    return array;
    
}

function removeMarkersFromMap(){
    for (var i = 0; i < markerArray.length; i++) {
    markerArray[i].setMap(null);
  }
}

function affiche_tableau_marker(array, map, _rayon, point_localisation)
{
    for(var i =0; i<array.length;i++)
    {
        var latlng = new google.maps.LatLng(array[i][2],array[i][1]);
        var distance = google.maps.geometry.spherical.computeDistanceBetween(point_localisation, latlng);
        
        if(distance <= _rayon)
        {
            getAdressFromLatLngAndCreateMarker(latlng,array[i][0],array[i][3],array[i][4], 0);
            nb_fontaines++;
        }
    }
 
    var span_nb_fontaines = document.getElementById("nb_fontaines");
    span_nb_fontaines.innerHTML = "Nombre de fontaines autour de vous : " + nb_fontaines;
}



$(window).load(function(){
    var mode = document.getElementById('hidden_mode').value;
    
    if(mode == "affichage")
        initialize(0);
    else if(mode == "validation")
        initialize(2);
    else
        initialize(-1);
});