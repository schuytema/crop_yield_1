<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventApplication model
 *
 * Model contains functions for EventApplication data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventApplication
 * @author	Paul Schuytema
 */
class m_eventapplication extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventApplication',array('FK_EventId' => id_clean($event_id)));
    }
    
    function set($event_id=NULL){
        $data = array(
            'Product' => db_clean($this->input->post('Product'),25),
            'ApplicationRate' => db_clean($this->input->post('ApplicationRate'),9),
            'ApplicationRateUnit' => db_clean($this->input->post('ApplicationRateUnit',25))
        );

        if(isset($event_id)){ //update
            $data['FK_EventId'] = id_clean($event_id);
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventApplication');
        } else { //create record
            $this->db->set($data);
            $this->db->insert('EventApplication');
        }
    }
    
    
    //gets event details matching a certain master event
    function get_application_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventApplication');
    }
    
    
    function delete_application_event($id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventApplication');
        }
    }        
}
/* End of file m_eventapplication.php */
/* Location: ./application/models/m_eventapplication.php */