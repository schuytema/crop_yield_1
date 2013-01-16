<div class="splitleft">
    <h1>User Details</h1>
    <?php
    if($results->num_rows()){
        $row = $results->row();
        
        //Account Status
        echo '<h3>Account Status</h3>';
        if(isset($acct_status)){
            echo '<span class="error_msg">'.$acct_status.'</span>';
        }
        echo form_open('admin/user_details/'.$id);
        echo form_hidden('id', $id);
        if($row->IsEnabled){
            echo 'Login account is enabled: '.form_submit('disable','Lock Account');
        } else {
            echo 'Login account is locked: '.form_submit('enable','Enable Account');
        }
        echo form_close();
        echo '<br />';
        
        //Account Details
        echo '<h3>Account Details</h3>';
        echo 'Username: '.$row->Username;
        echo '<br />Email: '.$row->Email;
        echo '<br />Registration Date: '.date('F d, Y g:i:s A',strtotime($row->FirstVisit));
        echo '<br />Last Visit: '.$i = ($row->LastVisit) ? date('F d, Y g:i:s A',strtotime($row->LastVisit)) : 'n/a';
        echo '<br />Visit Count: '.$i = ($row->VisitCount) ? $row->VisitCount : 'n/a';
        echo '<br /><br />';
        
        //Reset Password
        echo '<h3>Password Reset</h3>';
        if(isset($reset_status)){
            echo '<span class="error_msg">'.$reset_status.'</span>';
        }
        echo form_open('admin/user_details/'.$id);
        echo form_hidden('id', $id);
        echo 'Send user a new password: '.form_submit('reset_password','Reset Password','onclick="return confirm(\'Please confirm password reset:\')"');
        echo form_close();        
    } else {
        echo '<p>'.lang('users_not_found').'</p>';
    }
    echo '<br />';
    echo '<p align="center">'.anchor('admin/users','[Back]').'</p>';
    ?>
</div>