/*
 * load_map_polygon.js
 * Author: Nick Carlson
 * Date: June 5, 2012
 * Description: javascript to enable the creation & editing of a google polygon
 *      upon a Goolge Map utilizing Google Maps API
 */

var myLatlng = new google.maps.LatLng(40.882501,-90.698061);
var myOptions = {
  zoom: 15,
  center: myLatlng,
  mapTypeId: google.maps.MapTypeId.HYBRID
}

var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);


polygon = new google.maps.Polygon({
    paths: [
    new google.maps.LatLng(40.885665,-90.700743),
    new google.maps.LatLng(40.885681,-90.696001),
    new google.maps.LatLng(40.878543,-90.696237),
    new google.maps.LatLng(40.878672,-90.700786),
    ],
    fillColor: '#ffff00',
    fillOpacity: .3,
    strokeWeight: 5,
    clickable: false,
    zIndex: 1,
    editable: false,
  });
  
polygon.setMap(map);


