<?php
//will display the Cart screen

//When the user selects View Cart button from any screen.
//When the user selects Add to Cart button from the Product Detail screen.
//When the user selects Modify Cart Quantities button from any screen.
//When the user selects Save Cart Quantities button from the Cart screen.

//Each of the above buttons will be a submit button within a separate form.
//Each of the above buttons will invoke the show_cart.php. Each of the  script.
//The show_cart.php script will know which b can be identified by the invoked scrip
//because each button is associated with a unique name.

session_start();
require_once 'functions.php';

echo '<h1>Your Cart</h1>';


display_header();
// Optionally, also display the Cart totals.


//From View Cart button
if ( isset($_GET['view']) ){
    echo '<h3>Arrived from View Cart Button</h3>';
    display_cart();
    display_footerButtons();
}
//__________________________________________________________________________________________________________//
// From Add to Cart button ('add' button & product id received)
// obtain the product_id from $_GET array as passed on by the button;
// also update (or create) its corresponding entry in $_SESSION['cart'] array.

if ( isset($_GET['add']) && isset($_GET['id']) ) {
    $product_id = $_GET['id'];
    echo '<h3>Arrived from Add Button </h3>';
    //echo 'Product_id is ' . $product_id . '<br />';

    // If $_SESSION['cart'] array exists and product_id is present in it,
    //increment product_id value (quantity) by 1.
    if ( (isset($_SESSION['cart'])) && (isset($_SESSION['cart'][$product_id]))){
        $_SESSION['cart'][$product_id] += 1;
    }
    //if product does not exist in the cart	put product_id value (quantity) initialized to 1
    else {
        $_SESSION['cart'][$product_id] = 1;
    }
    //echo '<h3>If Session Cart is not set</h3>Quantity is ' . $_SESSION['cart'][$product_id] . '<br />';
    display_cart();
    display_footerButtons();
}
//__________________________________________________________________________________________________________//

if ( isset($_GET['modify']) ){
    echo '<h3>Arrived from Modify Button</h3>';
    display_cart();
    display_footerButtons();
}
//__________________________________________________________________________________________________________//

// If from "Save Cart Quantities" button,

// If for any prodid/quantity pair, quantity part in $_GET array is zero,
// delete (unset) that prodid/quantity pair from $_SESSION['cart'] array
if ( (isset($_GET['save'])) && (isset ($_SESSION['cart'])) && (count($_SESSION['cart']) > 0) )  {
    foreach ($_SESSION ['cart'] as $product_id=>$quantity){
        if ($_GET[$product_id] == 0){
            unset($_SESSION['cart'][$product_id]);
        } else {
            // Go through each prodid/quantity pair in $_SESSION['cart'] array
            // and make its quantity equal to the corresponding value in $_GET array.
            $_SESSION['cart'][$product_id] = $_GET[$product_id];
        }
    }
    echo '<h3>Arrived from Save Button</h3>';
    display_cart();
    display_footerButtons();

}

//// if $_SESSION['cart'] array exists and is not empty, calculate totals.
//if ( (isset ($_SESSION['cart'])) &&
//    (count($_SESSION['cart']) > 0) )  {
//    $_SESSION['total_price']=calc_total_price();
//    $_SESSION['total_items']=calc_total_items();
//}
?>
