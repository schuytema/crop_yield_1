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
                        <option value="<?php echo base_url(); ?>member/event_check/Application">Lime Application</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Chemical">Chemical</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Fertilizer">Fertilizer</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Harvest">Harvest</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Plant">Plant</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Replant">Replant</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Tillage">Tillage</option>
                        <option value="<?php echo base_url(); ?>member/event_check/Weather">Weather</option>
                      </select>
                  </td>
               </tr>

          </table>
    <BR CLEAR=LEFT>
    

    
          

    </form>
    <br><br>
</div>

