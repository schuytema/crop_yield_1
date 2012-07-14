<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventHarvest model
 *
 * Model contains functions for EventHarvest data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventHarvest
 * @author	Paul Schuytema
 */
class m_eventharvest extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventHarvest',array('FK_EventId' => id_clean($event_id)));
    }
    
    function set($event_id=NULL, $new=true, $equipment_id=NULL){
        $data = array(
            'Yield' => db_clean(strip_tags($this->input->post('Yield')),10),
            'YieldUnit' => db_clean($this->input->post('YieldUnit'),10),
            'GrainTestWeight' => db_clean(strip_tags($this->input->post('GrainTestWeight')),10),
            'GrainTestWeightUnit' => db_clean($this->input->post('GrainTestWeightUnit'),10),
            'PercentGrainMoisture' => db_clean(strip_tags($this->input->post('PercentGrainMoisture')),10),
            'FK_EventId' => id_clean($event_id)
        );

        if(!$new){ //update  
            if (isset($equipment_id))
            {
                $data['FK_EquipmentId'] = id_clean($equipment_id);
            } else {
                if (strlen($this->input->post('EquipmentProduct')) > 0)
                {
                    $data['FK_EquipmentId'] = id_clean($this->input->post('EquipmentProduct'));
                }
            }
            

            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventHarvest');
        } else { //create record
            if (isset($equipment_id))
            {
                $data['FK_EquipmentId'] = id_clean($equipment_id);
            } else {
                $data['FK_EquipmentId'] = id_clean($this->input->post('EquipmentProduct'));
            }
            
            $this->db->set($data);
            $this->db->insert('EventHarvest');
        }
    }
    
    //gets event details matching a certain master event
    function get_harvest_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventHarvest');
    }
    
    
    function delete_harvest_event($event_id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventHarvest');
        }
     }
        
}
/* End of file m_eventharvest.php */
/* Location: ./application/models/m_eventharvest.php */