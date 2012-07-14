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
    
    function set($event_id=NULL, $new=true, $chem_id=NULL){
        $data = array(
            'AmountActiveIngredient' => db_clean(strip_tags($this->input->post('AmountActiveIngredient')),20),
            'AmountActiveIngredientUnit' => db_clean($this->input->post('AmountActiveIngredientUnit'),3),
            'FK_EventId' => id_clean($event_id)
        );

        if(!$new){ //update  
            if (isset($chem_id))
            {
                $data['FK_ChemicalId'] = db_clean($chem_id,9);
            } else {
                if ($this->input->post('Product') != '')
                {
                    $data['FK_ChemicalId'] = db_clean($this->input->post('Product'),9);
                }
            }
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventChemical');
        } else { //create record
            if (isset($chem_id))
            {
                $data['FK_ChemicalId'] = db_clean($chem_id,9);
            } else {
                $data['FK_ChemicalId'] = db_clean($this->input->post('Product'),9);
            }
            $this->db->set($data);
            $this->db->insert('EventChemical');
        }
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