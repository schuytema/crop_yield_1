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
    
    function set($event_id=NULL, $new=true, $equipment_id=NULL, $crop_id=NULL){
        $data = array(            
            'FK_EventId' => id_clean($event_id),
            'PlantingRate' => db_clean($this->input->post('PlantingRate'),8),
            'PlantingRateUnit' => db_clean($this->input->post('PlantingRateUnit'),14),
            'RowSpacing' => db_clean($this->input->post('RowSpacing'),3),
            'RowSpacingUnit' => db_clean($this->input->post('RowSpacingUnit'),2)
        );

        if(!$new){ //update  
            if (isset($equipment_id))
            {
                $data['FK_EquipmentId'] = id_clean($equipment_id);
            } else {
                if (!empty($this->input->post('EquipmentProduct')))
                {
                    $data['FK_EquipmentId'] = id_clean($this->input->post('EquipmentProduct'));
                }
            }
            
            if (isset($crop_id))
            {
                $data['FK_CropId'] = id_clean($crop_id);
            } else {
                if (!empty($this->input->post('CropProduct')))
                {
                    $data['FK_CropId'] = id_clean($this->input->post('CropProduct'));
                }
            }
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventPlant');
        } else { //create record
            if (isset($equipment_id))
            {
                $data['FK_EquipmentId'] = id_clean($equipment_id);
            } else {
                $data['FK_EquipmentId'] = id_clean($this->input->post('EquipmentProduct'));
            }
            
            if (isset($crop_id))
            {
                $data['FK_CropId'] = id_clean($crop_id);
            } else {
                $data['FK_CropId'] = id_clean($this->input->post('CropProduct'));
            }
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