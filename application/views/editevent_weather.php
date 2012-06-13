<h3>Event Weather Details</h3>

<?php
    //check for edit
    if(isset($weather_data) && $weather_data->num_rows()){
        $row = $weather_data->row();
    }
    ?>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Weather:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <?php
                      echo form_dropdown('Weather', $this->config->item('weather'), set_value('Weather',(isset($row->Weather)) ? $row->Weather : NULL));
                      ?>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent Damaged:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentDamaged" value="<?php echo set_value('PercentDamaged',(isset($row->PercentDamaged)) ? $row->PercentDamaged : NULL); ?>">&nbsp;%
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

