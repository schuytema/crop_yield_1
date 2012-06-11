<!-- content -->
<div class="splitleft">
    <h1>Edit Farm</h1>
    <p>Use this form to enter and update your basic farm information.</p>
    <?php echo '<p><font color="red">'.validation_errors().'</font></p>'; ?>
    <form action="<?php echo $action; ?>" method="POST">
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Farm Name:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="40" name="Name" value="<?php echo set_value('Name'); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Address:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="50" name="Address" value="<?php echo set_value('Address'); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right" colspan="2">
                      <b>City:</b>&nbsp;&nbsp;<input type="text" size="20" name="City" value="<?php echo set_value('City'); ?>">&nbsp;&nbsp;<b>State:</b>&nbsp;&nbsp;<input type="text" size="2" name="State" value="<?php echo set_value('State'); ?>">&nbsp;&nbsp;<b>Zip:</b>&nbsp;&nbsp;<input type="text" size="10" name="Zip" value="<?php echo set_value('Zip'); ?>">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Phone:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="50" name="Phone" value="<?php echo set_value('Phone'); ?>">
                  </td>
               </tr>
          </table>
    <BR CLEAR=LEFT>
	<footer>
	  <input type="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

