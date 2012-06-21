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
        coords.push(xy.lat()+','+xy.lng());
    }
    if (coords.length) {
        document.getElementById("Coordinates").value = coords.join(';');
    } else {
        document.getElementById("Coordinates").value = '';
    }
}

//set initial location
var latlng = new google.maps.LatLng(40.877374,-90.676775);

//set initial bounds
var latlngbounds = new google.maps.LatLngBounds();

var myOptions = {
  center: latlng,
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
            editable: true
        });
        
        google.maps.event.addListener(stored_polygon.getPath(), 'set_at', function() {
            update_coordinates(stored_polygon);
        });
    
        google.maps.event.addListener(stored_polygon.getPath(), 'insert_at', function() {
            update_coordinates(stored_polygon);
        });
        
        stored_polygon.setMap(map);
        
        //extend bounds to fit polygon
        map.fitBounds( latlngbounds );
    }
    else
    {
        map.setZoom(10);
    }
});