<!-- content -->
<div class="splitleft">
    <h1>Field Overview</h1>
    <h3>Field Map</h3>
    <div id="map_canvas"></div>
    <h3>Field Information</h3>
        <blockquote>
            <b>Swallow Hills East</b><br>
            73 acres (user)<br>
            72.15 acres (calculated)<br>
            Drainage effectiveness: 37%<br>
            <a href="<?php echo base_url(); ?>member/editfield">{edit field information}</a>
        </blockquote>             
    <h3>Field Events</h3>
    <table  id="table-data" width="600">
        <thead>
            <th>Date</th>
            <th>Event Type</th>
            <th>Notes</th>
            <th>Actions</th>
        </thead>
        <tr>
            <td width="100">2012-03-12</td>
            <td width="100">Tillage</td>
            <td width="200">Dry soil and winds out of...</td>
            <td width="150"><a href="<?php echo base_url(); ?>member/event">details</a>&nbsp;|&nbsp;<a href="#">delete</a></td>
        </tr>
        <tr>
            <td>2012-03-27</td>
            <td>Application</td>
            <td>Done a week later than...</td>
            <td><a href="<?php echo base_url(); ?>member/event">details</a>&nbsp;|&nbsp;<a href="#">delete</a></td>
        </tr>
        <tr>
            <td>2012-05-18</td>
            <td>Planting</td>
            <td>Planter froze up on row...</td>
            <td><a href="<?php echo base_url(); ?>member/event">details</a>&nbsp;|&nbsp;<a href="#">delete</a></td>
        </tr>
    </table>
    <a href="<?php echo base_url(); ?>member/editevent">{add new event}</a>
    <br><br>
</div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/load_map_polygon.js"></script>

