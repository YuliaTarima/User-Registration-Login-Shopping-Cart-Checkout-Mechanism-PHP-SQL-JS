<?php
    //will be invoked when user selects Process Checkout from the Checkout screen.
    //It will display the Process_Checkout screen.

    session_start();

    require_once 'functions.php';

    extractAllCustomerPost_putAllIntoSession();
    extractAllShippingPost_putAllIntoSession();

    echo '<h1>Process_Checkout Screen</h1>';
    display_cart();

    echo "<div class='textLeft'>";
    echo '<h2>Customer Info</h2>
        <strong>Name: </strong>' . extractCustomerPost_putIntoSession('customer_name') . '<br />
        <strong>Address:</strong>' . extractCustomerPost_putIntoSession('customer_address') . '<br />
        <strong>Apt or Unit Number: </strong>' . extractCustomerPost_putIntoSession('customer_unit') . '<br />
        <strong>Customer City: </strong> ' . extractCustomerPost_putIntoSession('customer_city') . '<br />
        <strong>Customer State: </strong> ' . extractCustomerPost_putIntoSession('customer_state') . '<br />
        <strong>Customer ZipCode:</strong> ' . extractCustomerPost_putIntoSession('customer_zip') . '<br />
        <strong>Customer Country:</strong> ' . extractCustomerPost_putIntoSession('customer_country') . '<br />

        <h2>Shipping Info</h2>
        <strong>Name: </strong>' . extractShippingPost_putIntoSession('shipping_name') . '<br />
        <strong>Address: </strong>' . extractShippingPost_putIntoSession('shipping_address') . '<br />
        <strong>Apt or Unit Number: </strong>' . extractShippingPost_putIntoSession('shipping_unit') . '<br />
        <strong>City: </strong>' . extractShippingPost_putIntoSession('shipping_city') . '<br />
        <strong>State: </strong>' . extractShippingPost_putIntoSession('shipping_state') . '<br />
        <strong>Zip Code: </strong>' . extractShippingPost_putIntoSession('shipping_zip') . '<br />
        <strong>Country: </strong>' . extractShippingPost_putIntoSession('shipping_country') . '<br />
<!--<strong>Shipping Type: </strong>' . extractShippingPost_putIntoSession('shipping_type') . '<br />-->


        <h2>Credit Card Info</h2>
        <strong>Credit Card Type: </strong>' . $_POST['card_type'] . '<br />
        <strong>Credit Card Number: </strong>' . $_POST['card_number'] . '<br />
        <strong>Credit Card CCV: </strong>' . $_POST['card_code'] . '<br />
        <strong>Credit Card expiration Month: </strong>' . $_POST['card_exp_month'] . '<br />
        <strong>Credit Card Expiration Year: </strong>' . $_POST['card_exp_year'] . '<br />
        <strong>Name on Credit Card: </strong>' . $_POST['card_name'] . '<br /><br />';

        display_button('purchase.php', 'purchase', 'Purchase');
        display_button('checkout.php', 'edit_cart', 'Backup for Editing');
        display_button('cancel.php', 'cancel', 'Cancel Order');

    echo '</div>'; //close textLeft
?>
