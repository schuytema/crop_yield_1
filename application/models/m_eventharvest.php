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
    
    function set($event_id=NULL, $new=true){
        $data = array(
            'FK_EventId' => id_clean($event_id),
            'FK_EquipmentId' => id_clean($this->input->post('EquipmentImplement'),8),
            'FK_EquipmentId_Power' => id_clean($this->input->post('EquipmentPower'),8)
        );

        if(!$new){ //update  
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventHarvest');
        } else { //create record
            $this->db->set($data);
            $this->db->insert('EventHarvest');
       }
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