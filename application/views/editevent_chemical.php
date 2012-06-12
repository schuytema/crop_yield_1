   
    <h3>Event Chemical Details</h3>
    
    
    
    
    
    
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
                    
                    echo '<select id="Brand" name="Brand"><option>select type...</select>';

                    echo '</td></tr>';

                    //products
                    echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';
                    
                    echo '<select id="Product" name="Product"><option>select brand...</select></select>';

                    echo '</td></tr>';
                    

                } else {
                    echo '<tr><td colspan="2"><font color="red>Chemical data not found.</font></td><tr>';
                }
            
            ?>
            
            
              
               <tr valign="top">
                  <td align="right">
                      <b>Amount of Active Ingredient:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="AmountActiveIngredient">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="AmountActiveIngredientUnit">
                        <option value="lbs">lbs</option>
                        <option value="kg">kq</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          <br><br>

    
   
          
	<footer>
	  <input type="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

