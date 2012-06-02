<?php

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        session_start();
        
        $this->load->helper('url');
    }



    public function index()
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('home');
        $this->load->view('footer',$data);
    }
    
    public function farm()
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('farm');
        $this->load->view('footer',$data);
    }
    
    public function editfield($action='new')
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('editfield');
        $this->load->view('footer',$data);
    }


    
    

}

/* End of file member.php */
/* Location: ./application/controllers/member.php */