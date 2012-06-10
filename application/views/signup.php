<div class="splitleft">
    <p><span class="style4">Sign up to access Grow Your Fields 0.1a</span></p>
    <?php
    if($msg){
        echo '<div class="error_msg">'.$msg.'</div>';
    }
    ?>
    <form class="box signup" action="<?php echo base_url(); ?>main/signup" method="POST">
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
          <label>Password</label>
          <input type="password" name="Password">
          <label>Password (again)</label>
          <input type="password" name="Password2">
          <label>Invitation Key</label>
          <input type="text" name="Key">
          <label>Terms of Use</label>
          &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="Terms">&nbsp;&nbspI have read and accepted the <a href="<?php echo base_url(); ?>main/terms" target="_blank">Terms of Use</a>
	</fieldset>
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Sign Up" tabindex="4">
	</footer>
    </form>
    
    <br>
</div>

