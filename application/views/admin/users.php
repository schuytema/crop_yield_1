<div class="splitleft">
    <h1>User Management</h1>
    <?php
    if($results->num_rows()){
        $result = $results->result();
        echo '<table id="table-data" width="670">';
        echo '<thead><th width="20%">Last Name</th><th width="20%">First Name</th><th width="30%">Email</th><th width="20%">Account Status</th><th width="10%">Manage</th></thead>';
        foreach($result AS $row){
            $status = ($row->IsEnabled) ? 'Enabled' : '<span class="error_msg">Disabled</span>';
            echo '<tr><td>'.$row->LastName.'</td><td>'.$row->FirstName.'</td><td>'.$row->Email.'</td><td>'.$status.'</td><td>'.anchor('admin/user_details/'.$row->PK_UserId,'View').'</td></tr>';
        }
        echo '</table>';
        echo '<p>'.$links.'</p>';
    } else {
        echo '<p>'.lang('users_not_found').'</p>';
    }
    ?>
    <br />
</div>