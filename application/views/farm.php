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
          </tr>
          </table>
    <BR CLEAR=LEFT>
    <br>
    <span class="fieldhead">Your Fields</span><br>
    <table  id="table-data" width="650">
        <thead>
            <th width="50">Done?</th>
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
                    $field_done = $this->m_event->field_done_for_season($row->PK_FieldId);
                    if ($field_done)
                    {
                        echo '<td><img src="'.base_url().'css/images/done_check_sm.png"></td>';
                    } else {
                        echo '<td>&nbsp;</td>';
                    }
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

