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
    <table  id="table-data" width="600">
        <thead>
            <th width="250">Implement</th>
            <th width="100">Type</th>
            <th width="100">Brand</th>
            <th width="150">Actions</th>
        </thead>
        <?php
            
            if($fields->num_rows()){
                $result = $fields->result();
                foreach($result AS $row)
                {
                    echo '<tr>';
                    echo '<td>'.$row->Name.'</td>';
                    echo '<td>'.$row->UserSize.'</td>';
                    $num_events = $this->m_event->get_event_count($row->PK_FieldId);
                    echo '<td>'.$num_events.'</td>';
                    $deleteText = "return confirm('Confirm field delete: ".$row->Name."')";
                    echo '<td><a href="'.base_url().'member/field/'.$row->PK_FieldId.'">details</a>&nbsp;|&nbsp;'.anchor(base_url().'member/delete_field/'.$row->PK_FieldId,'delete',array('class'=>'delete','onclick'=>$deleteText)).'</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4"><font color="red">No fields have been defined for this farm.</font></td><tr>';
            }
        ?>

    </table>
    <a href="<?php echo base_url(); ?>member/editequipment">{add new implement}</a>
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
                    $deleteText = "return confirm('Confirm farm delete: ".$row->Name."')";
                    echo '<td><a href="'.base_url().'member/farm/'.$row->PK_FarmId.'">details</a>&nbsp;|&nbsp;'.anchor(base_url().'member/delete_farm/'.$row->PK_FarmId,'delete',array('class'=>'delete','onclick'=>$deleteText)).'</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4"><font color="red">No farms have been defined for this enterprise.</font></td><tr>';
            }
        ?>

    </table>
    <a href="<?php echo base_url(); ?>member/editfarm">{add new farm}</a>
    <br><br>
</div>

