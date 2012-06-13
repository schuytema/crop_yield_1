<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventFertilizer model
 *
 * Model contains functions for EventFertilizer data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventFertilizer
 * @author	Paul Schuytema
 */
class m_eventfertilizer extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventFertilizer',array('FK_EventId' => id_clean($event_id)));
    }
    
    
    //gets event details matching a certain master event
    function get_fertilizer_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventFertilizer');
    }
    
    
    function delete_fertilizer_event($id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventFertilizer');
        }
     }
        
}
/* End of file m_eventfertilizer.php */
/* Location: ./application/models/m_eventfertilizer.php */