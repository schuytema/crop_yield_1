<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User model
 *
 * Model contains functions for user data
 *
 * @package     CropYield
 * @subpackage	Models
 * @category	User
 * @author	Mike Cokel
 */
class m_user extends CI_Model{
    
    function __construct(){
        parent::__construct();
    }
    
    //get record by username
    function get_by_username($user){
        $this->db->where('LOWER(Username)=',strtolower(db_clean($user,100)));
        return $this->db->get('User');
    }
    
    //update visit log; increase visit count by 1
    function update_visit($id,$count){
        //update record
        $data = array('LastVisit' => date('Y-m-d H:i:s'),
            'VisitCount' => $count + 1,
            'FailedLoginCount' => 0
        );
        $this->db->set($data);
        $this->db->where('PK_UserId',$id);
        $this->db->update('User');
    }
    
    function failed_login($user,$max_attempts){
        $this->db->select('PK_UserId,FailedLoginCount');
        $this->db->where('LOWER(Username)=',strtolower(db_clean($user,100)));
        $query = $this->db->get('User');
        if($query->num_rows()){
            $row = $query->row();
            $failed_attempts = $row->FailedLoginCount+1;
            
            //update record
            $data = array(
               'FailedLoginCount' => $failed_attempts,
               'IsEnabled' => ($failed_attempts >= $max_attempts) ? 0 : 1
            );
            $this->db->where('PK_UserId', $row->PK_UserId);
            $this->db->update('User', $data);
        }
    }
    
    function does_username_exist($user){
        $this->db->select('PK_UserId');
        $this->db->where('LOWER(Username)=', strtolower(db_clean($user,100)));
        $query = $this->db->get('User');
        return ($query->num_rows()) ? TRUE : FALSE;
    }
    
    function does_email_exist($email){
        $this->db->select('PK_UserId');
        $this->db->where('LOWER(Email)=', strtolower(db_clean($email,100)));
        $query = $this->db->get('User');
        return ($query->num_rows()) ? TRUE : FALSE;
    }
    
    //data cleaned from auth lib
    function create_user($data){
        $data['FirstVisit'] = date('Y-m-d H:i:s');
        $data['FailedLoginCount'] = 0;
        $data['IsEnabled'] = 1;
        if($this->db->insert('User',$data)) {
            return array('id' => $this->db->insert_id());
        }
        return FALSE;
    }
    
}
/* End of file m_user.php */
/* Location: ./application/models/m_user.php */