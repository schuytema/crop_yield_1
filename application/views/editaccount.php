<div class="splitleft">
    <h1>Edit Your Basic Account Information</span</h3>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/reset.css" /> 
    <form class="box signup" action="<?php echo base_url(); ?>member/farm" method="POST">
	<fieldset class="boxBody">
	  <label>Name</label>
          <table border="0" align="center" cellspacing="0" cellpadding="0" width="420">
              <tr>
                  <td>
                    <input type="text" name="First">
                    <br>&nbsp;&nbsp;&nbsp;&nbsp;<font color="gray>">first</font>
                  </td>
                  <td>
                     <input type="text" name="Last">
                     <br>&nbsp;&nbsp;&nbsp;&nbsp;<font color="gray>">last</font>
                  </td>
          </tr>
          </table>
          <label>Email Address</label>
          <input type="text" name="Email">
          <label>Username</label>
          <input type="text" name="Username">
          <label>Existing Password</label>
          <input type="password" name="Password">
          &nbsp;&nbsp;&nbsp;&nbsp;<label>New Password</label>
          &nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="Password">
          &nbsp;&nbsp;&nbsp;&nbsp;<label>New Password (again)</label>
          &nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="Password2">
	</fieldset>
	<footer>
	  <input type="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    
    <br>
</div>

