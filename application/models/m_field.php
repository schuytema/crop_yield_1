<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Farm model
 *
 * Model contains functions for field data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Farm
 * @author	Paul Schuytema
 */
class m_field extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    function set($farm_id=NULL, $field_id=NULL){
        $data = array(
            'FK_FarmId' => $farm_id,
            'Name' => db_clean(strip_tags($this->input->post('Name')),100),
            'UserSize' => db_clean(strip_tags($this->input->post('UserSize')),11),
            'UserSizeUnit' => db_clean($this->input->post('UserSizeUnit'),9),
            'PercentDrainageEffectiveness' => db_clean(strip_tags($this->input->post('PercentDrainageEffectiveness')),5),
            'Coordinates' => db_clean($this->input->post('Coordinates')),
            'CalcSize' => db_clean($this->input->post('CalcSize')),
            'CalcSizeUnit' => 'acres',
            'Irrigated' => db_clean($this->input->post('Irrigated'), false),
            'Tiled' => db_clean($this->input->post('Tiled'), false),
            'TillagePractice' => db_clean($this->input->post('TillagePractice'))
        );
        
        if(isset($field_id)){ //update
            $this->db->set($data);
            $this->db->where('PK_FieldId',id_clean($field_id));
            $this->db->update('Field');
        } else { //create record (once per subscription)
            $this->db->set($data);
            $this->db->insert('Field');
        }
    }
    
    function get($id=NULL){
        return $this->db->get_where('Field',array('PK_FieldId' => id_clean($id)));
    }
    
    function get_farm_id_from_field($id=NULL){
        $farm_id = NULL;
        $query = $this->db->get_where('Field',array('PK_FieldId' => id_clean($id)));
        if($query->num_rows())
        {
            $row = $query->row();
            $farm_id = $row->FK_FarmId;
        }
        return $farm_id;
    }
    
    //gets field info for overview
    function get_fields($farm_id=NULL){
        if(isset($farm_id)){
            $this->db->where('FK_FarmId',id_clean($farm_id));
        }
        $this->db->distinct();
        $this->db->select('Name, UserSize, PK_FieldId');
        $this->db->order_by('Name');
        return $this->db->get('Field');
    }
    
    function get_field_name($field_id=NULL){
        $this->db->where('PK_FieldId',id_clean($field_id));
        $this->db->select('Name');
        $field = $this->db->get('Field');
        if($field->num_rows())
        {
            $result = $field->result();
            foreach($result AS $row)
            {
                $name = $row->Name;
            }
        }
        return $name;
    }
    
    function delete_field($id=NULL)
    {
        if(isset($id))
        {
            $this->db->where('PK_FieldId', $id);
            $this->db->delete('Field');
        }
     }
        
}
/* End of file m_field.php */
/* Location: ./application/models/m_field.php */