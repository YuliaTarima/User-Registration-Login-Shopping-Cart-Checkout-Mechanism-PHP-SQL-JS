<?php
//will be invoked when the user selects "Empty Cart" button from the Category List screen (index.php).

session_start();
require_once 'functions.php';
unset($_SESSION['cart']);

echo '<h1>Cart Emptied</h1>';

display_button('index.php', 'continue', 'Continue Shopping');

?>

