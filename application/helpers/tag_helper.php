<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * HTML Tag helper funcitons: dynamically load stuff
 *
 * @package     CropYield
 * @subpackage	Helpers
 * @category	HTML
 * @author	Mike Cokel
 */

// ------------------------------------------------------------------------

/**
 * Build header <meta /> tags
 *
 * @access	public
 * @param	array
 * @return	string
 */
function meta_content($arr=array()){
    $output = NULL;
    if(empty($arr)){
        return $output;
    }

    foreach($arr AS $meta => $data){
        $output .= '<meta name="'.strtolower($data['name']).'" content="'.htmlspecialchars($data['content'],null,null,false).'" />';
    }
    return $output;
}

// ------------------------------------------------------------------------

/**
 * Build header <link /> tags
 *
 * @access	public
 * @param	array
 * @return	string
 */
function link_content($arr=array()){
    $output = NULL;
    if(empty($arr)){
        return $output;
    }

    foreach($arr AS $link => $data){
        $output .= '<link rel="'.strtolower($data['rel']).'"';
        if(!empty($data['type'])){
            $output .= ' type="'.strtolower($data['type']).'"';
        }
        $output .= ' href="'.$data['href'].'" />';
    }
    return $output;
}
