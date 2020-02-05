<?php
//will be invoked as a startup page or when the user selects the Continue Shopping button from  any screen.

//will display the home page i.e. the Category List screen.

session_start();
require_once 'functions.php';

echo '<h1>Computer Store Home Page</h1>';
echo '<h2>Category List Screen</h2>';


display_header();
display_category_list();

display_button('logout.php', 'logout', 'Logout');
display_button('empty.php', 'empty', 'Empty');

?>
