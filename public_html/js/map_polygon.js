/*
 * map_polygon.js
 * Author: Nick Carlson
 * Date: June 5, 2012
 * Description: javascript to enable the creation & editing of google polygons
 *      upon a Goolge Map utilizing Google Maps API
 */

/* support functions */

function deleteControl(controlDiv, map) {

  // Set CSS styles for the DIV containing the control
  // Setting padding to 5 px will offset the control
  // from the edge of the map.
  controlDiv.style.paddingTop = '5px';

  // Set CSS for the control border.
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = 'white';
  controlUI.style.borderStyle = 'solid';
  controlUI.style.borderColor = '#000';
  controlUI.style.borderWidth = '1px';
  controlUI.style.cursor = 'pointer';
  controlUI.style.textAlign = 'center';
  controlUI.style.height = '24px';
  controlUI.style.display = 'none';
  controlUI.title = 'Delete selected polygon';
  controlUI.id = 'delete-button';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior.
  var controlText = document.createElement('div');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '12px';
  controlText.style.color = '#000';
  controlText.style.paddingLeft = '4px';
  controlText.style.paddingRight = '4px';
  controlText.innerHTML = '<strong>Delete</strong>';
  controlUI.appendChild(controlText);

  // Setup the click event listeners
  google.maps.event.addDomListener(controlUI, 'click', deleteSelectedShape);
}

function toggleDeleteButton() {
    //toggle the display of the delete button, based on the selection of a polygon
    if (selectedShape) {
        $('#delete-button').toggle(true);
    } else {
        $('#delete-button').toggle(false);
    }
}

function clearSelection() {
    //remove the selection from the currently selected polygon, if any
    if (selectedShape) {
        // Retrieves the current options from the drawing manager and replaces the
        // stroke or fill color as appropriate.
        var polygonOptions = drawingManager.get('polygonOptions');        
        selectedShape.set('fillColor',polygonOptions.fillColor);
        selectedShape.set('strokeColor',polygonOptions.strokeColor);
        selectedShape.setEditable(false);
        selectedShape = null;
    }
    toggleDeleteButton();
}

function setSelection(shape) {
    //set the given shape as selected
    clearSelection();
    selectedShape = shape;
    shape.setEditable(true);
    shape.set('fillColor','#ffffff');
    shape.set('strokeColor','#ffffff');
    toggleDeleteButton();
}

function deleteSelectedShape() {
    //delete the currently selected shape
    if (selectedShape) {
        for(var i in polygon_arr){
        if(polygon_arr[i]==selectedShape){
            polygon_arr.splice(i,1);
            break;
        }
        }
        selectedShape.setMap(null);
        update_coordinates();
        clearSelection();
    }
}

function createPolygon(polygon) {
    //add polygon to tracking array
    polygon_arr.push(polygon);
    
    //update coordinates list & calculated values
    update_coordinates();
    
    //add vertex listeners
    google.maps.event.addListener(polygon.getPath(), 'set_at', function() {
        update_coordinates();
    });
    
    google.maps.event.addListener(polygon.getPath(), 'insert_at', function() {
        update_coordinates();
    });
    
    google.maps.event.addListener(polygon.getPath(), 'remove_at', function() {
        update_coordinates();
    });
    
    //add delete vertex listeners
    google.maps.event.addListener(polygon, 'rightclick', function(mouse_event_object) {
        if (mouse_event_object.vertex != null) {
            polygon.getPath().removeAt(mouse_event_object.vertex);
        }
    });
    
    // Add an event listener that selects the newly-drawn shape when the user
    // mouses down on it.
    google.maps.event.addListener(polygon, 'click', function() {
        setSelection(polygon);
    });
    
    //set this newly created polygon as selected
    setSelection(polygon);
}

function update_coordinates() {
    var vertices;
    var coords;
    var xy;
    var coord_arr = [];
    var calc_size = 0;
    //cycle through all polygons on the map
    for (var x=0; x < polygon_arr.length; x++) {
        vertices = polygon_arr[x].getPath();
        coords = [];
        //cycle through all the coordinate pairs
        for (var i =0; i < vertices.length; i++) {
            xy = vertices.getAt(i);
            coords.push(xy.lat()+','+xy.lng());
        }
        if (coords.length) {
            //join all coordinates in this path with ";"
            coord_arr.push(coords.join(';'));
            //add the calculated size of this path to the sum of all paths
            calc_size += Math.round(google.maps.geometry.spherical.computeArea(vertices)*sq_meters_to_acres*10000)/10000;
        }
    }
    if (coord_arr.length) {
        //combine path coordinate strings into one multi-path string
        document.getElementById("Coordinates").value = coord_arr.join('|');
        document.getElementById("CalcSize").value = calc_size;
    } else {
        //clear string
        document.getElementById("Coordinates").value = '';
        document.getElementById("CalcSize").value = 0;
    }
}

/* initial values */

var selectedShape; //holds selected shape
var defaultPolygonOptions = { //options for creating a polygon
    fillColor: '#ffff00',
    strokeColor: '#ffff00',
    fillOpacity: .3,
    strokeWeight: 1,
    clickable: true,
    zIndex: 1,
    editable: true
  };
var polygon_arr = []; //holds all polygons on the map

var sq_meters_to_acres = 0.000247105381; //conversion rate: 1 sq. meter (Google default) = 0.000247105381 acres

var latlng = new google.maps.LatLng(40.877374,-90.676775); //set initial location

var myOptions = { //map options
  zoom: 10,
  center: latlng,
  mapTypeId: google.maps.MapTypeId.HYBRID
}

var map = new google.maps.Map(document.getElementById("map_edit_canvas"), myOptions); //create the map

var DeleteControlDiv = document.createElement('div'); //create custom control container
var DeleteControl = new deleteControl(DeleteControlDiv, map); //create custom control
DeleteControlDiv.index = 1;
map.controls[google.maps.ControlPosition.TOP_CENTER].push(DeleteControlDiv);

//check for farm address availability
if (window['farm'] != undefined) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': farm.address+' '+farm.city+', '+farm.state+' '+farm.zip }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        latlng = results[0].geometry.location;
        map.fitBounds(results[0].geometry.viewport);
      }
    });
}

//create drawing manager instance
var drawingManager = new google.maps.drawing.DrawingManager({
  drawingControl: true,
  drawingControlOptions: {
    position: google.maps.ControlPosition.TOP_CENTER,
    drawingModes: [google.maps.drawing.OverlayType.POLYGON]
  },
  polygonOptions: { //options for creating a polygon
    fillColor: '#ffff00',
    strokeColor: '#ffff00',
    fillOpacity: .3,
    strokeWeight: 1,
    clickable: true,
    zIndex: 1,
    editable: true
  }
});

drawingManager.setMap(map);

//set listener for completed polygon
google.maps.event.addListener(drawingManager, 'polygoncomplete', createPolygon);

$(document).ready(function(){
    //load existing polygons
    if ($("#Coordinates").val().length) {
        //set initial bounds
        var latlngbounds = new google.maps.LatLngBounds();
        var stored_poly_array = ($("#Coordinates").val()).split("|");
        var stored_array = [];
        var coords_array = [];
        var stored_path = [];
        var point;
        //cycle through all polygons
        for (x=0; x<stored_poly_array.length; x++) {
            stored_array = stored_poly_array[x].split(";");
            stored_path = [];
            //cycle through all coordinate pairs
            for (i=0; i<stored_array.length; i++) {
                coords_array = stored_array[i].split(",");
                point = new google.maps.LatLng(coords_array[0],coords_array[1]);
                stored_path.push(point);
                latlngbounds.extend(point);
            }; 
            
            //disallow editing & load stored path
            polygon = new google.maps.Polygon({ 
                //options for loading a polygon
                paths: stored_path,
                fillColor: '#ffff00',
                strokeColor: '#ffff00',
                fillOpacity: .3,
                strokeWeight: 1,
                clickable: true,
                zIndex: 1,
                editable: false
            });
            
            //add listeners
            createPolygon(polygon);
            
            //add to the map
            polygon.setMap(map);
        }
        
        //extend bounds to fit polygon
        map.fitBounds( latlngbounds );
    }
    
    // Clear the current selection when the drawing mode is changed, or when the
    // map is clicked.
    google.maps.event.addListener(map, 'click', clearSelection);

    //clear any selection
    clearSelection();
});