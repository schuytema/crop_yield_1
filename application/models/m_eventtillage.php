<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventTillage model
 *
 * Model contains functions for EventTillage data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventTillage
 * @author	Paul Schuytema
 */
class m_eventtillage extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventTillage',array('FK_EventId' => id_clean($event_id)));
    }
    
    
    //gets event details matching a certain master event
    function get_tillage_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventTillage');
    }
    
    function set($event_id=NULL, $new=true){
        $data = array(
            'FK_EquipmentId' => db_clean($this->input->post('EquipmentProduct'),25),
            'FK_EventId' => id_clean($event_id)
        );

        if(!$new){ //update  
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventTillage');
        } else { //create record
            //print_r($data);
            $this->db->set($data);
            $this->db->insert('EventTillage');
        }
    }
    
    
    function delete_tillage_event($event_id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventTillage');
        }
     }
        
}
/* End of file m_eventtillage.php */
/* Location: ./application/models/m_eventtillage.php */