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
    
    //get by ID
    function get($id){
        return $this->db->get_where('Crop',array('PK_CropId' => id_clean($id)));
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
        $info['Type'] = NULL;
        $info['Brand'] = NULL;
        $info['Product'] = NULL;
        
        $this->db->where('PK_CropId',$id);
        $results = $this->db->get('Crop');
        if($results->num_rows())
        {
            $datarow = $results->row();
            $info['Type'] = $datarow->CropType;
            $info['Brand'] = $datarow->Brand;
            $info['Product'] = $datarow->Product;
        }
        
        return $info;
    }
    
    function set_crop_manually($type, $brand, $product)
    {
        $data = array(
            'CropType' => db_clean(($type),20),
            'Brand' => db_clean(strip_tags(($brand)),100),
            'Product' => db_clean(strip_tags(($product)),200),
            'Verified' => 0
        );
        //print_r($data);
        $this->db->set($data);
        $this->db->insert('Crop');
        return $this->db->insert_id();
    }
    
    //return first product that matches brand
    function get_existing_product($type,$brand,$product,$verified=NULL){
        //verified check (optional)
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->where('CropType',db_clean($type,20));
        $this->db->where('Brand',db_clean($brand,100));
        $this->db->where('Product',db_clean($product,200));
        $this->db->order_by('PK_CropId','asc');
        $this->db->limit(1);
        return $this->db->get('Crop');
    }
    
    //get unverified (user-submitted) data
    function get_unverified($limit=NULL){
        if(isset($limit)){
            $this->db->limit(id_clean($limit));
        }
        return $this->db->get_where('Crop',array('Verified' => 0));
    }
    
    //verification tool: set Verified to 'true'; update Brand,Product to manage text mods
    function verify_entry($id,$brand,$product){
        $data = array(
            'Verified' => 1,
            'Brand' => db_clean($brand,100,FALSE),
            'Product' => db_clean($product,200,FALSE)
        );
        $this->db->set($data);
        $this->db->where('PK_CropId', id_clean($id));
        $this->db->update('Crop');
    }
    
    //verification tool: replace user-input ($id) with existing entry ($replacement_id)
    function replace_entry($id,$replacement_id){
        //update table "cropinstance"
        $data = array(
            'FK_CropId' => id_clean($replacement_id)
        );
        $this->db->set($data);
        $this->db->where('FK_CropId', id_clean($id));
        $this->db->update('Cropinstance');
        
        //remove user-supplied entry from table "crop"
        $this->db->delete('Crop', array('PK_CropId' => id_clean($id))); 
    }
}
/* End of file m_equipment.php */
/* Location: ./application/models/m_equipment.php */