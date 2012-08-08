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

<img src="<?php echo base_url(); ?>css/images/sm_logo5.jpg" alt="logo" width="165" height="97" />
