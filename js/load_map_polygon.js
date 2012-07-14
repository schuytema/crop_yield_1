/*
 * load_map_polygon.js
 * Author: Nick Carlson
 * Date: June 5, 2012
 * Description: javascript to enable the creation & editing of a google polygon
 *      upon a Goolge Map utilizing Google Maps API
 */

//set initial location
var latlng = new google.maps.LatLng(40.877374,-90.676775);

//set initial bounds
var latlngbounds = new google.maps.LatLngBounds();

//set options
var myOptions = {
  center: latlng,
  mapTypeId: google.maps.MapTypeId.HYBRID
}

var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

var stored_polygon;

$(document).ready(function(){
    //load existing polygon
    if ($("#Coordinates").val().length) {
        var stored_array = ($("#Coordinates").val()).split(";");
        var coords_array = [];
        var stored_path = [];
        var point;
        for (i=0; i<stored_array.length; i++) {
            coords_array = stored_array[i].split(",");
            point = new google.maps.LatLng(coords_array[0],coords_array[1]);
            stored_path.push(point);
            latlngbounds.extend(point);
        }; 
        stored_polygon = new google.maps.Polygon({ 
            paths: stored_path,
            fillColor: '#ffff00',
            fillOpacity: .3,
            strokeWeight: 1,
            clickable: false,
            zIndex: 1,
            editable: false
        });
        
        //add polygon to the map
        stored_polygon.setMap(map);
        
        //extend bounds to fit polygon
        map.fitBounds( latlngbounds );
    }
});