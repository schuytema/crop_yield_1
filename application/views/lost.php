<div class="splitleft">
    <h1>Password Reset</h1>
    <?php
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }
    
    if(!isset($reset)){
    ?>
    <p>Forgot your password? Please enter an email address to help locate your account.</p>
    <form class="box lost" action="<?php echo base_url().$url; ?>" method="POST">
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

