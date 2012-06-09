<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Javascript helper funcitons: dynamically build js related objects
 *
 * @package     CropYield
 * @subpackage	Helpers
 * @category	Javascript
 * @author	Mike Cokel
 */

// ------------------------------------------------------------------------

/**
 * Build fully qualified <script>...</script> statements 
 * Function accepts an array of file names:
 * - local files: [script_name.js] 
 * - external files: [www.google.com/js/cool_script.js]
 * 
 * @access	public
 * @param	array
 * @return	string
 */
function js_load($arr=array()){
    $output = NULL;
    if(empty($arr)){
        return $output;
    }

    foreach($arr AS $file){
        $output .= '<script type="text/javascript" src="'.$file.'"></script>';
    }
    return $output;
}

// ------------------------------------------------------------------------

/**
 * Build js object definitions
 * 
 * Note: PHP 5.4 may have JSON escape options
 * 
 * @access	public
 * @param	array
 * @return	string
 */
function js_object($arr=array()){
    $output = NULL;
    if(empty($arr)){
        return $output;
    }
    
    foreach($arr AS $object => $data){
        $output .= 'var '.$object.' = '.json_encode($data).';';
    }
    $output = str_replace("\/","/",$output);
    return '<script type="text/javascript">'.$output.'</script>';
}
