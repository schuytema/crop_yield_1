<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventPlant model
 *
 * Model contains functions for EventPlant data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventPlant
 * @author	Paul Schuytema
 */
class m_eventplant extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventPlant',array('FK_EventId' => id_clean($event_id)));
    }
    
    function set($event_id=NULL, $new=true){
        $data = array(            
            'FK_EventId' => id_clean($event_id),
            'FK_EquipmentId' => id_clean($this->input->post('EquipmentImplement'),8),
            'FK_EquipmentId_Power' => id_clean($this->input->post('EquipmentPower'),8),
            'PlantingRate' => db_clean(strip_tags($this->input->post('PlantingRate')),8),
            'PlantingRateUnit' => db_clean(strip_tags($this->input->post('PlantingRateUnit')),14),
            'RowSpacing' => db_clean(strip_tags($this->input->post('RowSpacing')),3),
            'RowSpacingUnit' => db_clean(strip_tags($this->input->post('RowSpacingUnit')),2),
            'PreviousCrop' => db_clean(strip_tags($this->input->post('PreviousCrop')),30),
            'VariableRate' => id_clean($this->input->post('VariableRate'),1),
            'SeedDepth' => db_clean(strip_tags($this->input->post('SeedDepth')),3),
            'SeedDepthUnit' => db_clean(strip_tags($this->input->post('SeedDepthUnit')),2),
            'TwinRows' => id_clean($this->input->post('TwinRows'),1)
        );

        if(!$new){ //update  
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventPlant');
        } else { //create record
            $this->db->set($data);
            $this->db->insert('EventPlant');
        }
    }    
    
    //gets event details matching a certain master event
    function get_plant_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventPlant');
    }
    
    
    function delete_plant_event($event_id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventPlant');
        }
     }
        
}
/* End of file m_eventplant.php */
/* Location: ./application/models/m_eventplant.php */