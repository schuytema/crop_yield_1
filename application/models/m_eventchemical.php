<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventChemical model
 *
 * Model contains functions for EventChemical data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventChemical
 * @author	Paul Schuytema
 */
class m_eventchemical extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventChemical',array('FK_EventId' => id_clean($event_id)));
    }
    
    
    //gets event details matching a certain master event
    function get_chemical_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventChemical');
    }
    
    
    function delete_chemical_event($event_id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventChemical');
        }
     }
        
}
/* End of file m_eventchemical.php */
/* Location: ./application/models/m_eventchemical.php */