<h3>Event <?php echo $event_type; ?> Details</h3>
    
    <h4>Equipment Used</h4>
    
    <?php
    //check for edit
    if(isset($plant_data) && $plant_data->num_rows()){
        $row = $plant_data->row();
    }
    ?>
    
    <table  style="float:left;" width="510">
            <?php            
            //Power
            if($power->num_rows()){
                $result = $power->result();

                //equipment select
                echo '<tr valign="top"><td align="right" width="200"><b>Power:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                $imps = array('' => 'Select Power');
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('EquipmentPower', $imps, set_value('EquipmentPower',(isset($row->FK_EquipmentId_Power)) ? $row->FK_EquipmentId_Power : NULL));
                echo '</td></tr>';
            } else {
                echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            }
            
            //Implement
            if($implements->num_rows()){
                $result = $implements->result();

                //equipment select
                echo '<tr valign="top"><td align="right" width="200"><b>Implement:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                $imps = array('' => 'Select Implement');
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('EquipmentImplement', $imps, set_value('EquipmentImplement',(isset($row->FK_EquipmentId)) ? $row->FK_EquipmentId : NULL));
                echo '</td></tr>';
            } else {
                echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            }            
            ?>
    </table>   
    <BR CLEAR=LEFT>
   
    <!-- new crop info area -->
    <h4>Crop Data</h4>
    <?php
    if (!isset($crop_info)) {
        $crop_info = array(0=>array());
    }
    foreach($crop_info as $key => $crop) {
        $view_data = array('form_num'=>$key+1,'crop'=>$crop,'crop_types'=>$crop_types,'event_type'=>$event_type);
        $this->load->view('crop_info',$view_data);
    }
    ?>    

    <table  style="float:left;" width="510"><tr style="text-align:right;"><td><button id="add_new_crop_entry" type="button">Add Another Crop/Variety</button></td></tr></table>
    <BR CLEAR=LEFT>

    <h4>Planting Data</h4> 

        <table  style="float:left;" width="510">
            <tr valign="top">
                <td align="right">
                    <b>Average Planting Rate</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <input type="text" size="10" name="PlantingRate" value="<?php echo set_value('PlantingRate',(isset($row->PlantingRate)) ? $row->PlantingRate : NULL); ?>">
                    <?php
                    echo form_dropdown('PlantingRateUnit', $this->config->item('planting_rate_units'), set_value('PlantingRateUnit',(isset($row->PlantingRateUnit)) ? $row->PlantingRateUnit : NULL));
                    ?>
                </td>
            </tr>      
            
            <tr valign="top">
                <td align="right">
                    <b>Row Spacing</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <input type="text" size="10" name="RowSpacing" value="<?php echo set_value('RowSpacing',(isset($row->RowSpacing)) ? $row->RowSpacing : NULL); ?>">
                    <?php
                    echo form_dropdown('RowSpacingUnit', $this->config->item('planting_row_spacing_units'), set_value('RowSpacingUnit',(isset($row->RowSpacingUnit)) ? $row->RowSpacingUnit : NULL));
                    ?>
                </td>
            </tr>           
            
            <tr valign="top">
                <td align="right">
                    <b>Seed Depth</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <input type="text" size="10" name="SeedDepth" value="<?php echo set_value('SeedDepth',(isset($row->SeedDepth)) ? $row->SeedDepth : NULL); ?>">
                    <?php
                    echo form_dropdown('SeedDepthUnit', $this->config->item('seed_depth_spacing_units'), set_value('SeedDepthUnit',(isset($row->SeedDepthUnit)) ? $row->SeedDepthUnit : NULL));
                    ?>
                </td>
            </tr>           
            
            <tr valign="top">
                <td align="right">
                    <b>Previous Crop:</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <?php
                    echo form_dropdown('PreviousCrop', $this->config->item('crop_type'), set_value('PreviousCrop',(isset($row->PreviousCrop)) ? $row->PreviousCrop : NULL));
                    ?>
                </td>
            </tr> 
               
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Variable Rate?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      echo form_dropdown('VariableRate', $this->config->item('no_yes_bool'), set_value('VariableRate',(isset($row->VariableRate)) ? $row->VariableRate : NULL));
                    ?>
                  </td>
               </tr>
               
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Twin Rows?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      echo form_dropdown('TwinRows', $this->config->item('no_yes_bool'), set_value('TwinRows',(isset($row->TwinRows)) ? $row->TwinRows : NULL));
                    ?>
                  </td>
               </tr>
          </table>

        
          <BR CLEAR=LEFT>
    <br><br>
          
	<footer>
	  <input type="submit" class="btnLogin" name="submit" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>