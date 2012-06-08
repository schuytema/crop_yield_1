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
    
    <p><a href="#">{apply event to multiple fields}</a></p>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Your Fields:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                    <input type="checkbox" name="fields[]" value="1">Hartz Seven<br>
                    <input type="checkbox" name="fields[]" value="2">Swallow Hills back<br>
                    <input type="checkbox" name="fields[]" value="3" checked>Swallow Hills east 
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
          <br><br>
    
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
          <br><br>
          
          <h3>Event Fertilizer Details</h3>
       
        <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Percent N:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="3" name="PercentN">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent P:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentP">&nbsp;%
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent K:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentK">&nbsp;%
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
    
    
    <h3>Event Harvest Details</h3>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Brand">
                        <option value="Case IH">Case IH</option>
                        <option value="John Deere">John Deere</option>
                        <option value="Lexion">Lexion</option>
                        <option value="New Holland">New Holland</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product">
                        <option value="7010">7010</option>
                        <option value="7088">7088</option>
                        <option value="8010">8010</option>
                        <option value="8020">8020</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
       
        <h4>Yield Data</h4>   
          
        <table  style="float:left;" width="510">
               <tr valign="top">
                  <td align="right" width="200">
                      <b>Yield:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <input type="text" size="4" name="Yield">
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Units:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="YieldUnit">
                        <option value="bu/acre">bu/acre</option>
                        <option value="bu/sq. mile">bu/sq. mile</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Grain Test Weight:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="4" name="GrainTestWeight">&nbsp;lbs/bu
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent Moisture:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentMoisture">&nbsp;%
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
    <br><br>
    
    <h3>Event Plant Details</h3>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Brand">
                        <option value="Case IH">Case IH</option>
                        <option value="Ford">Ford</option>
                        <option value="John Deere">John Deere</option>
                        <option value="Kinze">Kinze</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product">
                        <option value="7010">455</option>
                        <option value="7088">1770</option>
                        <option value="8010">7000</option>
                        <option value="8020">7200</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
       
        <h4>Planting Data</h4>   
          
        need to figure this out
        
          <BR CLEAR=LEFT>
    <br><br>
    
    <h3>Event Tillage Details</h3>
    
    <h4>Equipment Used</h4>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Brand:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Brand">
                        <option value="Bush Hog">Bush Hog</option>
                        <option value="Case IH">Case IH</option>
                        <option value="Ford">Ford</option>
                        <option value="John Deere">John Deere</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Product:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <select name="Product">
                        <option value="610">610</option>
                        <option value="625">625</option>
                        <option value="980">980</option>
                        <option value="1010">1010</option>
                      </select>
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
    <br><br>
    
    <h3>Event Weather Details</h3>
    
    <table  style="float:left;" width="510">
              <tr valign="top">
                  <td align="right" width="200">
                      <b>Weather:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left" width="310">
                      <select name="Weather">
                        <option value="Rain">Rain</option>
                        <option value="Hail">Hail</option>
                        <option value="Flood">Flood</option>
                        <option value="Tornado">Tornado</option>
                        <option value="Winds">Winds</option>
                      </select>
                  </td>
               </tr>
               <tr valign="top">
                  <td align="right">
                      <b>Percent Damaged:</b>&nbsp;&nbsp;
                  </td>
                  <td align="left">
                      <input type="text" size="3" name="PercentDamaged">&nbsp;%
                  </td>
               </tr>
          </table>
          <BR CLEAR=LEFT>
    <br><br>
          
	<footer>
	  <input type="submit" class="btnLogin" value="Submit" tabindex="4">
	</footer>
    </form>
    <br><br>
</div>

