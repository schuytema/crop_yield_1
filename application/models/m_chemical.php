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
    function get_type(){
        $this->db->distinct();
        $this->db->select('ChemicalType');
        return $this->db->get('Chemical');
    }
    
    //return all brands by type
    function get_brand($type=NULL){
        if(isset($type)){
            $this->db->where('ChemicalType',db_clean($type,20));
        }
        $this->db->distinct();
        $this->db->select('Brand');
        $this->db->order_by('Brand');
        return $this->db->get('Chemical');
    }
    
    //return products by type,brand
    function get_product($type=NULL,$brand=NULL){
        if(isset($type)){
            $this->db->where('ChemicalType',db_clean($type,20));
        }
        
        if(isset($brand)){
            $this->db->where('Brand',db_clean($brand,100));
        }
        $this->db->distinct();
        $this->db->select('PK_ChemicalId,Product');
        $this->db->order_by('Product');
        return $this->db->get('Chemical');
    }
    
}
/* End of file m_chemical.php */
/* Location: ./application/models/m_chemical.php */