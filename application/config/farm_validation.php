<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Farm validation
 *
 * @package     CropYield
 * @subpackage	Config
 * @category	Form Validation
 * @author	Mike Cokel
 */
$config['farm'] = array(
    array('field' => 'Name','label' => 'Farm Name','rules' => 'trim|required|max_length[100]'),
    array('field' => 'Address','label' => 'Farm Address','rules' => 'trim|required|max_length[100]'),
    array('field' => 'City','label' => 'City','rules' => 'trim|required|max_length[50]'),
    array('field' => 'State','label' => 'State','rules' => 'trim|required'),
    array('field' => 'Zip','label' => 'Zipcode','rules' => 'trim|required|check_zip_code'),
    array('field' => 'Phone','label' => 'Phone','rules' => 'trim|required|max_length[20]')
);