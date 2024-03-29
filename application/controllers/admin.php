<?php
class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->lang->load('main');
        $this->load->helper('language');
        $this->load->model('m_user');
        $this->load->library('data_verification');
        $this->load->helper('help_system');
    }
    
    function index(){
        $data['msg'] = NULL;
        if($this->input->post('username')){
            if($this->auth->login(trim($this->input->post('username')),trim($this->input->post('password')),true)){
                redirect('admin/home/','refresh');
            }
            //error(s) occurred while processing request
            $data['msg'] = $this->auth->get_errors();
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Application Manager';
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/login');
        $this->load->view('admin/footer',$data);
    }
    
    function expired(){
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Session Expired';
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/expired');
        $this->load->view('admin/footer',$data);
    }
    
    function logout(){
        $this->auth->logout();
        redirect('/','refresh');
    }
    
    function home(){
        if(!$this->acl->is_allowed('admin_tool')){
            redirect('/','refresh');
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Application Manager';
        $auth_data = $this->php_session->get('AUTH');
        $data['user_info'] = $this->m_user->get_by_userid($auth_data['UserId']);
        $data['unverified_crop'] = $this->data_verification->unverified('crop');
        $data['unverified_equip'] = $this->data_verification->unverified('equipment');
                
        $this->load->view('admin/header',$data);
        $this->load->view('admin/home');
        $this->load->view('admin/footer',$data);
    }
    
    function account(){
        if(!$this->acl->is_allowed('admin_tool')){
            redirect('/','refresh');
        }
        
        $auth_data = $this->php_session->get('AUTH');
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->load->library('MY_form_validation',NULL,'form_validation');
            $this->load->config('account_validation');
            $this->form_validation->set_rules($this->config->item('account'));
            if($this->form_validation->run()){
                //send to db
                $this->auth->update_account();
                //redirect to overview
                redirect('admin/home','refresh');
            } 
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - My Account';
        
        $data['user_info'] = $this->m_user->get_by_userid($auth_data['UserId']);
        $data['form_url'] = 'admin/account';
                
        $this->load->view('admin/header',$data);
        $this->load->view('editaccount');
        $this->load->view('admin/footer',$data);
    }
    
    function crop_verification(){
        if(!$this->acl->is_allowed('admin_tool')){
            redirect('/','refresh');
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css')),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js'),
                $this->config->item('jquery_ui_js'),
                base_url().'js/data_verification.js',
            )
        );
        
        //js object builder
        $data['js_object'] = js_object(
            array(
                'CI' => array('base_url' => base_url(),'form_type' => 'crop')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Crop Verification';
        $data['unverified'] = $this->data_verification->unverified('crop');
                
        $this->load->view('admin/header',$data);
        $this->load->view('admin/crop_verification',$data);
        $this->load->view('admin/footer',$data);
    }
    
    function equip_verification(){
        if(!$this->acl->is_allowed('admin_tool')){
            redirect('/','refresh');
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css')),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js'),
                $this->config->item('jquery_ui_js'),
                base_url().'js/data_verification.js',
            )
        );
        
        //js object builder
        $data['js_object'] = js_object(
            array(
                'CI' => array('base_url' => base_url(),'form_type' => 'equipment')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Equipment Verification';
        $data['unverified'] = $this->data_verification->unverified('equipment');
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/equip_verification',$data);
        $this->load->view('admin/footer',$data);
    }
    
    function lost(){
        if($this->php_session->get('AUTH')){
            //user is logged in; send to member's area
            redirect('admin/home','refresh');
        }
        
        $data['reset'] = NULL;
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|max_length[100]|valid_email');
            if($this->form_validation->run()){
                $this->auth->recover_password_by_email(trim($this->input->post('Email')));
                $data['reset'] = TRUE;
            }
        }
                
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Password Reset';
        $data['url'] = 'admin/lost';
        
        $this->load->view('admin/header',$data);
        $this->load->view('lost');
        $this->load->view('admin/footer',$data);
    }
    
    function users(){
        if(!$this->acl->is_allowed('admin_tool')){
            redirect('/','refresh');
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        $this->load->library('pagination');
        $config['base_url'] = base_url().'admin/users/';
        $config['total_rows'] = $this->m_user->record_count();
        $config['per_page'] = 20; 
        $config['uri_segment'] = 3;
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['results'] = $this->m_user->get_all($config['per_page'],$page);
        $data['links'] = $this->pagination->create_links();
        $data['title'] = 'Grow Our Yields - User Management';
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/users',$data);
        $this->load->view('admin/footer',$data);
    }
    
    function user_details(){
        if(!$this->acl->is_allowed('admin_tool')){
            redirect('/','refresh');
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        //process
        if($this->input->post('disable')){ //disable account
            $this->m_user->update_user($this->input->post('id'),array('IsEnabled' => 0));
            $data['acct_status'] = 'The account has been locked.';
        }

        if($this->input->post('enable')){ //enable account
            $this->m_user->update_user($this->input->post('id'),array('IsEnabled' => 1,'FailedLoginCount' => 0));
            $data['acct_status'] = 'The account has been enabled.';
        }
        
        if($this->input->post('reset_password')){ //reset password
            if($this->auth->recover_password_by_id($this->input->post('id'))){
                $data['reset_status'] = 'A password reset link has been sent to the user.';
            } else{
                $data['reset_status'] = 'The password reset request failed.';
                log_message('error','Admin User Tool: Password reset request failed for user ID: '.$this->input->post('id'));
            }
        }
        
        $data['results'] = $this->m_user->get_by_userid($this->uri->segment(3));
        $data['id'] = trim($this->uri->segment(3));
        $data['title'] = 'Grow Our Yields - User Details';
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/user_details',$data);
        $this->load->view('admin/footer',$data);
    }
        
    ////////////////////////////////////////////////////////////////////////////
    //////////////////////////// AJAX REQUESTS /////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
    function verification_data(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //ensure session has not expired; user has sufficient rights
            if(!$this->acl->is_allowed('admin_tool')){
                echo json_encode(array('expired_session' => true));
                return false;
            }
            
            if($this->input->post('form_type') == 'crop'){ //crop entry
                //get crop info
                $data['entry'] = $this->m_crop->get($this->input->post('id'));
                //get brand info
                $data['brand'] = $this->m_crop->get_brand($data['entry']->row()->CropType,1);
                $view = $this->load->view('admin/manage_crop_entry',$data,TRUE);
                echo json_encode(array('result' =>$view));
            } else { //equipment entry
                //load dropdown list (because tillage types live here)
                $this->load->config('edit_dropdowns');
                //get crop info
                $data['entry'] = $this->m_equipment->get($this->input->post('id'));
                //get brand info
                $data['brand'] = $this->m_equipment->get_brand($data['entry']->row()->EquipmentType,1);
                $view = $this->load->view('admin/manage_equip_entry',$data,TRUE);
                echo json_encode(array('result' =>$view));
            }
        }
    }
    
    function get_product(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //ensure session has not expired; user has sufficient rights
            if(!$this->acl->is_allowed('admin_tool')){
                echo json_encode(array('expired_session' => true));
                return false;
            }
            
            $data['response'] = false;
            if($this->input->post('form_type') == 'crop'){
                $query = $this->m_crop->get_product(trim($this->input->post('type')),trim($this->input->post('brand'),1));
                if($query->num_rows()){
                    $result = $query->result();
                    $data['response'] = true; //Set response
                    $data['list'] = array(); //Create array
                    foreach($result as $row){
                        $data['list'][] = array('value'=> $row->PK_CropId,'display' => $row->Product);
                    }
                }
                
            } else {
                $query = $this->m_equipment->get_product(trim($this->input->post('type')),trim($this->input->post('brand'),1));
                if($query->num_rows()){
                    $result = $query->result();
                    $data['response'] = true; //Set response
                    $data['list'] = array(); //Create array
                    foreach($result as $row){
                        $data['list'][] = array('value'=> $row->PK_EquipmentId,'display' => $row->Product);
                    }
                }
            }
            echo json_encode($data);
        }
    }
    
    function process_verification(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            //ensure session has not expired; user has sufficient rights
            if(!$this->acl->is_allowed('admin_tool')){
                echo json_encode(array('expired_session' => true));
                return false;
            }
                        
            if($this->input->post('form') && $this->input->post('id')){
                $type = ($this->input->post('form_type') == 'crop') ? 'crop' : 'equipment';
                if($this->data_verification->process($type)){
                    echo json_encode(true);
                } else {
                    //retrieve errors
                    echo json_encode(array('error' => $this->data_verification->get_errors()));
                }
            } else {
                echo json_encode(array('error' => lang('data_ver_general_error')));
            }
        }
    }
}