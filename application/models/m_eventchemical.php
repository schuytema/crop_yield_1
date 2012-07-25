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
    
    function set($event_id=NULL, $new=true){
        $data = array(   
            'FK_EventId' => id_clean($event_id),
            'FK_EquipmentId' => db_clean($this->input->post('FK_EquipmentId'),9),
            'FK_ChemicalId' => db_clean($this->input->post('FK_ChemicalId'),9),
            'AmountActiveIngredient' => db_clean(strip_tags($this->input->post('AmountActiveIngredient')),20),
            'AmountActiveIngredientUnit' => db_clean($this->input->post('AmountActiveIngredientUnit'),10),
            'FK_ChemicalId2' => db_clean($this->input->post('FK_ChemicalId2'),9, false),
            'AmountActiveIngredient2' => db_clean(strip_tags($this->input->post('AmountActiveIngredient2')),20, false),
            'AmountActiveIngredientUnit2' => db_clean($this->input->post('AmountActiveIngredientUnit2'),10, false),
            'FK_ChemicalId3' => db_clean($this->input->post('FK_ChemicalId3'),9, false),
            'AmountActiveIngredient3' => db_clean(strip_tags($this->input->post('AmountActiveIngredient3')),20, false),
            'AmountActiveIngredientUnit3' => db_clean($this->input->post('AmountActiveIngredientUnit3'),10, false),
            'FK_ChemicalId4' => db_clean($this->input->post('FK_ChemicalId4'),9, false),
            'AmountActiveIngredient4' => db_clean(strip_tags($this->input->post('AmountActiveIngredient4')),20, false),
            'AmountActiveIngredientUnit4' => db_clean($this->input->post('AmountActiveIngredientUnit4'),10, false)
        );

        if(!$new){ //update  
            $this->db->set($data);
            $this->db->where('FK_EventId',id_clean($event_id));
            $this->db->update('EventChemical');
        } else { //create record
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