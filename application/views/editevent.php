<!-- content -->
<div class="splitleft">
    <h1>Edit Event(New)</h1>
    <?php
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }
    ?>
    <h3>Master Event Data</h3>
    
    <form action="<?php echo base_url(); ?>member/field" method="POST">
        <table  style="float:left;" width="510">
              <tr valign="middle">
                  <td align="right" width="200">
                      <b>Type:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="EventPick" onchange="window.location=this.value;">
                        <option value="<?php echo base_url(); ?>member/editevent">Select Event Type</option>
                        <option value="<?php echo base_url(); ?>member/editevent_application">Lime Application</option>
                        <option value="<?php echo base_url(); ?>member/editevent_chemical">Chemical</option>
                        <option value="<?php echo base_url(); ?>member/editevent_fertilizer">Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/editevent_harvest">Harvest</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant/Plant">Plant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_plant/Replant">Replant</option>
                        <option value="<?php echo base_url(); ?>member/editevent_tillage">Tillage</option>
                        <option value="<?php echo base_url(); ?>member/editevent_weather">Weather</option>
                      </select>
                  </td>
               </tr>

          </table>
    <BR CLEAR=LEFT>
    

    
          

    </form>
    <br><br>
</div>

