<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();



//set up values

$config['selectYesNo'] = array(
    array('text'=>'Yes','value'=>'Yes'),
    array('text'=>'No','value'=>'No')
);




//meta content types
//note that name and email address are required
$config['contactMail'] = array(
        'labelWidth' => '40%',
        'fieldWidth' => '60%',
        'recipientEmail' => 'paul@schuytema.com',
        'contactTitle' => 'How can we help?',
        'contactMsg' => 'Please use the form below to get in touch with the <b>Grow Our Yields</b> team.',
        'successMsg' => 'Thank you for contacting us! You will hear back within 24 hours.',
        'useCaptcha' => true,
	'contactDef' => array(
            array('name'=>'name','label'=>'Your Name','maillabel'=>'Name','msg'=>'','type'=>'text', 'validation'=>'required'),
            array('name'=>'email','label'=>'Your Email Address','maillabel'=>'Email Address','msg'=>'','type'=>'text', 'validation'=>'required'),
            array('name'=>'member','label'=>'Are You a Member?','maillabel'=>'Are They a Member?','msg'=>'','type'=>'select','source'=>'selectYesNo', 'validation'=>'none'),
            array('name'=>'msg','label'=>'Message','maillabel'=>'Message','msg'=>'','type'=>'textarea', 'validation'=>'none')
	)
);



/* End of file contact_data.php */
/* Location: ./system/application/config/contact_data.php */