<h3>Event Tillage Details</h3>
    
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
                        <option value="Other" >Other</option>
                      </select>
                      <div id="other_one">
                          <br>Please enter:&nbsp;<input type="text" size="20" name="OtherBrand">
                      </div>
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
                        <option value="Other">Other</option>
                      </select>
                      <div id="other_two">
                          <br>Please enter:&nbsp;<input type="text" size="20" name="OtherProduct">
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

function changeToVisible(val, obj)
{
    obj = document.getElementById(obj);
    if (val == 'Other')
    {
        //obj.style.visibility = 'visible';
        obj.style.display = 'inline';
    } else {
        //obj.style.visibility = 'hidden';
        obj.style.display = 'none';
    }

}

</script>

