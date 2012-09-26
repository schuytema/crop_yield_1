<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Account validation
 *
 * @package     CropYield
 * @subpackage	Config
 * @category	Account Validation
 * @author	Mike Cokel
 */
$config['account'] = array(
    array('field' => 'FirstName','label' => 'First Name','rules' => 'trim|required|max_length[25]'),
    array('field' => 'LastName','label' => 'Last Name','rules' => 'trim|required|max_length[50]'),
    array('field' => 'Email','label' => 'Email','rules' => 'trim|max_length[100]|valid_email|check_email'),
    array('field' => 'Username','label' => 'Username','rules' => 'trim|min_length[3]|max_length[100]|check_username'),
    array('field' => 'CurrPassword','label' => 'Existing Password','rules' => 'trim|verify_password|verify_new_password_exists'),
    array('field' => 'Password','label' => 'New Password','rules' => 'trim|min_length[8]|max_length[50]|verify_current_password_exists|is_legal_password|matches[VerifyPassword]'),
    array('field' => 'VerifyPassword','label' => 'New Password (again)','rules' => 'trim')
);      