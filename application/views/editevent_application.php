
    <h3>Event Application Details</h3>
    
    <?php
    //check for edit
    if(isset($application_data) && $application_data->num_rows()){
        $row = $application_data->row();
    }
    ?>
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      //$options = array('Ammonia','Lime');
                      echo form_dropdown('Product', $this->config->item('application_product'), set_value('Product',(isset($row->Product)) ? $row->Product : NULL));
                    ?>
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
                      echo form_dropdown('ApplicationRateUnit', $this->config->item('application_units'), set_value('ApplicationRateUnit',(isset($row->ApplicationRateUnit)) ? $row->ApplicationRateUnit : NULL));
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

