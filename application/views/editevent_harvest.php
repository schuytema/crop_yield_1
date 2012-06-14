<h4>Equipment Used</h4>

<?php
    //check for edit
    if(isset($harvest_data) && $harvest_data->num_rows()){
        $row = $harvest_data->row();
    }
    ?>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Brand">
                        <option value="Case IH">Case IH</option>
                        <option value="John Deere">John Deere</option>
                        <option value="Lexion">Lexion</option>
                        <option value="New Holland">New Holland</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product">
                        <option value="7010">7010</option>
                        <option value="7088">7088</option>
                        <option value="8010">8010</option>
                        <option value="8020">8020</option>
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
       
        <h4>Yield Data</h4>   
          
        <table  style="float:left;" width="510">
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Yield:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="4" name="Yield" value="<?php echo set_value('Yield',(isset($row->Yield)) ? $row->Yield : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <?php
                      echo form_dropdown('YieldUnit', $this->config->item('yield_units'), set_value('YieldUnit',(isset($row->YieldUnit)) ? $row->YieldUnit : NULL));
                      ?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Grain Test Weight:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="4" name="GrainTestWeight" value="<?php echo set_value('GrainTestWeight',(isset($row->GrainTestWeight)) ? $row->GrainTestWeight : NULL); ?>">&nbsp;lbs/bu
                      <input type="hidden" name="GrainTestWeightUnit" value="lbs/bu">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent Moisture:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentMoisture" value="<?php echo set_value('PercentMoisture',(isset($row->PercentMoisture)) ? $row->PercentMoisture : NULL); ?>">&nbsp;%
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

