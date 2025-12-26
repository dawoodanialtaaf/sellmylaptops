<?php
$meta_title = "Checkout";

//Header section
include("include/header.php");

if($accept_new_order != '1') {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL.'cart',$msg,'danger');
	exit();
}

//Fetching data from models
if(!$order_id || $basket_item_count_sum_data['basket_item_count']<=0) {
	setRedirect(SITE_URL.'cart');
	exit();
}

//Get order price based on orderID, path of this function (get_order_price) admin/_config/functions.php
$sum_of_orders = get_order_price($order_id);
$sell_order_total = ($sum_of_orders>0?$sum_of_orders:0);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/_config/functions.php
$order_item_list = get_order_item_list($order_id);
$order_num_of_rows = !empty($order_item_list)?count($order_item_list):'0';

//Get order batch data, path of this function (get_order_data) admin/_config/functions.php
$order_data = get_order_data($order_id);
$email_while_add_to_cart = $order_data['email_while_add_to_cart'];

$promocode_amt = 0;
$discount_amt_label = '';
$is_promocode_exist = false;
if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
	$promocode_amt = $order_data['promocode_amt'];
	$discount_amt_label = "Promocode";
	if($order_data['discount_type']=="percentage") {
		$discount_amt_label = "Promocode (".$order_data['discount']."% of Initial Quote)";
	}
	$is_promocode_exist = true;
}

$bonus_amount = 0;
$bonus_percentage = $order_data['bonus_percentage'];
$bonus_amount = (!empty($order_data['bonus_amount'])?$order_data['bonus_amount']:0);
$is_confirm_sale_terms = false;
if($display_terms_array['confirm_sale']=="confirm_sale") {
	$is_confirm_sale_terms = true;
}

$checkout_signup_prefill_email = '';
$checkout_signup_prefill_data = (!empty($_SESSION['checkout_signup_prefill_data'])?$_SESSION['checkout_signup_prefill_data']:array());
$sess_email_while_add_to_cart = (isset($_SESSION[$session_front_email_while_add_to_cart])?$_SESSION[$session_front_email_while_add_to_cart]:'');
if(!empty($checkout_signup_prefill_data['email'])) {
	$checkout_signup_prefill_email = $checkout_signup_prefill_data['email'];
} elseif($sess_email_while_add_to_cart) {
	$checkout_signup_prefill_email = $sess_email_while_add_to_cart;
} ?>

<style>
.payment-form {
    display: none;
}
</style>

  <section id="content" class="main-checkout-page">   
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="block checkout-page clearfix">
			<div class="row">
				<div class="col-md-12">
					<div class="block head border-line mt-0 pt-0 clearfix">
						<h1 class="h1 text-center"><?=_lang('heading_text','checkout')?></h1>
					</div>
				</div>
			</div>
            <div class="row">
              <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="block content p-0 clearfix">
                  <div class="accordion checkout-page" id="checkout">
					<?php
					if($user_id<=0 && $enable_login_register == '1') { ?>
						<div class="card">
							<div class="card-header" id="account">
								<h2 class="mb-0">
									<button class="btn btn-link" type="button" data-toggle="" data-target="#accountTab" aria-expanded="true" aria-controls="accountTab">
									1. <?=_lang('account_tab_title','checkout1111')?> <span class="checkout-step-data account_step_data"></span> <span class="collapseone_chkd"></span>
									</button>
								</h2>
							</div>
							<div id="accountTab" class="collapse show" aria-labelledby="account" data-parent="#checkout">
								<div class="card-body">
									<div class="row">
										<?php
										if($allow_guest_user_order == '1') { ?>
										<div class="col-md-6">
											<div class="checkout-block clearfix">
												<h3><?=_lang('account_tab_checkout_heading_text','checkout')?></h3>
												<form id="create_account_form">
													<div class="form-group">
														<label for="checkout_signup_email"><?=_lang('email_field_label_text','signup_form')?></label>
														<input type="email" maxlength="100" class="form-control" name="email" id="checkout_signup_email" value="<?=($checkout_signup_prefill_email?$checkout_signup_prefill_email:$user_data['email'])?>" autocomplete="off" required>
														<div id="checkout_signup_email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
														<div class="invalid-feedback email_exist_msg" style="display:none;"></div>
													</div>
													<button type="button" class="btn btn-primary btn-lg create_account_form_sbmt_btn"><?=_lang('continue_as_guest_button_text','checkout')?>&nbsp;<span id="create_account_form_sbmt_btn_spinning_icon" style="display:inline-flex;"></span></button>
												</form>
											</div>
										</div>
										<?php
										} ?>
										<div class="col-md-<?=($allow_guest_user_order == '1'?'6':'12')?>">
											<div class="checkout-block clearfix">
												<h3><?=_lang('account_tab_login_heading_text','checkout')?></h3>
												<form method="post" id="checkout_login_form">
													<div class="signin-f-form-msg" style="display:none;"></div>
													<span id="signin_f_spining_icon"></span>
													<div class="form-group">
														<label for="username"><?=_lang('email_field_label_text','login_form')?></label>
														<input type="text" class="form-control" id="s_username" name="username" autocomplete="off">
														<div id="checkout_login_email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
													</div>
													<div class="form-group">
														<label for="password"><?=_lang('password_field_label_text','login_form')?></label>
														<input type="password" class="form-control" id="s_password" name="password" autocomplete="off">
														<div id="checkout_login_password_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
													</div>
													<?php
													if($login_form_captcha == '1') { ?>
														<div class="form-group">
															<div id="g_form_gcaptcha"></div>
															<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
															<div id="checkout_login_captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
														</div>
													<?php
													} else {
														echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';
													} ?>
													<div class="form-group mb-0">
														<button type="button" class="btn btn-primary btn-lg checkout_login_form_sbmt_btn"><?=_lang('login_link_text')?></button>
														<input type="hidden" name="submit_form" id="submit_form" /><?php /*?><span class="or-section">or</span><?php */?>
														<a href="<?=$signup_link?>" class="btn-create-account create-an-account"><?=_lang('already_not_member_link_text','login_form')?></a> 
													</div>
													<?php
													$login_csrf_token = generateFormToken('ajax'); ?>
													<input type="hidden" name="csrf_token" value="<?=$login_csrf_token?>">
												</form>
												
												<?php
												if($settings['login_verification']=="email" || $settings['login_verification']=="sms") { ?>
												<form class="sign-in needs-validation login-f-verifycode-form" style="display:none;" novalidate>
													<div class="login-f-verifycode-form-msg" style="display:none;"></div>
													<span id="resend_login_f_verifycode_p_spining_icon"></span>
													<div class="form-group">
													  <input type="text" class="form-control" name="login_verification_code" id="login_f_verification_code" placeholder="<?=_lang('verification_code_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" onkeyup="this.value=this.value.replace(/[^\d]/,'');" required>
													  <div class="invalid-feedback">
														<?=_lang('verification_code_field_validation_text','signin_register_popup')?>
													  </div>
													</div>
									
													<div class="form-group pt-3 mb-0">
													  <button type="submit" class="btn btn-primary btn-lg mb-3 login_f_verifycode_form_btn"><?=_lang('verify_button_text')?></button>
													  <input type="hidden" name="submit_form" id="submit_form" />
													  <input type="hidden" name="user_id" id="login_f_verifycode_user_id" />
									
													  <button type="button" class="btn btn-outline-dark btn-lg resend_login_f_verifycode_btn"><?=_lang('resend_button_text')?></button>
													</div>
													
													<?php
													$l_v_a_csrf_token = generateFormToken('ajax');
													echo '<input type="hidden" name="csrf_token" value="'.$l_v_a_csrf_token.'">'; ?>
												</form>
												<?php
												} ?>
												
												<a href="<?=SITE_URL?>lost_password" class="link-forgot-pass"><?=_lang('forgotten_password_link_text','login_form')?></a>
												
												<?php
												//For social signup/signin
												if($social_login=='1') { ?>
													<div class="third_party_login clearfix">
														<h3><?=_lang('social_login_title_text','checkout')?></h3>
														<div class="third_parties clearfix">
															<?php
															if($social_login_option=="g_f") { ?>
																<a class="btn btn_md btn_fb s_facebook_auth mb-2" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/fb_img.png" alt="Facebook Auth"><span class="s_facebook_auth_spining_icon"></span></a>
																<a id="google_auth_btn" class="btn btn_md btn_gplus mb-2" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/google_plus.png" alt="Google Auth"> <span class="google_auth_btn_spining_icon"></span></a>		
															<?php
															} elseif($social_login_option=="g") { ?>
																<a id="google_auth_btn" class="btn btn_md btn_gplus mb-2" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/google_plus.png" alt="Google Auth"> <span class="google_auth_btn_spining_icon"></span></a>
															<?php
															} elseif($social_login_option=="f") { ?>
																<a class="btn btn_md btn_fb s_facebook_auth mb-2" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/fb_img.png" alt="Facebook Auth"><span class="s_facebook_auth_spining_icon"></span></a>
															<?php
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
					<?php
					} ?>

					<form <?php if ((isset($_SESSION[$session_front_user_id]) && $_SESSION[$session_front_user_id] > 0) || $enable_login_register != '1'){echo 'class="logged-in"';}?> method="post" id="checkout_form" enctype="multipart/form-data">
						<div class="card">
						  <div class="card-header" id="paymentOption">
							<h2 class="mb-0">
							  <button class="btn btn-link collapsed" type="button" data-toggle="" data-target="#payment" aria-expanded="false" aria-controls="payment">
								<?=($user_id>0 || $enable_login_register != '1'?1:2)?>. <?=_lang('payment_tab_title','checkout')?> <span class="checkout-step-data payment_step_data"></span> <span class="collapsetwo_chkd"></span>
							  </button>
							</h2>
						  </div>

						  <div id="payment" class="collapse <?=($user_id>0 || $enable_login_register != '1'?'show':'')?>" aria-labelledby="paymentOption" data-parent="#checkout">
							<div class="card-body">
							  <div class="checkout-block clearfix payment_info_tab">
								<h3><?=_lang('payment_tab_heading_text','checkout')?></h3>
								<div class="payment-select clearfix">
									<?php
									$o_payment_method_details = json_decode($order_data['payment_method_details'],true);
									$account_holder_name = (!empty($o_payment_method_details['account_holder_name'])?$o_payment_method_details['account_holder_name']:'');
									$account_number = (!empty($o_payment_method_details['account_number'])?$o_payment_method_details['account_number']:'');
									$short_code = (!empty($o_payment_method_details['short_code'])?$o_payment_method_details['short_code']:'');
									//$cash_name = (!empty($o_payment_method_details['cash_name'])?$o_payment_method_details['cash_name']:'');
									$cash_phone = (!empty($o_payment_method_details['cash_phone'])?$o_payment_method_details['cash_phone']:'');
									$paypal_address = (!empty($o_payment_method_details['paypal_address'])?$o_payment_method_details['paypal_address']:'');
									$venmo_address = (!empty($o_payment_method_details['venmo_address'])?$o_payment_method_details['venmo_address']:'');
									$zelle_address = (!empty($o_payment_method_details['zelle_address'])?$o_payment_method_details['zelle_address']:'');
									$amazon_gcard_address = (!empty($o_payment_method_details['amazon_gcard_address'])?$o_payment_method_details['amazon_gcard_address']:'');
									$cash_app_address = (!empty($o_payment_method_details['cash_app_address'])?$o_payment_method_details['cash_app_address']:'');
									$apple_pay_address = (!empty($o_payment_method_details['apple_pay_address'])?$o_payment_method_details['apple_pay_address']:'');
									$google_pay_address = (!empty($o_payment_method_details['google_pay_address'])?$o_payment_method_details['google_pay_address']:'');
									$coinbase_address = (!empty($o_payment_method_details['coinbase_address'])?$o_payment_method_details['coinbase_address']:'');
									$facebook_pay_address = (!empty($o_payment_method_details['facebook_pay_address'])?$o_payment_method_details['facebook_pay_address']:'');
									$payment_method_details = json_decode($user_data['payment_method_details'],true);

									if($user_data['use_payment_method_prefilled'] == '1') {
										$my_payment_option = $payment_method_details['my_payment_option'];
										if($my_payment_option) {
											$default_payment_option = $my_payment_option;
										}
										$account_holder_name = !empty($payment_method_details['data']['bank']['act_name'])?$payment_method_details['data']['bank']['act_name']:'';
										$account_number = !empty($payment_method_details['data']['bank']['act_number'])?$payment_method_details['data']['bank']['act_number']:'';
										$short_code = !empty($payment_method_details['data']['bank']['act_short_code'])?$payment_method_details['data']['bank']['act_short_code']:'';
										//$cash_name = !empty($payment_method_details['data']['cash']['cash_name'])?$payment_method_details['data']['cash']['cash_name']:'';
										$cash_phone = !empty($payment_method_details['data']['cash']['cash_phone'])?$payment_method_details['data']['cash']['cash_phone']:'';
										$paypal_address = !empty($payment_method_details['data']['paypal']['paypal_address'])?$payment_method_details['data']['paypal']['paypal_address']:'';
										$venmo_address = !empty($payment_method_details['data']['venmo']['venmo_address'])?$payment_method_details['data']['venmo']['venmo_address']:'';
										$zelle_address = !empty($payment_method_details['data']['zelle']['zelle_address'])?$payment_method_details['data']['zelle']['zelle_address']:'';
										$amazon_gcard_address = !empty($payment_method_details['data']['amazon_gcard']['amazon_gcard_address'])?$payment_method_details['data']['amazon_gcard']['amazon_gcard_address']:'';
										$cash_app_address = (!empty($payment_method_details['data']['cash_app']['cash_app_address'])?$payment_method_details['data']['cash_app']['cash_app_address']:'');
										$apple_pay_address = (!empty($payment_method_details['data']['apple_pay']['apple_pay_address'])?$payment_method_details['data']['apple_pay']['apple_pay_address']:'');
										$google_pay_address = (!empty($payment_method_details['data']['google_pay']['google_pay_address'])?$payment_method_details['data']['google_pay']['google_pay_address']:'');
										$coinbase_address = (!empty($payment_method_details['data']['coinbase']['coinbase_address'])?$payment_method_details['data']['coinbase']['coinbase_address']:'');
										$facebook_pay_address = (!empty($payment_method_details['data']['facebook_pay']['facebook_pay_address'])?$payment_method_details['data']['facebook_pay']['facebook_pay_address']:'');

									}

									foreach($payment_option_ordr_arr as $pooa_k=>$pooa_v) {
									
										$payment_icon_img = '';
										if(!empty($payment_icon[$pooa_v.'_icon'])) {
											$payment_icon_img = '<img src="'.SITE_URL.'media/images/payment/'.$payment_icon[$pooa_v.'_icon'].'" width="30">';
										}
										
										if($choosed_payment_option['bank']=="bank" && $pooa_v == "bank") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_bank" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="bank"){echo 'checked="checked"';}?> value="bank">
											<label class="custom-control-label" for="payment_method_bank"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['paypal']=="paypal" && $pooa_v == "paypal") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_paypal" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="paypal"){echo 'checked="checked"';}?> value="paypal">
											<label class="custom-control-label" for="payment_method_paypal"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['cheque']=="cheque" && $pooa_v == "cheque") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_cheque" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cheque"){echo 'checked="checked"';}?> value="cheque">
											<label class="custom-control-label" for="payment_method_cheque"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['coupon']=="coupon" && $pooa_v == "coupon") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_coupon" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="coupon"){echo 'checked="checked"';}?> value="coupon">
											<label class="custom-control-label" for="payment_method_coupon"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['zelle']=="zelle" && $pooa_v == "zelle") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_zelle" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="zelle"){echo 'checked="checked"';}?> value="zelle">
											<label class="custom-control-label" for="payment_method_zelle"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										
										if($choosed_payment_option['cash']=="cash" && $pooa_v == "cash") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_cash" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cash"){echo 'checked="checked"';}?> value="cash">
											<label class="custom-control-label" for="payment_method_cash"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										
										if($choosed_payment_option['venmo']=="venmo" && $pooa_v == "venmo") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_venmo" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="venmo"){echo 'checked="checked"';}?> value="venmo">
											<label class="custom-control-label" for="payment_method_venmo"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										
										if($choosed_payment_option['amazon_gcard']=="amazon_gcard" && $pooa_v == "amazon_gcard") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_amazon_gcard" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="amazon_gcard"){echo 'checked="checked"';}?> value="amazon_gcard">
											<label class="custom-control-label" for="payment_method_amazon_gcard"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['cash_app']=="cash_app" && $pooa_v == "cash_app") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_cash_app" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="cash_app"){echo 'checked="checked"';}?> value="cash_app">
											<label class="custom-control-label" for="payment_method_cash_app"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['apple_pay']=="apple_pay" && $pooa_v == "apple_pay") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_apple_pay" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="apple_pay"){echo 'checked="checked"';}?> value="apple_pay">
											<label class="custom-control-label" for="payment_method_apple_pay"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										
										if($choosed_payment_option['google_pay']=="google_pay" && $pooa_v == "google_pay") { ?>
										
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_google_pay" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="google_pay"){echo 'checked="checked"';}?> value="google_pay">
											<label class="custom-control-label" for="payment_method_google_pay"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['coinbase']=="coinbase" && $pooa_v == "coinbase") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_coinbase" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="coinbase"){echo 'checked="checked"';}?> value="coinbase">
											<label class="custom-control-label" for="payment_method_coinbase"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
										if($choosed_payment_option['facebook_pay']=="facebook_pay" && $pooa_v == "facebook_pay") { ?>
										<div class="custom-control custom-radio custom-control-inline">
											<input type="radio" id="payment_method_facebook_pay" name="payment_method" class="custom-control-input" <?php if($default_payment_option=="facebook_pay"){echo 'checked="checked"';}?> value="facebook_pay">
											<label class="custom-control-label" for="payment_method_facebook_pay"><?=$payment_icon[$pooa_v.'_name'].$payment_icon_img?></label>
										</div>
										<?php
										}
									} ?>
								</div>
								<?php

								if($choosed_payment_option['bank']=="bank") { ?>
								<div id="bank-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['bank']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" id="act_name" name="act_name" placeholder="<?=_lang('payment_method_act_name_place_holder_text','checkout')?>" autocomplete="nope" value="<?=$account_holder_name?>">
										<div id="act_name_error_msg" class="invalid-feedback  m_validations_showhide" style="display:none;"></div>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="act_number" name="act_number" placeholder="<?=_lang('payment_method_act_number_place_holder_text','checkout')?>" autocomplete="nope" value="<?=$account_number?>">
										<div id="act_number_error_msg" class="invalid-feedback  m_validations_showhide" style="display:none;"></div>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="act_short_code" name="act_short_code" placeholder="<?=_lang('payment_method_act_short_code_place_holder_text','checkout')?>" autocomplete="nope" value="<?=$short_code?>">
										<div id="act_short_code_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}

								if($choosed_payment_option['paypal']=="paypal") { ?>
								<div id="paypal-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['paypal']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" id="paypal_address" name="paypal_address" value="<?=$paypal_address?>" autocomplete="nope" placeholder="<?=_lang('payment_method_paypal_adr_place_holder_text','checkout')?>">
										<div id="paypal_address_error_msg" class="invalid-feedback  m_validations_showhide" style="display:none;"></div>
										<div id="exist_paypal_address_msg" class="invalid-feedback text-center" style="display:none;"></div>
									</div>

									<div class="form-group">
										<input type="text" class="form-control" id="confirm_paypal_address" name="confirm_paypal_address" value="<?=$paypal_address?>" autocomplete="nope" placeholder="<?=_lang('payment_method_paypal_adr_repeat_place_holder_text','checkout')?>">
										<div id="confirm_paypal_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}
								if($choosed_payment_option['cheque']=="cheque") { ?>
								<div id="cheque-form" class="payment-form clearfix">
								  <legend><?=$payment_instruction['cheque']?></legend>   
								</div>
								<?php
								}

								if($choosed_payment_option['coupon']=="coupon") { ?>
								<div id="coupon-form" class="payment-form clearfix">
								  <legend><?=$payment_instruction['coupon']?></legend>   
								</div>

								<?php
								}

								if($choosed_payment_option['venmo']=="venmo") { ?>
								<div id="venmo-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['venmo']?></legend>
									<div class="form-group">
										<input type="hidden" class="form-control" placeholder="<?=_lang('payment_method_venmo_adr_place_holder_text','checkout')?>" id="venmo_address"  name="venmo_address" autocomplete="nope" value="<?=$venmo_address?>">
										<div id="venmo_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php

								}

								if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
								<div id="amazon_gcard-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['amazon_gcard']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=_lang('payment_method_amazon_gcard_adr_place_holder_text','checkout')?>" id="amazon_gcard_address"  name="amazon_gcard_address" autocomplete="nope" value="<?=$amazon_gcard_address?>">
										<div id="amazon_gcard_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}
								if($choosed_payment_option['cash']=="cash") { ?>
								<div id="cash-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['cash']?></legend>
									<?php /*?><div class="form-group">
										<input type="text" class="form-control" id="cash_name" name="cash_name" placeholder="<?=_lang('payment_method_cash_name_place_holder_text','checkout')?>" value="<?=$cash_name?>">
										<div id="cash_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div><?php */?>

									<div class="form-group">
										<input type="tel" class="form-control" id="cash_phone" name="cash_phone" placeholder="<?=_lang('payment_method_cash_phone_place_holder_text','checkout')?>">
										<input type="hidden" name="f_cash_phone" id="f_cash_phone" />
										<div id="cash_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}

								if($choosed_payment_option['zelle']=="zelle") { ?>

								<div id="zelle-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['zelle']?></legend>
									<div class="form-group">
										<input type="email" maxlength="100" class="form-control" id="zelle_address" name="zelle_address" placeholder="<?=_lang('payment_method_zelle_adr_place_holder_text','checkout')?>" value="<?=$zelle_address?>">
										<div id="zelle_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}
								if($choosed_payment_option['cash_app']=="cash_app") { ?>
								<div id="cash_app-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['cash_app']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=_lang('payment_method_cash_app_adr_place_holder_text','checkout')?>" id="cash_app_address"  name="cash_app_address" autocomplete="nope" value="<?=$cash_app_address?>">
										<div id="cash_app_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}
								if($choosed_payment_option['apple_pay']=="apple_pay") { ?>

								<div id="apple_pay-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['apple_pay']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=_lang('payment_method_apple_pay_adr_place_holder_text','checkout')?>" id="apple_pay_address"  name="apple_pay_address" autocomplete="nope" value="<?=$apple_pay_address?>">
										<div id="apple_pay_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}
								if($choosed_payment_option['google_pay']=="google_pay") { ?>
								<div id="google_pay-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['google_pay']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=_lang('payment_method_google_pay_adr_place_holder_text','checkout')?>" id="google_pay_address"  name="google_pay_address" autocomplete="nope" value="<?=$google_pay_address?>">
										<div id="google_pay_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}
								if($choosed_payment_option['coinbase']=="coinbase") { ?>

								<div id="coinbase-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['coinbase']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=_lang('payment_method_coinbase_adr_place_holder_text','checkout')?>" id="coinbase_address"  name="coinbase_address" autocomplete="nope" value="<?=$coinbase_address?>">
										<div id="coinbase_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								}

								if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
								<div id="facebook_pay-form" class="payment-form clearfix">
									<legend><?=$payment_instruction['facebook_pay']?></legend>
									<div class="form-group">
										<input type="text" class="form-control" placeholder="<?=_lang('payment_method_facebook_pay_adr_place_holder_text','checkout')?>" id="facebook_pay_address"  name="facebook_pay_address" autocomplete="nope" value="<?=$facebook_pay_address?>">
										<div id="facebook_pay_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>   
								</div>
								<?php
								} ?>
							  </div>
							  <button type="button" class="btn step2next btn-primary btn-lg float-right mt-3 mb-3"><?=_lang('next_button_text')?></button>
							</div>
						  </div>
						</div>

						<div class="card">
						  <div class="card-header" id="shippingOption">
							<h2 class="mb-0">
							  <button class="btn btn-link collapsed" type="button" data-toggle="" data-target="#shipping" aria-expanded="false" aria-controls="shipping">
								<?=($user_id>0 || $enable_login_register != '1'?2:3)?>. <?=_lang('shipping_tab_title','checkout')?> <span class="checkout-step-data shipping_step_data"></span> <span class="collapsethree_chkd"></span>
							  </button>
							</h2>
						  </div>

						  <div id="shipping" class="collapse" aria-labelledby="shippingOption" data-parent="#checkout">
							<div class="card-body shipping-fields">
							  <div class="checkout-block get-paid-faster mb-5 clearfix">
								<?php
								if(!empty(array_filter($shipping_option))) { ?>
								<h3><?=_lang('select_shipping_method_title','checkout')?></h3>
								<div class="form-row">
									<div class="form-group col-md-12 shipping_method_section">
										<?php
										$shipping_option_instruction_arr = array();
										foreach($shipping_option_ordr_arr as $sooa_k=>$sooa_v) {
											$shipping_instruction = $shipping_option_ordr_instr_arr[$sooa_v];
											$shipping_option_instruction_arr[] = array('shipping_option'=>$sooa_v,'shipping_instruction'=>$shipping_instruction);
											
											$is_show_address_fields = '0';
											if(isset($shipping_option[$sooa_v.'_show_address_fields']) && $shipping_option[$sooa_v.'_show_address_fields'] == '1') {
												$is_show_address_fields = '1';
											}
											
											if($shipping_option['post_me_a_prepaid_label'] == $sooa_v) { ?>
											<div class="custom-control custom-radio">
												<label>
												<input class="shipping_method" type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_post_me_a_prepaid_label" name="shipping_method" value="post_me_a_prepaid_label">
												<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
												<?php
												if($shipping_option[$sooa_v.'_image']!="") {
													// echo '<img src="'.SITE_URL.'media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
												} ?>
											</div>
											<?php
											}

											if($shipping_option['print_a_prepaid_label'] == $sooa_v && $sell_order_total > 20) { ?>
											<div class="custom-control custom-radio">
												<label>
												<input class="shipping_method" type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_print_a_prepaid_label" name="shipping_method" value="print_a_prepaid_label">
												<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
												<?php
												if($shipping_option[$sooa_v.'_image']!="") {
													// echo '<img src="'.SITE_URL.'media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
												} ?>
											</div>
											<?php
											}

											if($shipping_option['use_my_own_courier'] == $sooa_v) { ?>
											<div class="custom-control custom-radio">
												<label>
												<input class="shipping_method" type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_use_my_own_courier" name="shipping_method" value="use_my_own_courier">
												<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
												<?php
												if($shipping_option[$sooa_v.'_image']!="") {
													// echo '<img src="'.SITE_URL.'media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
												} ?>
											</div>
											<?php
											}
											if($shipping_option['we_come_for_you'] == $sooa_v) { ?>
											<div class="custom-control custom-radio">
												<label>
												<input class="shipping_method" type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_we_come_for_you" name="shipping_method" value="we_come_for_you">
												<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
												<?php
												if($shipping_option[$sooa_v.'_image']!="") {
													// echo '<img src="'.SITE_URL.'media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
												} ?>
											</div>
											<?php
											}
											$store_location_list = get_store_location_list('','store');
											if($shipping_option['store'] == $sooa_v && !empty($store_location_list)) { ?>
											<div class="custom-control custom-radio">
												<label>
												<input type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_store" name="shipping_method" value="store">
												<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
												<?php
												if($shipping_option[$sooa_v.'_image']!="") {
													// echo '<img src="'.SITE_URL.'media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
												} ?>
											</div>
											<?php
											}

											$starbucks_location_list = get_store_location_list('','starbucks');
											if($shipping_option['starbucks'] == $sooa_v && !empty($starbucks_location_list)) { ?>
											<div class="custom-control custom-radio">
												<label>
												<input type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_starbucks" name="shipping_method" value="starbucks">
												<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
												<?php
												if($shipping_option[$sooa_v.'_image']!="") {
													// echo '<img src="'.SITE_URL.'media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
												} ?>
											</div>
											<?php
											}
										} ?>
									</div>

									<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
								
                                    <?php
                                    $shipping_api_enable_count = 0;
                                    if($enable_shipping_api_ups == '1') {
                                        $shipping_api_enable_count=$shipping_api_enable_count+1;
                                    }
                                    if($enable_shipping_api_fedex == '1') {
                                        $shipping_api_enable_count=$shipping_api_enable_count+1;
                                    }
                                    if($shipping_api_enable_count>1) { ?>
                                        <h5 class="shipping_label_option_showhide" style="display:none;"><?=_lang('shipping_label_option_heading_text','checkout')?></h5>
                                        <div class="form-row shipping_label_option_showhide" style="display:none;">
                                            <div class="form-group col-md-12 shipping_method_section">
                                                <?php 
												if($enable_shipping_api_ups == '1') { ?>
                                                <div class="custom-control custom-radio">
                                                    <label>
                                                    <input type="radio" name="shipment_label_option" value="ups" <?=($default_carrier_account == "ups"?'checked="checked"':'')?>>
                                                    <span><?=_lang('shipping_label_option_ups_text','checkout')?></span></label>
                                                </div>
                                                <?php 
												}
												if($enable_shipping_api_fedex == '1') { ?>
                                                <div class="custom-control custom-radio">
                                                    <label>
                                                    <input type="radio" name="shipment_label_option" value="fedex" <?=($default_carrier_account == "fedex"?'checked="checked"':'')?>>
                                                    <span><?=_lang('shipping_label_option_fedex_text','checkout')?></span></label>
                                                </div>
                                                <?php 
												} ?>
                                            </div>
                                        </div>
                                    <?php
                                    } else { ?>
                                        <input type="hidden" name="shipment_label_option" class="shipping_label_option_showhide" value="<?php if($enable_shipping_api_fedex == '1'){echo 'fedex';}elseif($enable_shipping_api_ups == '1'){echo 'ups';} ?>">
                                    <?php
                                    }
								} else { ?>
									<div class="custom-control custom-radio" style="display:none;">
										<input type="radio" id="sm_post_me_a_prepaid_label" name="shipping_method" value="none" checked="checked">
										<label><span>None</span></label>
										<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								<?php
								} ?>
								
								<input type="hidden" name="is_show_address_fields" id="is_show_address_fields" value="1">
								
								<div class="shipping-instruction-list">
									<?php
									foreach($shipping_option_instruction_arr as $shipping_option_instruction_dt) { ?>
										<div class="shipping-instruction" id="shipping-instruction-<?=$shipping_option_instruction_dt['shipping_option']?>" style="display:none;"><?=$shipping_option_instruction_dt['shipping_instruction']?></div>
									<?php
									} ?>
								</div>
								
								<div class="pickup_date_fields" style="display:none;">
									<div class="form-row">
										<div class="form-group col-md-12 mt-3 with-icon">
											<img src="<?=SITE_URL?>media/images/icons/date-gray.png" alt="" width="20">
											<input type="text" class="form-control date_picker" name="shipping_pickup_date" id="shipping_pickup_date" placeholder="<?=_lang('shipping_pickup_date_place_holder_text','checkout')?>" autocomplete="nope">
											<div id="shipping_pickup_date_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
										</div>
									</div>
								</div>
								
								<div class="pickup_date_fields"></div>
								<div class="shipping_method_locations mt-3"></div>
								<div class="shipping_method_dates">
									<div class="form-row">
										<div class="form-group col-md-12">
											<input type="text" name="date" placeholder="<?=_lang('shipping_method_date_place_holder_text','checkout')?>" class="form-control repair_appt_date" id="date" autocomplete="off">
											<small id="date_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
										</div>
									</div>
								</div>
								<div class="form-row shipping_method_times"></div>
							  </div>
							  
							  <div class="checkout_step_loading_icon"></div>
							  
							  <div class="checkout-block mb-5 clearfix address_details_tab">
								  <h3><?=_lang('shipping_tab_heading_text','checkout')?></h3>
								  <div class="form-row">
									<div class="form-group col-md-4">
									  <label for="first_name"><?=_lang('shipping_first_name_field_text','checkout')?></label>
									  <input type="text" name="first_name" id="first_name" class="form-control" value="<?=$user_data['first_name']?>"/>
									  <small id="first_name_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
									<div class="form-group col-md-4">
									  <label for="last_name"><?=_lang('shipping_last_name_field_text','checkout')?></label>
									  <input type="text" name="last_name" id="last_name" class="form-control" value="<?=$user_data['last_name']?>"/>
									  <small id="last_name_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
									<div class="form-group col-md-4">
									  <label for="c_cell_phone"><?=_lang('shipping_phone_field_text','checkout')?></label>
									  <input type="tel" id="c_cell_phone" name="c_cell_phone" class="form-control" placeholder="<?=_lang('phone_field_placeholder_text','checkout')?>">
									  <input type="hidden" name="phone_c_code" id="phone_c_code" />
									  <small id="c_cell_phone_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>
								  
								  <?php
								  if($enable_login_register != '1') { ?>
								  <div class="form-row">
									<div class="form-group col-md-12">
									  <label for="tmp_signup_email"><?=_lang('email_field_label_text','signup_form')?></label>
									  <input type="text" name="tmp_signup_email" id="tmp_signup_email" class="form-control" value="<?=(isset($email_while_add_to_cart)?$email_while_add_to_cart:'')?>"/>
									  <small id="shipping_email_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>
								  <?php
								  } ?>


								  <div class="form-row address_for_without_usa" style="display:none;">
									<div class="form-group col-md-12">
									  <label ><?=_lang('shipping_full_shipping_address_field_text','checkout')?></label>
									  <input type="text" name="address" class="form-control ca_address" id="ca_address" placeholder="Enter a address"  autocomplete="off"/>
									  <small id="ca_address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>
								  
								  <div class="form-row address-fields-showhide address_for_with_usa"> 
									<div class="form-group col-md-12">
									  <label for="address"><?=_lang('shipping_street_address_field_text','checkout')?></label>
									  <input type="text" name="address" id="address" class="form-control address" value="<?=$user_data['address']?>" autocomplete="off"/>
									  <small id="address_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>
								  
								  <?php
								  if($show_house_number_field == '1') { ?>
								  <div class="form-row address-fields-showhide">
									<div class="form-group col-md-12">
									  <label for="house_number"><?=_lang('shipping_street_house_number_field_text','checkout')?></label>
									  <input type="text" name="house_number" id="house_number" class="form-control" value="<?=$user_data['house_number']?>" autocomplete="off"/>
									  <small id="house_number_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>
								  <?php
								  } ?>

								  <div class="form-row address-fields-showhide">
									<div class="form-group col-md-12">
									  <label for="address2"><?=_lang('shipping_street_address_2_field_text','checkout')?></label>
									  <input type="text" name="address2" id="address2" class="form-control" value="<?=$user_data['address2']?>" autocomplete="off"/>
									  <small id="address2_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>

								  <div class="form-row address-fields-showhide">
									<div class="form-group <?php if($hide_state_field != '1') { ?>col-md-4<?php } else { ?>col-md-6<?php } ?>">
									  <label for="city"><?=_lang('shipping_city_field_text','checkout')?></label>
									  <input type="text" name="city" id="city" class="form-control" value="<?=$user_data['city']?>" autocomplete="off"/>
									  <small id="city_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
									<?php
									if($hide_state_field != '1') { ?>
									<div class="form-group col-md-4">
										<label for="state"><?=_lang('shipping_state_field_text','checkout')?></label>
										<input type="text" name="state" id="state" class="form-control" value="<?=$user_data['state']?>" autocomplete="off"/>
										<small id="state_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
									<?php
									} ?>
									
									<div class="form-group <?php if($hide_state_field != '1') { ?>col-md-4<?php } else { ?>col-md-6<?php } ?>">
										<label for="postcode"><?=_lang('shipping_zipcode_field_text','checkout')?></label>
										<input type="text" name="postcode" id="postcode" class="form-control" value="<?=$user_data['postcode']?>" autocomplete="off"/>
										<small id="postcode_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									</div>
								  </div>

								  <div class="form-row">
										<div class="form-group col-md-2" id="shipping_country_usa_div" style="display: none;">
											<label>
												<input type="radio" id="shipping_country_usa" name="shipping_country" value="USA" checked>
												<span>USA </span>
											</label>
										</div>
										<div class="form-group col-md-2" id="shipping_country_canada_div" style="display: none;">
											<label>
												<input type="radio" id="shipping_country_canada" name="shipping_country" value="Canada">
												<span>Canada</span>
											</label>
										</div>
									</div>					
							  </div>

							  <?php
							  if($is_confirm_sale_terms) { ?>
							  <button type="button" class="btn btn-primary btn-lg float-right mt-3 mb-3 step3next"><?=_lang('next_button_text')?></button>
							  <?php
							  } else { ?>
							  <button type="button" class="btn btn-primary btn-lg float-right mt-3 mb-3 get_paid"><?=_lang('checkout_button_text')?></button>
							  <?php
							  } ?>
							</div>
						  </div>
						</div>

						<?php
						if($is_confirm_sale_terms) { ?>
						<div class="card">
						  <div class="card-header" id="termsOptionSelect">
							<h2 class="mb-0">
							  <button class="btn btn-link collapsed" type="button" data-toggle=""
								data-target="#termsOption" aria-expanded="false" aria-controls="termsOption">
								<?=($user_id>0 || $enable_login_register != '1'?3:4)?>. <?=_lang('additional_options_and_terms_tab_title','checkout')?>
							  </button>
							</h2>
						  </div>
						  <div id="termsOption" class="collapse" aria-labelledby="termsOptionSelect"
							data-parent="#checkout">
							<div class="card-body">
							  <div class="checkout-block terms_condition clearfix">
								<?php
								if($is_confirm_sale_terms) { ?>
								<h3><?=_lang('additional_options_and_terms_tab_heading_text','checkout')?></h3>
								<div class="custom-control custom-checkbox">
								  <input type="checkbox" class="custom-control-input" name="terms_and_conditions" id="terms_and_conditions" value="1">
								  <label class="custom-control-label" for="terms_and_conditions"><?=_lang('terms_and_conditions_link_before_text','checkout')?> <a href="javascript:void(0)" class="help-icon click_terms_of_website_use"><?=_lang('terms_and_conditions_link_text','checkout')?></a></label>
								  <small id="terms_and_conditions_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
								</div>
								<?php
								} else {
									echo '<input type="hidden" name="terms_and_conditions" id="terms_and_conditions" value="1"/>';
								} ?>
							  </div>
							  
							  <div class="checkout_step_loading_icon"></div>
							  
							  <button type="button" class="btn btn-primary btn-lg float-right mt-3 mb-3 get_paid"><?=_lang('checkout_button_text')?></button>
							</div>
						  </div>
						</div>
						<?php
						} ?>
						
                        <input type="hidden" name="controller" value="checkout" />
						<input type="hidden" name="submit_form" id="submit_form" />
						<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
						<input type="hidden" name="user_id" id="user_id" value=""/>
						
						<?php
						if($enable_login_register == '1') { ?>
						<input type="hidden" name="tmp_signup_email" id="tmp_signup_email" value="<?=$checkout_signup_prefill_email?>"/>
						<?php
						}
						
						$csrf_token = generateFormToken('checkout'); ?>
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
					</form>
                  </div>
                </div>
              </div>

              <div class="col-xl-4 col-lg-4 col-md-12 mt-3">
                <div class="block content cart-page cart-summary-page clearfix">
                  <div class="h2 clearfix">
                    <div class="float-left">
                      <?=_lang('order_summary_heading_text','checkout')?>
                    </div>
                    <div class="float-right">
                      <a href="<?=SITE_URL?>cart" class="btn btn-link btn-edit"><?=_lang('edit_button_text')?></a>
                    </div>
                  </div>
                  <table class="table">
				    <?php
					if($order_num_of_rows>0) {
						$num_of_quantity = array();
						foreach($order_item_list as $order_item_list_data) {

						  //path of this function (get_order_item) admin/_config/functions.php
						  $order_item_data = get_order_item($order_item_list_data['id'],'list');
						  $model_data = get_single_model_data($order_item_list_data['model_id']);
						  $mdl_details_url = SITE_URL.$model_details_page_slug.$model_data['sef_url']; ?>
						  <tr>
						  <td class="details">
							<div class="row">
							  <div class="col-md-3 col-3 col-lg-2 col-xl-2">
								<?php
								if($order_item_list_data['model_img']) {
									echo '<img src="'.SITE_URL.'media/images/model/'.$order_item_list_data['model_img'].'"/>';
								} ?>
							  </div>
							  <div class="col-md-9 col-9 col-lg-10 col-xl-10">
								<?php
								if($order_item_data['device_name']) {
									echo '<h3>' . $order_item_data['device_name'] . '</h3>';
								}
								if($order_item_data['item_name']) {
								  echo $order_item_data['item_name'];
								}
								if($order_item_data['data']['imei_number']) {
								  echo '<strong>'._lang('imei_heading_text','checkout').'</strong> '.$order_item_data['data']['imei_number'];
								} ?>
								<h4 class="price"><?=amount_fomat($order_item_list_data['price'])?></h4>
							  </div>
							</div>
						  </td>
						  </tr>
						<?php
					    $num_of_quantity[] = $order_item_list_data['quantity'];
						}
					} ?>
                  </table>
                  <div class="border-divider mb-3"></div>
                  <div class="summary-details clearfix">
					<div class="row">
                      <div class="col-md-6 col-6">
                        <h4><?=_lang('sell_order_total_heading_text','checkout')?></h4>
                      </div>
                      <div class="col-md-6 col-6">
                        <span><?=($sell_order_total>0?amount_fomat($sell_order_total):amount_fomat('0'))?></span>
                      </div>
                    </div>

					<?php
					if($is_promocode_exist || $bonus_amount) {
		  				$total = ($sell_order_total+$promocode_amt+$bonus_amount);
						if($is_promocode_exist) { ?>
							<div class="row">
							  <div class="col-md-6 col-6">
								<h4><?=$discount_amt_label?></h4>
							  </div>
							  <div class="col-md-6 col-6">
								<span><?=amount_fomat($promocode_amt)?></span>
							  </div>
							</div>
						<?php
						}
						if($bonus_amount>0) { ?>
							<div class="row">
							  <div class="col-md-6 col-6">
								<h4><?=_lang('bonus_amount_heading_text','checkout')?> (<?=$bonus_percentage?>%)</h4>
							  </div>
							  <div class="col-md-6 col-6">
								<span><?= amount_fomat($bonus_amount) ?></span>
							  </div>
							</div>

						<?php

						} ?>
						<div class="row">
						  <div class="col-md-6 col-6">
							<h4><?=_lang('total_amount_heading_text','checkout')?></h4>
						  </div>
						  <div class="col-md-6 col-6">
							<span class="totla-price">
							  <?=amount_fomat($total)?>
							</span>
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

<?php
if($login_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
}

if($place_api_key && $place_api_key_status == '1') {
	echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$place_api_key.'&callback=initAutocomplete&libraries=places&v=weekly" async></script>';
} ?>

<script>
var autocomplete;
var address1;
var city;
var state;
var zipcode;

var g_c_login_f_wdt_id;
<?php
if($login_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		g_c_login_f_wdt_id = grecaptcha.render('g_form_gcaptcha', {
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
		check_checkout_login_form();
	}
};
<?php
} ?>

var iti_ipt;
var iti_ipt2;
var tpj=jQuery;

(function( $ ) {
	$(function() {
		var checkout_telInput = document.querySelector("#c_cell_phone");
		iti_ipt = window.intlTelInput(checkout_telInput, {
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>assets/js/intlTelInput-utils.js"
		});
		iti_ipt.setNumber("<?=($user_data['phone']?'+'.$user_data['country_code'].$user_data['phone']:'')?>");

		var checkout_telInput2 = document.querySelector("#cash_phone");
		iti_ipt2 = window.intlTelInput(checkout_telInput2, {
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>assets/js/intlTelInput-utils.js"
		});
		iti_ipt2.setNumber("<?=($cash_phone?'+'.$user_data['country_code'].$cash_phone:'')?>");
	});
})(jQuery);

//START for check booking available
function repair_appt_date_picker(type) {
	var closed_days = [];
	if(type == "change") {
		closed_days_val = jQuery('#location_id option:selected').data('closed_days');
		if(closed_days_val.length) {
			closed_days = closed_days_val; //[closed_days_val];
			console.log('closed_days: ',closed_days);
			jQuery('.repair_appt_date').datepicker({
				autoclose: true,
				startDate: "today",
				todayHighlight: true,
				daysOfWeekDisabled: closed_days,
				format: '<?=$js_date_format?>'
			}).on('changeDate', function(e) {
				getTimeSlotListByDate();
			});
		} else {
			jQuery('.repair_appt_date').datepicker({
				autoclose: true,
				startDate: "today",
				todayHighlight: true,
				format: '<?=$js_date_format?>'
			}).on('changeDate', function(e) {
				getTimeSlotListByDate();
			});
		}
	}
} //END for check booking available

function getLocationList(id)
{
	var location_id = id;
	if(location_id>0) {
		tpj(".shipping_method_times").html('');
		tpj(".location-adr-show-hide").hide();
		tpj("#location-adr-"+id).show();
		tpj(".shipping_method_dates").show();
		tpj(".repair_appt_date").val('');
		repair_appt_date_picker('change');
	} else {
		tpj(".shipping_method_times").html('');
		tpj(".location-adr-show-hide").hide();
		tpj(".shipping_method_dates").hide();
		tpj(".repair_appt_date").val('');
	}

	var show_appt_datetime_selection_in_place_order = tpj('#location_id option:selected').data('show_appt_datetime_selection_in_place_order');
	if(show_appt_datetime_selection_in_place_order == 1) {
		tpj(".shipping_method_dates").show();
		tpj(".repair_appt_date").val('');
	} else {
		tpj(".shipping_method_dates").hide();
		tpj(".repair_appt_date").val('');
	}
}

function check_payment_step() {
	tpj(".m_validations_showhide").hide();
	<?php
	if($choosed_payment_option['bank']=="bank") { ?>
	if(document.getElementById("payment_method_bank").checked==true) {
		if(document.getElementById("act_name").value.trim()=="") {
			tpj("#act_name_error_msg").show().text('<?=_lang('payment_method_act_name_validation_text','checkout')?>');
			return false;
		} else if(document.getElementById("act_number").value.trim()=="") {
			tpj("#act_number_error_msg").show().text('<?=_lang('payment_method_act_number_validation_text','checkout')?>');
			return false;
		} else if(document.getElementById("act_short_code").value.trim()=="") {
			tpj("#act_short_code_error_msg").show().text('<?=_lang('payment_method_act_short_code_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['paypal']=="paypal") { ?>
	if(document.getElementById("payment_method_paypal").checked==true) {
		var paypal_address = document.getElementById("paypal_address").value.trim();
		var confirm_paypal_address = document.getElementById("confirm_paypal_address").value.trim();
		if(paypal_address=="") {
			tpj("#paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_adr_validation_text','checkout')?>');
			return false;
		} else if(!paypal_address.match(mailformat)) {
			tpj("#paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_valid_adr_validation_text','checkout')?>');
			return false;
		} else if(confirm_paypal_address=="") {
			tpj("#confirm_paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_adr_repeat_validation_text','checkout')?>');
			return false;
		} else if(paypal_address!=confirm_paypal_address) {
			tpj("#paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_and_confirm_paypal_address_not_match_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['cash']=="cash") { ?>
	if(document.getElementById("payment_method_cash").checked==true) {
		<?php /*?>if(document.getElementById("cash_name").value.trim()=="") {
			tpj("#cash_name_error_msg").show().text('<?=_lang('payment_method_cash_name_validation_text','checkout')?>');
			return false;
		}<?php */?>

		tpj("#f_cash_phone").val(iti_ipt2.getNumber());

		var cash_phone = document.getElementById("cash_phone").value.trim();
		if(cash_phone=="") {
			tpj("#cash_phone_error_msg").show().text('<?=_lang('payment_method_cash_phone_validation_text','checkout')?>');
			return false;
		} else if(!iti_ipt2.isValidNumber()) {
			tpj("#cash_phone_error_msg").show().text('<?=_lang('payment_method_cash_valid_phone_validation_text','checkout')?>');
			return false;
		}
	}

	<?php
	}
	if($choosed_payment_option['zelle']=="zelle") { ?>
	if(document.getElementById("payment_method_zelle").checked==true) {
		var zelle_address = document.getElementById("zelle_address").value.trim();
		if(zelle_address=="") {
			tpj("#zelle_address_error_msg").show().text('<?=_lang('payment_method_zelle_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['venmo']=="venmo") { ?>
	if(document.getElementById("payment_method_venmo").checked==true) {
		var venmo_address = document.getElementById("venmo_address").value.trim();
		if(venmo_address=="") {
			tpj("#venmo_address_error_msg").show().text('<?=_lang('payment_method_venmo_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}

	if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
	if(document.getElementById("payment_method_amazon_gcard").checked==true) {
		var amazon_gcard_address = document.getElementById("amazon_gcard_address").value.trim();
		if(amazon_gcard_address=="") {
			tpj("#amazon_gcard_address_error_msg").show().text('<?=_lang('payment_method_amazon_gcard_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}

	if($choosed_payment_option['cash_app']=="cash_app") { ?>
	if(document.getElementById("payment_method_cash_app").checked==true) {
		var cash_app_address = document.getElementById("cash_app_address").value.trim();
		if(cash_app_address=="") {
			tpj("#cash_app_address_error_msg").show().text('<?=_lang('payment_method_cash_app_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
	if(document.getElementById("payment_method_apple_pay").checked==true) {
		var apple_pay_address = document.getElementById("apple_pay_address").value.trim();
		if(apple_pay_address=="") {
			tpj("#apple_pay_address_error_msg").show().text('<?=_lang('payment_method_apple_pay_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['google_pay']=="google_pay") { ?>
	if(document.getElementById("payment_method_google_pay").checked==true) {
		var google_pay_address = document.getElementById("google_pay_address").value.trim();
		if(google_pay_address=="") {
			tpj("#google_pay_address_error_msg").show().text('<?=_lang('payment_method_google_pay_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['coinbase']=="coinbase") { ?>
	if(document.getElementById("payment_method_coinbase").checked==true) {
		var coinbase_address = document.getElementById("coinbase_address").value.trim();
		if(coinbase_address=="") {
			tpj("#coinbase_address_error_msg").show().text('<?=_lang('payment_method_coinbase_adr_validation_text','checkout')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
	if(document.getElementById("payment_method_facebook_pay").checked==true) {
		var facebook_pay_address = document.getElementById("facebook_pay_address").value.trim();
		if(facebook_pay_address=="") {
			tpj("#facebook_pay_address_error_msg").show().text('<?=_lang('payment_method_facebook_pay_adr_validation_text','checkout')?>');
			return false;
		}
	}

	<?php

	} ?>
}

function check_payment_step2() {
	tpj(".m_validations_showhide").hide();
	<?php
	if($choosed_payment_option['bank']=="bank") { ?>
	if(document.getElementById("payment_method_bank").checked==true) {
		if(document.getElementById("act_name").value.trim()=="") {
			return false;
		} else if(document.getElementById("act_number").value.trim()=="") {
			return false;
		} else if(document.getElementById("act_short_code").value.trim()=="") {
			return false;
		}
	}

	<?php
	}
	if($choosed_payment_option['paypal']=="paypal") { ?>
	if(document.getElementById("payment_method_paypal").checked==true) {
		var paypal_address = document.getElementById("paypal_address").value.trim();
		var confirm_paypal_address = document.getElementById("confirm_paypal_address").value.trim();
		if(paypal_address=="") {
			return false;
		} else if(!paypal_address.match(mailformat)) {
			return false;

		} else if(confirm_paypal_address=="") {
			return false;
		} else if(paypal_address!=confirm_paypal_address) {
			return false;
		}
	}
	<?php
	}

	if($choosed_payment_option['cash']=="cash") { ?>
	if(document.getElementById("payment_method_cash").checked==true) {
		<?php /*?>if(document.getElementById("cash_name").value.trim()=="") {
			return false;
		}<?php */?>

		tpj("#f_cash_phone").val(iti_ipt2.getNumber());
		
		var cash_phone = document.getElementById("cash_phone").value.trim();
		if(cash_phone=="") {
			return false;
		} else if(!iti_ipt2.isValidNumber()) {
			return false;
		}
	}

	<?php
	}

	if($choosed_payment_option['zelle']=="zelle") { ?>
	if(document.getElementById("payment_method_zelle").checked==true) {
		var zelle_address = document.getElementById("zelle_address").value.trim();
		if(zelle_address=="") {
			return false;
		}
	}

	<?php
	}

	if($choosed_payment_option['venmo']=="venmo") { ?>
	if(document.getElementById("payment_method_venmo").checked==true) {
		var venmo_address = document.getElementById("venmo_address").value.trim();
		if(venmo_address=="") {
			return false;
		}
	}

	<?php
	}
	if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
	if(document.getElementById("payment_method_amazon_gcard").checked==true) {
		var amazon_gcard_address = document.getElementById("amazon_gcard_address").value.trim();
		if(amazon_gcard_address=="") {
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['cash_app']=="cash_app") { ?>
	if(document.getElementById("payment_method_cash_app").checked==true) {
		var cash_app_address = document.getElementById("cash_app_address").value.trim();
		if(cash_app_address=="") {
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
	if(document.getElementById("payment_method_apple_pay").checked==true) {
		var apple_pay_address = document.getElementById("apple_pay_address").value.trim();
		if(apple_pay_address=="") {
			return false;
		}
	}

	<?php
	}
	if($choosed_payment_option['google_pay']=="google_pay") { ?>
	if(document.getElementById("payment_method_google_pay").checked==true) {
		var google_pay_address = document.getElementById("google_pay_address").value.trim();
		if(google_pay_address=="") {
			return false;
		}

	}

	<?php
	}
	if($choosed_payment_option['coinbase']=="coinbase") { ?>
	if(document.getElementById("payment_method_coinbase").checked==true) {
		var coinbase_address = document.getElementById("coinbase_address").value.trim();
		if(coinbase_address=="") {
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
	if(document.getElementById("payment_method_facebook_pay").checked==true) {
		var facebook_pay_address = document.getElementById("facebook_pay_address").value.trim();
		if(facebook_pay_address=="") {
			return false;
		}
	}
	<?php
	} ?>
}

function check_address_details() {
	tpj(".m_validations_showhide").hide();
	var is_show_address_fields = tpj("#is_show_address_fields").val();

	var first_name = document.getElementById("first_name").value.trim();
	var last_name = document.getElementById("last_name").value.trim();
	var address = document.getElementById("address").value.trim();
	<?php
	if($show_house_number_field == '1') { ?>
	var house_number = document.getElementById("house_number").value.trim();
	<?php
	} ?>
	var city = document.getElementById("city").value.trim();
	<?php
	if($hide_state_field != '1') { ?>
	var state = document.getElementById("state").value.trim();
	<?php
	} ?>
	var postcode = document.getElementById("postcode").value.trim();
	
	var shipping_method = tpj("input[name='shipping_method']:checked").val();
	if(typeof shipping_method === 'undefined') {
		tpj("#shipping_method_error_msg").show().text('<?=_lang('shipping_method_validation_text','checkout')?>');
		return false;
	}

	if(shipping_method == "print_a_prepaid_label") {
		var address = document.getElementById("address").value.trim();

		if(typeof address != 'undefined') {
			if(address == "" && is_show_address_fields == '1') {
				tpj("#address_error_msg").show().text('<?=_lang('shipping_street_address_validation_text','checkout')?>');
				return false;
			}
		}
	}

	if(shipping_method == "post_me_a_prepaid_label") {
		var ca_address = document.getElementById("ca_address").value.trim();

		if(typeof ca_address != 'undefined') {
			if(ca_address == "" && is_show_address_fields == '1') {
				tpj("#ca_address_error_msg").show().text('<?=_lang('shipping_street_address_validation_text','checkout')?>');
				return false;
			}
		}

		
	}

	if(shipping_method == "store" || shipping_method == "starbucks") {
		if(document.getElementById("location_id").value.trim()=="") {
			tpj("#location_id_error_msg").show().text('<?=_lang('shipping_location_validation_text','checkout')?>');
			return false;
		}
		var show_appt_datetime_selection_in_place_order = tpj('#location_id option:selected').data('show_appt_datetime_selection_in_place_order');
		if(document.getElementById("date") != null) {
			var l_date = document.getElementById("date").value.trim();
			if(l_date=="" && show_appt_datetime_selection_in_place_order == 1) {
				tpj("#date_error_msg").show().text('<?=_lang('shipping_date_validation_text','checkout')?>');
				return false;
			}
		}
		if(document.getElementById("time_slot") != null) {
			var time_slot = document.getElementById("time_slot").value.trim();
			if(time_slot=="" && show_appt_datetime_selection_in_place_order == 1) {
				tpj("#time_slot_error_msg").show().text('<?=_lang('shipping_time_validation_text','checkout')?>');
				return false;
			}
		}
	}

	if(first_name == "") {
		tpj("#first_name_error_msg").show().text('<?=_lang('shipping_first_name_validation_text','checkout')?>');
		return false;
	} else if(last_name == "") {
		tpj("#last_name_error_msg").show().text('<?=_lang('shipping_last_name_validation_text','checkout')?>');
		return false;
	}
	
	tpj("#phone_c_code").val(iti_ipt.getSelectedCountryData().dialCode);
	var phone = document.getElementById("c_cell_phone").value.trim();
	if(phone=="") {
		tpj("#c_cell_phone_error_msg").show().text('<?=_lang('shipping_phone_validation_text','checkout')?>');
		return false;
	} else if(!iti_ipt.isValidNumber()) {
		tpj("#c_cell_phone_error_msg").show().text('<?=_lang('shipping_valid_phone_validation_text','checkout')?>');
		return false;
	} 
	
	<?php
	if($enable_login_register != '1') { ?>
	var shipping_email = document.getElementById("tmp_signup_email").value.trim();
	if(shipping_email=="") {
		tpj("#shipping_email_error_msg").show().text('<?=_lang('email_field_validation_text','signup_form')?>');
		return false;
	} else if(!shipping_email.match(mailformat)) {
		tpj("#shipping_email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','signup_form')?>');
		return false;
	}
	<?php
	} ?>	
	
	<?php
	if($show_house_number_field == '1') { ?>
	if(house_number == "" && is_show_address_fields == '1') {
		tpj("#house_number_error_msg").show().text('<?=_lang('shipping_street_house_number_validation_text','checkout')?>');
		return false;
	}
	<?php
	} ?>							
	 else if(city == "" && is_show_address_fields == '1') {
		tpj("#city_error_msg").show().text('<?=_lang('shipping_city_validation_text','checkout')?>');
		return false;
	}
	
	<?php
	if($hide_state_field != '1') { ?>
	 else if(state == "" && is_show_address_fields == '1') {
		tpj("#state_error_msg").show().text('<?=_lang('shipping_state_validation_text','checkout')?>');
		return false;
	}
	<?php
	} ?>
	
	 else if(postcode == "" && is_show_address_fields == '1') {
		tpj("#postcode_error_msg").show().text('<?=_lang('shipping_zipcode_validation_text','checkout')?>');
		return false;
	}
}

function getTimeSlotListByDate()
{
	var location_id = tpj("#location_id").val();
	if(location_id>0) {
		tpj(".time_slot_sec_showhide").show();
		var date = tpj("#date").val();
		post_data = "location_id="+location_id+"&date="+date+"&option=1&token=<?=get_unique_id_on_load()?>";
		tpj(document).ready(function($){
			tpj.ajax({
				type: "POST",
				url:"<?=SITE_URL?>ajax/get_timeslot_list.php",
				data:post_data,
				success:function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.html!="") {
							tpj(".shipping_method_times").html(resp_data.html);
							tpj('.repair_time_slot').on('change', function(e) {
								check_booking_available();
							});
						}

					} else {
						alert('Something went wrong!!');
						return false;
					}
				}
			});
		});
	}
}

function check_booking_available() {
	var location_id = tpj("#location_id").val();
	var date = tpj("#date").val();
	var time = tpj(".repair_time_slot").val();
	if(time) {
		var shipping_method = tpj("input[name='shipping_method']:checked").val();
		post_data = "date="+date+"&time="+time+"&location_id="+location_id+"&shipping_method="+shipping_method+"&token=<?=get_unique_id_on_load()?>";
		tpj.ajax({
			type: "POST",
			url:"<?=SITE_URL?>ajax/check_booking_available.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					if(resp_data.booking_allow==false) {
						tpj(".step3next").attr("disabled", "disabled");
						tpj(".time-slot-msg").show();
						tpj(".time-slot-msg").html(resp_data.msg);
					} else {
						tpj(".step3next").removeAttr("disabled");
						tpj(".time-slot-msg").hide();

					}
				} else {
					return false;
				}
			}
		});
	}
}

function check_create_account_form() {
	tpj(".m_validations_showhide").hide();				
	var email = tpj("#checkout_signup_email").val();
	if(email=="") {
		tpj("#checkout_signup_email_error_msg").show().text('<?=_lang('email_field_validation_text','signup_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		tpj("#checkout_signup_email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','signup_form')?>');
		return false;
	}
}

function check_checkout_login_form() {
	tpj(".m_validations_showhide").hide();
	tpj('.signin-f-form-msg').hide().html('');
				
	var username = tpj("#s_username").val();
	var password = tpj("#s_password").val();
	var captcha_token = tpj("#g_captcha_token").val();
	if(username=="") {
		tpj("#checkout_login_email_error_msg").show().text('<?=_lang('email_field_validation_text','login_form')?>');
		return false;
	} else if(!username.match(mailformat)) {
		tpj("#checkout_login_email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','login_form')?>');
		return false;
	} else if(password=="") {
		tpj("#checkout_login_password_error_msg").show().text('<?=_lang('password_field_validation_text','login_form')?>');
		return false;
	} else if(login_form_captcha == '1' && captcha_token == "") {
		tpj("#checkout_login_captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','login_form')?>');
		return false;

	}
}

(function( $ ) {
	$(function() {
		<?php
		$payment_methods_nm_arr = array('cash','paypal','bank','cheque','venmo','zelle','amazon_gcard','cash_app','apple_pay','google_pay','coinbase','facebook_pay','coupon');
		foreach($payment_methods_nm_arr as $payment_methods_nm_k=>$payment_methods_nm_v) { ?>
		if($('#payment_method_<?=$payment_methods_nm_v?>').is(':checked')) {
			$('#<?=$payment_methods_nm_v?>-form').show();
		}
		$("#payment_method_<?=$payment_methods_nm_v?>").click(function() {
			if($(this).is(':checked')) {
			  $('#<?=$payment_methods_nm_v?>-form').show();
			} else {
			  $('#<?=$payment_methods_nm_v?>-form').hide();
			}
			<?php
			foreach($payment_methods_nm_arr as $payment_methods_s_nm_k=>$payment_methods_s_nm_v) {
				if($payment_methods_nm_v!=$payment_methods_s_nm_v) {
					echo '$("#'.$payment_methods_s_nm_v.'-form").hide();';
				}
			} ?>
		});
		<?php
		} ?>

		$(".payment-form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_payment_step();
		});

		$(".address_details_tab, .shpping-insureance, .shipping-fields").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_address_details();
		});

		$(".step2next").on("click", function() {
			var ok = check_payment_step();
			if(ok == false) {
				return false;
			}

			var payment_step_data = $("input[name='payment_method']:checked").val();
			$(".payment_step_data").html(' '+payment_step_data);
			
			/*if($("input[id='payment_method_cash']").is(':checked')) {
				$("#termsOption").collapse('show');
			} else {*/
				$("#shipping").collapse('show');
			//}
			$(".collapsetwo_chkd").html('<a id="edit_payment_tab" href="javascript:void(0);"><?=_lang('edit_button_text')?></a>');
		});

		$(document).on("click", "#edit_payment_tab", function() {
			$("#payment").collapse('show');
			$(".collapsetwo_chkd").html('');
		});

		$(".step3next").on("click", function() {
			var ok = check_address_details();
			if(ok == false) {
				return false;
			}

			var shipping_step_data = $("input[name='shipping_method']:checked").next().html();
			shipping_step_data = shipping_step_data.replaceAll('_',' ');
			$(".shipping_step_data").html(' '+shipping_step_data);

			$("#termsOption").collapse('show');
			$(".collapsethree_chkd").html('<a id="edit_address_details" href="javascript:void(0);"><?=_lang('edit_button_text')?></a>');
		});
		$(document).on("click", "#edit_address_details", function() {
			$("#shipping").collapse('show');
			$(".collapsethree_chkd").html('');
		});

		$(document).on("click", "#edit_account_tab", function() {
			$("#accountTab").collapse('show');
			$(".collapseone_chkd").html('');

		});

		<?php
		if($is_confirm_sale_terms) { ?>
		$("#terms_and_conditions").on('click', function(event) {
			if(document.getElementById("terms_and_conditions").checked==true) {
				$("#terms_and_conditions_error_msg").hide();
			} else {
				$("#terms_and_conditions_error_msg").show().text('<?=_lang('terms_and_conditions_validation_text','checkout')?>');
			}
		});
		<?php
		} ?>

		$('#checkout_signup_email').on('input',function(e) {
			return false;
		});

		$(".get_paid").on("click", function() {

			<?php
			if($user_id<=0 && $enable_login_register == '1') { ?>
			var checkout_signup_email = $("#checkout_signup_email").val();
			if(checkout_signup_email == "") {
				$("#accountTab").collapse('show');
				alert("<?=_lang('fill_up_account_fields_validation_text','checkout')?>");
				return false;
			}
			<?php
			} ?>
			var ok = check_payment_step2();
			if(ok == false) {
				$("#payment").collapse('show');
				alert("<?=_lang('fill_up_payment_fields_validation_text','checkout')?>");
				return false;
			}

			var ok = check_address_details();
			//if(ok == false && !$("input[id='payment_method_cash']").is(':checked')) {
			if(ok == false) {
				$("#shipping").collapse('show');
				alert("<?=_lang('fill_up_address_details_fields_validation_text','checkout')?>");
				return false;
			}

			<?php
			if($is_confirm_sale_terms) { ?>
			if(document.getElementById("terms_and_conditions").checked==false) {
				$("#terms_and_conditions_error_msg").show().text('<?=_lang('terms_and_conditions_validation_text','checkout')?>');
				return false;
			}
			<?php
			} ?>
			
			$(".checkout_step_loading_icon").html('<?=$full_spining_icon_html?>');
			$(".get_paid").attr("disabled", "disabled");
			
			$("#checkout_form").submit();
		});

		$("input[name='shipping_method']").click(function() {
			$(".shipping_method_locations").hide();
			$(".shipping_method_dates").hide();
			$(".shipping_method_times").html('');
			$(".pickup_date_fields").hide();
			
			var id_show_address_fields = $(this).data("show_address_fields");
			$("#is_show_address_fields").val(id_show_address_fields);
			if(id_show_address_fields == '1') {
				$(".address-fields-showhide").show();
			} else {
				$(".address-fields-showhide").hide();
			}

            var shipping_method = $("input[name='shipping_method']:checked").val();
			if(shipping_method == "print_a_prepaid_label") {
				$(".shipping_label_option_showhide").show();
			} else {
				$(".shipping_label_option_showhide").hide();
			}

			if(shipping_method == "post_me_a_prepaid_label") {
				$(".address_for_without_usa").show();
				$('.address_for_with_usa').hide();
			} else {
				$(".address_for_without_usa").hide();
				$('.address_for_with_usa').show();
			}

			if(shipping_method == "post_me_a_prepaid_label") {
				document.getElementById('shipping_country_usa').checked = false;
				document.getElementById('shipping_country_canada').checked = true;
				$('#shipping_country_canada_div').show();
				$('#shipping_country_usa_div').hide();
			} else {
				document.getElementById('shipping_country_usa').checked = true;
				document.getElementById('shipping_country_canada').checked = false;
				$('#shipping_country_canada_div').hide();
				$('#shipping_country_usa_div').show();
			}
			

			$(".shipping-instruction").hide();
			$("#shipping-instruction-"+shipping_method).show();
			
			if(shipping_method == "store" || shipping_method == "starbucks") {
				$.ajax({
					type: 'POST',
					url: '<?=SITE_URL?>ajax/get_locations_html.php',
					data: {shipping_method:shipping_method},
					success: function(data) {
						if(data!="") {
							$(".shipping_method_locations").html(data);
							$(".shipping_method_locations").show();
							getLocationList(0);
						}
					}

				});
			}
			else if(shipping_method == "we_come_for_you") {
				$(".pickup_date_fields").show();
            }
        });

		$(".shipping_method_dates").hide();

		$("#create_account_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_create_account_form();
		});

		$(".create_account_form_sbmt_btn").click(function() {
			var ok = check_create_account_form();
			if(ok == false) {
				return false;
			} else {
				
				$("#create_account_form_sbmt_btn_spinning_icon").html('<?=$spining_icon_html?>');
				$("#create_account_form_sbmt_btn_spinning_icon").show();
				
				$(".account_step_data").html('');
				var email = $("#checkout_signup_email").val();
				post_data = "email="+email+"&token=<?=get_unique_id_on_load()?>";
				tpj(document).ready(function($){
					$.ajax({
						type: "POST",
						url:"<?=SITE_URL?>ajax/checkout_signup.php",
						data:post_data,
						success:function(data) {
							if(data!="") {
								$("#create_account_form_sbmt_btn_spinning_icon").html('');
								$("#create_account_form_sbmt_btn_spinning_icon").hide();
									
								var resp_data = JSON.parse(data);
								if(resp_data.exist==true) {
									$(".email_exist_msg").html(resp_data.msg);
									$(".email_exist_msg").show();
									$("#tmp_signup_email").val('');
								} else if(resp_data.signup==true) {
									$(".email_exist_msg").html("");
									$(".email_exist_msg").hide();
									$("#user_id").val(resp_data.user_id);
									$("#user_email").val('guest');
									$("#payment").collapse('show');
									$(".collapseone_chkd").html('<a id="edit_account_tab" href="javascript:void(0);"><?=_lang('edit_button_text')?></a>');
									$(".account_step_data").html(email);
									var checkout_signup_email = $("#checkout_signup_email").val();
									$("#tmp_signup_email").val(checkout_signup_email);
								} else {
									alert("Something went wrong!");
									return false;
								}
							}
						}
					});
				});
			}
		});

		$('.login_f_verifycode_form_btn').click(function() {
			var login_verification_code = $("#login_f_verification_code").val();
			if(login_verification_code=='') {
				$(".login-f-verifycode-form").addClass('was-validated');
				return false;
			}
			
			$("#resend_login_f_verifycode_p_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#resend_login_f_verifycode_p_spining_icon").show();
			
			$.ajax({
				type: 'POST',
				url: SITE_URL+'ajax/verify_login_account.php',
				data: $('.login-f-verifycode-form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.status == "invalid" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						} else if(resp_data.status == "success" && resp_data.msg != "") {
							window.location.href = resp_data.redirect_url;
						}
					}
					$("#resend_login_f_verifycode_p_spining_icon").html('');
					$("#resend_login_f_verifycode_p_spining_icon").hide();
				}
			});
			return false;
		});
		
		$('.resend_login_f_verifycode_btn').click(function() {
			$("#resend_login_f_verifycode_p_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#resend_login_f_verifycode_p_spining_icon").show();

			$.ajax({
				type: 'POST',
				url: SITE_URL+'ajax/verify_login_account.php?is_resend_verify=1',
				data: $('.login-f-verifycode-form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.status == "invalid" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						} else if(resp_data.status == "success" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						} else if(resp_data.status == "resend" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						}
					}
					$("#resend_login_f_verifycode_p_spining_icon").html('');
					$("#resend_login_f_verifycode_p_spining_icon").hide();
				}
			});
			return false;
		});
		
		$("#checkout_login_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_checkout_login_form();
		});
		$(".checkout_login_form_sbmt_btn").click(function() {
			var ok = check_checkout_login_form();
			if(ok == false) {
				return false;
			} else {
				$("#signin_f_spining_icon").html('<?=$full_spining_icon_html?>');
				$("#signin_f_spining_icon").show();

				$.ajax({
					type: 'POST',
					url: SITE_URL+'ajax/login.php',
					data: $('#checkout_login_form').serialize(),
					success: function(data) {
						if(data!="") {
							var resp_data = JSON.parse(data);
							if(resp_data.status == "invalid" && resp_data.msg != "") {
								$('.signin-f-form-msg').html(resp_data.msg);
								$('.signin-f-form-msg').show();

								$('#s_username').val('');
								$('#s_password').val('');

								if(g_c_login_f_wdt_id == '0' || g_c_login_f_wdt_id > 0) {
									grecaptcha.reset(g_c_login_f_wdt_id);
								}
							} else if(resp_data.status == "success" && resp_data.msg != "") {
								window.location.href = resp_data.redirect_url;
							} else if(resp_data.status == "resend" && resp_data.msg != "") {
								$('#checkout_login_form').hide();
								$('.link-forgot-pass').hide();
								$('.login-f-verifycode-form').show();
								$('#login_f_verifycode_user_id').val(resp_data.user_id);
							}
							$("#signin_f_spining_icon").html('');
							$("#signin_f_spining_icon").hide();
						}
					}
				});	
			}
		});
	});
})(jQuery);

//CHECK SHIPPING METHOD / SHIPPING LEBEL
// document.querySelectorAll('.shipping_method').forEach(function(el) {
//     el.addEventListener('change', function() {
// 		const targetElement = document.getElementById('address');

//         if( this.value == 'post_me_a_prepaid_label') {
// 			$('.address').removeClass('address');
// 			alert(2);
// 		} else {

// 		}
//     });
// });
//END CHECK SHIPPING METHOD / SHIPPING LEBEL

<?php
if($place_api_key && $place_api_key_status == '1') { ?>
function initAutocomplete() {
	address1 = document.querySelector("#address");
	city = document.querySelector("#city");
	state = document.querySelector("#state");
	zipcode = document.querySelector("#postcode");
	// Create the autocomplete object, restricting the search predictions to
	// addresses in the US and Canada.
	autocomplete = new google.maps.places.Autocomplete(address1, {
		componentRestrictions: {
			country: ["<?= $phone_country_short_code ?>"]
		},
		fields: ["address_components", "geometry"],
		types: ["address"],
	});
	// When the user selects an address from the drop-down, populate the
	// address fields in the form.
	autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
	// Get the place details from the autocomplete object.
	const place = autocomplete.getPlace();
	var address1_text = "";
	var postcode = "";
	// Get each component of the address from the place details,
	// and then fill-in the corresponding field on the form.
	// place.address_components are google.maps.GeocoderAddressComponent objects
	// which are documented at http://goo.gle/3l5i5Mr
	for(const component of place.address_components) {
		const componentType = component.types[0];
		switch(componentType) {
			case "street_number": {
				address1_text = component.long_name;
				break;
			}
			case "route": {
				address1_text += " " + component.long_name;
				break;
			}
			case "postal_code": {
				postcode = `${component.long_name} ${postcode}`;
				break;
			}
			/* case "postal_code_suffix": {
				postcode = `${postcode}-${component.long_name}`;
				break;
			} */
			case "locality": {
				city.value = component.long_name;
				break;
			}
			case "postal_town": {
				city.value = component.long_name;
				break;
			}
			case "administrative_area_level_1": {
				state.value = component.short_name;
				break;
			}
			case "country": {
				//state.value = component.long_name;
				break;
			}
		}
		address1.value = address1_text;
		zipcode.value = postcode;
	}
}
<?php
} ?>
</script>