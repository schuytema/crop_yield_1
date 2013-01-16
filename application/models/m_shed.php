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
            'SerialNum' => db_clean(strip_tags($this->input->post('SerialNum')),100)
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
    function get_implements($user_id=NULL, $power=0){
        $this->db->trans_start();
        if ($power > 1)
        {
            $query =    "SELECT Shed.FK_EquipmentId, Shed.Name, Shed.PK_ShedId, Shed.SerialNum FROM Shed ".
                        "LEFT JOIN Equipment ON Shed.FK_EquipmentId = Equipment.PK_EquipmentId ".
                        "WHERE (Shed.FK_BossId = $user_id);";
        } else {
            $query =    "SELECT Shed.FK_EquipmentId, Shed.Name, Shed.PK_ShedId, Shed.SerialNum FROM Shed ".
                        "LEFT JOIN Equipment ON Shed.FK_EquipmentId = Equipment.PK_EquipmentId ".
                        "WHERE (Shed.FK_BossId = $user_id) AND (Equipment.Power = $power);";
        }
        $results = $this->db->query($query);
        $this->db->trans_complete();
        return $results;
    }
    
    //gets implement counts
    function get_implement_counts($user_id=NULL, $power=0){
        $this->db->trans_start();
        if ($power > 1)
        {
            $query =    "SELECT Shed.FK_EquipmentId, Shed.Name, Shed.PK_ShedId FROM Shed ".
                        "LEFT JOIN Equipment ON Shed.FK_EquipmentId = Equipment.PK_EquipmentId ".
                        "WHERE (Shed.FK_BossId = $user_id);";
        } else {
            $query =    "SELECT Shed.FK_EquipmentId, Shed.Name, Shed.PK_ShedId FROM Shed ".
                        "LEFT JOIN Equipment ON Shed.FK_EquipmentId = Equipment.PK_EquipmentId ".
                        "WHERE (Shed.FK_BossId = $user_id) AND (Equipment.Power = $power);";
        }
        $results = $this->db->query($query);
        $count = $results->num_rows();
        $this->db->trans_complete();
        return $count;
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