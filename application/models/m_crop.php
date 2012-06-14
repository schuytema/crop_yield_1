<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Equipment model
 *
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Crop
 * @author	Nick Carlson
 */
class m_crop extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    //return all types
    function get_type($verified=NULL){
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('CropType');
        return $this->db->get('Crop');
    }
    
    //return all brands by type
    function get_brand($type=NULL,$verified=NULL){
        if(isset($type)){
            $this->db->where('CropType',db_clean($type,20));
        }
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('Brand');
        $this->db->order_by('Brand');
        return $this->db->get('Crop');
    }
    
    //return products by type,brand
    function get_product($type=NULL,$brand=NULL,$verified=NULL){
        if(isset($type)){
            $this->db->where('CropType',db_clean($type,20));
        }
        
        if(isset($brand)){
            $this->db->where('Brand',db_clean($brand,100));
        }
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('PK_CropId,Product');
        $this->db->order_by('Product');
        return $this->db->get('Crop');
    }
    
    //return all brands by type
    function get_product_info($id=NULL){
        $this->db->where('PK_CropId',$id);
        $results = $this->db->get('Crop');
        if($results->num_rows())
        {
            $datarow = $results->row();
        }
        $info['Type'] = $datarow->CropType;
        $info['Brand'] = $datarow->Brand;
        $info['Product'] = $datarow->Product;
        return $info;
    }
    
    function set_crop_manually($type, $brand, $product)
    {
        $data = array(
            'CropType' => db_clean(($type),20),
            'Brand' => db_clean(($brand),100),
            'Product' => db_clean(($product),200),
            'Verified' => 0
        );
        //print_r($data);
        $this->db->set($data);
        $this->db->insert('Crop');
        return $this->db->insert_id();
    }
    
}
/* End of file m_equipment.php */
/* Location: ./application/models/m_equipment.php */