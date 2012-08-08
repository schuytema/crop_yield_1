<?php
    //create form elements related to this crop
    echo '<fieldset style="width:510px;" class="crop_entry"><legend>Crop/Variety</legend>';
    echo '<table  style="float:left;" width="510">';

    //type
    echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">'.$crop['Type'].'</td></tr>';
    
    //brand
    echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">'.$crop['Brand'].'</td></tr>';
    
    //product
    echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">'.$crop['Product'].'</td></tr>';
    
    //acres planted
    echo '<tr valign="top"><td align="right" width="200"><b>Acres Planted:</b>&nbsp;&nbsp;</td><td align="left" width="310">'.$crop['acres_planted'].'</td></tr>';
 
    //yield
    $data = array(
        'name'        => 'crop['.$form_num.'][yield]',
        'id'          => 'Yield'.$form_num,
        'maxlength'   => '5',
        'size'        => '5',
        'value'       => set_value('crop['.$form_num.'][yield]',(isset($crop['yield'])) ? $crop['yield'] : NULL)
        );
    
    echo '<tr valign="top"><td align="right" width="200"><b>Yield:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
    echo form_input($data).' bu/acre';
    echo '</td></tr>';
    
    //grain test weight
    $data = array(
        'name'        => 'crop['.$form_num.'][grain_test_weight]',
        'id'          => 'GrainTestWeight'.$form_num,
        'maxlength'   => '6',
        'size'        => '6',
        'value'       => set_value('crop['.$form_num.'][grain_test_weight]',(isset($crop['grain_test_weight'])) ? $crop['grain_test_weight'] : NULL)
        );
    
    echo '<tr valign="top"><td align="right" width="200"><b>Grain Test Weight:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
    echo form_input($data).' lbs/bu';
    echo '</td></tr>';    
            
    //harvest percent moisture
    $data = array(
        'name'        => 'crop['.$form_num.'][percent_moisture]',
        'id'          => 'PercentMoisture'.$form_num,
        'maxlength'   => '6',
        'size'        => '6',
        'value'       => set_value('crop['.$form_num.'][percent_moisture]',(isset($crop['percent_moisture'])) ? $crop['percent_moisture'] : NULL)
        );
    
    echo '<tr valign="top"><td align="right" width="200"><b>Harvest Percent Moisture:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
    echo form_input($data);
    echo '</td></tr>';
            
    //aflatoxin
    $data = array(
        'name'        => 'crop['.$form_num.'][aflatoxin]',
        'id'          => 'Aflatoxin'.$form_num,
        'maxlength'   => '6',
        'size'        => '6',
        'value'       => set_value('crop['.$form_num.'][aflatoxin]',(isset($crop['aflatoxin'])) ? $crop['aflatoxin'] : NULL)
        );
    
    echo '<tr valign="top"><td align="right" width="200"><b>Aflatoxin:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
    echo form_input($data).' ppb';
    echo '</td></tr>';
    
    echo '<td><tr>';       
    //crop instance ID - hidden
    echo form_hidden('crop['.$form_num.'][crop_instance_id]', (isset($crop['crop_instance_id'])) ? $crop['crop_instance_id'] : NULL);
    echo '</td></tr>';

    echo '</table>';
    echo '</fieldset>';
?>