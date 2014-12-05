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
        var latlng = new google.maps.LatLng(array[i][0],array[i][1]);
        var distance = google.maps.geometry.spherical.computeDistanceBetween(point_localisation, latlng);
        
        if(distance <= _rayon)
        {
            codeLatLng(latlng, map, 0);
            nb_fontaines++;
        }
    }
    
    var span_nb_fontaines = document.getElementById("nb_fontaines");
    span_nb_fontaines.innerHTML = "Nombre de fontaines autour de vous : " + nb_fontaines;
}



$(window).load(function(){
    initialize(0)
});