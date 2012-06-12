<!-- content -->
<div class="splitleft">
    <?php
    echo '<h1>'.$page_title.'</h1>';
    echo '<p>'.$desc.'</p>';
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }
    
    //check for edit
    if(isset($farm_data) && $farm_data->num_rows()){
        $arr = array();
        $row = $farm_data->row();
        foreach ($row AS $field => $val){
            $arr[$field] = $val;
        }
    }
      
    echo form_open('member/editfarm');
    ?>
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Farm Name:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="40" name="Name" value="<?php echo set_value('Name',(isset($arr['Name'])) ? $arr['Name'] : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Address:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="50" name="Address" value="<?php echo set_value('Address',(isset($arr['Address'])) ? $arr['Address'] : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right" colspan="2">
                      <b>City:</b>&nbsp;&nbsp;<input type="text" size="20" name="City" value="<?php echo set_value('City',(isset($arr['City'])) ? $arr['City'] : NULL); ?>">&nbsp;&nbsp;<b>State:</b>&nbsp;&nbsp;<?php echo form_dropdown('State',$this->config->item('states'), set_value('State',(isset($arr['State'])) ? $arr['State'] : NULL));?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right" colspan="2">
                      <b>Zip:</b>&nbsp;&nbsp;<input type="text" size="10" name="Zip" value="<?php echo set_value('Zip',(isset($arr['Zip'])) ? $arr['Zip'] : NULL); ?>">&nbsp;&nbsp;<b>Phone:</b>&nbsp;&nbsp;<input type="text" size="20" name="Phone" value="<?php echo set_value('Phone',(isset($arr['Phone'])) ? $arr['Phone'] : NULL); ?>">
                  </td>
                  
               </tr>
          </table>
    <BR CLEAR=LEFT>
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    <?php
    echo form_close();
    ?>
    <br><br>
</div>

