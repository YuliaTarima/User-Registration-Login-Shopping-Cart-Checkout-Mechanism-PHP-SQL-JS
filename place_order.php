<?php
    //  will be invoked when the user selects Place Order from the Purchase It screen.
    // It will display the Order Placed screen.

    session_start();

    require_once 'functions.php';

    insert_customer();
    insert_order();

    echo '<h1>Order Placed Screen</h1>';

    echo '<h3>Your order has been placed</h3>
    It will be shipped according to your shipping selection.<br /><br />';

    display_button('index.php', 'continue', 'Continue Shopping');
    display_button('logout.php', 'logout', 'Logout');
    display_button('display_labels.php', 'labels', 'View Labels');

?>
