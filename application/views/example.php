<?php
echo '<div class="splitleft">';

if($types->num_rows()){
    $result = $types->result();
    
    //types
    echo 'Chemical type: <select id="ChemicalType" name="ChemicalType"><option value ="">Select Type</option>';
    foreach($result AS $row){
        echo '<option value ="'.$row->ChemicalType.'">'.$row->ChemicalType.'</option>';
    }
    echo '</select>';
    
    echo '<br /><br />';
    
    //brands
    echo 'Brand: <select id="Brand" name="Brand"><option>select type...</select>';
    
    echo '<br /><br />';
    
    //products
    echo 'Product: <select id="Product" name="Product"><option>select brand...</select></select>';
    
} else {
    echo '<p>Chemical data not found.</p>';
}

echo '</div>';
