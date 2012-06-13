<?php

class Main extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        $this->lang->load('main');
        $this->load->helper('language');
    }

    public function index()
    {
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
        $data['msg'] = NULL;
        if($this->input->post('username')){
            if($this->auth->login(trim($this->input->post('username')),trim($this->input->post('password')))){
                redirect('member/farm/','refresh');
            }
            //error(s) occurred while processing request
            $data['msg'] = $this->auth->get_errors();
        }
        
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
        if($this->php_session->get('AUTH')){
            //user is logged in; send to member's area
            redirect('member/farm','refresh');
        }
        
        $data['reset'] = NULL;
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|max_length[100]|valid_email');
            if($this->form_validation->run()){
                $this->auth->forgot_password(trim($this->input->post('Email')));
                $data['reset'] = TRUE;
            }
        }
        
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
        
        $data['title'] = 'Grow Our Yields - Password Reset';
        
        $this->load->view('header',$data);
        $this->load->view('lost');
        $this->load->view('footer',$data);
    }
    
    function signup()
    {
        if($this->php_session->get('AUTH')){
            //user is logged in; send to member's area
            redirect('member/farm','refresh');
        }
        
        $data['msg'] = NULL;
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->load->library('MY_form_validation',NULL,'form_validation');
            $this->form_validation->set_rules('FirstName', 'First Name', 'trim|required|max_length[25]');
            $this->form_validation->set_rules('LastName', 'Last Name', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('Email', 'Email', 'trim|required|max_length[100]|valid_email|check_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|required|min_length[3]|max_length[100]|check_username');
            $this->form_validation->set_rules('Password', 'Password', 'trim|required|min_length[8]|max_length[50]|matches[Password2]|is_legal_password');
            $this->form_validation->set_rules('Password2', 'Password (again)', 'trim|required');
            $this->form_validation->set_rules('Key', 'Invitation Key', 'trim|required|check_verification');
            $this->form_validation->set_rules('Terms', 'Terms of Use', 'trim|required');
            if($this->form_validation->run()){
                if($this->auth->create_account()){
                    redirect('member/farm','refresh');
                }
                //error(s) occurred while processing request
                $data['msg'] = $this->auth->get_errors();
            } else {
                $data['msg'] = validation_errors();
            }
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        //js object builder
        $data['js_object'] = js_object(
            array(
                'CI' => array('base_url' => base_url())
            )
        );
                  
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Sign Up';
        
        $this->load->view('header',$data);
        $this->load->view('signup');
        $this->load->view('footer',$data);
    }

    function pwr(){
        
        if(!$this->m_user->verify_pwr($this->uri->segment(3),$this->uri->segment(4),TRUE)->num_rows()){
            show_404();
        }
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        //js object builder
        $data['js_object'] = js_object(
            array(
                'CI' => array('base_url' => base_url())
            )
        );
                  
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js')
            )
        );
        
        $data['title'] = 'Grow Our Yields';
        
        $this->load->view('header',$data);
        $this->load->view('footer',$data);
    }
    
    function error(){
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
