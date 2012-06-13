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
    
    //get record by user id
    function get_by_userid($id){
        $this->db->where('PK_UserId',id_clean($id));
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
    
    function set_new_password_key($email,$key){
        //verify email address exists
        $this->db->select('PK_UserId');
        $this->db->where('LOWER(Email)=', strtolower(db_clean($email,100)));
        $query = $this->db->get('User');
        if(($query->num_rows())){
            $row = $query->row();
            //update record
            $data = array(
                'NewPasswordKey' => $key,
                'NewPasswordRequest' => date('Y-m-d H:i:s')
            );
            $this->db->set($data);
            $this->db->where('PK_UserId',$row->PK_UserId);
            $this->db->update('User');
            return $row->PK_UserId;
        }
        return FALSE;
    }
    
    //user created a new farm record; save foreign key
    function set_farm_id($user_id,$farm_id){
        $data = array('FK_FarmId' => $farm_id);
        $this->db->set($data);
        $this->db->where('PK_UserId',id_clean($user_id));
        $this->db->update('User');
    }
}
/* End of file m_user.php */
/* Location: ./application/models/m_user.php */