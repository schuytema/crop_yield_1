   
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
    
    
    
    
        <table  style="float:left;" width="510">
            
            <?php
            
                if($types->num_rows()){
                    $result = $types->result();

                    //types
                    echo '<tr valign="top"><td align="right" width="200"><b>Type:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    echo '<select id="ChemicalType" name="ChemicalType"><option value ="">Select Type</option>';
                    foreach($result AS $row){
                    echo '<option value ="'.$row->ChemicalType.'">'.$row->ChemicalType.'</option>';
                    }
                    echo '</select>';

                    echo '</td></tr>';

                    //brands
                    echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    
                    echo '<select id="Brand" name="Brand"><option>select type...</option></select>';

                    echo '</td></tr>';

                    //products
                    echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    
                    echo '<select id="Product" name="Product"><option value="">select brand...</option></select>';

                    echo '</td></tr>';
                    

                } else {
                    echo '<tr><td colspan="2"><font color="red>Chemical data not found.</font></td></tr>';
                }
            
            ?>
            
                <tr>
                    <td align="right" colspan="2">
                        <a href="#" onclick="javascript:changeToVisible('other_one');">{my product isn't in these lists}</a>
                        <div id="other_one">
                          <br>Please enter manually (select Type above):<br>
                          Brand:&nbsp;<input type="text" size="40" name="OtherBrand"><br>
                          Product:&nbsp;<input type="text" size="40" name="OtherProduct"><br>
                        </div>
                    </td>
                </tr>
            
              
               <tr valign="top">
                  <td align="right">
                      <b>Amount of Active Ingredient:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="AmountActiveIngredient" value="<?php echo set_value('AmountActiveIngredient',(isset($datarow->AmountActiveIngredient)) ? $datarow->AmountActiveIngredient : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <?php
                      echo form_dropdown('AmountActiveIngredientUnit', $this->config->item('chemical_units'), set_value('AmountActiveIngredientUnit',(isset($datarow->AmountActiveIngredientUnit)) ? $datarow->AmountActiveIngredientUnit : NULL));
                      ?>
                  </td>
               </tr>
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