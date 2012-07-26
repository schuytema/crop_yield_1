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
       
    <h4>Planting Data</h4>  
          
    <?php
    if(isset($crop_info))
    {
        echo '<blockquote>Current Crop:<br>Type:&nbsp;'.$crop_info['Type'].'<br>Brand:&nbsp;'.$crop_info['Brand'].'<br>Product:&nbsp;'.$crop_info['Product'].'</blockquote>';;
    }
    ?>
          
        <table  style="float:left;" width="510">
            
        <?php
            if($crop_types->num_rows()){
                $result = $crop_types->result();

                //types
                echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                echo '<select id="CropType" name="CropType"><option value ="">Select Type</option>';
                foreach($result AS $row){
                echo '<option value ="'.$row->CropType.'">'.$row->CropType.'</option>';
                }
                echo '</select>';

                echo '</td></tr>';

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<select id="CropBrand" name="CropBrand"><option>select type...</option></select>';

                echo '</td></tr>';

                //products
                echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<select id="CropProduct" name="CropProduct"><option value="">select brand...</option></select>';

                echo '</td></tr>';


            } else {
                echo '<tr><td colspan="2"><font color="red>Crop data not found.</font></td></tr>';
            }

        ?>
            <tr>
                <td align="right" colspan="2">
                    <a href="javascript:void(0);" id="show_other_two">{my product isn't in these lists}</a>
                    <div id="other_two">
                        <br>Please enter manually (select Type above):<br>
                        Brand:&nbsp;<input type="text" size="40" name="OtherCropBrand"><br>
                        Product:&nbsp;<input type="text" size="40" name="OtherCropProduct"><br>
                    </div>
                </td>
            </tr>

            <tr valign="top">
                <td align="right">
                    <b>Planting Rate</b>&nbsp;&nbsp;
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
                  <td align="right">
                      <b>Percent Planted:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentCrop" value="<?php echo set_value('PercentCrop',(isset($datarow->PercentCrop)) ? $datarow->PercentCrop : NULL); ?>">&nbsp;%
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