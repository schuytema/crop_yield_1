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
    
    
    //gets event details matching a certain master event
    function get_harvest_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventHarvest');
    }
    
    
    function delete_harvest_event($id=NULL)
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