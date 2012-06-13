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