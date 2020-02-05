<?php
    require_once 'sql.php';

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------------------------------  Display -----------------------------------------------------//

    echo '<b>Session is</b> ';
    print_r($_SESSION);
    echo '<br />';

    echo '<b>Cookie is</b> ';
    print_r($_COOKIE);
    echo '<br />';

    if (isset($_GET)) {
        echo '<b>Get is</b> ';
        print_r($_GET);
        echo '<br />';
    }
    if (isset($_POST)) {
        echo '<b>Post is</b> ';
        print_r($_POST);
        echo '<br />';
    }
    if (isset ($_SESSION['cart'])) {
        echo '<b>Cart is</b> ';
        print_r($_SESSION['cart']);
        echo '<br />';
    }
    if (isset($_SESSION['total_price'])) {
        echo '<b>Total price is</b> ';
        print_r($_SESSION['total_price']);
        echo '<br />';
    }
    if (isset ($_SESSION['total_items'])) {
        echo '<b>Total items is</b> ';
        print_r($_SESSION['total_items']);
        echo '<br />';
    }
    if (isset($_SESSION['shipping_cost'])) {
        echo '<b>Shipping Cost is</b> ';
        print_r($_SESSION['shipping_cost']);
        echo '<br />';
    }
    if (isset ($_SESSION['total_with_shipping'])) {
        echo '<b>Total with Shipping is</b> ';
        print_r($_SESSION['total_with_shipping']);
        echo '<br />';
    }
    if (isset ($_SESSION['customer'])) {
        echo '<b>Session Customer is</b> ';
        print_r($_SESSION['customer']);
        echo '<br />';
    }
    if (isset ($_SESSION['shipping'])) {
        echo '<b>Session Shipping is</b> ';
        print_r($_SESSION['shipping']);
        echo '<br />';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //--------------------------------------------  Buttons----------------------------------------------------//

    function display_button($url, $name, $value)
    {
        print <<< HTML
	<form action=$url>
		<input type='submit' name=$name value='$value'>
	</form>
HTML;
    }

    function display_button_withid($url, $name, $value, $id)
    {
        print <<< HTML
	<form action=$url>
		<input type='hidden' name='id' value=$id>
		<input type='submit' name=$name value='$value'>
	</form>
HTML;
    }

    //display a hyper link
    function display_link($url, $title)
    {
        print <<< HTML
	<a href='$url'>$title</a><br>
HTML;
    }

    //__________________________________________________________________________________________________________//
    // display View Cart and Modify Cart Quantities button
    // optionally display totals in the header
    function display_header()
    {
        display_button('show_cart.php', 'view', 'View Cart');
        display_button('show_cart.php', 'modify', 'Modify Cart Quantities');

        //optionally display totals here
    }

    function display_footerButtons()
    {
        display_button('index.php', 'continue', 'Continue Shopping');
        display_button('checkout.php', 'checkout', 'Go to Checkout');
    }

    //--------------------------------------------------------------------------------------------------------///
    ////////////////////////////////////////// SQL //////////////////////////////////////////////////////////////
    function check_preparedResult($object, $result)
    {
        //echo 'check_preparedResult Object is: ';
        //print_r($object);
        if ($result === false) {
            print($result . 'Failed: ' . htmlspecialchars($object->errno) . htmlspecialchars($object->error));
            exit;
        }
    }

    //list all the categories
    //accesses the database and gets every catid and catname from the table
    //displays each catname as a link with catid as its query string
    function display_category_list()
    {
        $con = connect_db('shopping_cart'); //connect to db

        $sql = "SELECT  category_id, category_name FROM categories";
        $stmt = $con->prepare($sql);
        check_preparedResult($con, $stmt); //check prepare errors

        $check = $stmt->execute();
        check_preparedResult($stmt, $check); //check execute errors

        $check = $stmt->bind_result($category_id, $category_name);
        check_preparedResult($stmt, $check); //check bind result errors

        echo '<h2>Choose from the Categories Below</h2>';
        echo '<ul>';
        while ($stmt->fetch()) {
            $url = 'prod_list.php?category_id=' . $category_id;
            $title = $category_name;
            echo '<li>';
            display_link($url, $title);
            echo '</li>';
        }
        echo '</ul>';
    }

    function display_prod_list($category_id)
    {
        $con = connect_db('shopping_cart'); //connect to db

        $sql = "SELECT product_id, product_name FROM products WHERE category_id=?";
        $stmt = $con->prepare($sql);
        check_preparedResult($con, $stmt);

        $check = $stmt->bind_param('i', $category_id);
        check_preparedResult($stmt, $check);

        $check = $stmt->execute();
        check_preparedResult($stmt, $check);

        $check = $stmt->bind_result($product_id, $product_name);
        check_preparedResult($stmt, $check);

        echo '<h2>Choose from the Products Below</h2>';
        echo '<ul>';
        while ($stmt->fetch()) {
            $url = 'prod_detail.php?product_id=' . $product_id;
            $title = "$product_name";
            echo '<li>';
            display_link($url, $title);
            echo '</li>';
        }
        echo '</ul>';
    }

    function display_prod_detail($product_id)
    {
        $con = connect_db('shopping_cart'); //connect to db

        $sql = "SELECT product_name, product_price, product_description FROM products WHERE product_id=?";
        $stmt = $con->prepare($sql);
        check_preparedResult($con, $stmt);

        $check = $stmt->bind_param('i', $product_id);
        check_preparedResult($stmt, $check);

        $check = $stmt->execute();
        check_preparedResult($stmt, $check);

        $check = $stmt->bind_result($product_name, $product_price, $product_description);
        check_preparedResult($stmt, $check);

        echo '<h2>Selected Product Details</h2>';
        while ($stmt->fetch()) {
            //echo 'product id is ' . $product_id;
            echo <<< HTML
            <p>
                Product Name: $product_name <br />
                Product Price: $product_price <br />
                Product Description: $product_description
            </p>
HTML;
        }
    }

    function get_product_values($product_id)
    {
//This method access the database
//It obtains different field values of a product.
//It puts them in an array as name/value pairs.
//Then returns the array.

        //{
            $con = connect_db('shopping_cart');

            $sql = "SELECT product_name, product_price, product_description FROM products WHERE product_id=?";
            $stmt = $con->prepare($sql);
            check_preparedResult($con, $stmt);

            $check = $stmt->bind_param('i', $product_id);
            check_preparedResult($stmt, $check);

            $check = $stmt->execute();
            check_preparedResult($stmt, $check);

            $check = $stmt->bind_result($product_name, $product_price, $product_description);
            check_preparedResult($stmt, $check);

            while ($stmt->fetch()) {
                $product_values['product_name'] = $product_name;
                $product_values['product_price'] = $product_price;
                $product_values['product_description'] = $product_description;

            }
            //echo '<h3>get_product_values is </h3>'; print_r($product_values); echo '<br />';
            return $product_values;

       // }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    function checkReturn_preparedResult($object, $result)
    {
        //echo 'check_preparedResult Object is: ';
        //print_r($object);
        if ($result === false) {
            print($result . 'Failed: ' . htmlspecialchars($object->errno) . htmlspecialchars($object->error));
            return -1;
        }
    }


    function insert_customer(){
        $con = connect_db('shopping_cart');

        if (isset($_SESSION['customer'])){
            $customer_name = $_SESSION['customer']['customer_name'];
            $customer_address = $_SESSION['customer']['customer_address'];
            $customer_unit = $_SESSION['customer']['customer_unit'];
            $customer_city = $_SESSION['customer']['customer_city'];
            $customer_state = $_SESSION['customer']['customer_state'];
            $customer_zip = $_SESSION['customer']['customer_zip'];
            $customer_country = $_SESSION['customer']['customer_country'];



            $sql="INSERT INTO shopping_cart.customers
                (
                    customer_id,
                    customer_name,
                    customer_address,
                    customer_unit_number,
                    customer_city,
                    customer_state,
                    customer_zip,
                    customer_country
                )
                VALUES (NULL,?,?,?,?,?,?,?)";

            $stmt = $con -> prepare($sql);
            checkReturn_preparedResult($con, $stmt);

            $check = $stmt -> bind_param
                (
                    'sssssss',
                    $customer_name,
                    $customer_address,
                    $customer_unit,
                    $customer_city,
                    $customer_state,
                    $customer_zip,
                    $customer_country
                );
            checkReturn_preparedResult($stmt, $check);

            $check = $stmt->execute();
            checkReturn_preparedResult($stmt, $check);

            $affected_rows = $stmt -> affected_rows;
            echo "Insert Customer affected rows: $affected_rows <br />";

            //return custid
            $_SESSION['customer']['customer_id'] = $customer_id = $stmt -> insert_id;
            //print $customer_id;
            return $customer_id;

        } else {
            echo "Error inserting Customer: Session Variable missing<br />";
            return -1;
        }
    }

    function insert_order(){

        $con = connect_db('shopping_cart');

        if (isset($_SESSION['shipping'])
            && isset($_SESSION['shipping']['shipping_type'])
            && isset($_SESSION['shipping_cost'])
            && isset($_SESSION['customer']['customer_id'])
        ){
            $shipping_name = $_SESSION['shipping']['shipping_name'];
            $shipping_address = $_SESSION['shipping']['shipping_address'];
            $shipping_unit = $_SESSION['shipping']['shipping_unit'];
            $shipping_city = $_SESSION['shipping']['shipping_city'];
            $shipping_state = $_SESSION['shipping']['shipping_state'];
            $shipping_zip = $_SESSION['shipping']['shipping_zip'];
            $shipping_country = $_SESSION['shipping']['shipping_country'];
            $shipping_type = $_SESSION['shipping']['shipping_type'];
            $shipping_cost =$_SESSION['shipping_cost'];
            $order_status = 'processed';
            $customer_id = $_SESSION['customer']['customer_id'];
            $order_date = date("Y-m-d H:i:s");

            $sql = "INSERT INTO shopping_cart.orders
            (
                 order_id,
                 customer_id,
                 shipping_name,
                 shipping_type,
                 shipping_cost,
                 order_date,
                 order_status,
                 shipping_address,
                 shipping_unit_number,
                 shipping_city,
                 shipping_state,
                 shipping_zip,
                 shipping_country
             ) VALUES (NULL,?,?,?,?,?,?,?,?,?,?,?,?)";

            $stmt = $con -> prepare($sql);
            checkReturn_preparedResult($con, $stmt);

            $check = $stmt -> bind_param
                ('issdssssssis',
                    $customer_id,
                    $shipping_name,
                    $shipping_type,
                    $shipping_cost,
                    $order_date,
                    $order_status,
                    $shipping_address,
                    $shipping_unit,
                    $shipping_city,
                    $shipping_state,
                    $shipping_zip,
                    $shipping_country
                );
            checkReturn_preparedResult($stmt, $check);

            $check = $stmt->execute();
            checkReturn_preparedResult($stmt, $check);

            $affected_rows = $stmt -> affected_rows;
            print "Insert orders affected rows: $affected_rows <br />";
            $_SESSION['order_id'] = $order_id = $stmt -> insert_id;
            //print $customer_id;
            return $order_id;

        } else {
            print "Error inserting order: Session Variable missing<br />";
            return -1;
        }
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------------------------------Display Cart----------------------------------------------------//

    function display_cart()
    {
        //if cart is empty, tell the user
        if ((!isset ($_SESSION['cart'])) || ((count($_SESSION['cart'])) == 0)) {
            Echo '<h3>Your Cart is Empty</h3>';
        } else {
            // If Cart is not empty display its contents in a table within a form.
            // Display prodid, name, unit price, quantity, total value etc.
            // as a row in the table.
            display_cartHeader();
            display_cartRow();
        }
    }

    function display_cartHeader()
    {
        echo "<h3>Products in Your Cart</h2>
    <form action='show_cart.php' >

		<table border='1' class='centered'>
		<tr>
            <th>Product Id</th>
            <th>Product Name</th>
            <th>Product Price</th>
            <th>Quantity</th>
            <th>Product Total</th>
        </tr>";
    }

    function displayCartQantity_checkIfModify($product_id, $quantity)
    {
        //if "Modify Cart Quantities" button is selected, display quantity in text field
        if (isset($_GET['modify'])) {
            echo "<td><input type='text' name='$product_id'  value='$quantity' style='width: 50px;'></td>";
            //Otherwise, display it normally.
        } else {
            echo "<td>$quantity</td>";
        }
    }

    function displayTotal_PriceCount()
    {
        //if $_SESSION['cart'] array exits and is not empty, calculate totals.
        if ((isset ($_SESSION['cart'])) && (count($_SESSION['cart']) > 0)) {
            $total_price = $_SESSION['total_price'] = calc_total_price();
            $total_items = $_SESSION['total_items'] = calc_total_items();
            echo "
                <tr> <td colspan='3'><strong>Totals</strong></td>
                     <td>$total_items</td>
                     <td>$total_price</td>
                </tr>
            ";
        }
    }

    function display_ShippingTotal()
    {
        if (isset($_SESSION['shipping']['shipping_type'])) {
            $shipping_cost = $_SESSION['shipping_cost'] = calc_shipping_cost();
            $total_with_shipping = $_SESSION['total_with_shipping'] = calc_total_with_shipping();
            echo "
                            <tr>
                                <td colspan='4'><strong>Shipping Cost</strong></td>
                                <td>$shipping_cost</td>
                            </tr>
                            <tr>
                                <td colspan='4'><strong>Total With Shipping Cost</strong></td>
                                <td>$total_with_shipping </td>
                            </tr>
            ";
        }
    }

    function display_cartRow()
    {
        //For each prodid/quantity pair in $_SESSION['cart'] array,
        // call get_prod_values() method and pass it prodid.
        // The method will return an array prod_values containing values
        // obtained from the database. The prod_values array will
        // contain product name and unit price etc for the product.

        $cart = $_SESSION['cart'];
        foreach ($cart as $product_id => $quantity) {
            //obtain product values in an associative array
            $product_values = get_product_values($product_id);

            if ($product_values) {
                $product_name = $product_values['product_name'];
                $product_price = $product_values['product_price'];
                $total_value = $quantity * $product_price;

                echo "
                    <tr>
                        <td>$product_id</td>
                        <td>$product_name</td>
                        <td>$product_price</td>
            ";

                //<td>$quantity</td>
                displayCartQantity_checkIfModify($product_id, $quantity);

                echo "      <td>$total_value</td>
                   </tr>
            ";
            }
        } //end foreach
        displayTotal_PriceCount();
        display_ShippingTotal();

        echo "</table><br/> <br/>"; //close table

        //if "Modify Cart Quantities" button is selected, display Save Quantity Button
        if (isset($_GET['modify'])) {
            display_button('show_cart.php', 'save', 'Save Cart Quantities');
        }
        echo "</form>"; //close form
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //-------------------------------------------  Calculate Totals  ------------------------------------------------//
    // calc_total_items();
    //calc_total_price();

    function calc_total_price()
    {
        //compute total customer payment here
        //pre: call when cart is not empty
        $total = 0;
        if ((isset ($_SESSION['cart'])) && (count($_SESSION['cart']) > 0)) {

            $cart = $_SESSION['cart'];
            foreach ($cart as $product_id => $quantity) {
                $product_values = get_product_values($product_id);
                $total += ($product_values['product_price'] * $quantity);
            }
        }
        // $_SESSION['total_price'] = $total;
        return $total;
    }

    function calc_total_items()
    {
        //compute total number of items in cart here
        //pre: call when cart is not empty
        $count = 0;
        if ((isset ($_SESSION['cart'])) && (count($_SESSION['cart']) > 0)) {

            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                $count += $quantity;
            }
        }
        //$_SESSION['total_items'] = $count;
        return $count;
    }


    function calc_shipping_cost()
    {
        //pre: call when $_SESSION['shippingtype'] is set
        $SHIPEXPEDITE = 20;
        $SHIPREGULAR = 10;
        $total = 0;
        if ((isset ($_SESSION['shipping']['shipping_type'])) && (count($_SESSION['shipping']['shipping_type']) > 0)) {
            $shipping_type = $_SESSION['shipping']['shipping_type'];
            if ($shipping_type == 'expedite') {
                return $SHIPEXPEDITE;
            } else {
                return $SHIPREGULAR;
            }
        }
        return $total;
    }

    function calc_total_with_shipping()
    {
        //pre: call when $_SESSION['shippingtype'] is set
        $SHIPEXPEDITE = 20;
        $SHIPREGULAR = 10;
        $total = 0;
        if ((isset ($_SESSION['shipping']['shipping_type'])) && (count($_SESSION['shipping']['shipping_type']) > 0)) {
            $shipping_type = $_SESSION['shipping']['shipping_type'];
            if ($shipping_type == 'expedite') {
                $total = calc_total_price() + $SHIPEXPEDITE;
            } else {
                $total = calc_total_price() + $SHIPREGULAR;
            }
        }
        return $total;
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //------------------------------------- Display Shipping and Billing Labels -------------------------------------//
    function display_BillingLabels()
    {
        if (isset($_SESSION['customer'])){
            echo "<div class='labels'>";
                echo '<h3>BILLING LABELS</h3>
                <strong>Billing name: </strong>' . $_SESSION['customer']['customer_name'] . ' <br />
                <strong>Billing address: </strong>' . $_SESSION['customer']['customer_address'] . ' <br />
                <strong>Billing unit or Apt. Number: </strong>' . $_SESSION['customer']['customer_unit'] . ' <br />
                <strong>Billing city: </strong>' . $_SESSION['customer']['customer_city'] . ' <br />
                <strong>Billing sate: </strong>' . $_SESSION['customer']['customer_state'] . ' <br />
                <strong>Billing zip: </strong>' . $_SESSION['customer']['customer_zip'] . ' <br />
                <strong>Billing country: </strong>' . $_SESSION['customer']['customer_country'] . ' <br />
            </div>';

        } else {
            echo 'Session Variable for Billing Labels Missing<br />';
        }

        displayHeader_billingShipping();
        displayLabels_row();
    }

    function display_ShippingLabels()
    {
        if (isset($_SESSION['customer'])){
            echo "<div class='labels'>";
            echo '<h3>SHIPPING LABELS</h3>
                <strong>Shipping name: </strong>' . $_SESSION['customer']['customer_name'] . ' <br />
                <strong>Shipping address: </strong>' . $_SESSION['customer']['customer_address'] . ' <br />
                <strong>Shipping unit or Apt. Number: </strong>' . $_SESSION['customer']['customer_unit'] . ' <br />
                <strong>Shipping city: </strong>' . $_SESSION['customer']['customer_city'] . ' <br />
                <strong>Shipping sate: </strong>' . $_SESSION['customer']['customer_state'] . ' <br />
                <strong>Shipping zip: </strong>' . $_SESSION['customer']['customer_zip'] . ' <br />
                <strong>Shipping country: </strong>' . $_SESSION['customer']['customer_country'] . ' <br />
            </div>';

        } else {
            echo 'Session Variable for Billing Labels Missing<br />';
        }

        displayHeader_billingShipping();
        displayLabels_row();
    }

    function displayHeader_billingShipping(){
        echo "<table border='1' class='centered'>
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>";
    }

    function displayLabels_row()
    {
        $cart = $_SESSION['cart'];
        foreach ($cart as $product_id => $quantity) {
            //obtain product values in an associative array
            $product_values = get_product_values($product_id);

            if ($product_values) {
                $product_name = $product_values['product_name'];
                $product_price = $product_values['product_price'];
                $product_description = $product_values['product_description'];
                $total_value = $quantity * $product_price;

                echo "
                    <tr>
                        <td>$product_id</td>
                        <td>$product_name</td>
                        <td>$product_description</td>
                        <td>$product_price</td>
                        <td>$quantity</td>
                        <td>$total_value</td>
                    </tr>
            ";
            }
        } //end foreach
        displayTotal_BillingShipping();
        displayLabels_ShippingTotal();

        echo '</table><br/> <br/>'; //close table
    }

    function displayTotal_BillingShipping()
    {
        //if $_SESSION['cart'] array exits and is not empty, calculate totals.
        if ((isset ($_SESSION['cart'])) && (count($_SESSION['cart']) > 0)) {
            $total_price = $_SESSION['total_price'] = calc_total_price();
            $total_items = $_SESSION['total_items'] = calc_total_items();
            echo "
                <tr> <td colspan='4'><strong>Totals</strong></td>
                     <td>$total_items</td>
                     <td>$total_price</td>
                </tr>
            ";
        }
    }

    function displayLabels_ShippingTotal()
    {
        if (isset($_SESSION['shipping']['shipping_type'])) {
            $shipping_cost = $_SESSION['shipping_cost'] = calc_shipping_cost();
            $total_with_shipping = $_SESSION['total_with_shipping'] = calc_total_with_shipping();
            echo "
                            <tr>
                                <td colspan='5'><strong>Shipping Cost</strong></td>
                                <td>$shipping_cost</td>
                            </tr>
                            <tr>
                                <td colspan='5'><strong>Total With Shipping Cost</strong></td>
                                <td>$total_with_shipping </td>
                            </tr>
            ";
        }
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //---------------------------------------- Extract from POST and put into SESSION -----------------------------------//
    function extractCustomerPost_putIntoSession($customer_info) {
        if (isset($_POST[$customer_info])) {
            $_SESSION ['customer'][$customer_info] = $_POST[$customer_info];
        } else if (!isset($_SESSION ['customer'][$customer_info])) {
            return '';
        }
        return $_SESSION ['customer'][$customer_info];
    }
    function extractAllCustomerPost_putAllIntoSession() {
        extractCustomerPost_putIntoSession('customer_name');
        extractCustomerPost_putIntoSession('customer_address');
        extractCustomerPost_putIntoSession('customer_unit');
        extractCustomerPost_putIntoSession('customer_city');
        extractCustomerPost_putIntoSession('customer_state');
        extractCustomerPost_putIntoSession('customer_zip');
        extractCustomerPost_putIntoSession('customer_country');
    }

    function extractShippingPost_putIntoSession($shipping_info) {
        if (isset($_POST[$shipping_info])) {
            $result = $_SESSION ['shipping'][$shipping_info] = $_POST[$shipping_info];
        } else {
            $result = '';
        }
        return $result;
    }
    function extractAllShippingPost_putAllIntoSession() {
        extractShippingPost_putIntoSession('shipping_name');
        extractShippingPost_putIntoSession('shipping_address');
        extractShippingPost_putIntoSession('shipping_unit');
        extractShippingPost_putIntoSession('shipping_city');
        extractShippingPost_putIntoSession('shipping_state');
        extractShippingPost_putIntoSession('shipping_zip');
        extractShippingPost_putIntoSession('shipping_country');
//        extractShippingPost_putIntoSession('shipping_type');
    }
?>
<link rel="stylesheet" href="style.css">
<script src="js.js"></script>
