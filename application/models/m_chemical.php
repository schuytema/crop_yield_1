<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chemicals model
 *
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	Chemicals
 * @author	Mike Cokel
 */
class m_chemical extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    //return all types
    function get_type($verified=NULL){
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('ChemicalType');
        return $this->db->get('Chemical');
    }
    
    //return all brands by type
    function get_brand($type=NULL,$verified=NULL){
        if(isset($type)){
            $this->db->where('ChemicalType',db_clean($type,20));
        }
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('Brand');
        $this->db->order_by('Brand');
        return $this->db->get('Chemical');
    }
    
    //return products by type,brand
    function get_product($type=NULL,$brand=NULL,$verified=NULL){
        if(isset($type)){
            $this->db->where('ChemicalType',db_clean($type,20));
        }
        
        if(isset($brand)){
            $this->db->where('Brand',db_clean($brand,100));
        }
        if (isset($verified)) {
            $this->db->where('Verified',id_clean($verified));
        }
        $this->db->distinct();
        $this->db->select('PK_ChemicalId,Product');
        $this->db->order_by('Product');
        return $this->db->get('Chemical');
    }
    
    //return all brands by type
    function get_product_info($id=NULL){
        $info['Type'] = NULL;
        $info['Brand'] = NULL;
        $info['Product'] = NULL;
        
        $this->db->where('PK_ChemicalId',$id);
        $results = $this->db->get('Chemical');
        if($results->num_rows())
        {
            $datarow = $results->row();
            $info['Type'] = $datarow->ChemicalType;
            $info['Brand'] = $datarow->Brand;
            $info['Product'] = $datarow->Product;
        }
        
        return $info;
    }
    
    function set_chemical_manually($type, $brand, $product)
    {
        $data = array(
            'ChemicalType' => db_clean(($type),20),
            'Brand' => db_clean(strip_tags(($brand)),100),
            'Product' => db_clean(strip_tags(($product)),200),
            'Verified' => 0
        );
        //print_r($data);
        $this->db->set($data);
        $this->db->insert('Chemical');
        $id = $this->db->insert_id();
        return $id;
    }
    
    //suggest chemical product by keyword
    function suggest($term){
        $this->db->distinct();
        $this->db->select('Product');
        $this->db->where('Product LIKE','%'.db_clean($term,200).'%');
        $this->db->order_by('Product');
        $this->db->limit(10);
        return $this->db->get('Chemical');
    }
    
    //fetch chemical data by product name
    function fetch($term){
        $this->db->where('Product LIKE','%'.db_clean($term,200).'%');
        $this->db->order_by('Product');
        return $this->db->get('Chemical');
    }
    
}
/* End of file m_chemical.php */
/* Location: ./application/models/m_chemical.php */