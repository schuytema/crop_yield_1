<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * Tools to work with the myriad of events we've got
 *
 * @package     CropYield
 * @subpackage	Libraries
 * @category	Event Manager
 * @author	Paul Schuytema
 */

class event_manager {

    var $CI;
    /**
    * Constructor
    *
    * @access	public
    */
    public function __construct(){
        // Set the super object to a local variable for use throughout the class
        $this->CI =& get_instance();
    }
    
    function delete_field_with_events($field_id=NULL)
    {
        $this->CI->db->trans_start();
        $this->CI->m_field->delete_field($field_id);
        $field_events = $this->CI->m_event->get_field_events($field_id);
        if($field_events->num_rows()){
            $result = $field_events->result();
            foreach($result AS $row)
            {
                switch ($row->EventType)
                {
                    case 'Application':
                        //remove application event - there can be only one per master event
                        $application = $this->CI->m_eventapplication->get_application_event($row->PK_EventId);
                        if($application->num_rows()){
                            $this->CI->m_eventapplication->delete_application_event($row->PK_EventId);
                        }
                    break;
                    case 'Chemical':
                        //remove chemical event - there can be only one per master event
                        $chemical = $this->CI->m_eventchemical->get_chemical_event($row->PK_EventId);
                        if($chemical->num_rows()){
                            $this->CI->m_eventchemical->delete_chemical_event($row->PK_EventId);
                        }
                    break;
                    case 'Fertilizer':
                        //remove fertilizer event - there can be only one per master event
                        $fertilizer = $this->CI->m_eventfertilizer->get_fertilizer_event($row->PK_EventId);
                        if($fertilizer->num_rows()){
                            $this->CI->m_eventfertilizer->delete_fertilizer_event($row->PK_EventId);
                        }
                    break;
                    case 'Harvest':
                        //remove harvest event - there can be only one per master event
                        $harvest = $this->CI->m_eventharvest->get($row->PK_EventId);
                        if($harvest->num_rows()){
                            $this->CI->m_eventharvest->delete_harvest_event($row->PK_EventId);
                            //remove all crop instance records - there can be several per event
                            $this->CI->m_cropinstance->delete_crop_instance(NULL,$row->PK_EventId);
                        }
                    break;
                    case 'Plant':
                    case 'Replant':
                        //remove plant event - there can be only one per master event
                        $plant = $this->CI->m_eventplant->get_plant_event($row->PK_EventId);
                        if($plant->num_rows()){
                            $this->CI->m_eventplant->delete_plant_event($row->PK_EventId);
                            //remove all crop instance records - there can be several per event
                            $this->CI->m_cropinstance->delete_crop_instance($row->PK_EventId,NULL);
                        }
                    break;
                    case 'Tillage':
                        //remove tillage event - there can be only one per master event
                        $tillage = $this->CI->m_eventtillage->get_tillage_event($row->PK_EventId);
                        if($tillage->num_rows()){
                            $this->CI->m_eventtillage->delete_tillage_event($row->PK_EventId);
                        }
                    break;
                    case 'Weather':
                        //remove weather event - there can be only one per master event
                        $weather = $this->CI->m_eventweather->get_weather_event($row->PK_EventId);
                        if($weather->num_rows()){
                            $this->CI->m_eventweather->delete_weather_event($row->PK_EventId);
                        }
                    break;

                }
                //now delete the event itself
                $this->CI->m_event->delete_event($row->PK_EventId);
            }
        } 
        $this->CI->db->trans_complete();
     }
     
    function delete_event($event_id=NULL)
    {
        $this->CI->db->trans_start();
        $event = $this->CI->m_event->get($event_id);
        if($event->num_rows()){
            $result = $event->result();
            foreach($result AS $row)
            {
                switch ($row->EventType)
                {
                    case 'Application':
                        //remove application event - there can be only one per master event
                        $application = $this->CI->m_eventapplication->get_application_event($event_id);
                        if($application->num_rows()){
                            $this->CI->m_eventapplication->delete_application_event($event_id);
                        }
                    break;
                    case 'Chemical':
                        //remove chemical event - there can be only one per master event
                        $chemical = $this->CI->m_eventchemical->get_chemical_event($event_id);
                        if($chemical->num_rows()){
                            $this->CI->m_eventchemical->delete_chemical_event($event_id);
                        }
                    break;
                    case 'Fertilizer':
                        //remove fertilizer event - there can be only one per master event
                        $fertilizer = $this->CI->m_eventfertilizer->get_fertilizer_event($event_id);
                        if($fertilizer->num_rows()){
                            $this->CI->m_eventfertilizer->delete_fertilizer_event($event_id);
                        }
                    break;
                    case 'Harvest':
                        //remove harvest event - there can be only one per master event
                        $harvest = $this->CI->m_eventharvest->get($event_id);
                        if($harvest->num_rows()){
                            $this->CI->m_eventharvest->delete_harvest_event($event_id);
                            //set harvest portions of crop instance records to NULL - there can be several per event
                            $this->CI->m_cropinstance->clear_harvest($event_id);
                        }
                    break;
                    case 'Plant':
                    case 'Replant':
                        //remove plant event - there can be only one per master event
                        $plant = $this->CI->m_eventplant->get_plant_event($event_id);
                        if($plant->num_rows()){
                            $this->CI->m_eventplant->delete_plant_event($event_id);
                            //remove all crop instance records - there can be several per event
                            $this->CI->m_cropinstance->delete_crop_instance($event_id,NULL);
                        }
                    break;
                    case 'Tillage':
                        //remove tillage event - there can be only one per master event
                        $tillage = $this->CI->m_eventtillage->get_tillage_event($event_id);
                        if($tillage->num_rows()){
                            $this->CI->m_eventtillage->delete_tillage_event($event_id);
                        }
                    break;
                    case 'Weather':
                        //remove weather event - there can be only one per master event
                        $weather = $this->CI->m_eventweather->get_weather_event($event_id);
                        if($weather->num_rows()){
                            $this->CI->m_eventweather->delete_weather_event($event_id);
                        }
                    break;

                }
                //now delete the event itself
                $this->CI->m_event->delete_event($event_id);
            }
        } 
        $this->CI->db->trans_complete();
     }
     
    function get_fields_from_event_form()
    {
        $field_array = array();
        $fields = $this->CI->input->post('fields');
        foreach ($fields as $field)
        {
            $field_array[] = $field;
        }
        return $field_array;
    }
    
}
// END event_manager Class

/* End of file event_manager.php */
/* Location: ./application/libraries/event_manager.php */