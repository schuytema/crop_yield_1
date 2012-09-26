<?php
//Authentication
$lang['auth_welcome_msg'] = 'Welcome to Grow Our Yields!'."\n\n".'Your efforts will help us grow our initial test database. Given enough regional data, we will be able to move forward to create best practice and prediction reports that can help you make better, more informed decisions in the future - and that means a better bottom line! Thank you for sharing your data - together, we can all Grow Our Yields.';
$lang['auth_welcome_subject'] = 'Welcome to Grow Our Yields';
$lang['auth_acct_failed'] = 'Account creation failed. Please try again.';
$lang['auth_user_exists'] = 'Username already exists. Please choose another username.';
$lang['auth_email_exists'] = 'Email already exists. Please choose another email.';
$lang['auth_login_failed'] = 'The username or password you entered is not valid.';

//Password
$lang['auth_pass_note'] = "Passwords must be at least 8 characters long and contain both letters and numbers.";


//Forgot Password
$lang['auth_forgot_pass_msg'] = 'Changing your password is simple. Please use the link below within 8 hours.'."\n\n".'%s'."\n\n".'Thank you,'."\n".'The Grow Our Yields Team';
$lang['auth_forgot_pass_subject'] = 'Reset Your Grow Our Yields Password';
$lang['auth_forgot_pass_reset_success'] = 'An email has been sent to the requested account with further information. If you do not receive an email then please confirm you have entered the same email address used during account signup.';

//Reset Password
$lang['auth_reset_pass_msg'] = 'Your password was recently updated. If you did not reset your password, please contact the Grow Our Yields Team.'."\n\n".'Thank you,'."\n".'The Grow Our Yields Team';
$lang['auth_reset_pass_subject'] = 'Grow Our Yields - Password Reset';
$lang['auth_reset_pass_success'] = 'Your password has been updated! Please login now to access your account.<br /><br />If you need further assistance, please contact The Grow Our Yields Team.';
$lang['auth_reset_pass_fail'] = 'An error occurred while updating your password. The allotted time (8 hours) to reset your password has expired.<br /><br />To reset your password, please select the "Login" link, followed by the "Forgot your password?" link and follow the instructions on the screen.<br /><br />If you need further assistance, please contact The Grow Our Yields Team.';

//Data Verification
$lang['data_ver_general_error'] = 'An error occurred while processing request. Please try again or contact system administrator.';
$lang['data_crop_verified'] = 'All crop entries have been verified.';
$lang['data_crop_require_attn'] = 'User-submitted crop data requires verification:';
$lang['data_equip_verified'] = 'All equipment entries have been verified.';
$lang['data_equip_require_attn'] = 'User-submitted equipment data requires verification:';

//Add/Edit Farm
$lang['farm_new_title'] = 'Add a New Farm';
$lang['farm_new_desc'] = 'Use this form to create a new farm record.';
$lang['farm_edit_title'] = 'Edit Farm';
$lang['farm_edit_desc'] = 'Use this form to update your basic farm information.';


//Add/Edit Field
$lang['field_new_title'] = 'Enter New Field Information';
$lang['field_new_desc'] = 'You can now create your new field\'s polygon and enter basic data to describe the size and drainage of your field.';
$lang['field_edit_title'] = 'Edit Existing Field Information';
$lang['field_edit_desc'] = 'Use this form to update this field\'s information.';

//Footer
$lang['footer_copyright'] = '&copy; 2012 GrowOurYields, LLC (all rights reserved)';

//Help System
$lang['h_field_title'] = 'Field Overview';
$lang['h_field_descr'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur, enim ac hendrerit semper, felis erat gravida nulla, suscipit ullamcorper sem justo nec neque. Ut quis ipsum vel magna iaculis tincidunt. Vestibulum ultricies hendrerit enim, eget convallis enim mattis non. Morbi suscipit gravida volutpat. Aenean vel ligula lectus, sit amet ornare urna. Nam libero libero, pellentesque non imperdiet eget, iaculis vel eros. Sed sollicitudin rhoncus tellus a ullamcorper. Fusce feugiat sapien eu mi convallis quis scelerisque mi viverra.
<br /><br />
Maecenas at quam eu erat lacinia malesuada. Duis faucibus dapibus dui, non tincidunt tortor fringilla ut. Maecenas fermentum, lectus vitae laoreet sagittis, dui justo blandit nunc, nec fermentum metus ligula at sem. Mauris turpis ligula, laoreet sit amet pretium non, ultricies non orci. Phasellus bibendum, velit at laoreet tempus, lacus leo porta enim, et malesuada quam nibh in arcu. Curabitur dignissim dictum elit id posuere. Praesent sapien nulla, tempus sit amet hendrerit sed, condimentum et lacus.';

$lang['h_event_title'] = 'Event Overview';
$lang['h_event_descr'] = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam consectetur, enim ac hendrerit semper, felis erat gravida nulla, suscipit ullamcorper sem justo nec neque. Ut quis ipsum vel magna iaculis tincidunt. Vestibulum ultricies hendrerit enim, eget convallis enim mattis non. Morbi suscipit gravida volutpat. Aenean vel ligula lectus, sit amet ornare urna. Nam libero libero, pellentesque non imperdiet eget, iaculis vel eros. Sed sollicitudin rhoncus tellus a ullamcorper. Fusce feugiat sapien eu mi convallis quis scelerisque mi viverra.
<br /><br />
Maecenas at quam eu erat lacinia malesuada. Duis faucibus dapibus dui, non tincidunt tortor fringilla ut. Maecenas fermentum, lectus vitae laoreet sagittis, dui justo blandit nunc, nec fermentum metus ligula at sem. Mauris turpis ligula, laoreet sit amet pretium non, ultricies non orci. Phasellus bibendum, velit at laoreet tempus, lacus leo porta enim, et malesuada quam nibh in arcu. Curabitur dignissim dictum elit id posuere. Praesent sapien nulla, tempus sit amet hendrerit sed, condimentum et lacus.';

$lang['h_editmap_title'] = 'Mapping Your Field';
$lang['h_editmap_descr'] = 'To create a field, you must plot its basic boundaries on the map.
    <h3>Plotting Coordinates</h3>
    Using the Polygon Tool button (top-center of map), left-click your mouse to plot a coordinate. Continue to plot coordinates around your field to complete a closed shape. In order to finish your field, you must close the shape by left-clicking on the first coordinate.
    <h3>Plotting Multiple Tracts</h3>
    You may plot multiple tracts of land as one field, as long as they are of the same crop, treatments, etc. This is helpful if a stream, farmhouse, or other obstruction segments an otherwise contiguous field.
    <h3>Editing Fields</h3>
    Once you have your shapes completed, click on the Hand Tool and left-click on a tract. Once a tract is selected, this tool will let you left-click and drag the vertices of your field to reposition them. You may also click the Undo Button when you have moved a vertex in order to undo the last move.
    <br/><br/>
    You may also right-click on a vertex to delete it from the field.
    <br/><br/>
    If you need to remove a tract entirely, select the Hand Tool and left-click on a tract. A Delete Button will appear next to the other drawing tools on the map. Clicking this button will delete the selected tract from the map.';

$lang['h_verification_title'] = 'Data Verification';
$lang['h_verification_descr'] = 'To verify a user-submitted entry, you must first click "Manage" to enable the verification tool.
    <br/><br/>
    A small window will display with the following options: <b>Accept or modify user-supplied entry</b> and <b>Replace user-supplied entry with item from database</b>.
    <h3>Accept or modify user-supplied entry</h3>
    You may accept or edit the supplied entry. Fields which may be modified include Brand, Product and, in the instance of Equipment Verification, Power and Tillage options.
    Once all fields have been reviewed, click "Submit" to complete the verification process.
    <h3>Replace user-supplied entry with item from database</h3>
    In some cases, user-submitted data may not be valid. You may replace the entry with an item from the database by selecting the appropriate Brand and Product. 
    Once all fields have been reviewed, click "Submit" to complete the verification process.';