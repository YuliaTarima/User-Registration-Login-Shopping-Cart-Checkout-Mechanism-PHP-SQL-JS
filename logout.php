<?php
//will be invoked when the user selects Logout from the Category List screen

session_start();
require_once 'functions.php';

session_regenerate_id();
session_destroy();

?>
<h1>Logout Screen</h1>
<h3>You are logged out.</h3>
