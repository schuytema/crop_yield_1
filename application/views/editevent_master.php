<!-- content -->
<link href="<?php echo base_url(); ?>css/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendar.js"></script>


<div class="splitleft">
    <h1>Edit Event(New)</h1>
    <h3>Master Event Data</h3>
    
    <form action="<?php echo base_url(); ?>member/field" method="POST">
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Type:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="EventPicker" onchange="window.location=this.value;">
                        <option value="<?php echo base_url(); ?>member/editevent_application"<?php if ($event_type == 'Application') { echo ' selected="selected"'; } ?>>Application</option>
                        <option value="<?php echo base_url(); ?>member/editevent_chemical"<?php if ($event_type == 'Chemical') { echo ' selected="selected"'; } ?>>Chemical</option>
                        <option value="<?php echo base_url(); ?>member/editevent_fertilizer"<?php if ($event_type == 'Fertilizer') { echo ' selected="selected"'; } ?>>Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/editevent_harvest"<?php if ($event_type == 'Harvest') { echo ' selected="selected"'; } ?>>Harvest</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant"<?php if ($event_type == 'Plant') { echo ' selected="selected"'; } ?>>Plant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_tillage"<?php if ($event_type == 'Tillage') { echo ' selected="selected"'; } ?>>Tillage</option>
                        <option value="<?php echo base_url(); ?>member/editevent_weather"<?php if ($event_type == 'Weather') { echo ' selected="selected"'; } ?>>Weather</option>
                      </select>
                      <input type="hidden" name="EventType" value="<?php echo $event_type; ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Date:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="15" name="Date" onclick="displayDatePicker('Date');"><a href="javascript:void(0);" onclick="displayDatePicker('Date');"><img src="<?php echo base_url(); ?>css/images/calendar.png" alt="calendar" border="0"></a>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Notes:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <TEXTAREA NAME="Notes" COLS=40 ROWS=6></TEXTAREA>
                  </td>
               </tr>
          </table>
    <BR CLEAR=LEFT>
    
    <h4>Select all fields that are affected by this event</h4>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Your Fields:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <input type="checkbox" name="fields[]" value="1">Hartz Seven<br>
                    <input type="checkbox" name="fields[]" value="2">Swallow Hills back<br>
                    <input type="checkbox" name="fields[]" value="3" checked>Swallow Hills east 
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          <br><br>
    
    

