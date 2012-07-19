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
        $this->load->model('m_crop');
        $this->load->model('m_farm');
        $this->load->model('m_shed');
        $this->load->model('m_field');
        $this->load->model('m_equipment');
        $this->load->model('m_event');
        $this->load->model('m_eventapplication');
        $this->load->model('m_eventchemical');
        $this->load->model('m_eventfertilizer');
        $this->load->model('m_eventharvest');
        $this->load->model('m_eventplant');
        $this->load->model('m_eventtillage');
        $this->load->model('m_eventweather');
        $this->lang->load('main');
        $this->load->helper('language');
        
        //$this->output->enable_profiler(TRUE);
    }

    function logout(){
        $this->auth->logout();
        redirect('/','refresh');
    }
    
    public function enterprise()
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
        
        $data['title'] = 'Grow Our Yields - Your Enterprise';
        
        //get info for the field table
        $auth_data = $this->php_session->get('AUTH');
        $data['user_info'] = $this->m_user->get_by_userid($auth_data['UserId']);
        $data['farms'] = $this->m_farm->get_farms($auth_data['UserId']);
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId']);
        
        $this->load->view('header',$data);
        $this->load->view('enterprise');
        $this->load->view('footer',$data);
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
            $data['events'] = $this->m_event->get_field_events($field_id);
        }
        
 	
        //js_helper: dynamically build <script> tags

        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js'),
                "https://maps.googleapis.com/maps/api/js?sensor=true",
                base_url().'js/load_map_polygon.js',
            )
        );	
              
     
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
        $auth_data = $this->php_session->get('AUTH');
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->load->library('MY_form_validation',NULL,'form_validation');
            $this->form_validation->set_rules('FirstName', 'First Name', 'trim|required|max_length[25]');
            $this->form_validation->set_rules('LastName', 'Last Name', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('Email', 'Email', 'trim|max_length[100]|valid_email|check_email');
            $this->form_validation->set_rules('Username', 'Username', 'trim|min_length[3]|max_length[100]|check_username');
            $this->form_validation->set_rules('CurrPassword', 'Existing Password', 'trim|verify_password|verify_new_password_exists');
            $this->form_validation->set_rules('Password', 'New Password', 'trim|min_length[8]|max_length[50]|verify_current_password_exists|is_legal_password|matches[VerifyPassword]');
            $this->form_validation->set_rules('VerifyPassword', 'New Password (again)', 'trim');
            if($this->form_validation->run()){
                //send to db
                $this->auth->update_account();
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/reset.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Account';
        
        $data['user_info'] = $this->m_user->get_by_userid($auth_data['UserId']);
        
        $this->load->view('header',$data);
        $this->load->view('editaccount');
        $this->load->view('footer',$data);
    }
    
    public function editshed($shed_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
      
        
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->form_validation->set_rules('Name', 'Name', 'trim|required');

            if (strlen($this->input->post('OtherEquipmentBrand')) == 0 && strlen($this->input->post('OtherEquipmentProduct')) == 0)
            {
                $this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required|numeric');             
            }

            if($this->form_validation->run()){
                //see if other stuff has been entered... if so, create the new equipment row
                if (strlen($this->input->post('OtherEquipmentBrand')) > 0 && strlen($this->input->post('OtherEquipmentProduct')) > 0)
                {
                    $equipment_id = $this->m_equipment->set_equipment_manually($this->input->post('EquipmentType'), $this->input->post('OtherEquipmentBrand'), $this->input->post('OtherEquipmentProduct'));
                } else {
                    $equipment_id = NULL;
                }
                
                if(isset($shed_id))
                {
                    $new = false;
                    $this->m_shed->set($auth_data['UserId'], $new, $equipment_id, $shed_id);    
                } else {

                    $new = true;
                    $this->m_shed->set($auth_data['UserId'], $new, $equipment_id); 
                }
                //redirect to overview
                redirect('member/enterprise','refresh');
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/shed.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Machine Shed';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($shed_id)){ 
            $data['shed_data'] = $this->m_shed->get($shed_id);
            $data['new_event'] = false;
            $data['equipment_info'] = $this->m_equipment->get_product_info($harvest_details->FK_EquipmentId);
        } else {
            $data['new_event'] = true;
        }
            

        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editshed',$data);
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
        else
        {
            $farm_info = $this->m_farm->get($auth_data['FarmId']);
            if ($farm_info->num_rows()) {
                $row = $farm_info->row();
                $js_object['farm'] = array(
                        'address' => $row->Address,
                        'city' => $row->City,
                        'state' => $row->State,
                        'zip' => $row->Zip
                    );
            }
        }
        
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->form_validation->set_rules('Coordinates', 'Field Coordinates', 'trim|required');
            $this->form_validation->set_rules('CalcSize', 'Calculated Size', 'trim|required|numeric');
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
        


        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js'),
                "https://maps.googleapis.com/maps/api/js?sensor=true&libraries=drawing,geometry",
                base_url().'js/map_polygon.js',
            )
        );
        
        //js object builder
        $js_object['CI'] = array('base_url' => base_url());
        $data['js_object'] = js_object($js_object);        
        
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
        

        $this->load->view('header',$data);
        $this->load->view('editevent',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_application($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        $this->load->library('event_manager');
        
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
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for application data
            //$this->form_validation->set_rules('Product', 'Product', 'required');
            $this->form_validation->set_rules('ApplicationRate', 'Application Rate', 'trim|required|numeric');
            //$this->form_validation->set_rules('ApplicationRateUnit', 'Units', 'required');
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){
                //send to db
                
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventapplication->set($event_id, $new);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventapplication->set($new_event_id, $new);
                    }
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Application';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['application_data'] = $this->m_eventapplication->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
        } else {
            $data['new_event'] = true;
        }
        
        $data['event_type'] = 'Application';
                
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_application',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_chemical($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
        
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
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for chemica; data
            $this->form_validation->set_rules('AmountActiveIngredient', 'Amount Active Ingredient', 'trim|required|numeric');
            $this->form_validation->set_rules('Product', 'Chemical Product', 'trim|required|numeric');
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){
                //see if other stuff has been entered... if so, crearte the new chemical row
                if (($this->input->post('OtherBrand') != '') && ($this->input->post('OtherProduct') != ''))
                {
                    $chem_id = $this->m_chemical->set_chemical_manually($this->input->post('ChemicalType'), $this->input->post('OtherBrand'), $this->input->post('OtherProduct'));
                    //echo $chem_id;
                } else {
                    $chem_id = NULL;
                }
                //send to db
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventchemical->set($event_id, $new, $chem_id);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventchemical->set($new_event_id, $new, $chem_id);
                    }
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js',
                base_url().'js/chemical.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Chemical';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['chemical_data'] = $this->m_eventchemical->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
            //get the info for the chemical if one's picked
            $chemical_details = $data['chemical_data']->row();
            $data['chemical_info'] = $this->m_chemical->get_product_info($chemical_details->FK_ChemicalId);
        } else {
            $data['new_event'] = true;
        }
        
        $data['event_type'] = 'Chemical';
                
        //get chemical type
        $data['types'] = $this->m_chemical->get_type();
        
        $data['action'] = current_url();
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_chemical',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_fertilizer($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
        
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
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for fertilizer data
            $this->form_validation->set_rules('PercentN', 'Percent N', 'trim|required|numeric');
            $this->form_validation->set_rules('PercentP', 'Percent P', 'trim|required|numeric');
            $this->form_validation->set_rules('PercentK', 'Percent K', 'trim|required|numeric');
            $this->form_validation->set_rules('ApplicationRate', 'Application Rate', 'trim|required|numeric');
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){
                //send to db
                
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventfertilizer->set($event_id, $new);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventfertilizer->set($new_event_id, $new);
                    }
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Fertilizer';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['fertilizer_data'] = $this->m_eventfertilizer->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
        } else {
            $data['new_event'] = true;
        }
        
        $data['event_type'] = 'Fertilizer';
                
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_fertilizer',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_harvest($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
        
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
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for harvest data
            $this->form_validation->set_rules('Yield', 'Yield', 'trim|required|numeric');
            if (strlen($this->input->post('OtherEquipmentBrand')) == 0 && strlen($this->input->post('OtherEquipmentProduct')) == 0)
            {
                $this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required|numeric');             
            }
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){
                //see if other stuff has been entered... if so, create the new equipment row
                if (strlen($this->input->post('OtherEquipmentBrand')) > 0 && strlen($this->input->post('OtherEquipmentProduct')) > 0)
                {
                    $equipment_id = $this->m_equipment->set_equipment_manually('Harvet', $this->input->post('OtherEquipmentBrand'), $this->input->post('OtherEquipmentProduct'));
                } else {
                    $equipment_id = NULL;
                }
                
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventharvest->set($event_id, $new, $equipment_id);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventharvest->set($new_event_id, $new, $equipment_id);
                    }
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js',
                base_url().'js/harvest.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Harvest';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['harvest_data'] = $this->m_eventharvest->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
            //get the info for the equipment if one's picked
            $harvest_details = $data['harvest_data']->row();
            $data['equipment_info'] = $this->m_equipment->get_product_info($harvest_details->FK_EquipmentId);
        } else {
            $data['new_event'] = true;
        }
        
        $data['event_type'] = 'Harvest';
        
        
        

        //get equipment brand
        $data['equipment_brands'] = $this->m_equipment->get_brand('Harvester');
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_harvest',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_plant($type = 'Plant', $event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
        
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
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for planting data
            //$this->form_validation->set_rules('EquipmentBrand', 'Equipment Brand', 'trim|required');
            //$this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required');
            //$this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required|numeric');
            if (strlen($this->input->post('OtherEquipmentBrand')) == 0 && strlen($this->input->post('OtherEquipmentProduct')) == 0)
            {
                $this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required|numeric');             
            }
            if (strlen($this->input->post('OtherCropBrand')) == 0 && strlen($this->input->post('OtherCropProduct')) == 0)
            {
                $this->form_validation->set_rules('CropProduct', 'Crop Product', 'trim|required|numeric');             
            }
            //$this->form_validation->set_rules('CropProduct', 'Crop Product', 'trim|required|numeric');
            //$this->form_validation->set_rules('CropType', 'Crop Type', 'trim|required');
            //$this->form_validation->set_rules('CropBrand', 'Crop Brand', 'trim|required');
            //$this->form_validation->set_rules('CropProduct', 'Crop Product', 'trim|required');
            $this->form_validation->set_rules('PlantingRate', 'Planting Rate', 'trim|required');
            $this->form_validation->set_rules('PlantingRateUnit', 'Planting Rate Unit', 'trim|required');
            $this->form_validation->set_rules('RowSpacing', 'Row Spacing', 'trim|required');
            $this->form_validation->set_rules('RowSpacingUnit', 'Row Spacing Unit', 'trim|required');
            $this->form_validation->set_rules('PercentCrop', 'Percent Planted', 'trim|required|numeric');
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){
                //see if other stuff has been entered... if so, create the new equipment row
                if (strlen($this->input->post('OtherEquipmentBrand')) > 0 && strlen($this->input->post('OtherEquipmentProduct')) > 0)
                {
                    $equipment_id = $this->m_equipment->set_equipment_manually('Planter', $this->input->post('OtherEquipmentBrand'), $this->input->post('OtherEquipmentProduct'));
                } else {
                    $equipment_id = NULL;
                }
                //see if other stuff has been entered... if so, create the new crop row
                if (strlen($this->input->post('OtherCropBrand')) > 0 && strlen($this->input->post('OtherCropProduct')) > 0)
                {
                    $crop_id = $this->m_crop->set_crop_manually($this->input->post('CropType'), $this->input->post('OtherCropBrand'), $this->input->post('OtherCropProduct'));
                } else {
                    $crop_id = NULL;
                }
                //send to db
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventplant->set($event_id, $new, $equipment_id, $crop_id);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventplant->set($new_event_id, $new, $equipment_id, $crop_id);
                    }
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js',
                base_url().'js/plant.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event '.$type;
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['plant_data'] = $this->m_eventplant->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
            //get the info for the equipment if one's picked
            $plant_details = $data['plant_data']->row();
            $data['equipment_info'] = $this->m_equipment->get_product_info($plant_details->FK_EquipmentId);
            //get the info for the crop if one's picked
            $data['crop_info'] = $this->m_crop->get_product_info($plant_details->FK_CropId);
        } else {
            $data['new_event'] = true;
        }
        
        $data['event_type'] = $type;
        
        //get equipment brand
        $data['equipment_brands'] = $this->m_equipment->get_brand('Planter');
        
        //get crop type
        $data['crop_types'] = $this->m_crop->get_type();
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_plant',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_tillage($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
        
        if(isset($field_id))
        {
            $owning_farm = $this->m_field->get_farm_id_from_field($field_id);
            if ($owning_farm != $auth_data['FarmId'])
            {
                redirect('member/enterprise','refresh');
            }
        }      
        
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for harvest data
            //$this->form_validation->set_rules('Yield', 'Yield', 'trim|required|numeric');
            //if (strlen($this->input->post('OtherEquipmentBrand')) == 0 && strlen($this->input->post('OtherEquipmentProduct')) == 0)
            //{
            //    $this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required|numeric');             
            //}
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){

                
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventtillage->set($event_id, $new);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventtillage->set($new_event_id, $new);
                    }
                }
                //redirect to overview
                redirect('member/enterprise','refresh');
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
            )
        );
        

        
        //js_helper: dynamically build <script> tags
        $data['js'] = js_load(
            array(
                $this->config->item('jquery_js'),
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js',
                base_url().'js/tillage.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Tillage';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['tillage_data'] = $this->m_eventtillage->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
            //get the info for the equipment if one's picked
            $tillage_details = $data['tillage_data']->row();
            //$data['equipment_info'] = $this->m_equipment->get_product_info($tillage_details->FK_EquipmentId);
            
        } else {
            $data['new_event'] = true;
        }
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId']);
        
        $data['event_type'] = 'Tillage';
        
        //js object builder
        $data['js_object'] = js_object(
            array(
                'CI' => array('base_url' => base_url())
            )
        );
        

        //get equipment brand
        //$data['equipment_brands'] = $this->m_equipment->get_brand('Tiller');
        
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_tillage',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_weather($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        
        $this->load->library('event_manager');
        
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
            //first, set up for master event data
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|max_length[20]');
            //then, set up for weather data
            $this->form_validation->set_rules('PercentDamaged', 'Percent Damaged', 'trim|required|numeric');
            if(!isset($event_id))
            {
                $this->form_validation->set_rules('fields', 'Fields', 'required');
            }

            if($this->form_validation->run()){
                //send to db
                
                if(isset($event_id))
                {
                    $this->m_event->set($field_id, $event_id);
                    $new = false;
                    $this->m_eventweather->set($event_id, $new);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventweather->set($new_event_id, $new);
                    }
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
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/event.js'
            )
        );
        
        $data['title'] = 'Grow Our Yields - Edit Event Weather';
        
        //load dropdown list
        $this->load->config('edit_dropdowns');
        
        
        if(isset($event_id)){ 
            $data['event_data'] = $this->m_event->get($event_id);
            $data['weather_data'] = $this->m_eventweather->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            $data['new_event'] = false;
        } else {
            $data['new_event'] = true;
        }
        
        $data['event_type'] = 'Weather';
                
        $data['fields'] = $this->m_field->get_fields($auth_data['FarmId']);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_weather',$data);
        $this->load->view('footer',$data);
    }
    
    function delete_shed($shed_id=NULL){  
        $this->m_shed->delete_shed($shed_id);
        redirect('member/enterprise','refresh');
    }
    
    
    function delete_field($field_id=NULL){  
        $this->load->library('event_manager');
        $this->event_manager->delete_field_with_events($field_id);
        redirect('member/farm','refresh');
    }
    
    function delete_event($event_id=NULL){  
        $this->load->library('event_manager');
        $this->event_manager->delete_event($event_id);
        redirect('member/farm','refresh');
    }

    
    ////////////////////////////////////////////////////////////////////////////
    /////////////////// EXAMPLES (remove when necessary) ///////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
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
    
    function chemical_keyword(){
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css'),
                array('rel'=>'stylesheet','type'=>'text/css','href'=>$this->config->item('jquery_ui_css'))
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
                $this->config->item('jquery_ui_js'),
                base_url().'js/chemical.js'
            )
        );
        
        // load views
        $this->load->view('header', $data);
        $this->load->view('chemical_example');
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
    
    function get_equipment_brand(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['response'] = false;
            $query = $this->m_equipment->get_brand(trim($this->input->post('type')));
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
    
    function get_equipment_product(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['response'] = false;
            $query = $this->m_equipment->get_product(trim($this->input->post('type')),trim($this->input->post('brand')));
            if($query->num_rows()){
                $result = $query->result();
                $data['response'] = true; //Set response
                $data['list'] = array(); //Create array
                foreach($result as $row){
                    $data['list'][] = array('value'=> $row->PK_EquipmentId,'display' => $row->Product);
                }
            }
            echo json_encode($data);
        }
    }

    function get_crop_brand(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['response'] = false;
            $query = $this->m_crop->get_brand(trim($this->input->post('type')));
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
    
    function get_crop_product(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['response'] = false;
            $query = $this->m_crop->get_product(trim($this->input->post('type')),trim($this->input->post('brand')));
            if($query->num_rows()){
                $result = $query->result();
                $data['response'] = true; //Set response
                $data['list'] = array(); //Create array
                foreach($result as $row){
                    $data['list'][] = array('value'=> $row->PK_CropId,'display' => $row->Product);
                }
            }
            echo json_encode($data);
        }
    }
    
    function chemical_suggest(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['message'] = NULL;
            $query = $this->m_chemical->suggest(trim($this->input->post('term')));
            if($query->num_rows() > 0){
                $data['message'] = array();
                foreach($query->result() as $row){
                    $data['message'][] = array('label'=> $row->Product, 'value'=> $row->Product); 
                }
            }
            echo json_encode($data);
        }
    }
    
    function chemical_fetch(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $array = array('result' =>'Product not found. Please search again.');
            if($this->input->post('term')){
                $data['list'] = $this->m_chemical->fetch(trim($this->input->post('term')));
                $array['result'] = $this->load->view('chemical_list',$data,TRUE);
            } 
            echo json_encode($array);
        }
    }

}

/* End of file member.php */
/* Location: ./application/controllers/member.php */
