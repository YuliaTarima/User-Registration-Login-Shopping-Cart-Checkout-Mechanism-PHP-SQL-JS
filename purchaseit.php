<?php
    //will be invoked when user selects Purchase It from the Process_Checkout screen.
    //It will display the Purchase It screen.

    session_start();

    require_once 'functions.php';
    extractShippingPost_putIntoSession('shipping_type');

    echo '<h1>Purchase It Screen</h1>';

    display_cart();

    display_button('place_order.php', 'place_order', 'Place Order');
    display_button('cancel.php', 'cancel', 'Cancel Order');
?>

