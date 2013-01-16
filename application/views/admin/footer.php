
<!-- Begin Page Menu  -->

   <div id="introduction">
   <?php    
    echo '<br />';
    echo '<h3>Account Access</h3>';
    if ($this->php_session->get('AUTH')) {
        $auth_data = $this->php_session->get('AUTH');
        echo '<ul>';
        echo '<li><a href="'.base_url().'admin/home">Home</a></li>';
        echo '<li><a href="'.base_url().'admin/logout">Logout</a></li>';
        echo '</ul>';
        echo '<br />';
        echo '<h3>Data Verification</h3>';
        echo '<ul>';
        echo '<li><a href="'.base_url().'admin/crop_verification">Crop</a></li>';
        echo '<li><a href="'.base_url().'admin/equip_verification">Equipment</a></li>';
        echo '</ul>';
        echo '<br />';
        echo '<h3>Tools</h3>';
        echo '<ul>';
        echo '<li><a href="'.base_url().'admin/users">User Management</a></li>';
        echo '</ul>';
        echo '<br /><br />';
    } else {
        echo '<ul>';
        echo '<li><a href="'.base_url().'">Login</a></li>';
        echo '</ul>';
        echo '<br /><br />';
    }
    ?>
   <img src="<?php echo base_url(); ?>css/images/sm_logo5.jpg" alt="logo" width="165" height="97" /></div>  
</div>


<!-- footer -->

</div>
<div id="footer">
<span class="style5"><?php echo lang('footer_copyright'); ?></span><br />
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