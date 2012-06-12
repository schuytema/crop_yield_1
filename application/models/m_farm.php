<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Farm model
 *
 * Model contains functions for farm data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Farm
 * @author	Mike Cokel
 */
class m_farm extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    function set($id=NULL){
        $data = array(
            'Name' => db_clean($this->input->post('Name'),100),
            'Address' => db_clean($this->input->post('Address'),100),
            'City' => db_clean($this->input->post('City'),50),
            'State' => db_clean($this->input->post('State'),2),
            'Zip' => db_clean($this->input->post('Zip'),5),
            'Phone' => db_clean($this->input->post('Phone'),20)
        );
        
        if(isset($id)){ //update
            $this->db->set($data);
            $this->db->where('PK_FarmId',id_clean($id));
            $this->db->update('Farm');
        } else { //create record (once per subscription)
            $auth_data = $this->php_session->get('AUTH');
            $data['FK_BossId'] = $auth_data['UserId'];
            $this->db->set($data);
            $this->db->insert('Farm');
            
            //update session vars & user record
            $id = $this->db->insert_id();
            $this->m_user->set_farm_id($auth_data['UserId'],$id);
            $this->auth->update_session(array('FarmId' => $id));
        }
    }
    
    function get($id=NULL){
        return $this->db->get_where('Farm',array('PK_FarmId' => id_clean($id)));
    }
        
}
/* End of file m_farm.php */
/* Location: ./application/models/m_farm.php */