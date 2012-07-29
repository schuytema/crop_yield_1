<h3>Event Tillage Details</h3>

<?php
    //check for edit
    if(isset($tillage_data) && $tillage_data->num_rows()){
        $row = $tillage_data->row();
    }
    ?>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <?php
            if($power->num_rows()){
                $result = $power->result();

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Power:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                $imps = array();
                if (!isset($row->FK_EquipmentId))
                {
                    $imps['0'] = 'Select Power';
                }
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('Power', $imps, set_value('Power',(isset($row->FK_EquipmentId_Power)) ? $row->FK_EquipmentId_Power : NULL));
                //echo form_dropdown('EquipmentProduct', $imps, set_select('EquipmentProduct', $row->FK_EquipmentId, TRUE));
                


                echo '</td></tr>';

              


            } else {
                echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            }
            
            if($implements->num_rows()){
                $result = $implements->result();

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Implement:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                $imps = array();
                if (!isset($row->FK_EquipmentId))
                {
                    $imps['0'] = 'Select Implement';
                }
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('EquipmentProduct', $imps, set_value('EquipmentProduct',(isset($row->FK_EquipmentId)) ? $row->FK_EquipmentId : NULL));
                //echo form_dropdown('EquipmentProduct', $imps, set_select('EquipmentProduct', $row->FK_EquipmentId, TRUE));
                


                echo '</td></tr>';

              


            } else {
                echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            }

        ?>
          </table>
          <BR CLEAR=LEFT>
    <br><br>
    
   
          
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

