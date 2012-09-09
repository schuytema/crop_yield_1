<div class="splitleft">
    <h1>Grow Our Yields Application Manager</h1>
    <?php
    if($msg){
        echo '<div class="error_msg">'.$msg.'</div>';
    }
    ?>
    <form class="box login" action="<?php echo base_url(); ?>" method="POST">
	<fieldset class="boxBody">
	  <label>Username</label>
	  <input type="text" tabindex="1" placeholder="Enter Your Username" required name="username">
	  <label><a href="<?php echo base_url(); ?>admin/lost" class="rLink" tabindex="5">Forget your password?</a>Password</label>
	  <input type="password" tabindex="2" required name="password">
	</fieldset>
	<footer>
	  <input type="submit" class="btnLogin" value="Login" tabindex="4">
	</footer>
    </form>
    
    <br>
</div>

