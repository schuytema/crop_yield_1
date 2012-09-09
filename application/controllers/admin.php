<?php
class Admin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->lang->load('main');
        $this->load->helper('language');
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Application Manager';
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/login');
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
        
        $this->load->view('admin/header',$data);
        $this->load->view('admin/home');
        $this->load->view('admin/footer',$data);
    }
    
}

