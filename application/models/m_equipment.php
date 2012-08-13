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
    
}
/* End of file m_equipment.php */
/* Location: ./application/models/m_equipment.php */