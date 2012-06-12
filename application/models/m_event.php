<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Farm model
 *
 * Model contains functions for field data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Event
 * @author	Paul Schuytema
 */
class m_event extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($id=NULL){
        return $this->db->get_where('Event',array('PK_EventId' => id_clean($id)));
    }
    
    function get_event_count($field_id=NULL){
        if(isset($field_id)){
            $this->db->where('FK_FieldId',db_clean($field_id,20));
        }
        $events = $this->db->get('Event');
        return $events->num_rows();
    }
    
    //gets events matching a certain field
    function get_field_events($field_id=NULL){
        if(isset($farm_id)){
            $this->db->where('FK_FieldId',db_clean($field_id,20));
        }
        return $this->db->get('Event');
    }
    
    function delete_event($id=NULL)
    {
        if(isset($id))
        {
            $this->db->where('PK_EventId', $id);
            $this->db->delete('Event');
        }
     }
        
}
/* End of file m_event.php */
/* Location: ./application/models/m_event.php */