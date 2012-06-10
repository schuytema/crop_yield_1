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
                        <option value="<?php echo base_url(); ?>member/editevent_chemical" selected="selected">Chemical</option>
                        <option value="<?php echo base_url(); ?>member/editevent_fertilizer">Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/editevent_harvest">Harvest</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant">Plant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_tillage">Tillage</option>
                        <option value="<?php echo base_url(); ?>member/editevent_weather">Weather</option>
                      </select>
                      <input type="hidden" name="EventTpe" value="Chemical">
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
    
    <h3>Event Chemical Details</h3>
    
    
    
    
    
    
        <table  style="float:left;" width="510">
            
            <?php
            
                if($types->num_rows()){
                    $result = $types->result();

                    //types
                    echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    echo '<select id="ChemicalType" name="ChemicalType"><option value ="">Select Type</option>';
                    foreach($result AS $row){
                    echo '<option value ="'.$row->ChemicalType.'">'.$row->ChemicalType.'</option>';
                    }
                    echo '</select>';

                    echo '</td></tr>';

                    //brands
                    echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    
                    echo '<select id="Brand" name="Brand"><option>select type...</select>';

                    echo '</td></tr>';

                    //products
                    echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    
                    echo '<select id="Product" name="Product"><option>select brand...</select></select>';

                    echo '</td></tr>';
                    

                } else {
                    echo '<tr><td colspan="2"><font color="red>Chemical data not found.</font></td><tr>';
                }
            
            ?>
            
            
              
               <tr valign="top">
                  <td align="right">
                      <b>Amount of Active Ingredient:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="AmountActiveIngredient">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="AmountActiveIngredientUnit">
                        <option value="lbs">lbs</option>
                        <option value="kg">kq</option>
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

