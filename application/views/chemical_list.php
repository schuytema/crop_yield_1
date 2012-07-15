<?php
if($list->num_rows()){
    $result = $list->result();
    foreach($result AS $row){
        echo '<p><b>ID</b>: '.$row->PK_ChemicalId.' <b>Brand</b>: '.$row->Brand.' <b>Product</b>: '.$row->Product.'<p>';
    }
} else {
    echo '<p>Product not found. Please search again.</p>';
}
echo '<br />';