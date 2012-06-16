<!-- content -->
<div class="splitleft">
    <h1>Field Overview</h1>
    <h3>Field Map</h3>
    <div id="map_canvas"></div>
    <h3>Field Information</h3>
        <blockquote>
            <?php
                if(isset($field) && $field->num_rows())
                {
                    $row = $field->row();
                    echo '<b>'.$row->Name.'</b><br>';
                    echo $row->UserSize.'&nbsp;'.$row->UserSizeUnit.' (user)<br>';
                    echo 'Drainage Effectiveness:&nbsp;'.$row->PercentDrainageEffectiveness.'%<br>';
                    echo '<a href="'.base_url().'member/editfield/'.$row->PK_FieldId.'">{edit field information}</a>';
                } else {
                    echo '<font color="red">No field data found.</font>';
                }
            ?>
        </blockquote>             
    <h3>Field Events</h3>
    <table  id="table-data" width="650">
        <thead>
            <th width="150">Date</th>
            <th width="100">Event Type</th>
            <th width="200">Notes</th>
            <th width="150">Actions</th>
        </thead>
        <?php
            if($events->num_rows()){
                $result = $events->result();
                foreach($result AS $row)
                {
                    echo '<tr valign="top">';
                    echo '<td>'.$row->Date.'</td>';
                    echo '<td>'.$row->EventType.'</td>';
                    echo '<td>'.$row->Notes.'</td>';
                    $deleteText = "return confirm('Confirm event delete: ".$row->EventType."')";
                    $lower = strtolower($row->EventType);
                    if ($lower == 'plant')
                    {
                        echo '<td><a href="'.base_url().'member/editevent_plant/Plant/'.$row->PK_EventId.'/'.$row->FK_FieldId.'">edit</a>&nbsp;|&nbsp;'.anchor(base_url().'member/delete_event/'.$row->PK_EventId,'delete',array('class'=>'delete','onclick'=>$deleteText)).'</td>';
                    } elseif ($lower == 'replant') {
                        echo '<td><a href="'.base_url().'member/editevent_plant/Replant/'.$row->PK_EventId.'/'.$row->FK_FieldId.'">edit</a>&nbsp;|&nbsp;'.anchor(base_url().'member/delete_event/'.$row->PK_EventId,'delete',array('class'=>'delete','onclick'=>$deleteText)).'</td>';
                    } else {
                        echo '<td><a href="'.base_url().'member/editevent_'.$lower.'/'.$row->PK_EventId.'/'.$row->FK_FieldId.'">edit</a>&nbsp;|&nbsp;'.anchor(base_url().'member/delete_event/'.$row->PK_EventId,'delete',array('class'=>'delete','onclick'=>$deleteText)).'</td>';                  
                    }
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4"><font color="red">No events have been defined for this field.</font></td><tr>';
            }
        ?>
        
    </table>
    <a href="<?php echo base_url(); ?>member/editevent">{add new event}</a>
    <br><br>
</div>