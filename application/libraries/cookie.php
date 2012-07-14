<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Cookie Class
 * Use cookies for non-sensitive data such as flash_data & user tracking
 * Data storage: serialized w/ the option of encryption (set in config.php)
 *
 * @package     CropYield
 * @subpackage	Libraries
 * @category	Cookies
 * @author	Mike Cokel
 */

class cookie {
    var $cookie_path            = '/';
    var $cookie_name            = 'ci_cookie';
    var $cookie_expiration      = 0; //expire at the end of php_session
    var $cookie_data            = array();
    var $flashdata_key          = 'flash';
    var $CI;
    /**
    * Constructor
    *
    * @access	public
    */
    function cookie($params = array()){
        // Set the super object to a local variable for use throughout the class
	$this->CI =& get_instance();

        // Do we need cookie encryption? If so, load the encryption class
        if ($this->CI->config->item('sess_encrypt_cookie')){
            $this->CI->load->library('encrypt');
	}

        //get cookie data & store in array
        $this->_get_cookie_data();

        // Delete 'old' flashdata (from last request)
	$this->_flashdata_sweep();
        // Mark all new flashdata as old (data will be deleted before next request)
	$this->_flashdata_mark();
    }

    // ------------------------------------------------------------------------

    /**
     * Set cookie
     *
     * @access	public
     * @param	string
     * @param	string
     * @return	void
     */
    public function set($name,$val){
        $this->cookie_data[$name] = $val;
        $this->_set_cookie();
    }

    // ------------------------------------------------------------------------

    /**
     * Return cookie value
     *
     * @access	public
     * @param	string
     * @return	string
     */
    public function get($name){
        return (!isset($this->cookie_data[$name])) ? FALSE : $this->cookie_data[$name];
    }

    // ------------------------------------------------------------------------

    /**
     * Get data from browser cookie
     *
     * @access	public
     * @param	mixed
     * @param	string
     * @return	void
     */
    private function _get_cookie_data(){
        // Fetch the cookie
	$cookie = $this->CI->input->cookie($this->cookie_name);

        if ($cookie === FALSE){
            log_message('debug', 'A cookie was not found.');
            return FALSE;
	}

        // Decrypt the cookie data
	if ($this->CI->config->item('sess_encrypt_cookie')){
            $cookie = $this->CI->encrypt->decode($cookie);
	}

        // Unserialize the php_session array
	$cookie = @unserialize($cookie);

        // Is the php_session data we unserialized an array with the correct format?
	if (!is_array($cookie)){
            $this->destroy();
            return FALSE;
	}

        //valid cookie
        $this->cookie_data = $cookie;
        unset($cookie);
    }

    // ------------------------------------------------------------------------

    /**
     * Delete cookie
     *
     * @access	public
     * @param	mixed
     * @param	string
     * @return	void
     */
    function destroy(){
        // Kill the cookie
	setcookie(
		$this->cookie_name,
		addslashes(serialize(array())),
		(time() - 31500000),
		$this->cookie_path,
		$this->CI->config->item('cookie_domain'),
		0
	);
    }

    // ------------------------------------------------------------------------

    /**
     * Add or change flashdata, only available
     * until the next request
     *
     * @access	public
     * @param	mixed
     * @param	string
     * @return	void
     */
    function set_flashdata($newdata = array(), $newval = ''){
        if (is_string($newdata)){
            $newdata = array($newdata => $newval);
        }

        if (count($newdata) > 0){
            foreach ($newdata as $key => $val){
                $flashdata_key = $this->flashdata_key.':new:'.$key;
                $this->set($flashdata_key,$val);
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Keeps existing flashdata available to next request.
     *
     * @access	public
     * @param	string
     * @return	void
     */
    function keep_flashdata($key){
        if(isset($this->cookie_data)){
            // 'old' flashdata gets removed.  Here we mark all
            // flashdata as 'new' to preserve it from _flashdata_sweep()
            // Note the function will return FALSE if the $key
            // provided cannot be found
            $old_flashdata_key = $this->flashdata_key.':old:'.$key;
            $value = $this->cookie_data[$old_flashdata_key];

            $new_flashdata_key = $this->flashdata_key.':new:'.$key;
            $this->set($new_flashdata_key,$value);
        }
    }

    // ------------------------------------------------------------------------

    /**
    * Fetch a specific flashdata item from the php_session array
    *
    * @access	public
    * @param	string
    * @return	string
    */
    function flashdata($key){
        $flashdata_key = $this->flashdata_key.':old:'.$key;
        return (!isset($this->cookie_data[$flashdata_key])) ? FALSE : $this->cookie_data[$flashdata_key];
    }

    // ------------------------------------------------------------------------

    /**
    * Identifies flashdata as 'old' for removal
    * when _flashdata_sweep() runs.
    *
    * @access	private
    * @return	void
    */
    private function _flashdata_mark(){
        if(isset($this->cookie_data)){
            foreach ($this->cookie_data as $name => $value){
                $parts = explode(':new:', $name);
                if (is_array($parts) && count($parts) === 2){
                    $new_name = $this->flashdata_key.':old:'.$parts[1];
                    unset($this->cookie_data[$name]);
                    $this->set($new_name,$value);
                }
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
    * Removes all flashdata marked as 'old'
    *
    * @access	private
    * @return	void
    */
    private function _flashdata_sweep(){
        if(isset($this->cookie_data)){
            foreach ($this->cookie_data as $key => $value){
                if (strpos($key, ':old:')){
                    unset($this->cookie_data[$key]);
                    $this->_set_cookie();
                }
            }
        }
    }

    // ------------------------------------------------------------------------

    /**
    * Write the cookie
    *
    * @access	private
    * @return	void
    */
    private function _set_cookie(){
        $cookie_data = $this->cookie_data;

        // Serialize the userdata for the cookie
        $cookie_data = serialize($cookie_data);

        if ($this->CI->config->item('sess_encrypt_cookie')){
            $cookie_data = $this->CI->encrypt->encode($cookie_data);
        }

        // Set the cookie
        setcookie(
                $this->cookie_name,
                $cookie_data,
                $this->cookie_expiration,
                $this->cookie_path,
                $this->CI->config->item('cookie_domain'),
                0
        );
    }
}

// END cookie Class

/* End of file cookie.php */
/* Location: ./application/libraries/cookie.php */
