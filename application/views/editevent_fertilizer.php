   <h3>Event Fertilizer Details</h3>
   
   <?php
    //check for edit
    if(isset($fertilizer_data) && $fertilizer_data->num_rows()){
        $row = $fertilizer_data->row();
    }
    ?>
       
        <table  style="float:left;" width="450">
              <tr valign="top">
                  <td align="right" width="50">
                      <b>N:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="100">
                      <input type="text" size="4" name="PercentN" value="<?php echo set_value('PercentN',(isset($row->PercentN)) ? $row->PercentN : NULL); ?>">&nbsp;lbs/100
                  </td>
                  <td align="right" width="50">
                      <b>P:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="100">
                      <input type="text" size="4" name="PercentP" value="<?php echo set_value('PercentP',(isset($row->PercentP)) ? $row->PercentP : NULL); ?>">&nbsp;lbs/100
                  </td>
                  <td align="right" width="50">
                      <b>K:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="100">
                      <input type="text" size="4" name="PercentK" value="<?php echo set_value('PercentK',(isset($row->PercentK)) ? $row->PercentK : NULL); ?>">&nbsp;lbs/100
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right" colspan="3">
                      <b>Average Application Rate:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" colspan="1">
                      <input type="text" size="10" name="ApplicationRate" value="<?php echo set_value('ApplicationRate',(isset($row->ApplicationRate)) ? $row->ApplicationRate : NULL); ?>">
                  </td>
                  <td align="left" colspan="2">
                      <?php
                      //$options = array('lbs/acre','lbs/sq. mile');
                      echo form_dropdown('ApplicationRateUnit', $this->config->item('fertilizer_units'), set_value('ApplicationRateUnit',(isset($row->ApplicationRateUnit)) ? $row->ApplicationRateUnit : NULL));
                      ?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right" colspan="3">
                      <b>Variable Rate?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" colspan="3">
                    <?php
                      echo form_dropdown('VariableRate', $this->config->item('no_yes_boolean'), set_value('VariableRate',(isset($row->VariableRate)) ? $row->VariableRate : NULL));
                    ?>
                  </td>
               </tr>
               
               <tr valign="top">
                  <td align="right" colspan="3">
                      <b>Form:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" colspan="3">
                    <?php
                      echo form_dropdown('Form', $this->config->item('fertilizer_form'), set_value('Form',(isset($row->Form)) ? $row->Form : NULL));
                    ?>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          <h4>Additives</h4>
        <table  style="float:left;" width="510">
            <tr valign="top">
                  <td align="right" width="200">
                      <b>Nitrogen Stabilizer?:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <?php
                      echo form_dropdown('NitrogenStabilizer', $this->config->item('no_yes_boolean'), set_value('NitrogenStabilizer',(isset($row->NitrogenStabilizer)) ? $row->NitrogenStabilizer : NULL));
                    ?>
                  </td>
               </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>Chelated Zinc:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('ChelatedZinc', $this->config->item('no_yes_boolean'), set_value('ChelatedZinc',(isset($row->ChelatedZinc)) ? $row->ChelatedZinc : NULL));
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>Sulphur:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('Sulphur', $this->config->item('no_yes_boolean'), set_value('Sulphur',(isset($row->Sulphur)) ? $row->Sulphur : NULL));
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>Boron:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('Boron', $this->config->item('no_yes_boolean'), set_value('Boron',(isset($row->Boron)) ? $row->Boron : NULL));
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

