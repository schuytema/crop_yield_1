<?php

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
    }



    public function index()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Welcome';
        
        $this->load->view('header',$data);
        $this->load->view('home');
        $this->load->view('footer',$data);
    }


    function contact()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Contact Us';
        
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

        $this->load->view('header',$data);
        $this->load->view('contact',$data);
        $this->load->view('footer',$data);

    }

    function privacy()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Privacy Policy';
        
        $this->load->view('header',$data);
        $this->load->view('privacy');
        $this->load->view('footer',$data);
    }
    
    function terms()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Terms of Use';
        
        $this->load->view('header',$data);
        $this->load->view('terms');
        $this->load->view('footer',$data);
    }

    function about()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - About Us';
        
        $this->load->view('header',$data);
        $this->load->view('about');
        $this->load->view('footer',$data);
    }
    
    function login()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Login';
        
        $this->load->view('header',$data);
        $this->load->view('login');
        $this->load->view('footer',$data);
    }
    
    function lost()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Not Found';
        
        $this->load->view('header',$data);
        $this->load->view('lost');
        $this->load->view('footer',$data);
    }
    
    function signup()
    {
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Sign Up';
        
        $this->load->view('header',$data);
        $this->load->view('signup');
        $this->load->view('footer',$data);
    }

    function error(){
        $data['member'] = false;
        
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Error';
        
        $this->load->view('header',$data);
        $this->load->view('error');
        $this->load->view('footer',$data);
    }
    
    
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */