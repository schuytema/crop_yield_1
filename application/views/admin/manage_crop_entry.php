<?php
if($entry->num_rows()){
    $row = $entry->row();
    
    $attr = array('class' => 'verification', 'id' => 'verification');
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
        'name'        => 'UserType',
        'id'          => 'UserType',
        'value'       => $row->CropType,
        'maxlength'   => '100',
        'size'        => '30',
        'style'       => 'width:50%;background-color:#D8D8D8;',
        'readonly'    => 'readonly'
    );
    echo 'Type: '.form_input($data).'<br/>';
     
    $data = array(
        'name'        => 'UserBrand',
        'id'          => 'UserBrand',
        'value'       => $row->Brand,
        'maxlength'   => '100',
        'size'        => '30',
        'style'       => 'width:50%',
    );
    echo 'Brand: '.form_input($data).'<br/>';
    $data = array(
        'name'        => 'UserProduct',
        'id'          => 'UserProduct',
        'value'       => $row->Product,
        'maxlength'   => '200',
        'size'        => '30',
        'style'       => 'width:50%',
    );
    echo 'Product: '.form_input($data).'<br/>';
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
        echo 'Type: <span class="Type">'.$row->CropType.'</span><br />';
        $result = $brand->result();
        $items = array(''=>'Select Brand');
        foreach($result AS $row){
            $items[$row->Brand] = $row->Brand;
        }
        echo 'Brand: '.form_dropdown('Brand',$items,NULL, 'id="Brand"').'<br />';
        echo 'Product: '.form_dropdown('Product',array(''=>'Select Brand'), NULL, 'id="Product"');
        echo '</div>';
        echo '</div>';
    }
    echo form_close();   
} else {
    echo '<p>Crop entry not found.</p>';
}
