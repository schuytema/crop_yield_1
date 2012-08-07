<div class="splitleft">
    <h1>Edit Event <?php help_link('h_event'); ?></h1>
    
    <?php
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }
    
    //check for edit
    if(isset($event_data) && $event_data->num_rows()){
        $row = $event_data->row();
    }
      
    echo form_open($action);
    ?>
    
    <h3>Master Event Data</h3>
    
    <form action="<?php echo base_url(); ?>member/field" method="POST">
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Type:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="EventPicker" onchange="window.location=this.value;">
                        <option value="<?php echo base_url(); ?>member/editevent_application"<?php if ($event_type == 'Application') { echo ' selected="selected"'; } ?>>Lime Application</option>
                        <option value="<?php echo base_url(); ?>member/editevent_chemical"<?php if ($event_type == 'Chemical') { echo ' selected="selected"'; } ?>>Chemical</option>
                        <option value="<?php echo base_url(); ?>member/editevent_fertilizer"<?php if ($event_type == 'Fertilizer') { echo ' selected="selected"'; } ?>>Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/editevent_harvest"<?php if ($event_type == 'Harvest') { echo ' selected="selected"'; } ?>>Harvest</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant/Plant"<?php if ($event_type == 'Plant') { echo ' selected="selected"'; } ?>>Plant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant/Replant"<?php if ($event_type == 'Replant') { echo ' selected="selected"'; } ?>>Replant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_tillage"<?php if ($event_type == 'Tillage') { echo ' selected="selected"'; } ?>>Tillage</option>
                        <option value="<?php echo base_url(); ?>member/editevent_weather"<?php if ($event_type == 'Weather') { echo ' selected="selected"'; } ?>>Weather</option>
                      </select>
                      <input type="hidden" name="EventType" value="<?php echo $event_type; ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Date:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="15" name="Date" id="Date" value="<?php echo set_value('Date',(isset($row->Date)) ? $row->Date : NULL); ?>" readonly="readonly">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Notes:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <TEXTAREA NAME="Notes" COLS=40 ROWS=6><?php echo set_value('Notes',(isset($row->Notes)) ? $row->Notes : NULL); ?></TEXTAREA>
                  </td>
               </tr>
          </table>
    <BR CLEAR=LEFT>
   
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <?php
                        if ($new_event)
                        {
                            echo '<b>Affected Fields:</b>&nbsp;&nbsp;';
                        } else {
                            echo '<b>Event on Field:</b>&nbsp;&nbsp;';
                        }
                      ?>
                  </td>
                  <td align="left" width="310">
                    <?php
                        if (in_array($event_type,$this->config->item('single_field_events'))) { //single field events
                            if($fields->num_rows()) {
                                $result = $fields->result();
                                $field_arr = array();
                                foreach($result AS $item)
                                {
                                    $field_arr[$item->PK_FieldId] = $item->Name;
                                }
                                echo form_dropdown('fields', $field_arr, set_value('fields',(isset($row->FK_FieldId)) ? $row->FK_FieldId : NULL)); 
                            }
                        }
                        else
                        {
                            if ($new_event)
                            {
                                if($fields->num_rows())
                                {
                                    $result = $fields->result();
                                    {
                                        //allowed to pick multiple fields
                                        foreach($result AS $item)
                                        {
                                            echo '<input type="checkbox" name="fields[]" value="'.$item->PK_FieldId.'">'.$item->Name.'<br>';
                                        }
                                    }
                                }
                            } else {
                                echo $field_name;
                            }
                        }
                    ?>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          <br>