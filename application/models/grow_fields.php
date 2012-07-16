<?php


class Grow_fields extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    function get_chemical_brands($type = 'Herbicide')
    {
        $query = $this->db->query("SELECT DISTINCT Brand FROM Chemical WHERE ChemicalType ='$type'  ORDER BY Brand ASC");
        
        $results = array();

        foreach ($query->result() as $row)
        {
            $results[] = $row->Brand;
        }
        return $results;
    }
    
    function get_chemical_products($brand = 'ACETO AGRI. CHEMICALS CORP.')
    {   
        $query = $this->db->query("SELECT DISTINCT Product FROM Chemical WHERE Brand ='$brand'  ORDER BY Product ASC");
        
        $results = array();

        foreach ($query->result() as $row)
        {
            $results[] = $row->Product;
        }
        return $results;
    }
    
}

?>
