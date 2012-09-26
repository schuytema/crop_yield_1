<?php
if($entry->num_rows()){
    $row = $entry->row();
    
    $attr = array('class' => 'equip_verification', 'id' => 'equip_verification');
    echo form_open('#',$attr);
    $data = array(
        'name'        => 'val_type',
        'value'       => 'user',
        'checked'     => TRUE,
        'style'       => 'margin:5px'
    );
    echo form_radio($data).'Accept or modify user-supplied entry:<br/>';
    echo '<div class="div_user">';
    
    echo '<div style="margin:0 0 0 20px;">';
    $data = array(
        'name'        => 'Type',
        'id'          => 'Type',
        'value'       => $row->EquipmentType,
        'maxlength'   => '100',
        'size'        => '30',
        'style'       => 'width:50%;background-color:#D8D8D8;',
        'readonly'    => 'readonly'
    );
    echo 'Type: '.form_input($data).'<br/>';
     
    $data = array(
        'name'        => 'Brand',
        'id'          => 'Brand',
        'value'       => $row->Brand,
        'maxlength'   => '100',
        'size'        => '30',
        'style'       => 'width:50%',
    );
    echo 'Brand: '.form_input($data).'<br/>';
    $data = array(
        'name'        => 'Product',
        'id'          => 'Product',
        'value'       => $row->Product,
        'maxlength'   => '200',
        'size'        => '30',
        'style'       => 'width:50%',
    );
    echo 'Product/Model: '.form_input($data).'<br/>';
    
    $options = array(0 => 'No',1 => 'Yes');
    echo 'Power: '.form_dropdown('Power',$options,$row->Power).'<br/>';
    
    if($row->EquipmentType == 'Tillage'){
        echo 'Tillage type: '.form_dropdown('TillageType', $this->config->item('tillage_type'),$row->TillageType);
    }
    
    echo '</div>';
    echo '</div>';
        
    if($brand->num_rows()){
        $data = array(
            'name'        => 'val_type',
            'value'       => 'db',
            'style'       => 'margin:5px'
        );
        echo '<br>'.form_radio($data).'Replace user-supplied entry with item from database:<br/>';
        echo '<div class="div_db" style="display: none;">';
        echo '<div style="margin:0 0 0 20px;">';
        echo 'Type: <span class="EquipmentType">'.$row->EquipmentType.'</span><br />';
        $result = $brand->result();
        $items = array(''=>'Select Brand');
        foreach($result AS $row){
            $items[$row->Brand] = $row->Brand;
        }
        echo 'Brand: '.form_dropdown('EquipBrand',$items,NULL, 'id="EquipBrand"').'<br />';
        echo 'Product/Model: '.form_dropdown('EquipProduct',array(''=>'Select Brand'), NULL, 'id="EquipProduct"');
        echo '</div>';
        echo '</div>';
    }
    echo form_close();   
} else {
    echo '<p>Equipment entry not found.</p>';
}
