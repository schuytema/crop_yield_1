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
    
    function set($event_id=NULL, $new=true){
        $data = array(
            'PercentN' => db_clean(strip_tags($this->input->post('PercentN')),3),
            'PercentP' => db_clean(strip_tags($this->input->post('PercentP')),3),
            'PercentK' => db_clean(strip_tags($this->input->post('PercentK')),3),
            'ApplicationRate' => db_clean(strip_tags($this->input->post('ApplicationRate')),9),
            'ApplicationRateUnit' => db_clean($this->input->post('ApplicationRateUnit'),25),
            'VariableRate' => db_clean($this->input->post('VariableRate'),3),
            'FK_EventId' => id_clean($event_id)
        );

        if(!$new){ //update  
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventFertilizer');
        } else { //create record
            //print_r($data);
            $this->db->set($data);
            $this->db->insert('EventFertilizer');
        }
    }
    
    
    //gets event details matching a certain master event
    function get_fertilizer_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventFertilizer');
    }
    
    
    function delete_fertilizer_event($event_id=NULL)
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