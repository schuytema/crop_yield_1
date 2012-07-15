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
            'Name' => db_clean(strip_tags($this->input->post('Name')),100),
            'Address' => db_clean(strip_tags($this->input->post('Address')),100),
            'City' => db_clean(strip_tags($this->input->post('City')),50),
            'State' => db_clean(strip_tags($this->input->post('State')),2),
            'Zip' => db_clean(strip_tags($this->input->post('Zip')),5),
            'Phone' => db_clean(strip_tags($this->input->post('Phone')),20)
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
    
    //gets farm info for overview
    function get_farms($user_id=NULL){
        if(isset($user_id)){
            $this->db->where('FK_BossId',db_clean($user_id,20));
        }
        $this->db->distinct();
        $this->db->select('Name, City, PK_FarmId');
        $this->db->order_by('Name');
        return $this->db->get('Farm');
    }
    
    function get_field_count($farm_id=NULL){
        if(isset($farm_id)){
            $this->db->where('FK_FarmId',db_clean($farm_id,20));
        }
        $events = $this->db->get('Field');
        return $events->num_rows();
    }
        
}
/* End of file m_farm.php */
/* Location: ./application/models/m_farm.php */