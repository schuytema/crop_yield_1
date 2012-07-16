<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Shed model
 *
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Shed
 * @author	Paul Schuytema
 */
class m_shed extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    function set($user_id=NULL, $new=true, $equipment_id=NULL, $shed_id=NULL){
        $data = array(
            'FK_BossId' => $user_id,
            'Name' => db_clean(strip_tags($this->input->post('Name')),100),
            'UserSize' => db_clean(strip_tags($this->input->post('UserSize')),11),
            'UserSizeUnit' => db_clean($this->input->post('UserSizeUnit'),9),
            'PercentDrainageEffectiveness' => db_clean(strip_tags($this->input->post('PercentDrainageEffectiveness')),5),
            'Coordinates' => db_clean($this->input->post('Coordinates')),
            'CalcSize' => db_clean($this->input->post('CalcSize')),
            'CalcSizeUnit' => 'acres'
        );
        
        if(!$new){ //update  
            if (isset($equipment_id))
            {
                $data['FK_EquipmentId'] = id_clean($equipment_id);
            } else {
                if (strlen($this->input->post('EquipmentProduct')) > 0)
                {
                    $data['FK_EquipmentId'] = id_clean($this->input->post('EquipmentProduct'));
                }
            }
            

            $this->db->set($data);
            $this->db->where('FK_ShedId',id_clean($shed_id));
            $this->db->update('Shed');
        } else { //create record
            if (isset($equipment_id))
            {
                $data['FK_EquipmentId'] = id_clean($equipment_id);
            } else {
                $data['FK_EquipmentId'] = id_clean($this->input->post('EquipmentProduct'));
            }
            
            $this->db->set($data);
            $this->db->insert('Shed');
        }
    }
    
    function get($id=NULL){
        return $this->db->get_where('Shed',array('PK_ShedId' => id_clean($id)));
    }
    
    
    //gets implement names
    function get_implements($user_id=NULL){
        if(isset($user_id)){
            $this->db->where('FK_BossId',db_clean($user_id,20));
        }
        $this->db->distinct();
        $this->db->select('Name, PK_EquipmentId');
        $this->db->order_by('Name');
        return $this->db->get('Shed');
    }
    
    
    function delete_shed($id=NULL)
    {
        if(isset($id))
        {
            $this->db->where('PK_ShedId', $id);
            $this->db->delete('Shed');
        }
     }
    
}
/* End of file m_equipment.php */
/* Location: ./application/models/m_equipment.php */