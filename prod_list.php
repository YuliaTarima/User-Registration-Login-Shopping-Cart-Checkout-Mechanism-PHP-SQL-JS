<?php
//will be invoked when the user selects a category from the Category List screen (index.php).
//It will display the Product List screen.

session_start();
require_once 'functions.php';

echo '<h1>Product List Screen</h1>';
display_header();

$category_id=$_GET['category_id'];
display_prod_list($category_id);

display_button('index.php', 'continue', 'Continue Shopping');

?>
