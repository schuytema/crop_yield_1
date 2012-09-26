<div class="splitleft">
    <h1>Equipment Verification</h1>
    <?php
    if($unverified->num_rows()){
        $result = $unverified->result();
        echo '<table id="table-data" width="670">';
        echo '<thead><th width="20%">Type</th><th width="30%">Brand</th><th width="40%">Product/Model</th><th width="10%">Action</th></thead>';
        foreach($result AS $row){
            echo '<tr><td>'.$row->EquipmentType.'</td><td>'.$row->Brand.'</td><td>'.$row->Product.'</td><td>'.anchor('#','Manage',array('name' => 'equip_manage','id' => $row->PK_EquipmentId)).'<div id="m_'.$row->PK_EquipmentId.'"></div></td></tr>';
        }
        echo '</table>';
    } else {
        echo '<p>All equipment data is validated.</p>';
    }
    ?>
    <br />
</div>
