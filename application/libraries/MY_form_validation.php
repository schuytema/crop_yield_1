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
    
    function check_zip_code($str){
        $CI =& get_instance();
        $code = preg_replace("/[\s|-]/", "", $str);
        if (((strlen($code) != 5) && (strlen($code) != 9)) || !is_numeric($code)){
            $CI->form_validation->set_message('check_zip_code', 'The Zip code value is not valid.');
            return FALSE;
        }
        return TRUE;
    }
    
    function check_username($str){
        $CI =& get_instance();
        if(isset($str)){
            if($CI->m_user->does_username_exist($str)){
                $CI->form_validation->set_message('check_username', 'Username already exists. Please choose another username.');
                return FALSE;
            }
        }
        return TRUE;
    }
    
    function check_email($str){
        $CI =& get_instance();
        if(isset($str)){
            if($CI->m_user->does_email_exist($str)){
                $CI->form_validation->set_message('check_email', 'Email already exists. Please choose another email.');
                return FALSE;
            }
        }
        return TRUE;
    }
    
    function verify_password($str){
        $CI =& get_instance();
        if(isset($str)){
            if(!$CI->auth->verify_password($str)){
                $CI->form_validation->set_message('verify_password', 'Please enter correct current password.');
                return FALSE;
            }
        }
        return TRUE;
    }
    
    function verify_new_password_exists($str){
        $CI =& get_instance();
        if(isset($str)){
            if(!$CI->input->post('Password')){
                $CI->form_validation->set_message('verify_new_password_exists', 'Please enter a new password.');
                return FALSE;
            }
        }
        return TRUE;
    }
    
    function verify_current_password_exists($str){
        $CI =& get_instance();
        if(isset($str)){
            if(!$CI->input->post('CurrPassword')){
                $CI->form_validation->set_message('verify_current_password_exists', 'Please enter correct current password.');
                return FALSE;
            }
        }
        return TRUE;
    }
        
}
