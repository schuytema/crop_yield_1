<?php

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if(!$this->php_session->get('AUTH')){
            redirect('main/login','refresh');
        }
        
        //verify farm record exists; if not - send to farm form
        $auth_data = $this->php_session->get('AUTH');
        if(!isset($auth_data['FarmId']) && $this->router->method != 'editfarm'){
            redirect('member/editfarm','refresh');
        }
        
                
        $this->load->model('grow_fields');
        
        $this->load->model('m_chemical');
    }
    
    public function farm()
    {
        
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Your Farm';
        
        
        $this->load->view('header',$data);
        $this->load->view('farm');
        $this->load->view('footer',$data);
    }
    
    public function field($field_id = 1)
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Field View';
        
        $this->load->view('header',$data);
        $this->load->view('field');
        $this->load->view('footer',$data);
    }
    
    public function event($event_id = 1)
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Event View';
        
        $this->load->view('header',$data);
        $this->load->view('event');
        $this->load->view('footer',$data);
    }
    
    public function editaccount($user_id=1)
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Account';
        
        $this->load->view('header',$data);
        $this->load->view('editaccount');
        $this->load->view('footer',$data);
    }
    
    public function editfarm($farm_id=1)
    {
        $data['member'] = true;
        
        $auth_data = $this->php_session->get('AUTH');
        $data['edit_mode'] = (isset($auth_data['FarmId'])) ? TRUE : FALSE;
        //utilize lang file
        $data['title'] = ($data['edit_mode']) ? 'Grow Our Yields - Edit Farm' : 'Grow Our Yields - Create Farm';
        $data['page_title'] = ($data['edit_mode']) ? 'Edit Farm' : 'Create Farm';
        $data['title'] = ($data['edit_mode']) ? 'Grow Our Yields - Edit Farm' : 'Grow Our Yields - Add Farm';
        
        
        if($this->input->post('submit')){
            //form validation
            
            //write to db
            
            //send to members homepage if successful; else re-populate form
        }
        
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
        
        
        $this->load->view('header',$data);
        $this->load->view('editfarm');
        $this->load->view('footer',$data);
    }
    
    public function editfield($farm_id=1, $action='new')
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Field';
        
        $this->load->view('header',$data);
        $this->load->view('editfield');
        $this->load->view('footer',$data);
    }
    
    public function editevent()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event';
        

        $this->load->view('header',$data);
        $this->load->view('editevent',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_application()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Application';
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_application',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_chemical()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Chemical';
        
        //js object builder
        $data['js_object'] = js_object(
            array(
                'CI' => array('base_url' => base_url())
            )
        );
                  
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js'),
                base_url().'js/chemical.js'
            )
        );
        
        //get chemical type
        $data['types'] = $this->m_chemical->get_type();

        $this->load->view('header',$data);
        $this->load->view('editevent_chemical',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_fertilizer()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Fertilizer';
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_fertilizer',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_harvest()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Harvest';
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_harvest',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_plant()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Plant';
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_plant',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_tillage()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Tillage';
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_tillage',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_weather()
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event Weather';
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_weather',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_org($field_id=1, $action='new')
    {
        $data['member'] = true;
        
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
        
        $data['title'] = 'Grow Our Yields - Edit Event';
        
        //this stuff is just for a first pass demo
        $data['brands'] = $this->grow_fields->get_chemical_brands('Herbicide');
        $data['products'] = $this->grow_fields->get_chemical_products('ACETO AGRI. CHEMICALS CORP.');
        $this->load->view('header',$data);
        $this->load->view('editevent_org',$data);
        $this->load->view('footer',$data);
    }
    
    //example
    function linked_list(){
        $data['member'] = true;
        
        //@TODO: load all meta data (i.e. meta description & meta keywords, when applicable), css and js by the following methods:
        
        //utilize helpers to dynamically load css & js files (i.e. load only the resources we need)
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
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
                $this->config->item('jquery_js'),
                base_url().'js/chemical.js'
            )
        );
        
        //get chemical type
        $data['types'] = $this->m_chemical->get_type();
        
        // load views
        $this->load->view('header', $data);
        $this->load->view('example', $data);
        $this->load->view('footer', $data);
    }
    
    ////////////////////////////////////////////////////////////////////////////
    //////////////////////////// AJAX REQUESTS /////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
    function get_chemical_brand(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['response'] = false;
            $query = $this->m_chemical->get_brand(trim($this->input->post('type')));
            if($query->num_rows()){
                $result = $query->result();
                $data['response'] = true; //Set response
                $data['list'] = array(); //Create array
                foreach($result as $row){
                    $data['list'][] = array('value'=> $row->Brand,'display' => $row->Brand);
                }
            }
            echo json_encode($data);
        }
    }
    
    function get_chemical_product(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['response'] = false;
            $query = $this->m_chemical->get_product(trim($this->input->post('type')),trim($this->input->post('brand')));
            if($query->num_rows()){
                $result = $query->result();
                $data['response'] = true; //Set response
                $data['list'] = array(); //Create array
                foreach($result as $row){
                    $data['list'][] = array('value'=> $row->PK_ChemicalId,'display' => $row->Product);
                }
            }
            echo json_encode($data);
        }
    }


}

/* End of file member.php */
/* Location: ./application/controllers/member.php */