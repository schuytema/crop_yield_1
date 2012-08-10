<table  style="float:left;" width="510">
        <?php            
        //Power
        if($power->num_rows()){
            $result = $power->result();

            //equipment select
            echo '<tr valign="top"><td align="right" width="200"><b>Power:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            $imps = array('' => 'Select Power');
            foreach($result AS $item){
                $imps[$item->FK_EquipmentId] = $item->Name;
            }

            echo form_dropdown('EquipmentPower', $imps, set_value('EquipmentPower',(isset($row->FK_EquipmentId_Power)) ? $row->FK_EquipmentId_Power : NULL));
            echo '</td></tr>';
        } else {
            echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
        }

        //Implement
        if($implements->num_rows()){
            $result = $implements->result();

            //equipment select
            echo '<tr valign="top"><td align="right" width="200"><b>Implement:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

            $imps = array('' => 'Select Implement');
            foreach($result AS $item){
                $imps[$item->FK_EquipmentId] = $item->Name;
            }

            echo form_dropdown('EquipmentImplement', $imps, set_value('EquipmentImplement',(isset($row->FK_EquipmentId)) ? $row->FK_EquipmentId : NULL));
            echo '</td></tr>';
        } else {
            //echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            $imps = array('' => 'No Implements Defined');
            echo '<tr valign="top"><td align="right" width="200"><b>Implement:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
            echo form_dropdown('EquipmentImplement', $imps, set_value('EquipmentImplement',(isset($row->FK_EquipmentId)) ? $row->FK_EquipmentId : NULL));
            echo '</td></tr>';
        } 
        
        
        
        
        ?>
</table>   