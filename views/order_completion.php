<?php
$meta_title = "Complete Order";

//Header section
include("include/header.php");

//Get order id
$order_id = '';
if(isset($_SESSION[$session_front_tmp_order_id])) {
	$order_id = $_SESSION[$session_front_tmp_order_id];
}
if(!$order_id) {
	setRedirect(SITE_URL);
	exit();
}

//Get order batch data, path of this function (get_order_data) admin/_config/functions.php
$order_data = get_order_data($order_id);
$access_token = $order_data['access_token'];

//Get order price based on orderID, path of this function (get_order_price) admin/_config/functions.php
$sum_of_orders = get_order_price($order_id);
$sell_order_total = ($sum_of_orders>0?$sum_of_orders:'');

//Get order item list based on orderID, path of this function (get_order_item_list) admin/_config/functions.php
$order_item_list = get_order_item_list($order_id);

$promocode_sys_msg = "";
if(isset($_SESSION['promocode_sys_msg'])) {
	$promocode_sys_msg = $_SESSION['promocode_sys_msg'];
	unset($_SESSION['promocode_sys_msg']);
}

$shipment_label_api_error_msg = "";
if(isset($_SESSION['shipment_label_api_error_msg'])) {
	$shipment_label_api_error_msg = $_SESSION['shipment_label_api_error_msg'];
	unset($_SESSION['shipment_label_api_error_msg']);
}

$o_page_type = "";
if($order_data['sales_pack'] == "post_me_a_prepaid_label") {
	$o_page_type = "post_me_a_prepaid_label";
} elseif($order_data['sales_pack'] == "print_a_prepaid_label") {
	$o_page_type = "print_a_prepaid_label";
} elseif($order_data['sales_pack'] == "use_my_own_courier") {
	$o_page_type = "use_my_own_courier";
} elseif($order_data['sales_pack'] == "store") {
	$o_page_type = "store";
} elseif($order_data['sales_pack'] == "starbucks") {
	$o_page_type = "starbucks";
} elseif($order_data['sales_pack'] == "we_come_for_you") {
	$o_page_type = "we_come_for_you";
}
$order_complete_page_data = get_order_complete_page_data($o_page_type);

$success_page_content = json_decode($order_complete_page_data['content_fields'],true);
if(empty($success_page_content['heading'])) {
	$success_page_content['heading'] = '';
}
if(empty($success_page_content['sub_heading'])) {
	$success_page_content['sub_heading'] = '';
}
if(empty($success_page_content['intro_text'])) {
	$success_page_content['intro_text'] = '';
}
if(empty($success_page_content['step_heading'])) {
	$success_page_content['step_heading'] = '';
}
if(empty($success_page_content['step_sub_heading'])) {
	$success_page_content['step_sub_heading'] = '';
}
if(empty($success_page_content['step1_title'])) {
	$success_page_content['step1_title'] = '';
}
if(empty($success_page_content['step1_instruction'])) {
	$success_page_content['step1_instruction'] = '';
}
if(empty($success_page_content['step1_icon'])) {
	$success_page_content['step1_icon'] = '';
}
if(empty($success_page_content['step2_title'])) {
	$success_page_content['step2_title'] = '';
}
if(empty($success_page_content['step2_instruction'])) {
	$success_page_content['step2_instruction'] = '';
}
if(empty($success_page_content['step2_icon'])) {
	$success_page_content['step2_icon'] = '';
}
if(empty($success_page_content['step3_title'])) {
	$success_page_content['step3_title'] = '';
}
if(empty($success_page_content['step3_instruction'])) {
	$success_page_content['step3_instruction'] = '';
}
if(empty($success_page_content['step3_icon'])) {
	$success_page_content['step3_icon'] = '';
}

$heading_text = $success_page_content['heading'];
$sub_heading_text = $success_page_content['sub_heading'];
$intro_text = $success_page_content['intro_text'];
$step_heading_text = $success_page_content['step_heading'];
$step_sub_heading_text = $success_page_content['step_sub_heading'];
$step1_title_text = $success_page_content['step1_title'];
$step1_instruction_text = $success_page_content['step1_instruction'];
$step1_icon = $success_page_content['step1_icon'];
$step2_title_text = $success_page_content['step2_title'];
$step2_instruction_text = $success_page_content['step2_instruction'];
$step2_icon = $success_page_content['step2_icon'];
$step3_title_text = $success_page_content['step3_title'];
$step3_instruction_text = $success_page_content['step3_instruction'];
$step3_icon = $success_page_content['step3_icon'];

$promocode_amt = 0;
$discount_amt_label = "";
$is_promocode_exist = false;
if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
	$promocode_amt = $order_data['promocode_amt'];
	$is_promocode_exist = true;
}

$bonus_amount = 0;
$bonus_percentage = $order_data['bonus_percentage'];
if($order_data['bonus_amount']>0) {
	$bonus_amount = $order_data['bonus_amount'];
}

$transaction_product_str = '';
$transaction_product_arr = array();
foreach($order_item_list as $order_item_list_data) {
	$order_item_data = get_order_item($order_item_list_data['id'],'print');

	$order_item_id = $order_item_list_data['order_item_id'];
	$item_name = $order_item_data['device_name'].($order_item_data['item_name']?' - '.$order_item_data['item_name']:'');
	$cat_title = $order_item_list_data['cat_title'];
	$item_price = $order_item_list_data['price'];
	$item_qty = $order_item_list_data['quantity'];

	$transaction_product_arr[] = array('sku'=>$order_item_id, 'name'=>$item_name, 'category'=>$cat_title, 'price'=>$item_price,'quantity'=>$item_qty);
}
if(!empty($transaction_product_arr)) {
	$transaction_product_str = json_encode($transaction_product_arr);
	$transaction_product_str = str_replace('<br>',', ',$transaction_product_str);
}

if($is_promocode_exist || $bonus_amount) {
	$order_total = ($sell_order_total+$promocode_amt+$bonus_amount);
} else {
	$order_total = $sell_order_total;
}

if(!empty($settings['o_compl_page_success_step_image'])) {
	//echo '<style>.block.shipping-step{background: url('.SITE_URL.'media/images/'.$settings['o_compl_page_success_step_image'].') !important;}</style>';
} ?>

<section>
<div class="container-fluid">
  <div class="row">
   <div class="col-md-12">
	  <div class="block setting-page py-0 clearfix">
		<div class="row">
		   <div class="col-md-6 order-md-2">
			 <div class="block heading shipping-heading page-heading">
			   <?php
			   if($heading_text) {
			   	   echo '<h3>'.nl2br($heading_text).'</h3>';
			   } ?>
			 </div>
			 <div class="block shipping-info">
				<?php
				$shipment_label_broker_id = $order_data['shipment_label_broker_id'];
				$shipment_label_broker_qrcode_url = $order_data['shipment_label_broker_qrcode_url'];
				
				if($sub_heading_text) {
					echo '<p>'.str_replace(array('${order_id}','${order_code}'),array('<span>'.$order_data['order_code'].'</span>','<span>'.$order_data['order_code'].'</span>'),nl2br($sub_heading_text)).'</p>';
				}

				$shipment_label_d_url = '';
				$shipment_label_url = $order_data['shipment_label_url'];
				if($order_data['sales_pack']=="print_a_prepaid_label" && $shipment_label_url!="") {
					$shipment_label_d_url = SITE_URL.'?controller=download&download_link='.$shipment_label_url;
					if($order_data['shipment_tracking_code']) {
						echo '<p>'._lang('shipping_label_tracking_code_label_text','order_completion').' <span># '.$order_data['shipment_tracking_code'].'</span></p>';
					}	
				} elseif($order_data['sales_pack']=="print_a_prepaid_label" && $shipment_label_url=="" && $shipping_option['print_a_prepaid_label'] == "print_a_prepaid_label") { ?>
					<p><div class="alert alert-info alert-dismissable"><?=_lang('unable_to_create_shipment_message_text','order_completion').($shipment_label_api_error_msg?'<br>'.$shipment_label_api_error_msg:'')?></div></p>
				<?php
				}	
				if($promocode_sys_msg) { ?>
					<p><div class="alert alert-info alert-dismissable"><?=$promocode_sys_msg?></div></p>
				<?php
				}
				if($intro_text) {
			   	   echo '<p>'.nl2br($intro_text).'</p>';
			    }
				if($show_cust_delivery_note == '1') { ?>
					<a class="btn btn-primary btn-lg mb-3" href="<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank"><?=_lang('delivery_note_button_text','order_completion')?> <i class="fas fa-download"></i></a>
				<?php
				}
				if($show_cust_order_form == '1' && $order_data['packing_slip']) { ?>
					<a class="btn btn-primary btn-lg mb-3" href="<?=SITE_URL?>media/pdf/<?=$order_data['packing_slip']?>" target="_blank"><?=_lang('packing_slip_button_text','order_completion')?> <i class="fas fa-download"></i></a>
				<?php
				}
				if($show_cust_sales_confirmation == '1') { ?>
					<a class="btn btn-primary btn-lg mb-3" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank"><?=_lang('receipt_button_text','order_completion')?> <i class="fas fa-download"></i></a>
				<?php
				}
				if($shipment_label_d_url) { ?>
					<a class="btn btn-primary bg-gradient mb-3" href="<?=$shipment_label_d_url?>"><?=_lang('shipment_label_button_text','order_completion')?> <i class="fa fa-download ml-2"></i></a>
				<?php
				}
				if($shipment_label_broker_qrcode_url) {
					$shipment_label_broker_qrcode_d_url = SITE_URL.'?controller=download&download_link='.$shipment_label_broker_qrcode_url; ?>
					<a class="btn btn-primary btn-lg mb-3" href="<?=$shipment_label_broker_qrcode_d_url?>"><?=_lang('label_broker_qrcode_button_text','order_completion')?> <i class="fas fa-download"></i></a>
				<?php
				} ?>
			 </div>
			 <?php /*?><div class="text-center pb-5 pt-5 d-md-none">
			   <a href="<?=SITE_URL?>#category-section" class="btn btn-primary btn-lg rounded-pill"><?=_lang('place_another_order_button_text')?></a>
			 </div><?php */?>
		   </div>
		   <div class="col-md-6 order-md-1">
			 <div class="block shipping-head-img text-center">
			   <img src="<?=SITE_URL?>media/images/icons/success.png" alt="">
			 </div>
		   </div>
		</div>
		<?php /*?><div class="row d-none d-md-block">
		  <div class="col-md-12 pt-5 text-center">
			<a href="<?=SITE_URL?>#category-section" class="btn btn-primary btn-lg rounded-pill"><?=_lang('place_another_order_button_text')?></a>
		  </div>
		</div><?php */?>
		<div class="row">
		  <div class="col-md-12">
			<div class="block heading page-heading shipping-step-heading text-center">
				<?php
				if($step_heading_text) {
					echo '<h3>'.nl2br($step_heading_text).'</h3>';
				}
				if($step_sub_heading_text) {
					echo '<h4>'.nl2br($step_sub_heading_text).'</h4>';
				} ?>
			</div>
		  </div>
		</div>
		<div class="row justify-content-center">
		  <div class="col-md-12">
			<div class="block shipping-step">
			  <?php
			  if($step1_icon || $step1_title_text || $step1_instruction_text) { ?>
				  <div class="row">
					<div class="col-md-3 d-none d-lg-block text-center">
						<?php
						if($step1_icon) {
							echo '<img src="'.SITE_URL.'/media/images/order_complete/'.$step1_icon.'" alt="'.$step1_title_text.'">';
						} ?>
					</div>
					<div class="col-md-12 col-lg-9 text-content">
					  <div class="step-number d-lg-none">
						<div>
						  <span class="text">1</span>
						</div>
					  </div>
					  <h4 class="clearfix">
						<?php
						if($step1_icon) {
							echo '<img class="d-lg-none" src="'.SITE_URL.'/media/images/order_complete/'.$step1_icon.'" alt="'.$step1_title_text.'">';
						}
						if($step1_title_text) {
							echo '<span>'.nl2br($step1_title_text).'</span>';
						} ?>
					  </h4>
					  <?php
					  if($step1_instruction_text) {
						echo '<p>'.nl2br($step1_instruction_text).'</p>';
					  } ?>
					</div>
				  </div>
			  <?php
			  }
			  if($step2_icon || $step2_title_text || $step2_instruction_text) { ?>
				  <div class="row">
					<div class="col-md-12 col-lg-9 text-content">
					   <div class="step-number d-lg-none">
						 <div>
						   <span class="text">2</span>
						 </div>
					   </div>
					  <h4 class="clearfix">
						<?php
						if($step2_icon) {
							echo '<img class="d-lg-none" src="'.SITE_URL.'/media/images/order_complete/'.$step2_icon.'" alt="'.$step2_title_text.'">';
						}
						if($step2_title_text) {
							echo '<span>'.nl2br($step2_title_text).'</span>';
						} ?>
					  </h4>
					  <?php
					  if($step2_instruction_text) {
						echo '<p>'.nl2br($step2_instruction_text).'</p>';
					  } ?>
					</div>
					<div class="col-md-3 text-center d-none d-lg-block">
						<?php
						if($step2_icon) {
							echo '<img src="'.SITE_URL.'/media/images/order_complete/'.$step2_icon.'" alt="'.$step2_title_text.'">';
						} ?>
					</div>
				  </div>
			  <?php
			  }
			  if($step3_icon || $step3_title_text || $step3_instruction_text) { ?>
				  <div class="row">
					<div class="col-md-3  d-none d-lg-block text-center">
						<?php
						if($step3_icon) {
							echo '<img src="'.SITE_URL.'/media/images/order_complete/'.$step3_icon.'" alt="'.$step3_title_text.'">';
						} ?>
					</div>
					<div class="col-md-12 col-lg-9 text-content">
					  <div class="step-number d-lg-none">
						<div>
						  <span class="text">3</span>
						</div>
					  </div>
					  <h4 class="clearfix">
						<?php
						if($step3_icon) {
							echo '<img class="d-lg-none" src="'.SITE_URL.'/media/images/order_complete/'.$step3_icon.'" alt="'.$step3_title_text.'">';
						}
						if($step3_title_text) {
							echo '<span>'.nl2br($step3_title_text).'</span>';
						} ?>
					  </h4>
					  <?php
					  if($step3_instruction_text) {
						echo '<p>'.str_replace('${download_pdf_lebal_link}',$shipment_label_d_url,nl2br($step3_instruction_text)).'</p>';
					  } ?>
					</div>
				  </div>
			  <?php
			  } ?>
			</div>
		  </div>
		</div>
	  </div>
   </div>
  </div>
</div>
</section>

<script language="javascript" type="text/javascript">
function open_window(url) {
	window.open(url,"Loading",'toolbar=0, location=0, directories=0, status=0, menubar=0, scrollbars=1, resizable=0, width=1000, height=800');
}
</script>