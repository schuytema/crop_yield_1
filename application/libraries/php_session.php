<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * PHP Session Class
 *
 * Utilizes native PHP php_session functions for sensitive and/or large data sets
 *
 * @package     CropYield
 * @subpackage	Libraries
 * @category	PHP Session
 * @author	Mike Cokel
 */

class PHP_Session {

    /**
    * Constructor
    *
    * Starts the php_session with session_start()
    *
    * @access	public
    */
    function PHP_Session(){
        session_start();
    }

    // ------------------------------------------------------------------------

    /**
    * Sets a php_session variable
    * @param string name of variable
    * @param mixed value of variable
    * @return void
    * @access public
    */
    public function set($name, $value){
        $_SESSION[$name] = $value;
    }

    // ------------------------------------------------------------------------

    /**
    * Fetches a php_session variable
    * @param string name of variable
    * @return mixed value of php_session varaible
    * @access public
    */
    public function get($name){
        if (isset($_SESSION[$name])){
            return $_SESSION[$name];
        } else {
            return FALSE;
        }
    }

    // ------------------------------------------------------------------------

    /**
    * unsets a php_session variable
    * @param string name of variable
    * @return void
    * @access public
    */
    public function del($name){
        unset($_SESSION[$name]);
    }

    // ------------------------------------------------------------------------

    /**
    * Destroys the whole php_session
    * @return void
    * @access public
    */
    public function destroy(){
        $_SESSION = array();
        session_destroy();
        session_regenerate_id();
    } 
}
// END php_session Class

/* End of file php_session.php */
/* Location: ./application/libraries/php_session.php */