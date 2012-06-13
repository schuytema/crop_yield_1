<!-- content -->
<div class="splitleft">
    <?php
    echo '<h1>'.$page_title.'</h1>';
    echo '<p>'.$desc.'</p>';
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }
    
    //check for edit
    if(isset($field_data) && $field_data->num_rows()){
        $row = $field_data->row();
    }
      
    echo form_open($action);
    ?>
    <h3>Field location</h3>
    <div id="map_canvas"></div>
    <h3>Basic Field Data</h3>
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Field Name:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="40" name="Name" value="<?php echo set_value('Name',(isset($row->Name)) ? $row->Name : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Size of Field:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="7" name="UserSize" value="<?php echo set_value('UserSize',(isset($row->UserSize)) ? $row->UserSize : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                    <?php echo form_dropdown('UserSizeUnit',$this->config->item('size_units'), set_value('UserSizeUnit',(isset($row->UserSizeUnit)) ? $row->UserSizeUnit : NULL));?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Drainage Effectiveness:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentDrainageEffectiveness" value="<?php echo set_value('PercentDrainageEffectiveness',(isset($row->PercentDrainageEffectiveness)) ? $row->PercentDrainageEffectiveness : NULL); ?>">&nbsp;%
                  </td>
               </tr>
          </table>
    <BR CLEAR=LEFT>
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    <?php
    echo form_close();
    ?>
    <br><br>
</div>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true&libraries=drawing"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/map_polygon.js"></script>