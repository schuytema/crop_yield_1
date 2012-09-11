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
    <h3>Field location <?php echo help_link('h_editmap'); ?></h3>
    <div id="map_edit_canvas"></div>
    <input type="hidden" name="Coordinates" id="Coordinates" value="<?php echo set_value('Coordinates',(isset($row->Coordinates)) ? $row->Coordinates : NULL); ?>">
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
                      <b>Size of Field (Calculated):</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" name="CalcSize" id="CalcSize" value="<?php echo set_value('CalcSize',(isset($row->CalcSize)) ? $row->CalcSize : NULL); ?>" readonly="readonly" /> acres
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Drainage Effectiveness:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <?php echo form_dropdown('PercentDrainageEffectiveness',$this->config->item('drainage'), set_value('PercentDrainageEffectiveness',(isset($row->PercentDrainageEffectiveness)) ? $row->PercentDrainageEffectiveness : NULL));?>               
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Irrigated?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                    <?php echo form_dropdown('Irrigated',$this->config->item('no_yes_boolean'), set_value('Irrigated',(isset($row->Irrigated)) ? $row->Irrigated : NULL));?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Tiled?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                    <?php echo form_dropdown('Tiled',$this->config->item('no_yes_boolean'), set_value('Tiled',(isset($row->Tiled)) ? $row->Tiled : NULL));?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Tillage Practice:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                    <?php echo form_dropdown('TillagePractice',$this->config->item('tillage_practice'), set_value('TillagePractice',(isset($row->TillagePractice)) ? $row->TillagePractice : NULL));?>
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