   
    <h3>Event Chemical Details</h3>
    
    <?php
    //check for edit
    if(isset($chemical_data) && $chemical_data->num_rows()){
        $datarow = $chemical_data->row();
    }
    
    if(isset($chemical_info))
    {
        echo '<blockquote>Current Chemical:<br>Type:&nbsp;'.$chemical_info['Type'].'<br>Brand:&nbsp;'.$chemical_info['Brand'].'<br>Product:&nbsp;'.$chemical_info['Product'].'</blockquote>';;
    }
    
    ?>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <?php
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
    <h4>Tank Mix</h4>
        <table  style="float:left;" width="510">   
            <tr valign="top">
                <td align="right" width="200">
                    <b>Product:</b>&nbsp;&nbsp;
                </td>
                <td align="left" colspan="2">
                    <input type="text" id="keyword" name="keyword" size="50"/>&nbsp<a href="javascript:void(0);" id="keyword_submit">click</a>
                    <div id="results" style="display: none;"></div>

                </td>
            </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>(1) Product:</b>&nbsp;&nbsp;
                </td>
                <td align="left" colspan="2">
                    <input type="text" id="FK_ChemicalId" name="FK_ChemicalId" size="50"/>

                </td>
            </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>Amount of Active Ingredient:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="150">
                    <input type="text" size="10" name="AmountActiveIngredient" value="<?php echo set_value('AmountActiveIngredient',(isset($datarow->AmountActiveIngredient)) ? $datarow->AmountActiveIngredient : NULL); ?>">
                </td>
                <td align="left" width="150">
                      <?php
                      echo form_dropdown('AmountActiveIngredientUnit', $this->config->item('chemical_units'), set_value('AmountActiveIngredientUnit',(isset($datarow->AmountActiveIngredientUnit)) ? $datarow->AmountActiveIngredientUnit : NULL));
                      ?>
                </td>
            </tr>
            
                <tr>
                    <td align="right" colspan="2">
                        <a href="#" onclick="javascript:changeToVisible('other_one');">{add another product to my tank}</a>
                        <div id="other_one">
                          <br>Please enter manually (select Type above):<br>
                          Brand:&nbsp;<input type="text" size="40" name="OtherBrand"><br>
                          Product:&nbsp;<input type="text" size="40" name="OtherProduct"><br>
                        </div>
                    </td>
                </tr>
\
          </table>
          <BR CLEAR=LEFT>
          <br><br>

    
   
          
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

<script type="text/javascript">

function changeToVisible(obj)
{
    obj = document.getElementById(obj);
    obj.style.display = 'inline';
}

</script>