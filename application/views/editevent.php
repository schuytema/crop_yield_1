<!-- content -->
<link href="<?php echo base_url(); ?>css/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/calendar.js"></script>


<div class="splitleft">
    <h1>Edit Event(New)</h1>
    <h3>Master Event Data</h3>
    
    <form action="<?php echo base_url(); ?>member/field" method="POST">
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Type:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="EventType">
                        <option value="Application">Application</option>
                        <option value="Chemical">Chemical</option>
                        <option value="Fertilizer">Fertilizer</option>
                        <option value="Harvest">Harvest</option>
                        <option value="Plant">Plant</option>
                        <option value="Tillage">Tillage</option>
                        <option value="Weather">Weather</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Date:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="15" name="Date" onclick="displayDatePicker('Date');"><a href="javascript:void(0);" onclick="displayDatePicker('Date');"><img src="<?php echo base_url(); ?>css/images/calendar.png" alt="calendar" border="0"></a>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Notes:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <TEXTAREA NAME="Notes" COLS=40 ROWS=6></TEXTAREA>
                  </td>
               </tr>
          </table>
    <BR CLEAR=LEFT>
    <h3>Event Application Details</h3>
    
    
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Product">
                        <option value="Ammonia">Ammonia</option>
                        <option value="Lime">Lime</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Application Rate:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="ApplicationRate">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="ApplicationRateUnit">
                        <option value="lbs/acre">lbs/acre</option>
                        <option value="lbs/sq. mile">lbs/sq. mile</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          <br><br>
          <h3>Event Chemical Details</h3>
    
    
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Type:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Type">
                        <option value="Herbicide">Herbicide</option>
                        <option value="Insecticide">Insecticide</option>
                        <option value="Fungicide">Fungicide</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Brand">
                        <?php
                        foreach ($brands as $brand)
                        {
                            echo '<option value="'.$brand.'">'.$brand.'</option>';
                        }
                        ?>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Products:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product">
                        <?php
                        foreach ($products as $product)
                        {
                            echo '<option value="'.$product.'">'.$product.'</option>';
                        }
                        ?>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Amount of Active Ingredient:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="10" name="AmountActiveIngredient">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="AmountActiveIngredientUnit">
                        <option value="lbs">lbs</option>
                        <option value="kg">kq</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          
	<footer>
	  <input type="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

