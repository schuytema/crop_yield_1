<div class="splitleft">
    <h1>Crop Verification <?php echo help_link('h_verification'); ?></h1>
    <?php
    if($unverified->num_rows()){
        $result = $unverified->result();
        echo '<table id="table-data" width="670">';
        echo '<thead><th width="20%">Type</th><th width="30%">Brand</th><th width="40%">Product</th><th width="10%">Action</th></thead>';
        foreach($result AS $row){
            echo '<tr><td>'.$row->CropType.'</td><td>'.$row->Brand.'</td><td>'.$row->Product.'</td><td>'.anchor('#','Manage',array('name' => 'crop_manage','id' => $row->PK_CropId)).'<div id="m_'.$row->PK_CropId.'"></div></td></tr>';
        }
        echo '</table>';
    } else {
        echo '<p>'.lang('data_crop_verified').'</p>';
    }
    ?>
    <br />
</div>
