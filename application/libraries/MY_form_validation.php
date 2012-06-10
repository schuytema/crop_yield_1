<?php
class MY_Form_validation extends CI_Form_validation {
    function __construct(){
        parent::__construct();
    }
    
    function is_legal_password($str){
        $CI =& get_instance();
        if(!preg_match("#[0-9]+#", $str)) {
            $CI->form_validation->set_message('is_legal_password', 'Password must include at least one number!');
            return FALSE;
        }

        if(!preg_match("#[a-z]+#", $str) && !preg_match("#[A-Z]+#", $str)) {
            $CI->form_validation->set_message('is_legal_password', 'Password must include at least one letter!');
            return FALSE;
        }
        return TRUE;
    }
    
    function check_verification($str){
        $CI =& get_instance();
        if($str != $CI->config->item('invitation_key')) {
            $CI->form_validation->set_message('check_verification', 'The invitation key is incorrect.');
            return FALSE;
        }
        return TRUE;
    }
    
}
