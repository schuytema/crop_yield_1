<!-- content -->
<link href="<?php echo base_url(); ?>css/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendar.js"></script>


<div class="splitleft">
    <br><span class="shedhead">Machine Shed</span><br><br>

<?php
    if(validation_errors()){
        echo '<div class="error_msg">'.validation_errors().'</div>';
    }

    //check for edit
    if(isset($shed_data) && $shed_data->num_rows()){
        $row = $shed_data->row();
    }
    
    echo form_open($action);
    ?>
    
    <table  style="float:left;" width="510">
            <tr valign="top">
                  <td align="right" width="200">
                      <b>Nickname:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="30" name="Name" value="<?php echo set_value('Name',(isset($row->Name)) ? $row->Name : NULL); ?>">
                  </td>
               </tr>
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Type:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="EquipmentType" id="EquipmentType">
                        <option value="">Select Type</option>
                        <option value="Tractor">Tractor</option>
                        <option value="Planter">Planter</option>
                        <option value="Harvester">Harvester</option>
                        <option value="Tiller">Tiller</option>
                        <option value="Sprayer">Sprayer</option>
                      </select>
                  </td>
               </tr>
              <?php


                    //brands
                    echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                    echo '<select id="EquipmentBrand" name="EquipmentBrand"><option value="">select type...</option></select>';

                    echo '</td></tr>';
                    
                    
                    //echo '<tr valign="top"><td align="right" width="200"><b>Brand:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                    //echo '<select id="EquipmentBrand" name="EquipmentBrand"><option value ="">Select Type</option>';
                    //foreach($result AS $row){
                        //echo '<option value ="'.$row->Brand.'">'.$row->Brand.'</option>';
                    //}
                    //echo '</select>';

                    //echo '</td></tr>';
                    

                    //products
                    echo '<tr valign="top"><td align="right" width="200"><b>Product:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                    echo '<select id="EquipmentProduct" name="EquipmentProduct"><option value="">select brand...</option></select>';

                    echo '</td></tr>';



            ?>
               <tr>
                    <td align="right" colspan="2">
                        <a href="javascript:Void(0);" id="show_other_one">{my equipment isn't in these lists}</a>
                        <div id="other_one">
                          <br>Please enter equipment manually:<br>
                          Brand:&nbsp;<input type="text" size="40" name="OtherEquipmentBrand"><br>
                          Product:&nbsp;<input type="text" size="40" name="OtherEquipmentProduct"><br>
                        </div>
                    </td>
                </tr>
          </table>
          <BR CLEAR=LEFT>
       
        
    <br>

    
   
          
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

