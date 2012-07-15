<?php
/* - Entering 2 or more characters in the input box triggers jquery UI's autocomplete feature (see js/chemical.js - line 50)
 * - The js autocomplete feature posts to the function chemical_suggest (see controllers/member.php), which in turn calls the m_chemical model to produce 
 *   a suggestion list based on the input box value
 * - Clicking the submit button triggers a javascript event (see js/chemical.js - line 67)
 * - The js click event posts to the function chemical_fetch (see controllers/member.php), which builds db results based on the
 *   input box value
 */

echo '<h2>Keyword Search Example</h2>';
//keyword search
echo 'Product Name: <p><input type="text" id="keyword" name="keyword" size="25"/><input type="submit" id="keyword_submit"></p>';

//results area
echo '<div id="results" style="display: none;"></div>';
