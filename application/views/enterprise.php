<!-- content -->
<div class="splitleft">
    <h1>Enterprise Overview</h1>
    <table  style="float:left;">
              <tr valign="top">
                  <td align="left" width="300">
                     <h3>Account Information</h3>
                        <blockquote>
                            <?php
                                if(isset($user_info) && $user_info->num_rows())
                                {
                                    $row = $user_info->row();
                                    echo $row->FirstName.'&nbsp;'.$row->LastName.'<br>';
                                    echo 'Username:&nbsp;'.$row->Username.'<br>';
                                    echo 'Email:&nbsp;'.$row->Email.'<br>';
                                    echo '<a href="'.base_url().'member/editaccount">{edit account information}</a>';
                                } else {
                                    echo '<font color="red">No account data found.</font><br><br>';
                                }
                            ?>
                        </blockquote>
                  </td>
          </tr>
          </table>
    <BR CLEAR=LEFT>
    <br>
    <span class="shedhead">Machine Shed</span><br>
    <table  id="table-data" width="670">
        <thead>
            <th width="200">Implement Nickname</th>
            <th width="100">Type</th>
            <th width="100">Brand</th>
            <th width="200">Product</th>
            <th width="70">Action</th>
        </thead>
        <?php
            
            if($implements->num_rows()){
                $result = $implements->result();
                foreach($result AS $row)
                {
                    echo '<tr valign="top">';
                    echo '<td>'.$row->Name.'</td>';
   
                    $prod_info = $this->m_equipment->get_product_info($row->FK_EquipmentId);
                    echo '<td>'.$prod_info['Type'].'</td>';
                    echo '<td>'.$prod_info['Brand'].'</td>';
                    echo '<td>'.$prod_info['Product'].'</td>';
                    $deleteText = "return confirm('Confirm implement delete: ".$row->Name."')";
                    echo '<td>'.anchor(base_url().'member/delete_shed/'.$row->PK_ShedId,'delete',array('class'=>'delete','onclick'=>$deleteText)).'</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5"><font color="red">No implements have been defined for this enterprise.</font></td><tr>';
            }
        ?>

    </table>
    <a href="<?php echo base_url(); ?>member/editshed">{add new implement}</a>
    <BR CLEAR=LEFT>
    <br>
    <span class="farmhead">Your Farms</span><br>
    <table  id="table-data" width="600">
        <thead>
            <th width="250">Farm Name</th>
            <th width="100">Location</th>
            <th width="100">Num Fields</th>
            <th width="150">Actions</th>
        </thead>
        <?php
            
            if($farms->num_rows()){
                $result = $farms->result();
                foreach($result AS $row)
                {
                    echo '<tr>';
                    echo '<td>'.$row->Name.'</td>';
                    echo '<td>'.$row->City.'</td>';
                    $num_fields = $this->m_farm->get_field_count($row->PK_FarmId);
                    echo '<td>'.$num_fields.'</td>';
                    echo '<td><a href="'.base_url().'member/load_farm/'.$row->PK_FarmId.'">details</a>&nbsp;|&nbsp;'.anchor(base_url().'member/delete_farm/'.$row->PK_FarmId,'delete',array('class'=>'delete','onclick'=>'return confirm(\'Do you want to delete '.$row->Name.'?\n\nPlease confirm you want to delete this farm, along with all associated fields and events.\')')).'</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4"><font color="red">No farms have been defined for this enterprise.</font></td><tr>';
            }
        ?>

    </table>
    <a href="<?php echo base_url(); ?>member/addfarm">{add new farm}</a>
    <br><br>
</div>

