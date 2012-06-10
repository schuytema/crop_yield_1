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
                        <option value="<?php echo base_url(); ?>member/editevent_fertilizer">Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/editevent_harvest" selected="selected">Harvest</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant">Plant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_tillage">Tillage</option>
                        <option value="<?php echo base_url(); ?>member/editevent_weather">Weather</option>
                      </select>
                      <input type="hidden" name="EventTpe" value="Harvest">
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
    
   
          <h3>Event Harvest Details</h3>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Brand">
                        <option value="Case IH">Case IH</option>
                        <option value="John Deere">John Deere</option>
                        <option value="Lexion">Lexion</option>
                        <option value="New Holland">New Holland</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product">
                        <option value="7010">7010</option>
                        <option value="7088">7088</option>
                        <option value="8010">8010</option>
                        <option value="8020">8020</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
       
        <h4>Yield Data</h4>   
          
        <table  style="float:left;" width="510">
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Yield:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="4" name="Yield">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="YieldUnit">
                        <option value="bu/acre">bu/acre</option>
                        <option value="bu/sq. mile">bu/sq. mile</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Grain Test Weight:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="4" name="GrainTestWeight">&nbsp;lbs/bu
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent Moisture:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentMoisture">&nbsp;%
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

