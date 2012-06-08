
<!-- Begin Page Menu  -->

   <div id="introduction"><br />
   <?php    if ($member) 
            {
                echo '<h3>Account Access</h3>';
                echo '<ul>';
                echo '<li><a href="'.base_url().'">Logout</a></li>';
                echo '</ul>';
                echo '<br>';
                echo '<h3>My Farm</h3>';
                echo '<ul>';
                echo '<li><a href="'.base_url().'member/farm">Overview</a></li>';
                echo '<li><a href="'.base_url().'member/editfield">Add Field</a></li>';
                echo '</ul>';
            } else {
                echo '<h3>Account Access</h3>';
                echo '<ul>';
                echo '<li><a href="'.base_url().'main/login">Login</a></li>';
                echo '<li><a href="'.base_url().'main/signup">Sign Up</a></li>';
                echo '</ul>';
                
            }
    ?>
<br />
<br />
   <img src="<?php echo base_url(); ?>css/images/sm_logo4.jpg" alt="logo" width="165" height="97" /></div>

  
</div>


<!-- footer -->

</div>
<div id="footer">
<span class="style5">copyright 2012 GrowOurYields.com | <a href="<?php echo base_url(); ?>main/privacy">Privacy Policy</a> | <a href="<?php echo base_url(); ?>main/terms">Terms of Use</a></span><br />
<br />
</div>
</div>

</body>

</html>