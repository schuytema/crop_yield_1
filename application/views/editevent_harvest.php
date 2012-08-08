<h3>Event Harvest Details</h3>

    <div id="harvest_error_msg" class="error_msg">To record harvest information for this field, please create a plant event for this field in the current season.</div>

    <div id="equipment_container">
    <h4>Equipment Used</h4>
    <?php
        $view_data = array('power'=>$power,'implements'=>$implements);
        //check for edit
        if(isset($harvest_data) && $harvest_data->num_rows()){
            $row = $harvest_data->row();
            $view_data['row'] = $row;
        }

        $this->load->view('equipment_select',$view_data);
    ?>
    
    </div>
    <BR CLEAR=LEFT>
    
    <div id="crop_container">
    <h4>Crop Data</h4>
    <?php
    if (isset($crop_info)) {
        foreach($crop_info as $key => $crop) {
            $view_data = array('form_num'=>$key+1,'crop'=>$crop);
            $this->load->view('harvest_crop_info',$view_data);
        }
    }
    ?>    
    </div>
    <BR CLEAR=LEFT>

    <div id="submit_container">
        <br><br>
        <footer>
        <input type="submit" class="btnLogin" name="submit" value="Submit" tabindex="4">
        </footer>
    </div>
    </form>
    <br><br>
</div>