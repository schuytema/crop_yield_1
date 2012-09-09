<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Access Control List Class
 * 
 * @package     CropYield
 * @subpackage	Libraries
 * @category	Access Control
 * @author	Mike Cokel
 */

class Acl {
    
    //array key: user role (table user)
    //array value: list of allowed roles
    private $role_hierarchy = array(
        'user' => array('user'),
        'admin' => array('user','admin'),
        'developer' => array('user','admin','developer')
    );
    var $acl = array();
    var $CI;
    
    function __construct(){
        // Set the super object to a local variable for use throughout the class
        $this->CI =& get_instance();
        
        if ($this->CI->php_session->get('ACL')){
            $this->acl = $this->CI->php_session->get('ACL');
        }
    }
    
    // --------------------------------------------------------------------

    /**
     * Initialize acl system at user login
     * 
     * User roles exist within a hierarchy and managed by the codebase.
     * As the application becomes more complex, it may be necessary to modify
     * hierarchy management
     *
     * @access	public
     * @param	int
     * @return	void
     */
    function init($role=NULL){
        if(isset($this->role_hierarchy[$role])){
            $this->CI->db->where_in('role',$this->role_hierarchy[$role]);
            $query = $this->CI->db->get('permission');
            if($query->num_rows()){
                $result = $query->result();
                foreach ($result as $row){
                    $this->acl[$row->Resource]['Create'] = $row->Create;
                    $this->acl[$row->Resource]['Read'] = $row->Read;
                    $this->acl[$row->Resource]['Update'] = $row->Update;
                    $this->acl[$row->Resource]['Delete'] = $row->Delete;
                }
                $this->CI->php_session->set('ACL',$this->acl);
            }
        }
    }
    
    // --------------------------------------------------------------------

    /**
     * Verify user has access to given resource
     *
     * @access	public
     * @param	string
     * @return	boolean
     */
    function is_allowed($resource,$permission='Read'){
        if(!isset($this->acl[$resource])){
            return FALSE;
        }
        return $this->acl[$resource][$permission];
    }
}
// END Acl Class

/* End of file Acl.php */
/* Location: ./application/libraries/Acl.php */