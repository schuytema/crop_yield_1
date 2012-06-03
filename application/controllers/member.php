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
    
    public function farm($farm_id = 1)
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('farm');
        $this->load->view('footer',$data);
    }
    
    public function field($field_id = 1)
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('field');
        $this->load->view('footer',$data);
    }
    
    public function event($event_id = 1)
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('event');
        $this->load->view('footer',$data);
    }
    
    public function editaccount($user_id=1)
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('editaccount');
        $this->load->view('footer',$data);
    }
    
    public function editfarm($farm_id=1)
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('editfarm');
        $this->load->view('footer',$data);
    }
    
    public function editfield($farm_id=1, $action='new')
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('editfield');
        $this->load->view('footer',$data);
    }
    
    public function editevent($field_id=1, $action='new')
    {
        $data['member'] = true;
        $this->load->view('header');
        $this->load->view('editfield');
        $this->load->view('footer',$data);
    }


}

/* End of file member.php */
/* Location: ./application/controllers/member.php */