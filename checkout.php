<?php
    //will be invoked when user selects Go to Checkout from the Cart screen.
    //It will display the Checkout screen.

    session_start();

    require_once 'functions.php';

    echo '<h1>Checkout Screen</h1>';
    display_cart();
?>

<form name="customerInfo" class="blueform" action="process_checkout.php" method="POST" ">
<!--<input type="hidden" name="state" value="fromCheckout">-->

<fieldset>
    <legend>Customer Info</legend>
    <label for="customer_name">Name: </label>
    <input type="text" name="customer_name" id="customer_name" autofocus autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_name'); ?>"
           placeholder="Your First and Last Name" required/><br/>

    <label for="customer_address">Street Address: </label>
    <input type="text" name="customer_address" id="customer_address" autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_address'); ?>"
           placeholder="Your Street Address" required/><br/>

    <label for="customer_unit">Apt or Unit Number: </label>
    <input type="text" name="customer_unit" id="customer_unit" autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_unit'); ?>"
           placeholder="Your Apartment or Unit Number"/><br/>

    <label for="customer_city">City: </label>
    <input type="text" name="customer_city" id="customer_city" autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_city'); ?>"
           placeholder="Your City" required/><br/>

    <label for="customer_state">State: </label>
    <input type="text" name="customer_state" id="customer_state" autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_state'); ?>"
           placeholder="Your State" required/><br/>

    <label for="customer_zip">Zip Code or Postal Code: </label>
    <input type="text" name="customer_zip" id="customer_zip" autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_zip'); ?>"
           placeholder="Your Zip Code" required/><br/>

    <label for="customer_country">Country: </label>
    <input type="text" name="customer_country" id="customer_country" autocomplete="on"
           value="<?php echo extractCustomerPost_putIntoSession('customer_country'); ?>"
           placeholder="Your Country" required/><br/>
</fieldset>


<fieldset>
    <legend>Shipping Info</legend>

    <label>Check if same as above:
        <input type='checkbox' onclick="insert_shippingDetails()" style="width: 20px; vertical-align: -60%;"
               class="inlineInput"/><br/><br/>
    </label>

    <label for="shipping_name">Name: </label>
    <input type="text" name="shipping_name" id="shipping_name" autocomplete="on" required
           placeholder="First and Last Name"/><br/>

    <label for="shipping_address">Street Address: </label>
    <input type="text" name="shipping_address" id="shipping_address" autocomplete="on" required
           placeholder="Street Address"/><br/>

    <label for="shipping_unit">Apt or Unit Number: </label>
    <input type="text" name="shipping_unit" id="shipping_unit" autocomplete="on"
           placeholder="Apartment or Unit Number"/><br/>

    <label for="shipping_city">City: </label>
    <input type="text" name="shipping_city" id="shipping_city" autocomplete="on" required
           placeholder="City"/><br/>

    <label for="shipping_state">State: </label>
    <input type="text" name="shipping_state" id="shipping_state" autocomplete="on" required
           placeholder="State"/><br/>

    <label for="shipping_zip">Zip Code or Postal Code: </label>
    <input type="text" name="shipping_zip" id="shipping_zip" autocomplete="on" required
           placeholder="Zip Code or Postal Code"/><br/>

    <label for="shipping_country">Country: </label>
    <input type="text" name="shipping_country" id="shipping_country" autocomplete="on" required
           placeholder="Country"/><br/>
</fieldset>

<fieldset>
    <legend>Credit Card Info</legend>
    <label>
        Card Type:
        <select name="card_type">
            <option value="visa">Visa</option>
            <option value="master_card">Master Card</option>
            <option value="amex" selected>American Express</option>
        </select>
    </label> <br/>
    <label>
        Card Number:
        <input type="text" name="card_number" id="card_number" placeholder="999-99-999"  required/><br/>
    </label>
    <label>
        Security Code (On the back of the card):
        <input type="text" name="card_code" id="card_code" placeholder="666"  required/><br/>
    </label>
    <label>
        Expiration Date:&NonBreakingSpace;&NonBreakingSpace;
        <select name="card_exp_month" style="width: 110px;" class="inlineInput">
            <option value="01">01 (January)</option>
            <option value="02">02 (February)</option>
            <option value="03" selected>03 (March)</option>
        </select>&NonBreakingSpace; Month &NonBreakingSpace;
        <select name="card_exp_year" style="width: 100px;" class="inlineInput">
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015" selected>2015</option>
        </select> &NonBreakingSpace; Year
    </label><br/><br/>
    <label>
        Name on Card:
        <input type="text" name="card_name" id="card_name" placeholder="Name on Card"  required/><br/>
    </label>
</fieldset><br />
<input type="submit" name="process_checkout" value="Process Checkout"/>
</form>

<?php
    display_button('cancel.php', 'cancel', 'Cancel Order');
?>

