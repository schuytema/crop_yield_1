<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User-supplied Data Verification Class
 * - crop data
 * - equipment data
 *
 * @package     CropYield
 * @subpackage	Libraries
 * @category	User Data Verification
 * @author	Mike Cokel
 */

class data_verification {
    var $allowed_types = array('crop','equipment');
    private $error = array();
    var $CI;

    /**
    * Constructor
    * @access	public
    */
    function __construct(){
        // Set the super object to a local variable for use throughout the class
        $this->CI =& get_instance();
        
        //load dependencies
        $this->CI->load->model('m_crop');
        $this->CI->load->model('m_equipment');
        $this->CI->load->library('Form_validation');
    }
    
    //return query of unverified data based on type
    function unverified($type=NULL){
        $arr = array_flip($this->allowed_types);
        if(!isset($arr[$type])){
            return FALSE;
        }
        
        switch($type){
            case 'crop':
                return $this->CI->m_crop->get_unverified();
                break;
            case 'equipment':
                return $this->CI->m_equipment->get_unverified();
                break;                
        }
    }
    
    function process($type=NULL){
        $arr = array_flip($this->allowed_types);
        if(!isset($arr[$type])){
            $this->error[] = lang('data_ver_general_error'); //unknown type
            return FALSE;
        }
                
        switch($type){
            case 'crop':
                return $this->_process_crop();
                break;
            case 'equipment':
                return $this->_process_equipment();
                break;                
        }
    }
    
    private function _process_crop(){
        $id = $this->CI->input->post('id');
        //place query string (param=val&param2=val2...) into POST array for form validation
        parse_str($this->CI->input->post('form'),$_POST);
        if($this->CI->input->post('val_type') == 'user'){ //user-supplied data
            $this->CI->form_validation->set_rules('UserBrand', 'Brand', 'trim|required');
            $this->CI->form_validation->set_rules('UserProduct', 'Product', 'trim|required');
            if($this->CI->form_validation->run()){
                $this->CI->m_crop->verify_entry($id,$this->CI->input->post('UserBrand'),$this->CI->input->post('UserProduct'));
                return TRUE;
            } else {
                $this->error[] = validation_errors();
                return FALSE;
            }
        } else { //data entry from DB
            //remove entry ($id); replace crop instance w/ new ID (product value)
            $this->CI->form_validation->set_rules('Brand', 'Brand', 'trim|required');
            $this->CI->form_validation->set_rules('Product', 'Product', 'trim|required|numeric');
            if($this->CI->form_validation->run()){
                $this->CI->m_crop->replace_entry($id,$this->CI->input->post('Product'));
                return TRUE;
            } else {
                $this->error[] = validation_errors();
                return FALSE;
            }
        }
        $this->error[] = lang('data_ver_general_error'); //unknown type
        return FALSE;
    }
    
    private function _process_equipment(){
        $id = $this->CI->input->post('id');
        //place query string (param=val&param2=val2...) into POST array for form validation
        parse_str($this->CI->input->post('form'),$_POST);
        if($this->CI->input->post('val_type') == 'user'){ //user-supplied data
            $this->CI->form_validation->set_rules('UserBrand', 'Brand', 'trim|required');
            $this->CI->form_validation->set_rules('UserProduct', 'Product/Model', 'trim|required');
            $this->CI->form_validation->set_rules('UserPower', 'Power', 'trim|required');
            $this->CI->form_validation->set_rules('UserTillageType', 'Tillage type', 'trim');
            if($this->CI->form_validation->run()){
                $this->CI->m_equipment->verify_entry($id,$this->CI->input->post('UserBrand'),$this->CI->input->post('UserProduct'),$this->CI->input->post('UserPower'),$this->CI->input->post('UserTillageType'));
                return TRUE;
            } else {
                $this->error[] = validation_errors();
                return FALSE;
            }
        } else { //data entry from DB
            //remove entry ($id); replace crop instance w/ new ID (product value)
            $this->CI->form_validation->set_rules('Brand', 'Brand', 'trim|required');
            $this->CI->form_validation->set_rules('Product', 'Product/Model', 'trim|required|numeric');
            if($this->CI->form_validation->run()){
                $this->CI->m_equipment->replace_entry($id,$this->CI->input->post('Product'));
                return TRUE;
            } else {
                $this->error[] = validation_errors();
                return FALSE;
            }
        }
        $this->error[] = lang('data_ver_general_error'); //unknown type
        return FALSE;
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
    
}
// END data_verification Class

/* End of file data_verification.php */
/* Location: ./application/libraries/data_verification.php */