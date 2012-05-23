<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class Mail {

    function send_contact_email($sender_email, $sender_name, $sender_msg)
    {
        $CI =& get_instance();
        $CI->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.schuytema.com';
        $config['smtp_user'] = 'paul+schuytema.com';
        $config['smtp_pass'] = 'aikoaiko';

        $CI->email->initialize($config);

        $site_meta_id = $CI->config->item('siteMetaID');
        $site_meta_values = $CI->data_access->get_content_array('siteMeta', 'SiteID', $site_meta_id);

        $email = $site_meta_values['Email'];
        $biz_name = $site_meta_values['BusinessName'];

        $CI->email->from($sender_email, $sender_name);
        $CI->email->to($email);

        $CI->email->subject($biz_name.'::Online Contact');

        $msg = "Email sent from the ".$biz_name." webserver.\n\n";
        $msg = $msg."Sender's name: ".$sender_name.".\n\n";
        $msg = $msg."Sender's email address: ".$sender_email.".\n\n";
        $msg = $msg."Sender's message to you:\n\n";
        $msg = $msg.$sender_msg."\n\n";

        $CI->email->message($msg);

        $CI->email->send();
    }

    function send_contact_email_custom($contact_type)
    {
        $CI =& get_instance();
        $contact_info = $CI->config->item($contact_type);
        $contact_form = $contact_info['contactDef'];

        $CI->load->library('email');

        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'mail.schuytema.com';
        $config['smtp_user'] = 'paul+schuytema.com';
        $config['smtp_pass'] = 'aikoaiko';

        $CI->email->initialize($config);

        $CI->email->from($CI->input->post('email'), $CI->input->post('name'));
        $CI->email->to($contact_info['recipientEmail']);

        $CI->email->subject($contact_info['contactTitle']);



        $msg = "Email sent from the CropYield webserver.\n\n";

        foreach ($contact_form as $form_row)
        {
            if ($form_row['type'] == 'check')
            {
                $msg .= $form_row['maillabel'].": ";
                $cms_menu = $CI->config->item($form_row['source']);;
                $count = 0;
                foreach ($cms_menu as $menu_item)
                {
                    $count = $count + 1;
                    if ($CI->input->post($form_row['name'].$count) != '')
                    {
                        $msg .= $CI->input->post($form_row['name'].$count).", ";
                    }
                }
                $msg = substr($msg,0,-2);
                $msg .= "\n\n";
            } else {
                $msg .= $form_row['maillabel'].": ".$CI->input->post($form_row['name'])."\n\n";
            }
        }

        $CI->email->message($msg);

        $CI->email->send();
    }

    function generate_contact_form($action, $contact_type = 'contactMail')
    {
        $CI =& get_instance();
        //load cmsKey info
        $cms_info = $CI->config->item($contact_type);
        $cms_form = $cms_info['contactDef'];

        //set width info
        $label_width = $cms_info['labelWidth'];
        $field_width = $cms_info['fieldWidth'];
        $num_rows = 10;
        $num_cols = 40;
        $text_width = 50;

        //display the title
        $cms_edit_title = $cms_info['contactTitle'];
        if ($cms_edit_title != '')
        {
            $form_data = '<span class="head2">'.$cms_edit_title.'</span><br>';
        } else {
            $form_data = '';
        }

        //display the message
        $cms_edit_msg = $cms_info['contactMsg'];
        if ($cms_edit_msg != '')
        {
            $form_data .= '<div class="preview">'.$cms_edit_msg.'</div>';
        } 

        //set up initial form values
        $form_data = $form_data.'<form method="post" action="'.$action.'" enctype="multipart/form-data"><div class="data"><table width="478">';


         foreach ($cms_form as $form_row)
         {
             //set up the label cell
             if (strpos($form_row['validation'],'req') === false)
             {
                 $label = $form_row['label'];
             } else {

                 $label = '<font color="red">*</font>&nbsp;'.$form_row['label'];
             }
             $form_data = $form_data.'<tr valign="top"><td width="'.$label_width.'"><div align="right"><b>'.$label.'&nbsp;:&nbsp;</b></div></td>';

             $my_value = $CI->input->post($form_row['name']);

             switch ($form_row['type'])
             {
                case 'forced':
                        $form_data .= '<td width="'.$field_width.'" class="graytext"><input type="text" name="'.$form_row['name'].'" size="'.$text_width.'" maxlength="150" value="'.$form_row['value'].'" readonly>';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'forcedhidden':
                        $form_data .= '<td width="'.$field_width.'" class="graytext">'.$form_row['value1'].'<input type="hidden" name="'.$form_row['name'].'" size="'.$text_width.'" maxlength="150" value="'.$form_row['value2'].'">';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'text':
                        $form_data .= '<td width="'.$field_width.'"><input type="text" name="'.$form_row['name'].'" size="'.$text_width.'" maxlength="150" value="'.$my_value.'">';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'textmsg':
                        $form_data .= '<td width="'.$field_width.'"><input type="text" name="'.$form_row['nam'].'" size="'.$text_width.'" maxlength="150" value="'.$my_value.'">';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'textarea':
                        $form_data .= '<td width="'.$field_width.'"><textarea name="'.$form_row['name'].'" rows="'.$num_rows.'" cols="'.$num_cols.'">'.$my_value.'</textarea>';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'date':
                        $form_data .= '<td width="'.$field_width.'"><input type="text" name="'.$form_row['name'].'" onclick="displayDatePicker(\''.$form_row['label'].'\');" class="text" value="'.$my_value.'"/><a href="javascript:void(0);" onclick="displayDatePicker(\''.$form_row['label'].'\');"><img src="'.base_url().'style/images/calendar.png" alt="calendar" border="0"></a>';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'select':
                        $cms_menu = $CI->config->item($form_row['source']);
                        $default_value = $cms_menu[0]['value'];
                        $form_data .= '<td width="'.$field_width.'">';
                        $select_found = false;
                        $form_data .= '<select name="'.$form_row['name'].'">';
                        foreach ($cms_menu as $menu_item)
                        {
                            $form_data = $form_data.'<option value = "'.$menu_item['value'].'"';
                            if (($menu_item['value'] == $my_value) and ($select_found == false)) {
                                $form_data .= ' selected';
                                $select_found = true;
                            }
                            $form_data .= '>'.$menu_item['text'].'</option>';

                        }
                        $form_data = $form_data.'</select>';
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'check':
                        $cms_menu = $CI->config->item($form_row['source']);
                        $form_data = $form_data.'<td width="'.$field_width.'">';
                        $count = 0;
                        foreach ($cms_menu as $menu_item)
                        {
                            $count = $count + 1;
                            $form_data .= '<input type="checkbox" name="'.$form_row['name'].$count.'" value = "'.$menu_item['value'].'"';
                            $check_value = $CI->input->post($form_row['name'].$count);
                            if ($menu_item['value'] == $check_value) {
                                $form_data .= ' checked';
                            }
                            $form_data .= '>&nbsp;'.$menu_item['text'].'<br>';
                        }
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
                case 'radio':
                        $cms_menu = $CI->config->item($form_row['source']);
                        $form_data = $form_data.'<td width="'.$field_width.'">';
                        foreach ($cms_menu as $menu_item)
                        {
                            $form_data .= '<input type="radio" name="'.$form_row['name'].'" value = "'.$menu_item['value'].'"';
                            if ($menu_item['value'] == $my_value) {
                                $form_data .= ' checked';
                            }
                            $form_data .= '>&nbsp;'.$menu_item['text'].'<br>';
                        }
                        if ($form_row['msg'] != '')
                        {
                            $form_data .= '<br><span class="footertext">'.$form_row['msg'].'</span>';
                        }
                        $form_data .= '</td>';
                break;
             }
             $form_data .= '</tr>';
         }
         if ($cms_info['useCaptcha'])
         {
            $image = $image = base_url().'js/captcha/CaptchaSecurityImages.php';
            $form_data .= '<tr valign="top"><td width="'.$label_width.'"><div align="right"><font color="red">*</font>&nbsp;<b>Security Code&nbsp;:&nbsp;</b></div></td>';
            $form_data .= '<td width="'.$field_width.'"> <img src="'.$image.'" /><br /><input id="security_code" name="security_code" type="text" /></td></tr>';
         }
         //finish up formData population
         $form_data .= '<tr><td>&nbsp;</td><td><input type="submit" value="Submit"/></td></tr></table></div></form><br />';
         return $form_data;
     }

    function set_validation_rules($cms_type)
    {
        $CI =& get_instance();
         //load cmsKey info
         $cms_info = $CI->config->item($cms_type);
         $cms_form = $cms_info['contactDef'];
         //walk through items in form and set rules
         foreach ($cms_form as $form_row)
         {
             if (isset($form_row['validation']))
             {
                 if ($form_row['validation'] != 'none')
                 {
                    $CI->form_validation->set_rules($form_row['name'], $form_row['label'], $form_row['validation']);
                 }
             }
         }
    }

    


    
}

// END Mail class

/* End of file mail.php */
/* Location: ./application/libraries/mail.php */
