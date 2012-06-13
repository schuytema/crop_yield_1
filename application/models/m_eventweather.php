<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EventWeather model
 *
 * Model contains functions for EventWeather data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	EventWeather
 * @author	Paul Schuytema
 */
class m_eventweather extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    
    function get($event_id=NULL){
        return $this->db->get_where('EventWeather',array('FK_EventId' => id_clean($event_id)));
    }
    
    
    //gets event details matching a certain master event
    function get_weather_event($event_id=NULL){
        if(isset($event_id)){
            $this->db->where('FK_EventId',db_clean($event_id,20));
        }
        return $this->db->get('EventWeather');
    }
    
    
    function delete_weather_event($id=NULL)
    {
        if(isset($event_id))
        {
            $this->db->where('FK_EventId', $event_id);
            $this->db->delete('EventWeather');
        }
     }
        
}
/* End of file m_eventweather.php */
/* Location: ./application/models/m_eventweather.php */