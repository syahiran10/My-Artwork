<?php
// start session
session_start();
 
// connect to database
include 'config/database.php';
 
// include objects
include_once "objects/car-listing.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$product = new Product($db);
$product_image = new ProductImage($db);
 
// set page title
$page_title="Cart";
 
// include page header html
include 'layout_header.php';
 
// contents will be here 
 
// layout footer 
include 'layout_footer.php';
?>