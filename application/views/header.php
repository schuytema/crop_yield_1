<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
<meta http-equiv="Content-Language" content="en-gb" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
if(isset($meta_content)){
    echo $meta_content;
}
?>
<title><?php if(isset($title)) { echo $title; } else { echo 'Grow Our Yields';} //@TODO: give each page a title ?></title>
<?php
if(isset($link_content)){
    echo $link_content;
}
?>

</head>

<!-- Begin Body -->

<body>

<div id="border"><div id="container"> 

<!-- menu -->

<div id="topmenu">
     <ul>
        <li><a href="<?php echo base_url(); ?>" title="Home"><span>Home</span></a></li>
        <li><a href="<?php echo base_url(); ?>main/about" title="About Us"><span>About Us</span></a></li>
        <li><a href="<?php echo base_url(); ?>main/contact" title="Contact Us"><span>Contact Us</span></a></li>
    </ul>
</div>


<!-- header backround image is in the style sheet-->
<div id="header"></div>

<div id="content">

