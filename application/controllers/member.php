<?php

class Member extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
                
        if(!$this->php_session->get('AUTH')){
            redirect('main/login','refresh');
        }         
                
        $this->load->model('m_chemical');
        $this->load->model('m_crop');
        $this->load->model('m_cropinstance');
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
        $this->load->helper('help_system');
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
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId'],2);
        
        $this->load->view('header',$data);
        $this->load->view('enterprise');
        $this->load->view('footer',$data);
    }
    
    public function load_farm(){
        //set active farm
        $auth_data = $this->php_session->get('AUTH');
        if($this->m_farm->verify_owner($auth_data['UserId'],$this->uri->segment(3))){
            $this->auth->update_session(array('FarmId' => $this->uri->segment(3),'FarmName' => $this->m_farm->get_name($this->uri->segment(3))));
        }
        redirect('member/farm','refresh');
    }
    
    public function farm()
    {
        $auth_data = $this->php_session->get('AUTH');
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
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
        
        $data['title'] = 'Grow Our Yields - Your Farm';
        
        //get info for the field table
        
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
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
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
        $auth_data = $this->php_session->get('AUTH');
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
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
            $this->load->config('account_validation');
            $this->form_validation->set_rules($this->config->item('account'));
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
        $data['form_url'] = 'member/editaccount';
        
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
            $this->form_validation->set_rules('EquipmentType', 'Equipment Type', 'trim|required');

            if (strlen($this->input->post('OtherEquipmentBrand')) == 0 && strlen($this->input->post('OtherEquipmentProduct')) == 0)
            {
                $this->form_validation->set_rules('EquipmentProduct', 'Equipment Product', 'trim|required|numeric');             
            } else {
                //user entered text items
                $this->form_validation->set_rules('OtherEquipmentBrand', 'Brand', 'trim|required|max_length[100]');
                $this->form_validation->set_rules('OtherEquipmentProduct', 'Product', 'trim|required|max_length[200]');
            } 
            
            if($this->form_validation->run()){
                //see if other stuff has been entered... if so, create the new equipment row
                if (strlen($this->input->post('OtherEquipmentBrand')) > 0 && strlen($this->input->post('OtherEquipmentProduct')) > 0)
                {
                    $equipment_id = $this->m_equipment->set_equipment_manually($this->input->post('EquipmentType'), $this->input->post('OtherEquipmentBrand'), $this->input->post('OtherEquipmentProduct'), $this->input->post('TillageType'), $this->input->post('Power'));
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
    
    public function addfarm(){
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->load->library('MY_form_validation',NULL,'form_validation');
            $this->load->config('farm_validation');
            $this->form_validation->set_rules($this->config->item('farm'));
            if($this->form_validation->run()){
                //send to db
                $id = $this->m_farm->set();
                //update session; set as active farm
                $this->auth->update_session(array('FarmId' => $id,'FarmName' => $this->m_farm->get_name($id)));
                //redirect to overview
                redirect('member/farm','refresh');
            }
        }
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/style.css')
            )
        );
        
        //load state list
        $this->load->config('state_list');
        
        $data['title'] = 'Grow Our Yields - Farm Management';
        $data['page_title'] = lang('farm_new_title');
        $data['desc'] = lang('farm_new_desc');
        $data['form_url'] = 'member/addfarm';
        
        $this->load->view('header',$data);
        $this->load->view('editfarm');
        $this->load->view('footer',$data);
    }
    
    public function editfarm()
    {
        $auth_data = $this->php_session->get('AUTH');
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            $this->load->library('MY_form_validation',NULL,'form_validation');
            $this->load->config('farm_validation');
            $this->form_validation->set_rules($this->config->item('farm'));
            if($this->form_validation->run()){
                //send to db
                $id = $this->m_farm->set($auth_data['FarmId']);
                //update session var
                $this->auth->update_session(array('FarmName' => $this->m_farm->get_name($id)));
                //redirect to overview
                redirect('member/farm','refresh');
            } 
        }
        
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
        $data['farm_data'] = $this->m_farm->get($auth_data['FarmId']);
        $data['form_url'] = 'member/editfarm';
        
        $this->load->view('header',$data);
        $this->load->view('editfarm');
        $this->load->view('footer',$data);
    }
        
    public function editfield($field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
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
        $auth_data = $this->php_session->get('AUTH');
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
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
        $this->load->view('editevent',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_application($event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        $this->load->library('event_manager');
        $this->load->config('events');
        
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
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {
                    
                    redirect('member/field/'.$field_id,'refresh');
                }
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
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
        $this->load->library('event_manager');
        $this->load->config('events');
        
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
            $this->form_validation->set_rules('FK_ChemicalId', 'Product 1', 'trim|required');
            $this->form_validation->set_rules('Power', 'Power', 'required');
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
                    $this->m_eventchemical->set($event_id, $new);
                } else {
                    $fields = $this->event_manager->get_fields_from_event_form();
                    foreach ($fields as $field_id)
                    { 
                        $new_event_id = $this->m_event->set($field_id);
                        $new = true;
                        $this->m_eventchemical->set($new_event_id, $new);
                    }
                }
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {
                    
                    redirect('member/field/'.$field_id,'refresh');
                }
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
            $data['new_event'] = false;
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            //get the info for the chemical if one's picked
            //$chemical_details = $data['chemical_data']->row();
            //$data['chemical_info'] = $this->m_chemical->get_product_info($chemical_details->FK_ChemicalId);
        } else {
            $data['new_event'] = true;
        }
        
        $data['power'] = $this->m_shed->get_implements($auth_data['UserId'],1);
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId'],0);
        
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
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
        $this->load->library('event_manager');
        $this->load->config('events');
        
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
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {        
                    redirect('member/field/'.$field_id,'refresh');
                }
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
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
        //$this->load->library('event_manager');
        $this->load->config('events');
        
        if(isset($field_id))
        {
            $owning_farm = $this->m_field->get_farm_id_from_field($field_id);
            if ($owning_farm != $auth_data['FarmId'])
            {
                redirect('member/enterprise','refresh');
            }
        }  
        
        if(isset($event_id))
        {   //check for event ID matching field & field ownership
            $redirect = TRUE;
            $query = $this->m_event->get($event_id);
            if ($query->num_rows()) {
                $row = $query->row();
                //get owning field, according to event ID
                $owning_field = $row->FK_FieldId;
                if (isset($field_id)) {
                    if ($owning_field == $field_id) {
                        //supplied field is the event's owning field
                        $redirect = FALSE;
                    }
                } else { //field ID not supplied
                    //get owning farm, according to the field ID supplied from db
                    $owning_farm = $this->m_field->get_farm_id_from_field($owning_field);
                    if ($owning_farm == $auth_data['FarmId'])
                    {
                        //calculated field is owned by the current farm
                        $redirect = FALSE;
                    }
                }
            }
            if ($redirect)
            {
                //event ID doesn't match field or field ownership
                redirect('member/enterprise','refresh');
            }
        } else {
            $query = $this->m_field->get_fields($auth_data['FarmId']);
            $data['fields'] = $query;
            if ($query->num_rows()) {
                $row = $query->row();
                $field_id = $row->PK_FieldId;
            }
        }
        
        //submission
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            //general planting rules
            $this->form_validation->set_rules(
                array(
                    array('field' => 'Date','label' => 'Date','rules' => 'trim|required|max_length[20]'),
                    array('field' => 'Notes','label' => 'Notes','rules' => 'trim|max_length[500]'),
                    array('field' => 'EquipmentImplement','label' => 'Implement','rules' => 'trim|numeric'),
                    array('field' => 'EquipmentPower','label' => 'Power','rules' => 'trim|required|numeric')
                )
            );
            
            if(!isset($event_id)) {
                //allow editing of field selection
                $this->form_validation->set_rules('fields', 'Field', 'trim|required|numeric');
            }
            
            //crop/variety rules
            $counter = 0;
            foreach($this->input->post('crop') as $key => $arr) {
                $counter++;
                $this->form_validation->set_rules('crop['.$key.'][yield]', 'Crop/Variety #'.$counter.': Yield', 'trim|required|numeric');
                $this->form_validation->set_rules('crop['.$key.'][grain_test_weight]', 'Crop/Variety #'.$counter.': Grain Test Weight', 'trim|required|numeric');
                $this->form_validation->set_rules('crop['.$key.'][percent_moisture]', 'Crop/Variety #'.$counter.': Harvest Percent Moisture', 'trim|required|numeric');
                $this->form_validation->set_rules('crop['.$key.'][aflatoxin]', 'Crop/Variety #'.$counter.': Aflatoxin', 'trim|required|numeric');
                $this->form_validation->set_rules('crop['.$key.'][crop_instance_id]', 'Crop/Variety #'.$counter.': Crop Instance ID', 'trim|required|numeric');
            }
             
            if($this->form_validation->run()){
                //send to event table
                if (isset($event_id)) {
                    //update
                    $this->m_event->set($field_id,$event_id);
                    $new = false;
                    //send to eventharvest table
                    $this->m_eventharvest->set($event_id, $new);
                    $harvest_event_id = $event_id;
                } else {
                    $field_id = $this->input->post('fields'); 
                    //insert
                    $new_event_id = $this->m_event->set($field_id);
                    $new = true;
                    //send to eventharvest table
                    $this->m_eventharvest->set($new_event_id, $new);
                    $harvest_event_id = $new_event_id;
                }
                
                //send to cropinstance table
                foreach($this->input->post('crop') as $key => $arr) {
                    //existing crop instance record
                    $this->m_cropinstance->set_harvest($harvest_event_id,$arr['yield'],$arr['grain_test_weight'],$arr['percent_moisture'],$arr['aflatoxin'],$arr['crop_instance_id']);
                }
                
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {
                    redirect('member/field/'.$field_id,'refresh');
                }
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
            //existing event
            $data['new_event'] = false;
            $data['event_data'] = $this->m_event->get($event_id);
            $data['harvest_data'] = $this->m_eventharvest->get($event_id);
            $data['crop_data'] = $this->m_cropinstance->get(NULL,$event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            
            //get the crop instance details, if available (acres planted & crop ID)
            if ($data['crop_data']->num_rows()) {
                $result = $data['crop_data']->result();
                $data['crop_info'] = array();
                foreach($result as $row) {
                    //get the info for the crop if one's picked (type/brand/product)
                    $crop_detail_array = $this->m_crop->get_product_info($row->FK_CropId);
                    //attach acres planted
                    $crop_detail_array['acres_planted'] = $row->AcresPlanted;
                    //attach yield
                    $crop_detail_array['yield'] = $row->Yield;
                    //attach grain test weight
                    $crop_detail_array['grain_test_weight'] = $row->GrainTestWeight;
                    //attach harvest percent moisture
                    $crop_detail_array['percent_moisture'] = $row->PercentMoisture;
                    //attach aflatoxin
                    $crop_detail_array['aflatoxin'] = $row->Aflatoxin;
                    
                    //attach crop instance id
                    $crop_detail_array['crop_instance_id'] = $row->PK_CropInstanceId;
                    
                    //place into array for view
                    $data['crop_info'][] = $crop_detail_array;
                }
            }
        } else {
            $data['new_event'] = true;
            $plant_event_id = $this->m_event->get_current_plant_event($field_id);
            $data['crop_data'] = $this->m_cropinstance->get($plant_event_id);
            
            //get the crop instance details, if available (acres planted & crop ID)
            if ($data['crop_data']->num_rows()) {
                $result = $data['crop_data']->result();
                $data['crop_info'] = array();
                foreach($result as $row) {
                    //get the info for the crop if one's picked (type/brand/product)
                    $crop_detail_array = $this->m_crop->get_product_info($row->FK_CropId);
                    //attach acres planted
                    $crop_detail_array['acres_planted'] = $row->AcresPlanted;
                    //attach crop instance id
                    $crop_detail_array['crop_instance_id'] = $row->PK_CropInstanceId;
                    
                    //place into array for view
                    $data['crop_info'][] = $crop_detail_array;
                }
            }
        }
        
        $data['event_type'] = 'Harvest';
        
        //get implements
        $data['power'] = $this->m_shed->get_implements($auth_data['UserId'],1);
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId'],0);
        
        $data['action'] = current_url();

        $this->load->view('header',$data);
        $this->load->view('editevent_master',$data);
        $this->load->view('editevent_harvest',$data);
        $this->load->view('footer',$data);
    }
    
    public function editevent_plant($type = 'Plant', $event_id=NULL, $field_id=NULL)
    {
        $auth_data = $this->php_session->get('AUTH');
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
        //$this->load->library('event_manager');
        $this->load->config('events');
        
        if(isset($field_id))
        {
            $owning_farm = $this->m_field->get_farm_id_from_field($field_id);
            if ($owning_farm != $auth_data['FarmId'])
            {
                redirect('member/enterprise','refresh');
            }
        }  
        
        if(isset($event_id))
        {   //check for event ID matching field & field ownership
            $redirect = TRUE;
            $query = $this->m_event->get($event_id);
            if ($query->num_rows()) {
                $row = $query->row();
                //get owning field, according to event ID
                $owning_field = $row->FK_FieldId;
                if (isset($field_id)) {
                    if ($owning_field == $field_id) {
                        //supplied field is the event's owning field
                        $redirect = FALSE;
                    }
                } else { //field ID not supplied
                    //get owning farm, according to the field ID supplied from db
                    $owning_farm = $this->m_field->get_farm_id_from_field($owning_field);
                    if ($owning_farm == $auth_data['FarmId'])
                    {
                        //calculated field is owned by the current farm
                        $redirect = FALSE;
                    }
                }
            }
            if ($redirect)
            {
                //event ID doesn't match field or field ownership
                redirect('member/enterprise','refresh');
            }
        }
        
        //submission
        if($this->input->post('submit')){
            $this->load->library('Form_validation');
            //general planting rules
            $this->form_validation->set_rules(
                array(
                    array('field' => 'Date','label' => 'Date','rules' => 'trim|required|max_length[20]'),
                    array('field' => 'Notes','label' => 'Notes','rules' => 'trim|max_length[500]'),
                    array('field' => 'EquipmentImplement','label' => 'Implement','rules' => 'trim|numeric'),
                    array('field' => 'EquipmentPower','label' => 'Power','rules' => 'trim|required|numeric'),
                    array('field' => 'PlantingRate','label' => 'Average Planting Rate','rules' => 'trim|required|numeric'),
                    array('field' => 'PlantingRateUnit','label' => 'Average Planting Rate Unit','rules' => 'trim|required'),
                    array('field' => 'RowSpacing','label' => 'Row Spacing','rules' => 'trim|required|numeric'),
                    array('field' => 'RowSpacingUnit','label' => 'Row Spacing Unit','rules' => 'trim|required'),
                    array('field' => 'SeedDepth','label' => 'Seed Depth','rules' => 'trim|required|numeric'),
                    array('field' => 'SeedDepthUnit','label' => 'Seed Depth Unit','rules' => 'trim|required'),
                    array('field' => 'PreviousCrop','label' => 'Previous Crop','rules' => 'trim|required'),
                    array('field' => 'VariableRate','label' => 'Variable Rate','rules' => 'trim|numeric'),
                    array('field' => 'TwinRows','label' => 'Twin Rows','rules' => 'trim|numeric')
                )
            );
            
            if(!isset($event_id)) {
                //allow editing of field selection
                $this->form_validation->set_rules('fields', 'Field', 'trim|required|numeric');
            }
            
            //crop/variety rules
            $counter = 0;
            foreach($this->input->post('crop') as $key => $arr) {
                $counter++;
                $this->form_validation->set_rules('crop['.$key.'][type]', 'Crop/Variety #'.$counter.': Type', 'trim|required');
                $this->form_validation->set_rules('crop['.$key.'][acres_planted]', 'Crop/Variety #'.$counter.': Acres Planted', 'trim|required|numeric');
                $this->form_validation->set_rules('crop['.$key.'][other]', 'Crop/Variety #'.$counter.': Checkbox', 'trim');
                $this->form_validation->set_rules('crop['.$key.'][brand]', 'Crop/Variety #'.$counter.': Brand', 'trim'); 
                if (isset($arr['other'])) { //custom brand/product
                    //custom brand
                    $this->form_validation->set_rules('crop['.$key.'][other_brand]', 'Crop/Variety #'.$counter.': Brand', 'trim|required|max_length[100]');
                    //custom product
                    $this->form_validation->set_rules('crop['.$key.'][other_product]', 'Crop/Variety #'.$counter.': Product', 'trim|required|max_length[200]');
                    //product id
                    $this->form_validation->set_rules('crop['.$key.'][product]', 'Crop/Variety #'.$counter.': Product', 'trim'); 
                } 
                else 
                { //standard product
                    //custom brand
                    $this->form_validation->set_rules('crop['.$key.'][other_brand]', 'Crop/Variety #'.$counter.': Brand', 'trim');
                    //custom product
                    $this->form_validation->set_rules('crop['.$key.'][other_product]', 'Crop/Variety #'.$counter.': Product', 'trim');
                    //product id
                    $this->form_validation->set_rules('crop['.$key.'][product]', 'Crop/Variety #'.$counter.': Product', 'trim|required|numeric');
                }
            }
             
            if($this->form_validation->run()){
                //send to event table
                if (isset($event_id)) {
                    //update
                    $this->m_event->set($field_id,$event_id);
                    $new = false;
                    //send to eventplant table
                    $this->m_eventplant->set($event_id, $new);
                    $plant_event_id = $event_id;
                } else {
                    $field_id = $this->input->post('fields'); 
                    //insert
                    $new_event_id = $this->m_event->set($field_id);
                    $new = true;
                    //send to eventplant table
                    $this->m_eventplant->set($new_event_id, $new);
                    $plant_event_id = $new_event_id;
                }
                
                //send to cropinstance table
                $preserved_crop_instances = array();
                foreach($this->input->post('crop') as $key => $arr) {
                    
                    //determine crop id
                    $crop_id = NULL;
                    if (isset($arr['other'])) {
                        //custom brand/product
                        $query = $this->m_crop->get_existing_product($arr['type'],$arr['other_brand'],$arr['other_product']);
                        if ($query->num_rows()) {
                            //this product already exists; don't add it again
                            $row = $query->row();
                            $crop_id = $row->PK_CropId;
                        } else {
                            //this product doesn't yet exist; add it
                            $crop_id = $this->m_crop->set_crop_manually($arr['type'],$arr['other_brand'],$arr['other_product']);
                        }
                    } else {
                        //standard product
                        $crop_id = $arr['product'];
                    }
                    
                    //insert/update
                    if (isset($arr['crop_instance_id']) && !empty($arr['crop_instance_id'])) {
                        //existing crop instance record
                        $this->m_cropinstance->set_plant($plant_event_id, $crop_id, $arr['acres_planted'],$arr['crop_instance_id']);
                        $preserved_crop_instances[] = $arr['crop_instance_id'];
                    } else {
                        //insert into cropinstance table
                        $preserved_crop_instances[] = $this->m_cropinstance->set_plant($plant_event_id, $crop_id, $arr['acres_planted']);
                    }
                }
                
                //delete others (not submitted)
                $this->m_cropinstance->delete_excluded($preserved_crop_instances,$plant_event_id);
                
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {
                    redirect('member/field/'.$field_id,'refresh');
                }
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
            //existing event
            $data['new_event'] = false;
            $data['event_data'] = $this->m_event->get($event_id);
            $data['plant_data'] = $this->m_eventplant->get($event_id);
            $data['crop_data'] = $this->m_cropinstance->get($event_id);
            $data['field_name'] = $this->m_field->get_field_name($field_id);
            
            //get the crop instance details, if available (acres planted & crop ID)
            if ($data['crop_data']->num_rows()) {
                $result = $data['crop_data']->result();
                $data['crop_info'] = array();
                foreach($result as $row) {
                    //get the info for the crop if one's picked (type/brand/product)
                    $crop_detail_array = $this->m_crop->get_product_info($row->FK_CropId);
                    //attach acres planted
                    $crop_detail_array['acres_planted'] = $row->AcresPlanted;
                    //attach relevant brand list
                    $crop_detail_array['brand_list'] = $this->m_crop->get_brand($crop_detail_array['Type']);
                    //attach relevant product list
                    $crop_detail_array['product_list'] = $this->m_crop->get_product($crop_detail_array['Type'],$crop_detail_array['Brand']);
                    //attach relevant product id
                    $crop_detail_array['product'] = $row->FK_CropId;
                    //attach crop instance id
                    $crop_detail_array['crop_instance_id'] = $row->PK_CropInstanceId;
                    
                    //place into array for view
                    $data['crop_info'][] = $crop_detail_array;
                }
            }
            
        } else {
            $data['new_event'] = true;
            
            //get the crop instance details, if submission was attempted
            if ($this->input->post('crop')) {
                $data['crop_info'] = array();
                foreach($this->input->post('crop') as $key => $arr) {
                    if (isset($arr['type'])) {
                        //attach relevant type
                        //$crop_detail_array['Type'] = $arr['type'];
                        //attach relevant brand list
                        $crop_detail_array['brand_list'] = $this->m_crop->get_brand($arr['type']);
                        
                        if (isset($arr['brand'])) {
                            //attach relevant brand
                            //$crop_detail_array['Brand'] = $arr['brand'];
                            //attach relevant product list
                            $crop_detail_array['product_list'] = $this->m_crop->get_product($arr['type'],$arr['brand']);
                        }
                        if (isset($arr['product'])) {
                            //attach relevant product
                            //$crop_detail_array['Product'] = $arr['product'];
                        }
                    }
                    //place into array for view
                    $data['crop_info'][] = $crop_detail_array;
                }
            }
        }
        
        $data['event_type'] = $type;
        
        //get implements
        $data['power'] = $this->m_shed->get_implements($auth_data['UserId'],1);
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId'],0);
        
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
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
        $this->load->library('event_manager');
        $this->load->config('events');
        
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
            //then, set up for tillage data
            $this->form_validation->set_rules('Power', 'Power', 'required');
            
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
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {
                    
                    redirect('member/field/'.$field_id,'refresh');
                }
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
                base_url().'js/event.js'
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
        $data['power'] = $this->m_shed->get_implements($auth_data['UserId'],1);
        $data['implements'] = $this->m_shed->get_implements($auth_data['UserId'],0);
        
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
        if(empty($auth_data['FarmId'])){
            redirect('member/enterprise','refresh');
        }
        
        $this->load->library('event_manager');
        $this->load->config('events');
        
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
                //redirect to proper overview
                if($new)
                {
                    redirect('member/farm','refresh');
                } else {
                    
                    redirect('member/field/'.$field_id,'refresh');
                }
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
        //first, get the field ID of the event to delete
        $event_data = $this->m_event->get($event_id);
        $row = $event_data->row();
        $this->load->library('event_manager');
        $this->event_manager->delete_event($event_id);
        redirect('member/field/'.$row->FK_FieldId,'refresh');
    }

    function delete_farm(){
        $auth_data = $this->php_session->get('AUTH');
        if($this->m_farm->verify_owner($auth_data['UserId'],$this->uri->segment(3))){
            $this->m_farm->delete($this->uri->segment(3));
            
            //check active farm status
            if($auth_data['FarmId'] == $this->uri->segment(3)){
                $this->auth->update_session(array('FarmId' => NULL,'FarmName' => NULL));
            }
        }
        redirect('member/enterprise','refresh');
    }
    
    function help(){
        $this->load->config('help_system');
        $data['meta_content'] = meta_content(
            array(
                array('name'=>'description','content'=>'Grow our Yields Help Documentation.')
            )
        );
        
        $data['link_content'] = link_content(
            array(
                array('rel'=>'stylesheet','type'=>'text/css','href'=>base_url().'css/help.css')
            )
        );
        
        $data['title'] = 'Grow Our Yields - Help Documentation';
        
        $this->load->view('help_header',$data);
        $this->load->view('help');
        $this->load->view('help_footer',$data);
    }
    
    function event_check($event_type){
        $auth_data = $this->php_session->get('AUTH');
        $data['title'] = 'Grow Our Yields - Edit Event Weather';
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
        if ($this->m_shed->get_implement_counts($auth_data['UserId'], 1) > 0)
        {
           $has_equipment = true; 
        } else {
           $has_equipment = false;  
        }
        switch ($event_type) {
            case 'Application':
                redirect('member/editevent_application','refresh');
                break;
            case 'Chemical':
                if ($has_equipment)
                {
                    redirect('member/editevent_chemical','refresh');
                } else {
                    $this->load->view('header',$data);
                    $this->load->view('emptyshed',$data);
                    $this->load->view('footer',$data);
                }
                break;
            case 'Fertilizer':
                redirect('member/editevent_fertilizer','refresh');
                break;
            case 'Harvest':
                if ($has_equipment)
                {
                    redirect('member/editevent_harvest','refresh');
                } else {
                    $this->load->view('header',$data);
                    $this->load->view('emptyshed',$data);
                    $this->load->view('footer',$data);
                }
                break;
            case 'Plant':
                if ($has_equipment)
                {
                    redirect('member/editevent_plant/Plant','refresh');
                } else {
                    $this->load->view('header',$data);
                    $this->load->view('emptyshed',$data);
                    $this->load->view('footer',$data);
                }
                break;
            case 'Replant':
                if ($has_equipment)
                {
                    redirect('member/editevent_plant/Replant','refresh');
                } else {
                    $this->load->view('header',$data);
                    $this->load->view('emptyshed',$data);
                    $this->load->view('footer',$data);
                }
                break;
            case 'Tillage':
                if ($has_equipment)
                {
                    redirect('member/editevent_tillage','refresh');
                } else {
                    $this->load->view('header',$data);
                    $this->load->view('emptyshed',$data);
                    $this->load->view('footer',$data);
                }
                break;
            case 'Weather':
                redirect('member/editevent_weather','refresh');
                break;
        }
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
                $result = $data['list']->result();
                foreach($result AS $row){
                   $array['prod_id'] = $row->PK_ChemicalId;
                }
                $array['result'] = $this->load->view('chemical_list',$data,TRUE);
            } 
            echo json_encode($array);
        }
    }
    
    function add_crop_instance(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $data['crop_types'] = $this->m_crop->get_type(); //get crop types
            $data['event_type'] = trim($this->input->post('event_type')); //event type determines certain form fields
            $data['form_num'] = trim($this->input->post('form_num')); //index the new crop box should have
            $array['result'] = $this->load->view('plant_crop_info',$data,TRUE);
            echo json_encode($array);
        }
    }
    
    function get_harvest_crops(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $array['result'] = FALSE;

            //get requested field
            $field_id = $this->input->post('field');
            //check for authorized user of this data
            $auth_data = $this->php_session->get('AUTH');
            if(!empty($auth_data['FarmId'])){ //auth data exists

                //get owning farm
                $owning_farm = $this->m_field->get_farm_id_from_field($field_id);
                if ($owning_farm == $auth_data['FarmId']) { //user's farm owns this field 
                    $plant_event_id = $this->m_event->get_current_plant_event($field_id);
                    $data['crop_data'] = $this->m_cropinstance->get($plant_event_id);

                    //get the crop instance details, if available (acres planted & crop ID)
                    if ($data['crop_data']->num_rows()) {
                        $result = $data['crop_data']->result();
                        $array['result'] = '<h4>Crop Data</h4>';
                        foreach($result as $key => $row) {
                            //get the info for the crop if one's picked (type/brand/product)
                            $crop_detail_array = $this->m_crop->get_product_info($row->FK_CropId);
                            //attach acres planted
                            $crop_detail_array['acres_planted'] = $row->AcresPlanted;
                            //attach crop instance id
                            $crop_detail_array['crop_instance_id'] = $row->PK_CropInstanceId;

                            //load view data
                            $view_data = array('form_num'=>$key+1,'crop'=>$crop_detail_array);
                            $array['result'] .= $this->load->view('harvest_crop_info',$view_data,TRUE);
                        }
                    }
                }
            }
            //return result (even if false)
            echo json_encode($array);
        }
    }

}

/* End of file member.php */
/* Location: ./application/controllers/member.php */
