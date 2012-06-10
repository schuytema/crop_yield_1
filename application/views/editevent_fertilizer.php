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
                        <option value="<?php echo base_url(); ?>member/editevent_application">Application</option>
                        <option value="<?php echo base_url(); ?>member/editevent_chemical">Chemical</option>
                        <option value="<?php echo base_url(); ?>member/editevent_fertilizer" selected="selected">Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/editevent_harvest">Harvest</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant">Plant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_tillage">Tillage</option>
                        <option value="<?php echo base_url(); ?>member/editevent_weather">Weather</option>
                      </select>
                      <input type="hidden" name="EventTpe" value="Fertilizer">
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
    
    <p><a href="#">{apply event to multiple fields}</a></p>
    
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
    
   <h3>Event Fertilizer Details</h3>
       
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Percent N:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="3" name="PercentN">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent P:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentP">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent K:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentK">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Application Rate:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="ApplicationRate">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="ApplicationRateUnit">
                        <option value="lbs/acre">lbs/acre</option>
                        <option value="lbs/sq. mile">lbs/sq. mile</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
    <br><br>

    
   
          
	<footer>
	  <input type="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

