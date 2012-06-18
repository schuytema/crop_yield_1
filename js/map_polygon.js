/*
 * map_polygon.js
 * Author: Nick Carlson
 * Date: June 5, 2012
 * Description: javascript to enable the creation & editing of a google polygon
 *      upon a Goolge Map utilizing Google Maps API
 */

function update_coordinates(polygon) {
    var vertices = polygon.getPath();
    var coords = [];
    for (var i =0; i < vertices.length; i++) {
        var xy = vertices.getAt(i);
        coords.push('{"lat":"'+xy.lat()+'","lng":"'+xy.lng()+'"}');
    }
    if (coords.length) {
        document.getElementById("Coordinates").value = '{"coordinates": ['+coords.join(',')+']}';
    } else {
        document.getElementById("Coordinates").value = '';
    }
}

var myLatlng = new google.maps.LatLng(40.877374,-90.676775);
var myOptions = {
  zoom: 8,
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

var stored_polygon;

//load existing polygon
if (field_map.data.coordinates) {
    var stored_path = [];
    for (i=0; i<field_map.data.coordinates.length; i++) {
        stored_path.push(new google.maps.LatLng(field_map.data.coordinates.Lat,field_map.data.coordinates.Lng)) 
    }; 
    stored_polygon = new google.maps.Polygon({ 
        paths: stored_path,
        fillColor: '#ffff00',
        fillOpacity: .3,
        strokeWeight: 5,
        clickable: false,
        zIndex: 1,
        editable: false
    });
}

google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
    if (stored_polygon) {
        stored_polygon.setMap(null);
    }
    
    stored_polygon = polygon;
    update_coordinates(stored_polygon);
    
    google.maps.event.addListener(stored_polygon.getPath(), 'set_at', function() {
        update_coordinates(stored_polygon);
    });
    
    google.maps.event.addListener(stored_polygon.getPath(), 'insert_at', function() {
        update_coordinates(stored_polygon);
    });
});
