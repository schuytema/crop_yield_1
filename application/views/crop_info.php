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

        //types (list)
        echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
        $items = array(''=>'Select Type');
        foreach($result AS $row){
            $items[$row->CropType] = $row->CropType;
        }
        
        echo form_dropdown('crop['.$form_num.'][type]',$items, set_value('crop['.$form_num.'][type]',(isset($crop['Type'])) ? $crop['Type'] : NULL), 'id="CropType'.$form_num.'"');
        echo '</td></tr>';

        //brands (list)
        echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
        $items = array();
        if (isset($crop['brand_list']) && $crop['brand_list']->num_rows()) {
            $result = $crop['brand_list']->result();
            foreach($result AS $row){
                $items[$row->Brand] = $row->Brand;
            }
        } else {
            $items = array(''=>'Select Type');
        }
        
        echo form_dropdown('crop['.$form_num.'][brand]',$items, set_value('crop['.$form_num.'][brand]',(isset($crop['Brand'])) ? $crop['Brand'] : NULL), 'id="CropBrand'.$form_num.'"');
        
        //brands (custom input)
        $data = array(
              'name'        => 'crop['.$form_num.'][other_brand]',
              'id'          => 'OtherCropBrand'.$form_num,
              'maxlength'   => '100',
              'size'        => '40',
              'value'       => set_value('crop['.$form_num.'][other_brand]')
            );
        echo form_input($data);

        echo '</td></tr>';

        
        //products (list)
        echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
        $items = array();
        if (isset($crop['product_list']) && $crop['product_list']->num_rows()) {
            $result = $crop['product_list']->result();
            foreach($result AS $row){
                $items[$row->PK_CropId] = $row->Product;
            }
        } else {
            $items = array(''=>'Select Brand');
        }
        
        echo form_dropdown('crop['.$form_num.'][product]',$items, set_value('crop['.$form_num.'][product]',(isset($crop['Product'])) ? $crop['Product'] : NULL), 'id="CropProduct'.$form_num.'"');
        
        //products (custom input)
        $data = array(
              'name'        => 'crop['.$form_num.'][other_product]',
              'id'          => 'OtherCropProduct'.$form_num,
              'maxlength'   => '200',
              'size'        => '40',
              'value'       => set_value('crop['.$form_num.'][other_product]')
            );
        echo form_input($data);

        echo '</td></tr>';       
        
        //crop instance ID - hidden
        echo form_hidden('crop['.$form_num.'][crop_instance_id]', (isset($crop['crop_instance_id'])) ? $crop['crop_instance_id'] : NULL);

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
            
            $data = array(
                'class'       => 'custom_crop_entry_toggle',
                'name'        => 'crop['.$form_num.'][other]',
                'value'       => '1',
                'checked'     => set_value('crop['.$form_num.'][other]')
                );

            echo '<tr><td></td><td><span>'.form_checkbox($data)."My product isn't in these lists.</span></td></tr>";
        
            //acres planted
            $data = array(
                'name'        => 'crop['.$form_num.'][acres_planted]',
                'id'          => 'AcresPlanted'.$form_num,
                'maxlength'   => '5',
                'size'        => '5',
                'value'       => set_value('crop['.$form_num.'][acres_planted]',(isset($crop['acres_planted'])) ? $crop['acres_planted'] : NULL)
                );
            
            echo '<tr valign="top"><td align="right" width="200"><b>Planted:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo form_input($data).' acres';
            echo '</td></tr>';
        }

    } else {
        echo '<tr><td colspan="2"><font color="red>Crop/Variety data not found.</font></td></tr>';
    }

    echo '</table>';
    echo '</fieldset>';

?>