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
        if(!isset($auth_data['FarmId']) && $this->router->method != 'editfarm' && $this->router->method != 'logout'){
            redirect('member/editfarm','refresh');
        }
        
        $this->load->model('m_chemical');
        $this->load->model('m_farm');
        $this->load->model('m_field');
        $this->load->model('m_event');
        $this->lang->load('main');
        $this->load->helper('language');
        
        //$this->output->enable_profiler(TRUE);
    }

    function logout(){
        $this->auth->logout();
        redirect('main/','refresh');
    }
    
    public function farm()
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
        
        $data['title'] = 'Grow Our Yields - Your Farm';
        
        //get info for the field table
        $auth_data = $this->php_session->get('AUTH');
        $data['user_info'] = $this->m_user->get_by_userid($auth_data['UserId']);
        $data['farm'] = $this->m_farm->get($auth_data['FarmId']);
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $this->load->view('header',$data);
        $this->load->view('farm');
        $this->load->view('footer',$data);
    }
    
    public function field($field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        if(isset($field_id))
        {
            $owning_farm = $this->m_field->get_farm_id_from_field($field_id);
            if ($owning_farm != $auth_data['FarmId'])
            {
                redirect('member/farm','refresh');
            }
        } else {
            redirect('member/farm','refresh');
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
        
        $data['title'] = 'Grow Our Yields - Field View';
        
        //get info for the field data
        if(isset($field_id))
        {
            $data['field'] = $this->m_field->get($field_id);
        }
        
        $this->load->view('header',$data);
        $this->load->view('field');
        $this->load->view('footer',$data);
    }
    
    public function event($event_id = 1)
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
        
        $data['title'] = 'Grow Our Yields - Event View';
        
        $this->load->view('header',$data);
        $this->load->view('event');
        $this->load->view('footer',$data);
    }
    
    public function editaccount($user_id=1)
    {
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
    
    public function editfarm()
    {
        $auth_data = $this->php_session->get('AUTH');
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->load->library('MY_form_validation',NULL,'form_validation');
            $this->form_validation->set_rules('Name', 'Farm Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('Address', 'Farm Address', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('City', 'City', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('State', 'State', 'trim|required');
            $this->form_validation->set_rules('Zip', 'Zipcode', 'trim|required|check_zip_code');
            $this->form_validation->set_rules('Phone', 'Phone', 'trim|required|max_length[20]');
            if($this->form_validation->run()){
                //send to db
                $this->m_farm->set($auth_data['FarmId']);
                //redirect to overview
                redirect('member/farm','refresh');
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        //load state list
        $this->load->config('state_list');
        
        $data['title'] = 'Grow Our Yields - Farm Management';
        $data['page_title'] = lang('farm_edit_title');
        $data['desc'] = lang('farm_edit_desc');
        
        
        if(!isset($auth_data['FarmId'])){ //farm record does not exist; display first-time user info
            $data['page_title'] = lang('farm_new_title');
            $data['desc'] = lang('farm_new_desc');
        } else {
            $data['farm_data'] = $this->m_farm->get($auth_data['FarmId']);
        }
        
        $this->load->view('header',$data);
        $this->load->view('editfarm');
        $this->load->view('footer',$data);
    }
    
    public function editfield($field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        if(isset($field_id))
        {
            $owning_farm = $this->m_field->get_farm_id_from_field($field_id);
            if ($owning_farm != $auth_data['FarmId'])
            {
                redirect('member/farm','refresh');
            }
        }
        
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->form_validation->set_rules('Name', 'Field Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('UserSize', 'Field Sizes', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('UserSizeUnit', 'Unit', 'trim|required|max_length[9]');
            $this->form_validation->set_rules('PercentDrainageEffectiveness', 'Drainage', 'trim|required|max_length[7]');
            if($this->form_validation->run()){
                //send to db
                if(isset($field_id))
                {
                    $this->m_field->set($auth_data['FarmId'], $field_id);
                } else {
                    $this->m_field->set($auth_data['FarmId']);
                    echo 'field id!';
                }
                //redirect to overview
                redirect('member/farm','refresh');
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        $data['title'] = 'Grow Our Yields - Edit Field';
        $data['page_title'] = lang('field_edit_title');
        $data['desc'] = lang('field_edit_desc');
        
        
        if(!isset($field_id)){ //field record does not exist; display first-time user info
            $data['page_title'] = lang('field_new_title');
            $data['desc'] = lang('field_new_desc');
        } else {
            $data['field_data'] = $this->m_field->get($field_id);
        }
        
        //for the second run of form processing (with validation), so if we have a field to edit, it keeps the id
        $data['action'] = current_url();
        
        $this->load->view('header',$data);
        $this->load->view('editfield');
        $this->load->view('footer',$data);
    }
    
    public function editevent()
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
        
        $data['title'] = 'Grow Our Yields - Edit Event';
        

        $this->load->view('header',$data);
        $this->load->view('editevent',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_application()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Application';
        
        $data['event_type'] = 'Application';
        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                base_url().'js/calendar.js'
            )
        );
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_application',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_chemical()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Chemical';
        
        $data['event_type'] = 'Chemical';
        
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
                base_url().'js/chemical.js',
                base_url().'js/calendar.js'
            )
        );
        
        //get chemical type
        $data['types'] = $this->m_chemical->get_type();
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_chemical',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_fertilizer()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Fertilizer';
        
        $data['event_type'] = 'Fertilizer';
        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                base_url().'js/calendar.js'
            )
        );
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_fertilizer',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_harvest()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Harvest';
        
        $data['event_type'] = 'Harvest';
        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                base_url().'js/calendar.js'
            )
        );
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_harvest',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_plant()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Plant';
        
        $data['event_type'] = 'Plant';
        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                base_url().'js/calendar.js'
            )
        );
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        //this stuff is just for a first pass demo

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_plant',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_tillage()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Tillage';
        
        $data['event_type'] = 'Tillage';
        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                base_url().'js/calendar.js'
            )
        );
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_tillage',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_weather()
    {
        $auth_data = $this->php_session->get('AUTH');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Helping America\'s farmers make better decisions, one field at a time.'),
                array('name'=>'keywords','content'=>'grow our yields, yield, crop, corn, beans, soybeans, field, agriculture')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/calendar.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Weather';
        
        $data['event_type'] = 'Weather';
        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                base_url().'js/calendar.js'
            )
        );
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_weather',$data);
        $this->load->view('footer',$data);
    }
    
    
    function delete_field($field_id=NULL){   
        $this->m_field->delete_field($field_id);   
        $field_events = $this->m_event->get_field_events($field_id);
        if($field_events->num_rows()){
            $result = $field_events->result();
            foreach($result AS $row)
            {
                //@TODO handle deletion for all child events of any found events
                $this->m_event->delete_event($row->PK_EventId);
            }
        } 
        redirect('member/farm','refresh');
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