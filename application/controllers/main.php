<?php

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        session_start();
        
        $this->load->helper('url');
    }



    public function index()
    {
        
        $this->load->view('header');
        $this->load->view('home');
        $this->load->view('footer');
    }


    function contact()
    {
        $this->load->library('mail');
        $this->config->load('contact_data');
        $data['content'] = '';

        $this->load->library('form_validation');
        $this->mail->set_validation_rules('contactMail');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

        //page content widget
        if ($this->form_validation->run() == FALSE)
        {
            if (validation_errors() != '')
            {
                $data['content'] .= '<br><center><font color="red">'.validation_errors().'</font></center><br>';
            }
            $data['content'] .= $this->mail->generate_contact_form(base_url().$this->uri->uri_string(),'contactMail');
        }
        else
        {
            if ($_SESSION['security_code'] == $this->input->post('security_code'))
            //if (true)
            {
                //security code is fine
                //process email
                $this->mail->send_contact_email_custom('contactMail');
                $contact_info = $this->config->item('contactMail');
                $success_message = $contact_info['successMsg'];
                $data['content'] .= '<br>'.$success_message;
            } else {
                //security code isn't right
                $data['content'] .= '<br><center><font color="red">You didn\'t enter the proper security code</font></center><br>';
                $data['content'] .= $this->mail->generate_contact_form(base_url().$this->uri->uri_string(),'contactMail');
            }
        }

        $data['content'] = $data['content'].'<br><br>';

        $this->load->view('header');
        $this->load->view('contact',$data);
        $this->load->view('footer');

    }

    function privacy()
    {
        $this->load->view('header');
        $this->load->view('privacy');
        $this->load->view('footer');
    }

    function about()
    {
        $this->load->view('header');
        $this->load->view('about');
        $this->load->view('footer');
    }

    function error(){
        $this->load->view('header');
        $this->load->view('error');
        $this->load->view('footer');
    }

}

/* End of file main.php */
/* Location: ./system/application/controllers/main.php */