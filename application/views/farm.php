<!-- content -->
<div class="splitleft">
    <h1>Farm Overview</h1>
    <table  style="float:left;">
              <tr valign="top">
                  <td align="left" width="300">
                    <h3>Farm Information</h3>
                        <blockquote>
                            <b>Swallow Hills Farm</b><br>
                            RR1<br>
                            Kirkwood, IL 61447<br>
                            309-555-1212<br>
                            <a href="<?php echo base_url(); ?>member/editfarm">{edit farm information}</a>
                        </blockquote>
                  </td>
                  <td align="left" width="300">
                     <h3>Account Information</h3>
                        <blockquote>
                            Paul Schuytema<br>
                            Username: schuytema<br>
                            Email: paul@schuytema.com<br>
                            <a href="<?php echo base_url(); ?>member/editaccount">{edit account information}</a>
                        </blockquote>
                  </td>
          </tr>
          </table>
    <BR CLEAR=LEFT>
    <h3>Your Fields</h3>
    <table  id="table-data" width="600">
        <thead>
            <th>Field Name</th>
            <th>Size (acres)</th>
            <th>Events</th>
            <th>Actions</th>
        </thead>
        <tr>
            <td width="250">Hartz Seven</td>
            <td width="100">7.5</td>
            <td width="100">3</td>
            <td width="150"><a href="<?php echo base_url(); ?>member/field">details</a></td>
        </tr>
        <tr>
            <td>Swallow Hills back</td>
            <td>20</td>
            <td>3</td>
            <td><a href="<?php echo base_url(); ?>member/field">details</a></td>
        </tr>
        <tr>
            <td>Swallow Hills east</td>
            <td>73</td>
            <td>2</td>
            <td><a href="<?php echo base_url(); ?>member/field">details</a></td>
        </tr>
    </table>
    <a href="<?php echo base_url(); ?>member/editfield">{add new field}</a>
    <br><br>
</div>

