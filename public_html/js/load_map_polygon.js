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

$(document).ready(function(){
    //load existing polygon
    if ($("#Coordinates").val().length) {
        //set initial bounds
        var latlngbounds = new google.maps.LatLngBounds();
        var stored_poly_array = ($("#Coordinates").val()).split("|");
        var stored_array = [];
        var coords_array = [];
        var stored_path = [];
        var point;
        for (x=0; x<stored_poly_array.length; x++) {
            stored_array = stored_poly_array[x].split(";");
            stored_path = [];
            for (i=0; i<stored_array.length; i++) {
                coords_array = stored_array[i].split(",");
                point = new google.maps.LatLng(coords_array[0],coords_array[1]);
                stored_path.push(point);
                latlngbounds.extend(point);
            }; 
            stored_polygon = new google.maps.Polygon({ 
                paths: stored_path,
                fillColor: '#ffff00',
                strokeColor: '#ffff00',
                fillOpacity: .3,
                strokeWeight: 1,
                clickable: false,
                zIndex: 1,
                editable: false
            });

            stored_polygon.setMap(map);
        }
        
        //extend bounds to fit polygon
        map.fitBounds( latlngbounds );
    }
});