<?php
    //create form elements related to this crop
    echo '<fieldset style="width:510px;" class="crop_entry"><legend>Crop/Variety';
    if ($event_type != 'Harvest') {
        echo ' <a class="delete_crop" id="DeleteCrop'.$form_num.'" href="#">Delete</a>';
    }
    echo '</legend>';
    echo '<table  style="float:left;" width="510">';

    if($crop_types->num_rows()){
        $result = $crop_types->result();

        //types

        echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
        echo '<select id="CropType'.$form_num.'" name="crop['.$form_num.'][type]"><option value ="">Select Type</option>';
        foreach($result AS $row){
            echo '<option value ="'.$row->CropType.'">'.$row->CropType.'</option>';
        }
        echo '</select>';
        echo '</td></tr>';

        //brands
        echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

        echo '<select id="CropBrand'.$form_num.'" name="crop['.$form_num.'][brand]"><option>select type...</option></select>';
        echo '<input type="text" size="40" id="OtherCropBrand'.$form_num.'" name="crop['.$form_num.'][other_brand]">';

        echo '</td></tr>';

        //products
        echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

        echo '<select id="CropProduct'.$form_num.'" name="crop['.$form_num.'][product]"><option value="">select brand...</option></select>';
        echo '<input type="text" size="40" id="OtherCropProduct'.$form_num.'" name="crop['.$form_num.'][other_product]">';
        
        //crop instance ID - hidden
        echo '<input type="hidden" id="CropInstanceId'.$form_num.'" name="crop['.$form_num.'][crop_instance_id]">';

        echo '</td></tr>';

        if ($event_type == 'Harvest') {
            //yield
            echo '<tr valign="top"><td align="right" width="200"><b>Yield:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo '<input type="text" size="5" id="Yield'.$form_num.'" name="crop['.$form_num.'][yield]"> bu/acre';
            echo '</td></tr>';
            
            //grain test weight
            echo '<tr valign="top"><td align="right" width="200"><b>Grain Test Weight:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo '<input type="text" size="6" id="GrainTestWeight'.$form_num.'" name="crop['.$form_num.'][grain_test_weight]"> lbs/bu';
            echo '</td></tr>';
            
            //harvest percent moisture
            echo '<tr valign="top"><td align="right" width="200"><b>Harvest Percent Moisture:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo '<input type="text" size="6" id="PercentMoisture'.$form_num.'" name="crop['.$form_num.'][percent_moisture]">';
            echo '</td></tr>';
            
            //aflatoxin
            echo '<tr valign="top"><td align="right" width="200"><b>Aflatoxin:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo '<input type="text" size="6" id="Aflatoxin'.$form_num.'" name="crop['.$form_num.'][aflatoxin]"> ppb';
            echo '</td></tr>';
        } else { //Plant/Replant
            //custom entry flag
            echo '<tr><td></td><td>';
            echo '<span><input type="checkbox" class="custom_crop_entry_toggle" name="crop['.$form_num.'][other]" value="1">My product isn\'t in these lists.</span>';
            echo '</td></tr>';
        
            //acres planted
            echo '<tr valign="top"><td align="right" width="200"><b>Planted:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo '<input type="text" size="5" id="AcresPlanted'.$form_num.'" name="crop['.$form_num.'][acres_planted]"> acres';
            echo '</td></tr>';
        }

    } else {
        echo '<tr><td colspan="2"><font color="red>Crop/Variety data not found.</font></td></tr>';
    }

    echo '</table>';
    echo '</fieldset>';

?>