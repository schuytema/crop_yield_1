
<!-- Begin Page Menu  -->

   <div id="introduction"><br />
   <?php    if ($this->php_session->get('AUTH')) 
            {
                echo '<h3>Account Access</h3>';
                echo '<ul>';
                echo '<li><a href="'.base_url().'member/logout">Logout</a></li>';
                echo '</ul>';
                echo '<br>';
                echo '<h3>My Farm</h3>';
                echo '<ul>';
                echo '<li><a href="'.base_url().'member/farm">Overview</a></li>';
                echo '<li><a href="'.base_url().'member/editfield">Add Field</a></li>';
                echo '<li><a href="'.base_url().'member/editevent">Add Event</a></li>';
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
<span class="style5">&copy; 2012 GrowOurYields, LLC (all rights reserved) | <a href="<?php echo base_url(); ?>main/privacy">Privacy Policy</a> | <a href="<?php echo base_url(); ?>main/terms">Terms of Use</a></span><br />
<br />
</div>
</div>
<?php
//load js objects
if(isset($js_object)){
    echo $js_object;
}
//load javascript files
if(isset($js)){
    echo $js;
}
?>
</body>

</html>