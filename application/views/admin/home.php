<div class="splitleft">
    <h1>Application Manager</h1>
    <table  style="float:left;">
              <tr valign="top">
                  <td align="left" width="300">
                     <h3>Account Information</h3>
                        <blockquote>
                            <?php
                                if(isset($user_info) && $user_info->num_rows())
                                {
                                    $row = $user_info->row();
                                    echo $row->FirstName.'&nbsp;'.$row->LastName.'<br>';
                                    echo 'Username:&nbsp;'.$row->Username.'<br>';
                                    echo 'Email:&nbsp;'.$row->Email.'<br>';
                                    echo '<a href="'.base_url().'admin/account">{edit account information}</a>';
                                } else {
                                    echo '<div class="error_msg">No account data found.</div><br><br>';
                                }
                            ?>
                        </blockquote>
                  </td>
          </tr>
          </table>
    <BR CLEAR=LEFT>
    <br />
    <span class="fieldhead">Crop Verification</span><br>
    <?php
    if($unverified_crop->num_rows()){
        echo '<div class="error_msg">'.lang('data_crop_require_attn').' '.anchor('admin/crop_verification','{View Details}').'</div>';
    } else {
        echo '<div>'.lang('data_crop_verified').'</div>';
    }
    ?>
    
    <br />
    <span class="shedhead">Equipment Verification</span><br>
    <?php
    if($unverified_equip->num_rows()){
        echo '<div class="error_msg">'.lang('data_equip_require_attn').' '.anchor('admin/equip_verification','{View Details}').'</div>';
    } else {
        echo '<div>'.lang('data_equip_verified').'</div>';
    }
    ?>
    <br />
</div>