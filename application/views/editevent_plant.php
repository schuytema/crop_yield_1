<h3>Event <?php echo $event_type; ?> Details</h3>
    
    <h4>Equipment Used</h4>
    
    <?php
    //check for edit
    if(isset($plant_data) && $plant_data->num_rows()){
        $datarow = $plant_data->row();
    }
    ?>
    
    <table  style="float:left;" width="510">
              <?php
            if($implements->num_rows()){
                $result = $implements->result();

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Implement:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                $imps[0] = 'Select Implement';
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('EquipmentProduct', $imps, set_value('EquipmentProduct',(isset($datarow->FK_EquipmentId)) ? $datarow->FK_EquipmentId : NULL));

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
        if(!isset($crop_info))
        {
            //initialize array (to build at least one crop form)
            $crop_info = array(0=>array());
        }

        foreach($crop_info as $key => $crop) {
            $form_num = $key + 1;

            //create form elements related to this crop
            echo '<fieldset style="width:510px;" class="crop_entry"><legend>Crop/Variety '.$form_num.'</legend>';
            if (!empty($crop)) {
                //display existing crop
                echo '<blockquote>Current Crop/Variety:<br>Type:&nbsp;'.$crop['Type'].'<br>Brand:&nbsp;'.$crop['Brand'].'<br>Product:&nbsp;'.$crop['Product'].'<br>Acres Planted:&nbsp;'.$crop['AcresPlanted'].'</blockquote>';
            }
            echo '<table  style="float:left;" width="510">';

            if($crop_types->num_rows()){
                $result = $crop_types->result();

                //types

                echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                echo '<select id="CropType'.$form_num.'" name="CropType'.$form_num.'"><option value ="">Select Type</option>';
                foreach($result AS $row){
                echo '<option value ="'.$row->CropType.'">'.$row->CropType.'</option>';
                }
                echo '</select>';
                echo '</td></tr>';

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<select id="CropBrand'.$form_num.'" name="CropBrand'.$form_num.'"><option>select type...</option></select>';
                echo '<input type="text" size="40" id="OtherCropBrand'.$form_num.'" name="OtherCropBrand'.$form_num.'">';

                echo '</td></tr>';

                //products
                echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<select id="CropProduct'.$form_num.'" name="CropProduct'.$form_num.'"><option value="">select brand...</option></select>';
                echo '<input type="text" size="40" id="OtherCropProduct'.$form_num.'" name="OtherCropProduct'.$form_num.'">';

                echo '</td></tr>';
                
                //acres planted
                echo '<tr valign="top"><td align="right" width="200"><b>Planted:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<input type="text" size="5" id="AcresPlanted'.$form_num.'" name="AcresPlanted'.$form_num.'"> acres';

                echo '</td></tr>';
                
                //custom entry flag
                echo '<tr><td></td><td>';

                echo '<span><input type="checkbox" class="custom_crop_entry_toggle">My product isn\'t in these lists.</span>';

                echo '</td></tr>';

            } else {
                echo '<tr><td colspan="2"><font color="red>Crop/Variety data not found.</font></td></tr>';
            }

            echo '</table>';
            echo '</fieldset>';
        }
        echo '<table  style="float:left;" width="510"><tr style="text-align:right;"><td><button id="add_new_crop_entry" type="button">Add Another Crop/Variety</button></td></tr></table>';
        ?>
    
    <BR CLEAR=LEFT>

    <h4>Planting Data</h4> 

        <table  style="float:left;" width="510">
            <tr valign="top">
                <td align="right">
                    <b>Average Planting Rate</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <input type="text" size="10" name="PlantingRate" value="<?php echo set_value('PlantingRate',(isset($datarow->PlantingRate)) ? $datarow->PlantingRate : NULL); ?>">
                    <?php
                    echo form_dropdown('PlantingRateUnit', $this->config->item('planting_rate_units'), set_value('PlantingRateUnit',(isset($datarow->PlantingRateUnit)) ? $datarow->PlantingRateUnit : NULL));
                    ?>
                </td>
            </tr>      
            
            <tr valign="top">
                <td align="right">
                    <b>Row Spacing</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <input type="text" size="10" name="RowSpacing" value="<?php echo set_value('RowSpacing',(isset($datarow->RowSpacing)) ? $datarow->RowSpacing : NULL); ?>">
                    <?php
                    echo form_dropdown('RowSpacingUnit', $this->config->item('planting_row_spacing_units'), set_value('RowSpacingUnit',(isset($datarow->RowSpacingUnit)) ? $datarow->RowSpacingUnit : NULL));
                    ?>
                </td>
            </tr>           
            
            <tr valign="top">
                <td align="right">
                    <b>Seed Depth</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <input type="text" size="10" name="SeedDepth" value="<?php echo set_value('SeedDepth',(isset($datarow->SeedDepth)) ? $datarow->SeedDepth : NULL); ?>">
                    <?php
                    echo form_dropdown('SeedDepthUnit', $this->config->item('seed_depth_spacing_units'), set_value('SeedDepthUnit',(isset($datarow->SeedDepthUnit)) ? $datarow->SeedDepthUnit : NULL));
                    ?>
                </td>
            </tr>           
            
            <tr valign="top">
                <td align="right">
                    <b>Previous Crop:</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <?php
                    echo form_dropdown('PreviousCrop', $this->config->item('crop_type'), set_value('PreviousCrop',(isset($datarow->PreviousCrop)) ? $datarow->PreviousCrop : NULL));
                    ?>
                </td>
            </tr> 
               
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Variable Rate?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      echo form_dropdown('VariableRate', $this->config->item('no_yes_bool'), set_value('VariableRate',(isset($datarow->VariableRate)) ? $datarow->VariableRate : NULL));
                    ?>
                  </td>
               </tr>
               
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Twin Rows?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      echo form_dropdown('TwinRows', $this->config->item('no_yes_bool'), set_value('TwinRows',(isset($datarow->TwinRows)) ? $datarow->TwinRows : NULL));
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