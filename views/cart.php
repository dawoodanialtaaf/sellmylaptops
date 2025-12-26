<?php
$meta_title = "Review Order";

//Header section
include("include/header.php");

//Selected default payment method from model detail page
$select_payment_method = isset($_SESSION[$session_front_payment_method])?$_SESSION[$session_front_payment_method]:'';
if($select_payment_method!="") {
	$default_payment_option = $select_payment_method;
}

//Get order price based on orderID, path of this function (get_order_price) admin/_config/functions.php
$sum_of_orders=get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/_config/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = count($order_item_list);

//Get order batch data, path of this function (get_order_data) admin/_config/functions.php
$order_data = get_order_data($order_id);
$email_while_add_to_cart = $order_data['email_while_add_to_cart'];

$sell_page_link = SITE_URL.get_inbuild_page_url('sell');

//Review order section
if($order_num_of_rows>0) {
	//Include review order view
	require_once('views/cart/cart.php');
} 

//If your sales basket is empty section
else {
	//Include empty sales basket view
	require_once('views/cart/empty_basket.php');
} ?>
