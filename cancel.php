<?php
//will be invoked when the user selects Cancel Order from any screen.

session_start();

require_once 'functions.php';

echo '<h1>Your order has been cancelled</h1>';

display_button('index.php', 'continue', 'Continue Shopping');
display_button('logout.php', 'logout', 'Logout');

session_regenerate_id();
session_destroy();
?>

