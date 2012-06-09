<?php

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('grow_fields');
        
        $this->load->model('m_chemical');
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
        //this stuff is just for a first pass demo
        $data['brands'] = $this->grow_fields->get_chemical_brands('Herbicide');
        $data['products'] = $this->grow_fields->get_chemical_products('ACETO AGRI. CHEMICALS CORP.');
        $this->load->view('header');
        $this->load->view('editevent',$data);
        $this->load->view('footer',$data);
    }
    
    //example
    function linked_list(){
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