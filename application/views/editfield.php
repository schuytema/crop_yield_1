<!-- content -->
<div class="splitleft">
    <h1>Edit Field (New)</h1>
    <h3>Field location</h3>
    <p>Nick puts his Google polygon demo here.</p>
    <h3>Basic Field Data</h3>
    <form action="<?php echo base_url(); ?>member/farm" method="POST">
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Field Name:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="40" name="Name">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Size of Field:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="7" name="UserSizeUnit">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                    <select>
                        <option value="acres">acres</option>
                        <option value="sq. miles">sq. miles</option>
                    </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Drainage Effectiveness:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentDrainageEffectiveness">&nbsp;%
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

