<?php
$meta_keywords = "";
$meta_desc = "";
$meta_title = "";
$meta_canonical_url = "";

//Get admin user data
$admin_user_data = get_admin_user_data();

//START inbuild page url/link
$sell_my_model_link = SITE_URL.get_inbuild_page_url('sell-my-model');
$contact_link = SITE_URL.get_inbuild_page_url('contact');
$signup_link = SITE_URL.get_inbuild_page_url('signup');
$login_link = SITE_URL.get_inbuild_page_url('login');
$reviews_link = SITE_URL.get_inbuild_page_url('reviews');
$review_form_link = SITE_URL.get_inbuild_page_url('review-form');
$lost_password_link = SITE_URL.get_inbuild_page_url('lost_password');
//END inbuild page url/link

$request_uri = $_SERVER['REQUEST_URI'];

$user_id = 0;
$user_full_name = '';
$user_first_name = '';
$user_last_name = '';
$user_email = '';
$user_phone = '';

if(isset($_SESSION[$session_front_user_id])) {
	$user_id = $_SESSION[$session_front_user_id];

	//Get user data based on userID
	$user_data = get_user_data($user_id);
	if(empty($user_data['id'])) {
		unset($_SESSION[$session_front_login_user]);
		unset($_SESSION[$session_front_user_id]);

		$user_data = get_user_data(0);
		$user_id = 0;
	}

	$user_full_name = $user_data['name'];
	$user_first_name = $user_data['first_name'];
	$user_last_name = $user_data['last_name'];
	$user_email = $user_data['email'];
	$user_phone = $user_data['phone'];
}

$guest_user_id = 0;
if(isset($_SESSION[$session_front_guest_user_id])) {
	$guest_user_id = $_SESSION[$session_front_guest_user_id];

	//Get user data based on guest userID
	$guest_user_data = get_user_data($guest_user_id);
	if(empty($guest_user_data['id'])) {
		unset($_SESSION[$session_front_login_user]);
		unset($_SESSION[$session_front_user_id]);

		$guest_user_data = get_user_data(0);
		$guest_user_id = 0;
	}
	
	$user_full_name = $guest_user_data['name'];
	$user_first_name = $guest_user_data['first_name'];
	$user_last_name = $guest_user_data['last_name'];
	$user_email = $guest_user_data['email'];
	$user_phone = $guest_user_data['phone'];
}

$order_id = '';
if(isset($_SESSION[$session_front_order_id])) {
	$order_id = $_SESSION[$session_front_order_id];

	//Get basket items data, count & sum of order
	$basket_item_count_sum_data = get_basket_item_count_sum($order_id);
}

$order_item_ids = array();
if(isset($_SESSION[$session_front_order_item_ids])) {
	$order_item_ids = $_SESSION[$session_front_order_item_ids];
}

//Get user data based on userID
$user_data = get_user_data($user_id);

//Get user data based on userID
$guest_user_data = get_user_data($guest_user_id);

//Get basket items data, count & sum of order
$basket_item_count_sum_data = get_basket_item_count_sum($order_id);
?>