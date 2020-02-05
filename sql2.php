<?php
//-------------------------------------------------------------------------------------//
///////////////////// connect to MySQL, create and select DB ///////////////////////////

$con = new mysqli ('localhost', 'root');
if ($con->connect_error) { // check for connection errors
    die ('Connect Error (' . $con->connect_errno . ') ' . $con->connect_error . '<br />');
} else {
    echo 'Connection to MySQL successful: ' . $con->host_info . '<br />';
}
// Create database only if not exists
$db = 'shopping_cart';
$sql_create_db = "CREATE DATABASE IF NOT EXISTS " . $db;

if ($con->query($sql_create_db)) { // check for db errors
    echo 'Database ' . $db . ' is ready for use<br />';
} else {
    echo 'Error creating database ' . $db . '. Errno ' . $con->errno . ': ' . $con->error . '<br />';
    exit ();
}

// select db
$con->select_db($db);

if ($con->errno) { // check for select errors
    echo 'Error selecting database ' . $db . '. Errno ' . $con->errno . ': ' . $con->error . '<br />';
    exit ();
} else {
    echo 'Database ' . $db . ' selected <br />';
}
//-------------------------------------------------------------------------------------//
////////////// functions to connect db, check sql insert and populate tables ///////////////////////////

function connect_db($db)
{
    $con = new mysqli('localhost', 'root', '', $db);
    if ($con->connect_error) { //check for connection errors
        die('Connect Error (' . $con->connect_errno . ') '  . $con->connect_error . '<br />');
    }//else {
    	//print 'Connection to MySQL successful: ' . $con->host_info .'<br />';
    //}
    return $con;
}

function checkCreateTb($query, $table)
{
   // echo '<br /><br /><br />$table is ' . $table . '<br />';
    //echo '$query is ';
    //print_r($query);
   // echo '<br />';

    $con = connect_db('shopping_cart');

    if ($con->query($query)) { // check for table errors
        echo 'Table ' . $table . ' is ready for use<br />';
    } else {
        echo 'Error creating table ' . $table . '. Errno ' . $con->errno . ': ' . $con->error . '<br />';
        exit ();
    }
}

function checkInsert($query, $table)
{
//    echo '<br>$table is ' . $table . '<br />';
//    echo '$query is ';
//    print_r($query);
//    echo '<br />';

    $con = connect_db('shopping_cart');

    if ($con->query($query)) {
        echo 'Data in table ' . $table . ' is ready for use<br />';
    } else {
        echo 'Error inserting values into table ' . $table . '. Errno ' . $con->errno . ': ' . $con->error . '<br />';
        exit ();
    }
}

//-------------------------------------------------------------------------------------------//
///////////////////////////Create and populate table categories if not exists//////////////////

$table1 = 'categories';
$sql_create_table1 = "CREATE TABLE IF NOT EXISTS " . $table1 .
    " (
		category_id INT(50) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
		category_name VARCHAR(200) NOT NULL UNIQUE
	)";
checkCreateTb($sql_create_table1, $table1);

$sql_insert1 = "INSERT IGNORE INTO " . $table1 .

    "
        (category_id, category_name) VALUES
		('','Desktop'),
		('','Laptop'),
		('','Tablet')
	";

checkInsert($sql_insert1, $table1);

//---------------------------------------------------------------------------------------------------------//
//////////////////////////// Create and populate table products if not exists //////////////////////////////

$table2 = 'products';
$sql_create_table2 = "CREATE TABLE IF NOT EXISTS " . $table2 .
    " (
		product_id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
		category_id INT(50) UNSIGNED NOT NULL,
		product_name VARCHAR(50) NOT NULL UNIQUE,
		product_price FLOAT (8,2) NOT NULL,
		product_description VARCHAR(1500) NOT NULL,
		inventory INT(5) UNSIGNED NOT NULL
	)";

checkCreateTb($sql_create_table2, $table2);

// Insert values into table products
// Check by unique column name if these table rows already exist

$sql_insert2 = "INSERT IGNORE INTO " . $table2 .
    "
        (product_id, category_id, product_name, product_price, product_description, inventory) VALUES
		('', 1, 'HP-ENVY-700', 755.99, 'AMD Elite Quad-Core A10-6700 Accelerated Processor', 7),
		('', 3, 'Samsung GALAXY Tab 3', 249.99, 'Android Jelly Bean 4.1 OS Dual-Core Processor 1.2', 1),
		('', 2, 'Toshiba Satellite C55-A5310', 419.99, 'Intel? Core? i3-3120M Processor 2.8 GHz, 6GB DDR3', 2),
		('', 1, 'Asus-M51AD-US001S', 969.99, 'Intel? Core? i7-4770 Processor 3.4 GHz(4 MB cache)', 2)
	";

checkInsert($sql_insert2, $table2);
//---------------------------------------------------------------------------------------------------------//
//////////////////////////// Create and populate table customers if not exists //////////////////////////////

$table3 = 'customers';
$sql_create_table3 = "CREATE TABLE IF NOT EXISTS " . $table3 .
    " (
		customer_id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
		customer_name VARCHAR(50) NOT NULL UNIQUE,
		customer_address VARCHAR(300) NOT NULL,
		customer_unit_number VARCHAR(25),
		customer_city VARCHAR(50) NOT NULL,
		customer_state VARCHAR(25) NOT NULL,
		customer_zip INT(5) UNSIGNED NOT NULL,
		customer_country VARCHAR(50) NOT NULL
	)";
checkCreateTb($sql_create_table3, $table3);

// Insert values into table customers
// Check by unique column name if these table rows already exist

$sql_insert3 = "INSERT IGNORE INTO " . $table3 .
    "
        (customer_id, customer_name, customer_address, customer_unit_number, customer_city, customer_state, customer_zip, customer_country) VALUES
		('','Albert Adams','1 A Street', 1, 'Antoich', 'CA', 94531, 'USA'),
		('','Brian Brown','2 Bone Drive', 2, 'Brentwood', 'CA', 94513, 'USA'),
		('','Cynthia Clark','3 Concord Avenue', 3,  'Concord', 'CA', 94520, 'USA'),
		('','Donna Davis','4 Dracula Court', 4, 'Davis', 'CA', 95218, 'USA')
	";

checkInsert($sql_insert3, $table3);

//---------------------------------------------------------------------------------------------------------//
//////////////////////////// Create and populate table orders if not exists //////////////////////////////

$table4 = 'orders';
$sql_create_table4 = "CREATE TABLE IF NOT EXISTS " . $table4 .
    "(
		order_id INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
		customer_id INT(10) UNSIGNED NOT NULL UNIQUE,
		shipping_name VARCHAR(50) NOT NULL UNIQUE,
		shipping_type VARCHAR(50) NOT NULL,
		shipping_cost FLOAT (4,2) NOT NULL,
		order_date DATETIME(6),
		order_status VARCHAR(25) NOT NULL,
		shipping_address VARCHAR(500) NOT NULL,
		shipping_unit_number VARCHAR(25),
		shipping_city VARCHAR(50) NOT NULL,
		shipping_state VARCHAR(25) NOT NULL,
		shipping_zip INT(5) NOT NULL,
		shipping_country VARCHAR(50) NOT NULL

	)";
checkCreateTb($sql_create_table4, $table4);

// Insert values into table orders
// Check by unique column name if these table rows already exist

$sql_insert4 = "INSERT IGNORE INTO " . $table4 .
    "
        (order_id, customer_id, shipping_name, shipping_type, shipping_cost, order_date, order_status,
        shipping_address, shipping_unit_number, shipping_city, shipping_state, shipping_zip,
        shipping_country) VALUES

		('', 1, 'Albert Adams','regular', 24.22, CURRENT_TIMESTAMP, 'shipped', '1 A Street', 1,
		'Antoich', 'CA', 94531, 'USA'),
		('', 2, 'Brian Brown', 'regular', 18.59, CURRENT_TIMESTAMP, 'processing order', '2 Bone Drive', 2,
		'Brentwood', 'CA', 94513, 'USA'),
		('', 3, 'Cynthia Clark', 'expedite', 23.33, CURRENT_TIMESTAMP, 'delivered', '3 Concord Avenue', 3,
		 'Concord', 'CA', 94520, 'USA'),
		('', 4, 'Donna Davis',  'expedite', 230.588, CURRENT_TIMESTAMP, 'shipped', '4 Dracula Court', 4,
		'Davis', 'CA', 95218, 'USA')
	";

checkInsert($sql_insert4, $table4);

//---------------------------------------------------------------------------------------------------------//
//////////////////////////// Create and populate table orderitems if not exists //////////////////////////////

$table5 = 'order_items';
$sql_create_table5 = "CREATE TABLE IF NOT EXISTS " . $table5 .
    "(
		order_id INT(10) UNSIGNED NOT NULL UNIQUE,
		customer_id INT(10) UNSIGNED NOT NULL,
		product_id INT(10) UNSIGNED NOT NULL,
		product_price FLOAT (8,2) NOT NULL,
		product_quantity INT(100) UNSIGNED NOT NULL,
		PRIMARY KEY (customer_id, product_id)

	)";
checkCreateTb($sql_create_table5, $table5);

// Insert values into table orders
// Check by unique column name if these table rows already exist

$sql_insert5 = "INSERT IGNORE INTO " . $table5 .
    "
        (order_id, customer_id, product_id, product_price, product_quantity) VALUES
		(1, 1, 1,  755.99 , 1),
		(2, 2, 2,  249.99 , 2),
		(3, 3, 3,  419.99, 3),
		(4, 4, 4, 969.99, 4)
	";

checkInsert($sql_insert5, $table5);

?>
