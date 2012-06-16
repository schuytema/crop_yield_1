<h3>Event <?php echo $event_type; ?> Details</h3>
    
    <h4>Equipment Used</h4>
    
    <?php
    //check for edit
    if(isset($plant_data) && $plant_data->num_rows()){
        $datarow = $plant_data->row();
    }
    
    if(isset($equipment_info))
    {
        echo '<blockquote>Current Equipment:<br>Brand:&nbsp;'.$equipment_info['Brand'].'<br>Product:&nbsp;'.$equipment_info['Product'].'</blockquote>';;
    }
    ?>    
    
    <table  style="float:left;" width="510">
        <?php
            if($equipment_brands->num_rows()){
                $result = $equipment_brands->result();

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<select id="EquipmentBrand" name="EquipmentBrand"><option value ="">Select Type</option>';
                foreach($result AS $row){
                    echo '<option value ="'.$row->Brand.'">'.$row->Brand.'</option>';
                }
                echo '</select>';

                echo '</td></tr>';

                //products
                echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                echo '<select id="EquipmentProduct" name="EquipmentProduct"><option value="">select brand...</option></select>';

                echo '</td></tr>';


            } else {
                echo '<tr><td colspan="2"><font color="red>Equipment data not found.</font></td></tr>';
            }

        ?>
            <tr>
                <td align="right" colspan="2">
                    <a href="javascript:void(0);" id="show_other_one">{my product isn't in these lists}</a>
                    <div id="other_one">
                        <br>Please enter manually:<br>
                        Brand:&nbsp;<input type="text" size="40" name="OtherEquipmentBrand"><br>
                        Product:&nbsp;<input type="text" size="40" name="OtherEquipmentProduct"><br>
                    </div>
                </td>
            </tr>
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
                </td>
            </tr>
            
            <tr valign="top">
                <td align="right">
                    <b>Planting Rate Units:</b>&nbsp;&nbsp;
                </td>
                <td align="left">
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
                </td>
            </tr>           
            
            <tr valign="top">
                <td align="right">
                    <b>Row Spacing Units:</b>&nbsp;&nbsp;
                </td>
                <td align="left">
                    <?php
                    echo form_dropdown('RowSpacingUnit', $this->config->item('planting_row_spacing_units'), set_value('RowSpacingUnit',(isset($datarow->RowSpacingUnit)) ? $datarow->RowSpacingUnit : NULL));
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