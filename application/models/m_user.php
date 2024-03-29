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
    
    //get all user data
    function get_all($limit,$start){
        $this->db->limit($limit, $start);
        $this->db->order_by('LastName');
        return $this->db->get('User');
    }
    
    //count all records
    function record_count() {
        return $this->db->count_all('User');
    }

    
    //get record by username
    function get_by_username($user){
        $this->db->where('LOWER(Username)=',strtolower(db_clean($user,100)));
        return $this->db->get('User');
    }
    
    //get record by user id
    function get_by_userid($id){
        $this->db->where('PK_UserId',id_clean($id));
        return $this->db->get('User');
    }
    
    //get record by email
    function get_by_email($email){
        $this->db->where('LOWER(Email)=', strtolower(db_clean($email,100)));
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
            return $this->db->insert_id();
        }
        return FALSE;
    }
    
    //data cleaned from auth lib
    function update_user($id,$data){
        $this->db->set($data);
        $this->db->where('PK_UserId',$id);
        $this->db->update('User');
    }
    
    function set_new_password_key($id,$key){
        $data = array(
            'NewPasswordKey' => $key,
            'NewPasswordRequest' => date('Y-m-d H:i:s')
        );
        $this->db->set($data);
        $this->db->where('PK_UserId',id_clean($id));
        $this->db->update('User');
    }
        
    //verify password recovery params
    function verify_pwr($id,$key){
        $this->db->where('PK_UserId',id_clean($id));
        $this->db->where('NewPasswordKey',db_clean($key,32));
        $this->db->where('NewPasswordRequest > ( NOW( ) - INTERVAL 8 HOUR )');
        if($this->db->get('User')->num_rows()){
            return TRUE;
        }
        
        //no results: odds are time expired (or the id/key are invalid)
        //update record to nullify new password fields
        $data = array(
            'NewPasswordKey' => NULL,
            'NewPasswordRequest' => NULL,
        );
        $this->db->set($data);
        $this->db->where('PK_UserId',id_clean($id));
        $this->db->update('User');
        
        return FALSE;
    }
    
    //reset password system
    function reset_password($id,$key,$password){
        $data = array(
            'Password' => $password,
            'NewPasswordKey' => NULL,
            'NewPasswordRequest' => NULL
        );
        $this->db->set($data);
        $this->db->where('PK_UserId',id_clean($id));
        $this->db->where('NewPasswordKey',id_clean($key));
        if($this->db->update('User')){
            //get email for notification
            $this->db->select('Email');
            $query = $this->db->get_where('User',array('PK_UserId' =>id_clean($id)));
            return $query->row()->Email;
        }
        return FALSE;
    }
}
/* End of file m_user.php */
/* Location: ./application/models/m_user.php */