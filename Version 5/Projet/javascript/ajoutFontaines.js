/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function set_lat_lng_input(latlng)
{
    var _lat = latlng.lat();
    var _lng = latlng.lng();
    
    console.log(_lat);
    console.log(_lng);
}

$(window).load(function(){
    initialize(1)
});