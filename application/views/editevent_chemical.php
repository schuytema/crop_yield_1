   
    <h3>Event Chemical Details</h3>
    
    <?php
    //check for edit
    if(isset($chemical_data) && $chemical_data->num_rows()){
        $datarow = $chemical_data->row();
    }
    ?>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <?php
            if($power->num_rows()){
                $result = $power->result();

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Power:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                $imps = array();
                if (!isset($row->FK_EquipmentId))
                {
                    $imps['0'] = 'Select Power';
                }
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('Power', $imps, set_value('Power',(isset($datarow->FK_EquipmentId_Power)) ? $datarow->FK_EquipmentId_Power : NULL));
                //echo form_dropdown('EquipmentProduct', $imps, set_select('EquipmentProduct', $row->FK_EquipmentId, TRUE));
                


                echo '</td></tr>';

              


            } else {
                echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            }
            
            if($implements->num_rows()){
                $result = $implements->result();

                //brands
                echo '<tr valign="top"><td align="right" width="200"><b>Implement:</b>&nbsp;&nbsp;</td><td align="left" width="310">';

                $imps = array();
                if (!isset($row->FK_EquipmentId))
                {
                    $imps['0'] = 'Select Implement';
                }
                foreach($result AS $item){
                    $imps[$item->FK_EquipmentId] = $item->Name;
                }
                
                echo form_dropdown('EquipmentProduct', $imps, set_value('EquipmentProduct',(isset($datarow->FK_EquipmentId)) ? $datarow->FK_EquipmentId : NULL));
                //echo form_dropdown('EquipmentProduct', $imps, set_select('EquipmentProduct', $row->FK_EquipmentId, TRUE));
                


                echo '</td></tr>';

              


            } else {
                echo '<tr><td colspan="2"><font color="red>Implement data not found.</font></td></tr>';
            }

        ?>
          </table>
          <BR CLEAR=LEFT>
    <h4>Timing</h4>
        <table  style="float:left;" width="510">
            <tr valign="top">
                <td align="right" width="200">
                    <b>Pre Emergence?:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('PreEmergence', $this->config->item('no_yes_boolean'), set_value('PreEmergence',(isset($datarow->PreEmergence)) ? $datarow->PreEmergence : NULL));
                    ?>
                </td>
            </tr>
          </table>
          <BR CLEAR=LEFT>
    <h4>Additives</h4>
        <table  style="float:left;" width="510">
            <tr valign="top">
                <td align="right" width="200">
                    <b>Chelated Zinc:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('ChelatedZinc', $this->config->item('no_yes_boolean'), set_value('ChelatedZinc',(isset($datarow->ChelatedZinc)) ? $datarow->ChelatedZinc : NULL));
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>Sulphur:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('Sulphur', $this->config->item('no_yes_boolean'), set_value('Sulphur',(isset($datarow->Sulphur)) ? $datarow->Sulphur : NULL));
                    ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="right" width="200">
                    <b>Boron:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="310">
                    <?php
                    echo form_dropdown('Boron', $this->config->item('no_yes_boolean'), set_value('Boron',(isset($datarow->Boron)) ? $datarow->Boron : NULL));
                    ?>
                </td>
            </tr>
          </table>
          <BR CLEAR=LEFT>
    <h4>Tank Mix</h4>
        <table  style="float:left;" width="640">   
            <tr valign="top">
                <td align="left" width="150">
                    <b>Chemical Search:</b>&nbsp;&nbsp;
                </td>
                <td align="left" width="490">
                    <input type="text" id="keyword" name="keyword" size="60"/>&nbsp<a href="javascript:void(0);" id="keyword_submit">prod1</a>&nbsp|&nbsp;<a href="javascript:void(0);" id="keyword_submit2">prod2</a>&nbsp|&nbsp;<a href="javascript:void(0);" id="keyword_submit3">prod3</a>&nbsp|&nbsp;<a href="javascript:void(0);" id="keyword_submit4">prod4</a>
                    <div id="results" style="display: none;"></div>
                    <br>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Product 1:</b>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <div id="Prod1">
                    <?php
                    if (isset($datarow->FK_ChemicalId))
                    {
                        $prod_info = $this->m_chemical->get_product_info($datarow->FK_ChemicalId);
                        echo 'Brand: '.$prod_info['Brand'].' Product: '.$prod_info['Product'];
                    } else {
                        echo 'No Product 1 selected (required)';
                    }
                    ?>
                    </div>
                    <input type="hidden" id="FK_ChemicalId" name="FK_ChemicalId" value="<?php echo set_value('FK_ChemicalId',(isset($datarow->FK_ChemicalId)) ? $datarow->FK_ChemicalId : NULL); ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Amount of Product:</b>&nbsp;&nbsp;<input type="text" size="10" name="AmountActiveIngredient" value="<?php echo set_value('AmountActiveIngredient',(isset($datarow->AmountActiveIngredient)) ? $datarow->AmountActiveIngredient : NULL); ?>">&nbsp;&nbsp;
                      <?php
                      echo form_dropdown('AmountActiveIngredientUnit', $this->config->item('chemical_units'), set_value('AmountActiveIngredientUnit',(isset($datarow->AmountActiveIngredientUnit)) ? $datarow->AmountActiveIngredientUnit : NULL));
                      ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Product 2:</b>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <div id="Prod2">
                    <?php
                    if (isset($datarow->FK_ChemicalId2))
                    {
                        $prod_info = $this->m_chemical->get_product_info($datarow->FK_ChemicalId2);
                        echo 'Brand: '.$prod_info['Brand'].' Product: '.$prod_info['Product'];
                    } else {
                        echo 'No Product 2 selected (optional)';
                    }
                    ?>
                    </div>
                    <input type="hidden" id="FK_ChemicalId2" name="FK_ChemicalId2" value="<?php echo set_value('FK_ChemicalId2',(isset($datarow->FK_ChemicalId2)) ? $datarow->FK_ChemicalId2 : NULL); ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Amount of Product:</b>&nbsp;&nbsp;<input type="text" size="10" name="AmountActiveIngredient2" value="<?php echo set_value('AmountActiveIngredient2',(isset($datarow->AmountActiveIngredient2)) ? $datarow->AmountActiveIngredient2 : NULL); ?>">&nbsp;&nbsp;
                      <?php
                      echo form_dropdown('AmountActiveIngredientUnit2', $this->config->item('chemical_units'), set_value('AmountActiveIngredientUnit2',(isset($datarow->AmountActiveIngredientUnit2)) ? $datarow->AmountActiveIngredientUnit2 : NULL));
                      ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Product 3:</b>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <div id="Prod3">
                    <?php
                    if (isset($datarow->FK_ChemicalId3))
                    {
                        $prod_info = $this->m_chemical->get_product_info($datarow->FK_ChemicalId3);
                        echo 'Brand: '.$prod_info['Brand'].' Product: '.$prod_info['Product'];
                    } else {
                        echo 'No Product 3 selected (optional)';
                    }
                    ?>
                    </div>
                    <input type="hidden" id="FK_ChemicalId3" name="FK_ChemicalId3" value="<?php echo set_value('FK_ChemicalId3',(isset($datarow->FK_ChemicalId3)) ? $datarow->FK_ChemicalId3 : NULL); ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Amount of Product:</b>&nbsp;&nbsp;<input type="text" size="10" name="AmountActiveIngredient3" value="<?php echo set_value('AmountActiveIngredient3',(isset($datarow->AmountActiveIngredient3)) ? $datarow->AmountActiveIngredient3 : NULL); ?>">&nbsp;&nbsp;
                      <?php
                      echo form_dropdown('AmountActiveIngredientUnit3', $this->config->item('chemical_units'), set_value('AmountActiveIngredientUnit3',(isset($datarow->AmountActiveIngredientUnit3)) ? $datarow->AmountActiveIngredientUnit3 : NULL));
                      ?>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Product 4:</b>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2">
                    <div id="Prod4">
                    <?php
                    if (isset($datarow->FK_ChemicalId4))
                    {
                        $prod_info = $this->m_chemical->get_product_info($datarow->FK_ChemicalId4);
                        echo 'Brand: '.$prod_info['Brand'].' Product: '.$prod_info['Product'];
                    } else {
                        echo 'No Product 4 selected (optional)';
                    }
                    ?>
                    </div>
                    <input type="hidden" id="FK_ChemicalId4" name="FK_ChemicalId4" value="<?php echo set_value('FK_ChemicalId4',(isset($datarow->FK_ChemicalId4)) ? $datarow->FK_ChemicalId4 : NULL); ?>"/>
                </td>
            </tr>
            <tr valign="top">
                <td align="left" colspan="2">
                    <b>Amount of Product:</b>&nbsp;&nbsp;<input type="text" size="10" name="AmountActiveIngredient4" value="<?php echo set_value('AmountActiveIngredient4',(isset($datarow->AmountActiveIngredient4)) ? $datarow->AmountActiveIngredient4 : NULL); ?>">&nbsp;&nbsp;
                      <?php
                      echo form_dropdown('AmountActiveIngredientUnit4', $this->config->item('chemical_units'), set_value('AmountActiveIngredientUnit4',(isset($datarow->AmountActiveIngredientUnit4)) ? $datarow->AmountActiveIngredientUnit4 : NULL));
                      ?>
                </td>
            </tr>
          </table>
          <BR CLEAR=LEFT>
          <br><br>

    
   
          
	<footer>
	  <input type="submit" name="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

<script type="text/javascript">

function changeToVisible(obj)
{
    obj = document.getElementById(obj);
    obj.style.display = 'inline';
}

</script>