<div class="splitleft">
    <h1>Edit Your Basic Account Information</h1>
    <?php
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }
    
    //get user data
    if(isset($user_info) && $user_info->num_rows()){
        $row = $user_info->row();
        echo form_open($form_url,'class="box update"');
        ?>
        <fieldset class="boxBody">
            <label>Name</label>
            <table border="0" align="center" cellspacing="0" cellpadding="0" width="420">
                <tr>
                    <td>
                        <input type="text" name="FirstName" value="<?php echo set_value('FirstName',$row->FirstName); ?>">
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;<font color="gray">first</font>
                    </td>
                    <td>
                        <input type="text" name="LastName" value="<?php echo set_value('LastName',$row->LastName); ?>">
                        <br>&nbsp;&nbsp;&nbsp;&nbsp;<font color="gray">last</font>
                    </td>
                </tr>
            </table>
            <label>Update Email Address</label>
            <input type="text" name="Email" value="<?php echo set_value('Email'); ?>">
            &nbsp;&nbsp;<font color="gray">current email: <?php echo $row->Email;?></font>
            <label>Update Username</label>
            <input type="text" name="Username" value="<?php echo set_value('Username'); ?>">
            &nbsp;&nbsp;<font color="gray">current username: <?php echo $row->Username;?></font>
            <label>Existing Password</label>
            <input type="password" name="CurrPassword">
            <label>New Password</label>
            <input type="password" name="Password">
            &nbsp;&nbsp;<font color="gray"><?php echo lang('auth_pass_note');?></font>
            <label>New Password (again)</label>
            <input type="password" name="VerifyPassword">
            </fieldset>
            <footer>
            <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
            </footer>
        <?php
        echo form_close();
    } else {
        echo '<p>Account data not found.</p>';
    }
    ?>
    <br>
</div>

