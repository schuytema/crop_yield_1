<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Equipment model
 *
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Equipment
 * @author	Nick Carlson
 */
class m_equipment extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    //get by ID
    function get($id){
        return $this->db->get_where('Equipment',array('PK_EquipmentId' => id_clean($id)));
    }
    
    //return all types
    function get_type($verified=NULL){
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('EquipmentType');
        return $this->db->get('Equipment');
    }
    
    //return all brands by type
    function get_brand($type=NULL,$verified=NULL){
        if(isset($type)){
            $this->db->where('EquipmentType',db_clean($type,20));
        }
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('Brand');
        $this->db->order_by('Brand');
        return $this->db->get('Equipment');
    }
    
    //return products by type,brand
    function get_product($type=NULL,$brand=NULL,$verified=NULL){
        if(isset($type)){
            $this->db->where('EquipmentType',db_clean($type,20));
        }
        
        if(isset($brand)){
            $this->db->where('Brand',db_clean($brand,100));
        }
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('PK_EquipmentId,Product');
        $this->db->order_by('Product');
        return $this->db->get('Equipment');
    }
    
    //return all brands by type
    function get_product_info($id=NULL){
        $info['Type'] = NULL;
        $info['Brand'] = NULL;
        $info['Product'] = NULL;
        $info['Power'] = NULL;
        
        $this->db->where('PK_EquipmentId',$id);
        $results = $this->db->get('Equipment');
        if($results->num_rows())
        {
            $datarow = $results->row();
            $info['Type'] = $datarow->EquipmentType;
            $info['Brand'] = $datarow->Brand;
            $info['Product'] = $datarow->Product;
            $info['Power'] = $datarow->Power;
        }
        
        return $info;
    }
    
    function set_equipment_manually($type, $brand, $product, $tillage_type, $power)
    {
        $data = array(
            'EquipmentType' => db_clean(($type),20),
            'Brand' => db_clean(strip_tags(($brand)),100),
            'Product' => db_clean(strip_tags(($product)),200),
            'TillageType' => db_clean(strip_tags(($tillage_type)),100),
            'Power' => id_clean($power),
            'Verified' => 0
        );
        //print_r($data);
        $this->db->set($data);
        $this->db->insert('Equipment');
        return $this->db->insert_id();
    }
    
    //get unverified (user-submitted) data
    function get_unverified($limit=NULL){
        if(isset($limit)){
            $this->db->limit(id_clean($limit));
        }
        return $this->db->get_where('Equipment',array('Verified' => 0));
    }
    
    //verification tool: set Verified to 'true'; update Brand,Product,Power,TillageType to manage text mods
    function verify_entry($id,$brand,$product,$power,$tillage){
        $data = array(
            'Verified' => 1,
            'Brand' => db_clean($brand,100,FALSE),
            'Product' => db_clean($product,200,FALSE),
            'Power' => id_clean($power),
            'TillageType' => (isset($tillage)) ? db_clean($tillage,50) : NULL
        );
        $this->db->set($data);
        $this->db->where('PK_EquipmentId', id_clean($id));
        $this->db->update('Equipment');
    }
    
    //verification tool: remove user-input ($id) with existing entry ($replacement_id)
    function replace_entry($id,$replacement_id){
        //update records in "m_shed"
        $data = array(
            'FK_EquipmentId' => id_clean($replacement_id)
        );
        $this->db->set($data);
        $this->db->where('FK_EquipmentId', id_clean($id));
        $this->db->update('Shed'); 
        
        //remove user-supplied entry from table "equipment"
        $this->db->delete('Equipment', array('PK_EquipmentId' => id_clean($id))); 
    }
    
}
/* End of file m_equipment.php */
/* Location: ./application/models/m_equipment.php */