<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CropInstance model
 *
 * Model contains functions for CropInstance data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	CropInstance
 * @author	Nick Carlson
 */
class m_cropinstance extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($plantevent_id=NULL,$harvestevent_id=NULL){
        if ((!isset($plantevent_id)) && (!isset($harvestevent_id))) {
            return FALSE;
        }
        
        if (isset($plantevent_id)) {
            $this->db->where('FK_PlantEventId',id_clean($plantevent_id));
        }
        
        if (isset($harvestevent_id)) {
            $this->db->where('FK_HarvestEventId',id_clean($harvestevent_id));
        }
        
        $this->db->order_by('PK_CropInstanceId','asc');        
        return $this->db->get('CropInstance');
    }    
    
    function set_plant($event_id=NULL, $crop_id=NULL, $acres_planted=NULL, $crop_instance_id=NULL){
        $data = array(
            'FK_PlantEventId' => id_clean($event_id),
            'AcresPlanted' => db_clean(strip_tags($acres_planted)),
            'FK_CropId' => id_clean($crop_id)
        );
        
        if (isset($crop_instance_id)) { //update
            $this->db->set($data);
            $this->db->where('PK_CropInstanceId',id_clean($crop_instance_id));
            $this->db->update('CropInstance');
        } else { //create record
            
        }

        if(isset($id)){ //update
            $this->db->set($data);
            $this->db->where('PK_FarmId',id_clean($id));
            $this->db->update('Farm');
        } else { //create record
            $this->db->set($data);
            $this->db->insert('CropInstance');
            $crop_instance_id = $this->db->insert_id();
        }
        
        return $crop_instance_id;
    }    
     
    function delete_crop_instance($plantevent_id=NULL,$harvestevent_id=NULL){
        if ((!isset($plantevent_id)) && (!isset($harvestevent_id))) {
            return FALSE;
        }
        
        if (isset($plantevent_id)) {
            $this->db->where('FK_PlantEventId',id_clean($plantevent_id));
        }
        
        if (isset($harvestevent_id)) {
            $this->db->where('FK_HarvestEventId',id_clean($harvestevent_id));
        }
        
        if(isset($event_id))
        {
            $this->db->delete('CropInstance');
        }
    }     
}
/* End of file m_eventplant.php */
/* Location: ./application/models/m_eventplant.php */