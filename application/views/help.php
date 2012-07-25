<?php
$help = $this->config->item('help');
if(isset($help[$this->uri->segment(3)])){
    echo '<h1>'.lang($help[$this->uri->segment(3)]['title']).'</h1>';
    echo '<p>'.lang($help[$this->uri->segment(3)]['descr']).'</p>';
} else {
    echo '<p>Help item not found.</p>';
}