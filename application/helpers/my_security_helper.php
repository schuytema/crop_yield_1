<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * MY security helper - extends security_helper.php (system/helpers/security_helpers)
 *
 * @package     CropYield
 * @subpackage	Helpers
 * @category	Security functions
 * @author	Mike Cokel
 */
// ------------------------------------------------------------------------

/**
 * ID Clean
 * Determines if given ID is an integer and returns ID to a specific length.
 * Function will render any non-zero-length string into an integer.
 * In other words, it will convert hexadecmial and floating point numbers into integers.
 * Function helps prevent buffer overflow attacks by limiting size (ex: an id passed through the
 * URI has been hacked)
 *
 * For more info, see p.270 in Professional Codeigniter
 * @access	public
 * @param	int
 * @param	int
 * @return	int
 */
function id_clean($id, $size = 10){
    return intval(substr($id,0,$size));
}

/**
 * DB Clean
 * Function will return a prepared string (cleansed and set to appropriate max length) for safe database insertion
 * Note: If size is NULL, prepared string will not have limitations regarding length. This will be useful for datatypes
 * such as vachar(max).
 * For more info, see p.270 in Professional Codeigniter
 * @access	public
 * @param	int
 * @param	int
 * @return	int
 */
function db_clean($string, $size = NULL, $isNullable = TRUE){
    $CI =& get_instance();
    //if NULL values allowed, check for variable existence
    if($isNullable){
        $string = (!empty($string)) ? $string : NULL;
    }
    
    if(!empty($string)){
        if(!empty($size)){
            $string = substr($string,0,$size);
        }
        //load security library
        $string = $CI->security->xss_clean(trim($string));
    }
    return $string;
}
/* End of file MY_security_helper.php */
/* Location: ./application/helpers/MY_security_helper.php */