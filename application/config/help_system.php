<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Help System
 *
 * @package     CropYield
 * @subpackage	Config
 * @category	Help System
 * @author	Mike Cokel
 */

/*
 * Each help item will consist of the following:
 * - unique key w/ a format of h_NAME_OF_KEY
 * And an array with the following elements
 * - title (references a lang directive)
 * - descr (references a lang directive)
 */
$config['help'] = array(
    'h_field' => array('title' => 'h_field_title','descr' => 'h_field_descr'),
    'h_event' => array('title' => 'h_event_title','descr' => 'h_event_descr')
);
