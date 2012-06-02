
<!-- Begin Page Menu  -->

   <div id="introduction"><br />
       <h3>Account Access</h3>
        <ul>
                <li><a href="<?php echo base_url(); ?>main/login">Login</a></li>
                <li><a href="<?php echo base_url(); ?>main/signup">Sign Up</a></li>
        </ul>
       <br>
       <?php if ($member) {?>
        <h3>My Farm</h3>
        <ul>
                <li><a href="<?php echo base_url(); ?>member/farm">Overview</a></li>
                <li><a href="<?php echo base_url(); ?>member/editfield">Add Field</a></li>
        </ul>
       <?php } ?>
<br />
<br />
   <img src="<?php echo base_url(); ?>css/images/sm_logo2.jpg" alt="logo" width="165" height="97" /></div>

  
</div>


<!-- footer -->

</div>
<div id="footer">
<span class="style5">copyright 2012 GrowYourFarm.com | <a href="<?php echo base_url(); ?>main/privacy">Privacy Policy</a> | <a href="<?php echo base_url(); ?>main/terms">Terms of Use</a></span><br />
<br />
</div>
</div>

</body>

</html>