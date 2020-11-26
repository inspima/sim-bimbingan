<?php
$this->session->unset_userdata('logged_in');
session_destroy();
redirect('/login', 'refresh');
?>