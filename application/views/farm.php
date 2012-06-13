<!-- content -->
<div class="splitleft">
    <h1>Farm Overview</h1>
    <table  style="float:left;">
              <tr valign="top">
                  <td align="left" width="300">
                    <h3>Farm Information</h3>
                        <blockquote>
                            <?php
                                if(isset($farm) && $farm->num_rows())
                                {
                                    $row = $farm->row();
                                    echo '<b>'.$row->Name.'</b><br>';
                                    echo $row->Address.'<br>';
                                    echo $row->City.',&nbsp;'.$row->State.'&nbsp;&nbsp;'.$row->Zip.'<br>';
                                    echo $row->Phone.'<br>';
                                    echo '<a href="'.base_url().'member/editfarm">{edit farm information}</a>';
                                } else {
                                    echo '<font color="red">No farm data entered yet.</font><br><br>';
                                    echo '<a href="'.base_url().'member/editfarm">{enter initial farm information}</a>';
                                }
                            ?>
                        </blockquote>
                  </td>
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
    <h3>Your Fields</h3>
    <table  id="table-data" width="600">
        <thead>
            <th width="250">Field Name</th>
            <th width="100">Size (acres)</th>
            <th width="100">Events</th>
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
    <a href="<?php echo base_url(); ?>member/editfield">{add new field}</a>
    <br><br>
</div>

