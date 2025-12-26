<?php
require_once("../../admin/_config/config.php");

$order_id = $_GET['order_id'];
$access_token = $_GET['access_token'];
if($access_token == "") {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/_config/functions.php
$order_detail = get_order_data($order_id, $email = "", $access_token);
if(empty($order_detail)) {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/_config/functions.php
$sum_of_orders = get_order_price($order_id);
$sell_order_total = ($sum_of_orders>0?$sum_of_orders:'');

$promocode_amt = 0;
$discount_amt_label = '';
if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	$discount_amt_label = _lang('promocode_text','emails');
	if($order_detail['discount_type']=="percentage") {
		$discount_amt_label = _lang('promocode_text','emails')." (".$order_detail['discount']._lang('discount_initial_quote_text','emails').")";
	}
}

$bonus_amount = 0;
$bonus_percentage = $order_detail['bonus_percentage'];
if($order_detail['bonus_amount']>0) {
	$bonus_amount = $order_detail['bonus_amount'];
}

$total = $sell_order_total;
if($promocode_amt>0 || $bonus_amount>0) {
	$total = ($sell_order_total+$promocode_amt+$bonus_amount);
}
 
$order_items_html_arr = array();
$order_items_html_arr['order_id'] = $order_id;
$order_items_html_arr['total'] = $total;
$order_items_html_arr['sell_order_total'] = $sell_order_total;
$order_items_html_arr['promocode_amt'] = $promocode_amt;
$order_items_html_arr['discount_amt_label'] = $discount_amt_label;
$order_items_html_arr['bonus_amount'] = $bonus_amount;
$order_items_html_arr['order_data'] = $order_detail;
$order_items_html_data = get_order_items_html($order_items_html_arr);
$order_items_html = $order_items_html_data['html'];
$order_pdf_items_html = $order_items_html_data['pdf_html'];
$order_d_info_arr = $order_items_html_data['device_info_arr'];

$admin_user_data = get_admin_user_data();

$html = <<<EOF
<!-- EXAMPLE OF CSS STYLE -->
<style>
table,td{
  margin:0;
  padding:0;
}
.small-text{
  font-size:10px;
  text-align:center;
}
.block{
  width:45%;
}
.block-border{
  border:1px dashed #ddd;
}
.title{
  font-size:20px;
  font-weight:bold;
}
.tbl-border-radius{
border-radius:10px;
}
</style>
EOF;

$patterns = array(
	'{$logo_path}',
	'{$pdf_logo}',
	'{$logo}',
	'{$admin_logo}',
	'{$admin_email}',
	'{$admin_username}',
	'{$admin_site_url}',
	'{$admin_panel_name}',
	'{$from_name}',
	'{$from_email}',
	'{$site_name}',
	'{$site_url}',
	'{$customer_fname}',
	'{$customer_lname}',
	'{$customer_fullname}',
	'{$customer_phone}',
	'{$customer_email}',
	'{$billing_address1}',
	'{$billing_house_number}',
	'{$billing_address2}',
	'{$billing_city}',
	'{$billing_state}',
	'{$customer_country}',
	'{$billing_postcode}',
	'{$order_id}',
	'{$order_code}',
	'{$order_payment_method}',
	'{$order_date}',
	'{$order_approved_date}',
	'{$order_expire_date}',
	'{$order_status}',
	'{$order_sales_pack}',
	'{$current_date_time}',
	'{$order_item_list}',
	'{$order_instruction}',
	'{$company_name}',
	'{$company_address}',
	'{$company_city}',
	'{$company_state}',
	'{$company_postcode}',
	'{$company_country}',
	'{$shipping_fname}',
	'{$shipping_lname}',
	'{$shipping_company_name}',
	'{$shipping_address1}',
	'{$shipping_house_number}',
	'{$shipping_address2}',
	'{$shipping_city}',
	'{$shipping_state}',
	'{$shipping_postcode}',
	'{$shipping_phone}',
	'{$order_expiring_days}',
	'{$order_expired_days}',
	'{$company_email}',
	'{$company_phone}',
	'{$order_barcode}');

$order_date = $order_detail['order_date'];
$approved_date = $order_detail['approved_date'];
$expire_date = $order_detail['expire_date'];
$replacements = array(
	$logo_url,
	$pdf_logo_url,
	$logo,
	$admin_logo,
	$admin_user_data['email'],
	$admin_user_data['username'],
	ADMIN_URL,
	$settings['admin']['admin_panel_name'],
	$settings['email_method']['from_name'],
	$settings['email_method']['from_email'],
	$settings['site_name'],
	SITE_URL,
	$order_detail['first_name'],
	$order_detail['last_name'],
	$order_detail['name'],
	$order_detail['phone'],
	$order_detail['email'],
	$order_detail['address'],
	$order_detail['house_number'],
	$order_detail['address2'],
	$order_detail['city'],
	$order_detail['state'],
	$order_detail['country'],
	$order_detail['postcode'],
	$order_detail['order_id'],
	$order_detail['order_code'],
	!empty($payment_icon[$order_detail['payment_method'].'_name'])?$payment_icon[$order_detail['payment_method'].'_name']:"",
	($order_date!='' && $order_date!='0000-00-00 00:00:00'?format_date($order_date).' '.format_time($order_date):''),
	($approved_date!='' && $approved_date!='0000-00-00 00:00:00'?format_date($approved_date).' '.format_time($approved_date):''),
	($expire_date!='' && $expire_date!='0000-00-00 00:00:00'?format_date($expire_date).' '.format_time($expire_date):''),
	replace_us_to_space($order_detail['order_status']),
	!empty($shipping_option[$order_detail['sales_pack'].'_name'])?$shipping_option[$order_detail['sales_pack'].'_name']:"",
	format_date(date('Y-m-d H:i')).' '.format_time(date('Y-m-d H:i')),
	$order_pdf_items_html,
	'',
	$company_name,
	$company_address,
	$company_city,
	$company_state,
	$company_zipcode,
	$company_country,
	$order_detail['shipping_first_name'],
	$order_detail['shipping_last_name'],
	$order_detail['shipping_company_name'],
	$order_detail['shipping_address1'],
	$order_detail['shipping_house_number'],
	$order_detail['shipping_address2'],
	$order_detail['shipping_city'],
	$order_detail['shipping_state'],
	$order_detail['shipping_postcode'],
	$order_detail['shipping_phone'],
	$order_expiring_days,
	$order_expired_days,
	$site_email,
	$site_phone,
	'');

$delivery_note_pdf_content = str_replace($patterns,$replacements,$delivery_note_pdf_content);

if(trim($order_detail['shipping_address1'])) {
	$delivery_note_pdf_content = str_replace(array('{billing_address_fields.if_blank_then_hide-start}','{billing_address_fields.if_blank_then_hide-end}'),array('',''), $delivery_note_pdf_content);
} else {
	$delivery_note_pdf_content = preg_replace('#\{billing_address_fields.if_blank_then_hide-start}.*?\{billing_address_fields.if_blank_then_hide-end}#s', '$1  $3', $delivery_note_pdf_content);
}

$html .= $delivery_note_pdf_content;

require_once(CP_ROOT_PATH.'/libraries/tcpdf/config/tcpdf_config.php');
require_once(CP_ROOT_PATH.'/libraries/tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF();

// set document information
$pdf->SetCreator($settings['email_method']['from_name']);
$pdf->SetAuthor($settings['email_method']['from_name']);
$pdf->SetTitle($settings['email_method']['from_name']);

$pdf->SetPrintHeader(false);
$pdf->SetPrintFooter(false);

// add a page
$pdf->AddPage();

$pdf->SetFont('dejavusans');

$pdf->writeHtml($html);

ob_end_clean();

$random_mix_number = get_random_mix_token(8);
$pdf->Output(CP_ROOT_PATH.'media/pdf/delivery_note-'.$random_mix_number.'-'.$order_id.'.pdf', 'I');
?>
