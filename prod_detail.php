<?php
//prod.detail.php that will be invoked when the user selects a product from the Product List screen.
//It will display the Product Detail screen.

session_start();

require_once 'functions.php';

echo '<h1>Product Detail Screen</h1>';
display_header();

$product_id=$_GET['product_id'];
display_prod_detail($product_id);

display_button('index.php', 'continue', 'Continue Shopping');

display_button_withid('show_cart.php', 'add', 'Add to Cart', $product_id);

?>

