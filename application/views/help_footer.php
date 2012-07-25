
<div id="footer">
<span class="style5"><?php echo lang('footer_copyright'); ?></span><br />
<br />
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
