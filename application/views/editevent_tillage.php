<h3>Event Tillage Details</h3>

<?php
    //check for edit
    if(isset($tillage_data) && $tillage_data->num_rows()){
        $row = $tillage_data->row();
    }
    ?>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Brand" onchange="javascript:changeToVisible(this.options[this.selectedIndex].value,'other_one');">
                        <option value="Bush Hog">Bush Hog</option>
                        <option value="Case IH">Case IH</option>
                        <option value="Ford">Ford</option>
                        <option value="John Deere">John Deere</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product" onchange="javascript:changeToVisible(this.options[this.selectedIndex].value,'other_two');">
                        <option value="610">610</option>
                        <option value="625">625</option>
                        <option value="980">980</option>
                        <option value="1010">1010</option>
                      </select>
                  </td>
               </tr>
               <tr>
                    <td align="right" colspan="2">
                        <a href="javascript:Void(0);" onclick="javascript:changeToVisible('other_one');">{my equipment isn't in these lists}</a>
                        <div id="other_one">
                          <br>Please enter equipment manually:<br>
                          Brand:&nbsp;<input type="text" size="40" name="OtherBrand"><br>
                          Product:&nbsp;<input type="text" size="40" name="OtherProduct"><br>
                        </div>
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


<script type="text/javascript">

function changeToVisible(obj)
{
    obj = document.getElementById(obj);
    obj.style.display = 'inline';
}

</script>

