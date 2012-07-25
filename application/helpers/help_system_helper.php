<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Build image link for help system
 *
 * @package     CropYield
 * @subpackage	Helpers
 * @category	Help System
 * @author	Mike Cokel
 */

// ------------------------------------------------------------------------

function help_link($item){
    echo '<a href = \''.base_url().'member/help/'.$item.'\' onclick="window.open(this.href,\'help\',\'resizable=no,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,width=450,height=500\'); return false;" rel="nofollow" target="newWin"><img src="'.base_url().'css/images/help_icon.png" border="0" width="20" height="20" title="view documentation" alt="link to more information" /></a>';                
}