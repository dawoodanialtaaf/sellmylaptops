<?php
$csrf_token = generateFormToken('order_track');

$order_id = isset($_SESSION[$session_front_track_order_id])?$_SESSION[$session_front_track_order_id]:'';
$order_data = get_order_data($order_id);
if($order_id!="") {
	unset($_SESSION[$session_front_track_order_id]); 
}

$error_message = isset($_SESSION['error_message'])?$_SESSION['error_message']:'';
if($error_message!="") {
	unset($_SESSION['error_message']);
}

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$header_text_color = $active_page_data['header_text_color'];
$page_title = $active_page_data['title'];
?>

<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
				<div class="block header-caption">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<div class="image_text">'.$image_text.'</div>';
						} ?>
					</div>
			</div>
		</div>
	</div>
</section>



<form class="order_track_section" method="post" id="order_track_form">
  <section>
	<div class="container">
	  <div class="row justify-content-center"> 
		<div class="<?=(!empty($order_data)?'col-md-10 col-md-6 col-lg-6 col-xl-8':'col-md-6 col-lg-6 col-xl-6')?> "> 
			<div class="card">
				<div class="card-body">
					<div class="col-md-12">				
					<div class="text-center clearfix">		
						<div class="form-horizontal form-login" role="form">
							<?php
							if($error_message!="") { ?>
							<div class="row">
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><?=$error_message?>
								</div>
							</div>
							<?php
							} ?>

							<div class="head user-area-head text-center">
								<h1 class="h2 mb-3"><strong><?=$page_title?></strong></h1>
								<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
							</div>	
							
							<?php
							if(!empty($order_data)) {
								//Get order item list based on orderID, path of this function (get_order_item_list) admin/_config/functions.php
								$order_item_list = get_order_item_list($order_id);
								$order_num_of_rows = count($order_item_list);
								
								//Get order price based on orderID, path of this function (get_order_price) admin/_config/functions.php
								$sum_of_orders=get_order_price($order_id);
								
								$paid_amount_arr = array();
								$order_payment_status_list = get_order_payment_status_log($order_id);
								if(!empty($order_payment_status_list)) {
									foreach($order_payment_status_list as $order_payment_status_data) {
										$hsty_item_id = $order_payment_status_data['item_id'];
										$log_type = $order_payment_status_data['log_type'];
										if($log_type == "payment" && $order_payment_status_data['paid_amount']>0) {
											$paid_amount_arr[$hsty_item_id] = $order_payment_status_data['paid_amount'];
										}
									}
								}
								$sum_of_paid_order = array_sum($paid_amount_arr);
								
								//Order data gathering
								if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
									$promocode_amt = $order_data['promocode_amt'];
									$discount_amt_label = "Surcharge";
									if($order_data['discount_type']=="percentage")
										$discount_amt_label = "Surcharge (".$order_data['discount']."% of Initial Quote):";
									 
									$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
								} else {
									$total_of_order = $sum_of_orders;
								}
								
								$order_status = $order_data['order_status_name'];
								$order_status_slug = $order_data['order_status_slug'];
								/*$act_parcel_shipped = false;
								$act_device_checked = false;
								$act_order_paid = false;
								if($order_status_slug == "shipped" || $order_status_slug == "delivered" || $order_status_slug == "shipment_problem") {
									$act_parcel_shipped = true;
								} elseif($order_status_slug == "processing" || $order_status_slug == "approved" || $order_status_slug == "counter_offer" || $order_status_slug == "offer_accepted" || $order_status_slug == "offer_declined") {
									$act_parcel_shipped = true;
									$act_device_checked = true;
								} elseif($order_status_slug == "returned_to_sender" || $order_status_slug == "completed" || $order_status_slug == "expired") {
									$act_parcel_shipped = true;
									$act_device_checked = true;
									$act_order_paid = true;
								}*/
								
								$quantity_array = array();
								if($order_num_of_rows>0) {
									foreach($order_item_list as $order_item_list_data) {
										$quantity_array[] = $order_item_list_data['quantity'];
									}
								}
								
								$html = '<div class="order-status-info-header">
								  <h5 class="modal-title">'._lang('success_order_id_heading_text','order_track_form').$order_id.'</h5>
								</div>
								<div class="order-status-info pt-3 text-center">';
								  /*<div class="order-progress-bar clearfix">
									<span class="shipped '.($act_parcel_shipped?'active':'').'"></span>
									<span class="checked '.($act_device_checked?'active':'').'"></span>
									<span class="paid '.($act_order_paid?'active':'').'"></span>
								  </div>
								  <div class="order-status">
									<div class="shipped '.($act_parcel_shipped?'active':'').'">
									  <img src="'.SITE_URL.'media/images/icons/shipped.png" alt="">
									  <span>'._lang('success_parcel_is_shipped_heading_text','order_track_form').'</span>
									</div>
									<div class="checked '.($act_device_checked?'active':'').'">
									  <img src="'.SITE_URL.'media/images/icons/chcked.png" alt="">
									  <span>'._lang('success_devices_checked_heading_text','order_track_form').'</span>
									</div>
									<div class="paid '.($act_order_paid?'active':'').'">
									  <img src="'.SITE_URL.'media/images/icons/paid.png" alt="">
									  <span>'._lang('success_order_paid_heading_text','order_track_form').'</span>
									</div>
								  </div>*/
									$html .= '<div class="d-none d-md-block d-lg-block w-100">
										<table id="table_id" class="display dataTable">
											<thead>
											  <tr>
												<th>'._lang('success_order_id_column_text','order_track_form').'</th>
												<th>'._lang('success_order_date_column_text','order_track_form').'</th>
												<th>'._lang('success_order_qty_column_text','order_track_form').'</th>
												<th>'._lang('success_order_last_update_column_text','order_track_form').'</th>
												<th>'._lang('success_order_status_column_text','order_track_form').'</th>
											  </tr>
											</thead>
											<tbody>
												<tr><td>';
													if($order_data['user_type'] == "guest") {
													$html .= '<a href="'.SITE_URL.'order/'.$order_data['order_id'].'/'.$order_data['access_token'].'">'.$order_id.'</a>';
													} else {
													$html .= $order_id;
													}
													$html .= '</td><td>'.format_date($order_data['order_date']).'</td>
													<td>'.array_sum($quantity_array).'</td>
													<td>'.($order_data['order_update_date']!='0000-00-00 00:00:00'?format_date($order_data['order_update_date']):_lang('success_order_last_update_not_update_msg','order_track_form')).'</td>
													<td>'.replace_us_to_space($order_status).' '.($order_status == "completed"?amount_fomat($sum_of_paid_order):'').'</td>
												</tr>
											</tbody>
										</table>
									</div>';
									
								    if(empty($user_id) && $user_id<=0 && $order_data['user_type'] != "guest") {
								  		$html .= '<a class="link-text order_track_login" href="javascript:void(0);" data-toggle="modal" data-target="#SignInRegistration">'._lang('success_order_more_info_text','order_track_form').'</a>';
								    }
								$html .= '</div>
								</div>';
								echo $html;
							} else { ?>
								<div class="form-wrap clearfix">
									<div class="form-group">
										<input type="text" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','order_track_form')?>" class="form-control " value="<?=$user_email?>" autocomplete="off">
										<div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
									<div class="form-group">
										<input type="text" name="order_id" id="order_id" placeholder="<?=_lang('order_id_field_placeholder_text','order_track_form')?>" class="form-control" autocomplete="off">
										<div id="order_id_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
									
									<?php
									if($order_track_form_captcha == '1') { ?>
										<div class="form-group">
											<div id="g_form_gcaptcha"></div>
											<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
											<div id="captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
										</div>
									<?php
									} else {
									   echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';
								    } ?>
									
									<div class="form-group mb-0">
										<button type="submit" class="btn btn-primary btn-lg order_track_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="order_track_form_spining_icon"></span></button>
										<input type="hidden" name="submit_form" id="submit_form" />
                                        <input type="hidden" name="controller" value="order_track" />
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
	</div>
  </section>
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
</form>

<?php
if($order_track_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($order_track_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		grecaptcha.render('g_form_gcaptcha', {
			'sitekey' : '<?=$captcha_key?>',
			'callback' : onSubmitForm,
		});
	}
};

var onSubmitForm = function(response) {
	if(response.length == 0) {
		jQuery("#g_captcha_token").val('');
	} else {
		//$(".sbmt_button").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
		check_order_track_form();
	}
};
<?php
} ?>

var order_track_form_captcha = '<?=$order_track_form_captcha?>';

function check_order_track_form() {
	jQuery(".m_validations_showhide").hide();				

	var email = jQuery("#email").val();
	email = email.trim();
	var order_id = jQuery("#order_id").val();
	order_id = order_id.trim();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','order_track_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','order_track_form')?>');
		return false;
	} else if(order_id=="") {
		jQuery("#order_id_error_msg").show().text('<?=_lang('order_id_field_validation_text','order_track_form')?>');
		return false;
	} else if(order_track_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','order_track_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#order_track_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_order_track_form();
		});
		$(".order_track_form_sbmt_btn").click(function() {
			var ok = check_order_track_form();
			if(ok == false) {
				return false;
			} else {
				$("#order_track_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#order_track_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#order_track_form").submit();
			}
		});
	});
})(jQuery);
</script>