<div class="splitleft">
    <p><span class="style4">Grow Your Fields 0.1a Password Reset</span></p>
    <?php
    if($msg){
        echo '<div class="error_msg">'.$msg.'</div>';
    }
    
    if(!isset($reset)){
    ?>
    <p>Forgot your password? Please enter an email address to help locate your account.</p>
    <form class="box lost" action="<?php echo base_url(); ?>main/lost" method="POST">
	<fieldset class="boxBody">
	  <label>Email</label>
	  <input type="text" tabindex="1" placeholder="Enter Your Email Address" required name="Email">
	</fieldset>
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <?php
    } else {
        echo '<p>'.lang('auth_forgot_pass_reset_success').'</p>';
    }
    ?>
    <br>
</div>

