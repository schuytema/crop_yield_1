   <h3>Event Fertilizer Details</h3>
   
   <?php
    //check for edit
    if(isset($fertilizer_data) && $fertilizer_data->num_rows()){
        $row = $fertilizer_data->row();
    }
    ?>
       
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Percent N:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="3" name="PercentN" value="<?php echo set_value('PercentN',(isset($row->PercentN)) ? $row->PercentN : NULL); ?>">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent P:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentP" value="<?php echo set_value('PercentP',(isset($row->PercentP)) ? $row->PercentP : NULL); ?>">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent K:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentK" value="<?php echo set_value('PercentK',(isset($row->PercentK)) ? $row->PercentK : NULL); ?>">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Application Rate:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="ApplicationRate" value="<?php echo set_value('ApplicationRate',(isset($row->ApplicationRate)) ? $row->ApplicationRate : NULL); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <?php
                      //$options = array('lbs/acre','lbs/sq. mile');
                      echo form_dropdown('ApplicationRateUnit', $this->config->item('fertilizer_units'), set_value('ApplicationRateUnit',(isset($row->ApplicationRateUnit)) ? $row->ApplicationRateUnit : NULL));
                      ?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Variable Rate?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      //$options = array('Ammonia','Lime');
                      echo form_dropdown('VariableRate', $this->config->item('no_yes'), set_value('Product',(isset($row->VariableRate)) ? $row->VariableRate : NULL));
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

