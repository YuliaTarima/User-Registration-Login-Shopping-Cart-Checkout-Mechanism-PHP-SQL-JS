<?php
//will be invoked when user selects Purchase from the Process_Checkout screen.
//It will display the Purchase screen.

    session_start();

    require_once 'functions.php';

    echo '<h1>Purchase Screen</h1>';
    display_cart();
?>
    <h2>Select Your Shipping Type</h2>
    <form name="shippingType" class="blueform" action="purchaseit.php" method="POST">
        <fieldset>
            <legend>Shipping Type</legend>
            <label>
                <input type='radio' name='shipping_type' value='regular' checked
                       style="width: 20px; vertical-align: -60%;" class="inlineInput"/> regular
            </label>
            <label>
                <input type='radio' name='shipping_type' value='expedite'
                       style="width: 20px; vertical-align: -60%;" class="inlineInput"/> expedite
            </label>

        </fieldset><br />
    <?php
        display_button('purchaseit.php', 'purchase_it', 'Purchase It');
        echo '</form>';
        display_button('cancel.php', 'cancel', 'Cancel Order');

?>
