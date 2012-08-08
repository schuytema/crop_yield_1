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
            $this->db->where('PK_CropInstanceId',id_clean(strip_tags($crop_instance_id)));
            $this->db->update('CropInstance');
        } else { //create record
            $this->db->set($data);
            $this->db->insert('CropInstance');
            $crop_instance_id = $this->db->insert_id();
        }        
        return $crop_instance_id;
    }    
    
    function set_harvest($event_id=NULL, $yield=NULL, $grain_test_weight=NULL, $percent_moisture=NULL, $aflatoxin=NULL, $crop_instance_id=NULL){
        $data = array(
            'FK_HarvestEventId' => id_clean($event_id),
            'Yield' => db_clean(strip_tags($yield)),
            'GrainTestWeight' => db_clean(strip_tags($grain_test_weight)),
            'PercentMoisture' => db_clean(strip_tags($percent_moisture)),
            'Aflatoxin' => db_clean(strip_tags($aflatoxin))
        );
        
        if (isset($crop_instance_id)) { //update
            $this->db->set($data);
            $this->db->where('PK_CropInstanceId',id_clean(strip_tags($crop_instance_id)));
            $this->db->update('CropInstance');
        } else { //create record
            $this->db->set($data);
            $this->db->insert('CropInstance');
            $crop_instance_id = $this->db->insert_id();
        }        
        return $crop_instance_id;
    }  
    
    function clear_harvest($event_id){
        if (isset($event_id)) {
            $data = array(
                'Yield' => NULL,
                'GrainTestWeight' => NULL,
                'PercentMoisture' => NULL,
                'Aflatoxin' => NULL
            );

            $this->db->set($data);
            $this->db->where('FK_HarvestEventId',id_clean($event_id));
            $this->db->update('CropInstance');
        }
    }  
     
    function delete_crop_instance($plantevent_id=NULL,$harvestevent_id=NULL){
        if ((empty($plantevent_id)) && (empty($harvestevent_id))) {
            return FALSE;
        }
        
        if (isset($plantevent_id)) {
            $this->db->where('FK_PlantEventId',id_clean($plantevent_id));
        }
        
        if (isset($harvestevent_id)) {
            $this->db->where('FK_HarvestEventId',id_clean($harvestevent_id));
        }
        
        $this->db->delete('CropInstance');
    }     
    
    function delete_excluded($preserved_crop_instances=array(),$plantevent_id=NULL,$harvestevent_id=NULL) {
        if ((empty($plantevent_id)) && (empty($harvestevent_id))) {
            return FALSE;
        }
        
        if (isset($plantevent_id)) {
            $this->db->where('FK_PlantEventId',id_clean($plantevent_id));
        }
        
        if (isset($harvestevent_id)) {
            $this->db->where('FK_HarvestEventId',id_clean($harvestevent_id));
        }
        
        if(isset($preserved_crop_instances))
        {
            $this->db->where_not_in('PK_CropInstanceId',$preserved_crop_instances);
        }
        
        $this->db->delete('CropInstance');
    }
}
/* End of file m_eventplant.php */
/* Location: ./application/models/m_eventplant.php */