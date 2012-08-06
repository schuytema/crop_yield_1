<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Event model
 *
 * Model contains functions for event data
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
    
    function field_done_for_season($field_id=NULL){
        $done = false;
        $got_plant = false;
        $cur_year = date('Y');
        if(isset($field_id)){
            $this->db->where('FK_FieldId',db_clean($field_id,20));
        }
        $events = $this->db->get('Event');
        if($events->num_rows())
        {
            $result = $events->result();
            foreach($result AS $row)
            {
                if (($row->EventType == 'Plant') || ($row->EventType == 'Replant'))
                {
                    $p_year = substr($row->Date,0,4);
                    if ($p_year == $cur_year)
                    {
                        $got_plant = true;
                    } else {
                        $got_plant = false;
                    }
                }
                if (($row->EventType == 'Harvest') && ($got_plant))
                {
                    $h_year = substr($row->Date,0,4);
                    if ($h_year == $p_year)
                    {
                        $done = true;
                    } else {
                        $got_plant = false;
                        $done = false;
                    }
                }
                
            }
        }
        return $done;
    }
    
    //gets events matching a certain field
    function get_field_events($field_id=NULL){
        if(isset($field_id)){
            $this->db->where('FK_FieldId',db_clean($field_id,20));
        }
        $this->db->order_by("Date", "DESC"); 
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
     
     function set($field_id=NULL, $event_id=NULL){
        $data = array(
            'FK_FieldId' => $field_id,
            'EventType' => db_clean($this->input->post('EventType'),50),
            'Date' => db_clean(strip_tags($this->input->post('Date')),11),
            'Notes' => db_clean(strip_tags($this->input->post('Notes')),500)
        );
        
        if(isset($event_id)){ //update
            $this->db->set($data);
            $this->db->where('PK_EventId',id_clean($event_id));
            $this->db->update('Event');
        } else { //create record
            $this->db->set($data);
            if($this->db->insert('Event')) {
                return $this->db->insert_id();
            }
        }
    }
        
}
/* End of file m_event.php */
/* Location: ./application/models/m_event.php */