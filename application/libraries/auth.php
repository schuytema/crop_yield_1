<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication Class
 * 
 * Certain functionality inspired by the Portable PHP password hashing framework (PHPASS)
 * http://www.openwall.com/phpass/
 * 
 * and
 * 
 * https://wiki.mozilla.org/WebAppSec/Secure_Coding_Guidelines#Password_Storage
 * 
 * @package     CropYield
 * @subpackage	Libraries
 * @category	User Authentication
 * @author	Mike Cokel
 */

class Auth {
    var $lock_account = 5; //lock account at 5 consecutive, unsuccessful attempts
    private $cost_param = 13; //two digit cost parameter (valid range: 04-31); base-2 logarithm of the iteration count for the underlying Blowfish-based hashing algorithm
    private $error = array();
    var $CI;

    /**
    * Constructor
    * @access	public
    */
    function Auth(){
        // Set the super object to a local variable for use throughout the class
        $this->CI =& get_instance();
        
        $this->CI->load->model('m_user');
    }
    
    // ------------------------------------------------------------------------

    /**
    * User login: username, password
    * @param string
    * @param string
    * @access public
    * @return boolean
    */
    public function login($user,$pass){
        if((strlen($user) > 0) && (strlen($pass) > 0)){
            $query = $this->CI->m_user->get_by_username($user);
            if($query->num_rows()){
                $row = $query->row();
                //verify account is enabled
                if(!$row->IsEnabled){
                    $this->error[] = lang('auth_login_failed'); //Account locked!
                    return FALSE;
                }

                //verify password
                if($this->check_password($pass,$row->Password)){
                    //set session for direct access to member's area
                    $this->_set_session(array('PK_UserId' => $row->PK_UserId,'FK_FarmId' => $row->FK_FarmId));
                    $this->CI->m_user->update_visit($row->PK_UserId,$row->VisitCount);
                    return TRUE;
                }
            }
            //failed login
            $this->CI->m_user->failed_login($user,$this->lock_account);
            $this->error[] = lang('auth_login_failed');
            return FALSE;
        }
        return FALSE; 
    }
    
    // ------------------------------------------------------------------------

    /**
    * User logout
    * @return void
    * @access public
    */
    public function logout(){
        $this->CI->cookie->destroy();
        $this->CI->php_session->destroy();
    }
    
    // ------------------------------------------------------------------------
    
    function check_password($password,$stored_hash){
        $hash = hash_hmac('sha512',$password,$this->CI->config->item('encryption_key'));
        $hash = crypt($hash,$stored_hash);
        return $hash == $stored_hash;
    }
    
    // ------------------------------------------------------------------------
    
    function create_account(){
        //verify username, email do not exist
        if($this->CI->m_user->does_username_exist($this->CI->input->post('Username'))){
            $this->error[] = lang('auth_user_exists');
            return FALSE;
        }
        
        if($this->CI->m_user->does_email_exist($this->CI->input->post('Email'))){
            $this->error[] = lang('auth_email_exists');
            return FALSE;
        }
                
        //generate password hash
        $pass = $this->hash_password(db_clean($this->CI->input->post('Password')));
        
        //create account
        $data = array(
            'FirstName' => db_clean($this->CI->input->post('First'),25),
            'LastName' => db_clean($this->CI->input->post('Last'),50),
            'Email' => db_clean($this->CI->input->post('Email'),100),
            'Username' => db_clean($this->CI->input->post('Username'),100),
            'Password' => $pass
        );
        
        if($val = $this->CI->m_user->create_user($data)){
            //set session for direct access to member's area
            $this->_set_session(array('PK_UserId' => $val,'FK_FarmId' => NULL));
            
            //send welcome message
            $this->CI->load->library('mail');
            $this->CI->mail->send_mail(array('message' => lang('auth_welcome_msg'),'subject' => lang('auth_welcome_subject'),'to_address' => $data['Email']));
            
            return TRUE;
        }
        
        //something bad happened... log error
        log_message('error','Account creation failed!');
        $this->error[] = lang('auth_acct_failed');
        return FALSE;
    }
    
    // ------------------------------------------------------------------------
    
    /**
    * Generate a password hash
    * - each user will have a unique salt
    * - function will also apply a secret key from the application for added security
    * note: return string is 128 characters
    * 
    * see: https://wiki.mozilla.org/WebAppSec/Secure_Coding_Guidelines#Password_Storage
    * 
    * @param int
    * @access public
    * @return string
    */
    function hash_password($password){
        $hash = hash_hmac('sha512',$password,$this->CI->config->item('encryption_key'));
        //@TODO: check hash length??
        return crypt($hash, $this->gensalt_blowfish($this->random_byte_generator(16)));
    }
        
    // ------------------------------------------------------------------------

    /**
    * Generate a cryptographically secure pseudorandom string
    * - suitable for password hashing
    *
    * @param int
    * @access public
    * @return string
    */
    function random_byte_generator($count){
        //utilize Linux file: /dev/urandom
        $output = '';
        if(is_readable('/dev/urandom') && ($fh = @fopen('/dev/urandom', 'rb'))) {
            $output = fread($fh, $count);
            fclose($fh);
        }

        //failsafe: access to /dev/urandom not available OR we need more entropy
        if(strlen($output) < $count) {
            $output = '';
            $random_state = microtime();
            if(function_exists('getmypid')){
                $random_state .= getmypid();
            }
            for ($i = 0; $i < $count; $i += 16) {
                $random_state = md5(microtime().$random_state);
                $output .= pack('H*', md5($random_state));
            }
            $output = substr($output, 0, $count);
        }
        return $output;
    }
    
    // ------------------------------------------------------------------------
    /**
    * Generate salt based on the hash type: CRYPT_BLOWFISH (PHP 5.3.0 >); variant of bcyrpt
    * - bcrypt provides a hashing mechanism which can be configured to consume sufficient time
    *   to prevent brute forcing of hash values even with many computers
    * - bcrypt can be easily adjusted at any time to increase the amount of work
    *   and thus provide protection against more powerful systems
    *
    * @param string
    * @access public
    * @return string
    */    
    function gensalt_blowfish($input){
        $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $output = '$2a$';
        $output .= chr(ord('0') + $this->cost_param / 10);
        $output .= chr(ord('0') + $this->cost_param % 10);
        $output .= '$';

        $i = 0;
        do {
            $c1 = ord($input[$i++]);
            $output .= $itoa64[$c1 >> 2];
            $c1 = ($c1 & 0x03) << 4;
            if ($i >= 16) {
                    $output .= $itoa64[$c1];
                    break;
            }

            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 4;
            $output .= $itoa64[$c1];
            $c1 = ($c2 & 0x0f) << 2;

            $c2 = ord($input[$i++]);
            $c1 |= $c2 >> 6;
            $output .= $itoa64[$c1];
            $output .= $itoa64[$c2 & 0x3f];
        } while (1);

        return $output;
    }
    
    function get_errors(){
        $error = NULL;
        if(count($this->error)){
            foreach($this->error as $val){
                if($val != ''){
                    $error .= '<p>'.$val.'</p>';
                }
            }
        }
        return $error;
    }
    
    function _set_session($data){
        //initialize data
        $arr = array();
        $arr['Auth'] = TRUE;
        $arr['UserId'] = $data['PK_UserId'];
        $arr['FarmId'] = $data['FK_FarmId'];
        $this->CI->php_session->set('AUTH',$arr);
    }
    
}
// END Auth Class

/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */
