/*
 * map_polygon.js
 * Author: Nick Carlson
 * Date: June 5, 2012
 * Description: javascript to enable the creation & editing of a google polygon
 *      upon a Goolge Map utilizing Google Maps API
 */

var myLatlng = new google.maps.LatLng(40.877374,-90.676775);
var myOptions = {
  zoom: 12,
  center: myLatlng,
  mapTypeId: google.maps.MapTypeId.HYBRID
}

var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

var drawingManager = new google.maps.drawing.DrawingManager({
  drawingControl: true,
  drawingControlOptions: {
    position: google.maps.ControlPosition.TOP_CENTER,
    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
  },
  polygonOptions: {
    fillColor: '#ffff00',
    fillOpacity: .3,
    strokeWeight: 5,
    clickable: false,
    zIndex: 1,
    editable: true
  }
});
drawingManager.setMap(map);
