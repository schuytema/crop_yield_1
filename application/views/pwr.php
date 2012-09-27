<div class="splitleft">
    <h1>Reset Your Password</h1>
    <?php
    if(isset($status)){ //form submitted, display status
        echo '<p>'.$status.'</p>';
    } else {
        if(validation_errors()){
            echo '<div class="error_msg">'.validation_errors().'</div>';
        }
        echo form_open('main/pwr/'.$id.'/'.$key,'class="box login"');
        ?>
        <fieldset class="boxBody">
            <label>New Password</label>
            <input type="password" tabindex="1" required name="Password">
            <label>New Password (again)</label>
            <input type="password" tabindex="1" required name="VerifyPassword">
            </fieldset>
            <footer>
            <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
            </footer>
        <?php
        echo form_close();
    }
    ?>
    <br>
</div>

