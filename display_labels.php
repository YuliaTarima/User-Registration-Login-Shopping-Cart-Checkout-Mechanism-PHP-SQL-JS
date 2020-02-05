<?php
    //will be executed via a browser using URL printlabels.php.
    //It will display billing and shipping labels.
    //A billing label will include customer address followed by a detailed invoice (i.e. a bill).
    //A shipping label will include a shipping address followed by a detailed list of items shipped

    session_start();

    require_once 'functions.php';

    echo '<h1>Billing and Shipping Labels Screen</h1>';

    display_BillingLabels();
    display_ShippingLabels();
    display_button('logout.php', 'logout', 'Logout');

?>
