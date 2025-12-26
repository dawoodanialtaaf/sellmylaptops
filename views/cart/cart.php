<?php
$discount_heading_text = _lang('discount_heading_text','cart');

$promocode_amt = 0;
$discount_amt_label = "";
if($order_data['promocode_id']>0 && $order_data['promocode_amt']>0) {
	$promocode_amt = $order_data['promocode_amt'];
	$discount_amt_label = "";
	if($order_data['discount_type']=="percentage")
		$discount_amt_label = $discount_heading_text." (".$order_data['discount']."%)";

	$total_of_order = $sum_of_orders+$order_data['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}

if(!empty($guest_user_data) && $guest_user_id > 0) {
	$user_data = $guest_user_data;
	$user_id = $guest_user_id;
}

$open_shipping_popup = 0;
if(isset($_SESSION['open_shipping_popup'])) {
	$open_shipping_popup = $_SESSION['open_shipping_popup'];
	unset($_SESSION['open_shipping_popup']);
}

$is_confirm_sale_terms = false;
if($display_terms_array['confirm_sale']=="confirm_sale") {
	$is_confirm_sale_terms = true;
}

$a_j_csrf_token = generateFormToken('ajax'); ?>

<form method="post" id="revieworder_form">
	<section class="pb-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading page-heading text-center">
				  <h1><?=_lang('heading_text','cart')?></h1>
			  </div>
			  <div class="block order-details cart clearfix"> 
				<div class="table-div">
					<div class="table-row head d-none d-md-flex clearfix">
						<div class="table-cell sl"><?=_lang('column_no_text','cart')?></div>
						<div class="table-cell description"><?=_lang('column_details_text','cart')?></div>
						<div class="table-cell price"><?=_lang('column_qty_text','cart')?></div>
						<div class="table-cell price "><?=_lang('column_price_text','cart')?></div>   
						<div class="table-cell actions"><?=_lang('column_actions_text','cart')?></div> 
					</div>
					<?php
					$tid=1;
					foreach($order_item_list as $order_item_list_data) {
					$model_data = get_single_model_data($order_item_list_data['model_id']);
					$mdl_details_url = SITE_URL.$model_details_page_slug.$model_data['sef_url'];
					
					$f_is_allow_multi_quantity = $is_allow_multi_quantity;
					$category_data = get_category_data($model_data['cat_id']);
					$check_imei = $category_data['check_imei'];
					if($check_imei) {
						$f_is_allow_multi_quantity = 0;
					}

					//path of this function (get_order_item) admin/_config/functions.php
					$order_item_data = get_order_item($order_item_list_data['id'],'list'); ?>
					<div class="table-row d-md-flex clearfix">
						<div class="table-cell sl"><?=$tid?></div>
						<div class="table-cell item_de description item-description-<?=$order_item_list_data['id']?>">
							<div class="row">
								<div class="col-3 col-md-2 d-flex align-items-center">
									<?php
									if($model_data['model_img']) {
										echo '<img src="'.SITE_URL.'media/images/model/'.$model_data['model_img'].'"/>';
									} ?>
								</div>
								<div class="col-9 col-md-10">
									<?php
									if($order_item_data['device_name']) {
										echo '<h6>'.$order_item_data['device_name'].'</h6>';
									}
									if($order_item_data['item_name']) {
										echo $order_item_data['item_name'];
									}
									if($order_item_data['data']['imei_number']) {
									  echo '<br><b>'._lang('imei_heading_text','cart').'</b> '.$order_item_data['data']['imei_number'];
									} ?>
								</div>
							</div>		
						</div>
						<div class="table-cell price d-flex align-items-center ">
							<?php
							if($f_is_allow_multi_quantity == '1') { ?>
								<input type="number" class="form-control cng_quantity" min="1" max="999" id="qty-<?=$tid?>" name="qty[<?=$order_item_list_data['id']?>]" value="<?=$order_item_list_data['quantity']?>" data-qtyprice="<?=$order_item_list_data['quantity_price']?>"data-qtyid="<?=$order_item_list_data['id']?>" autocomplete="nope" style="width:80px;" onkeyup="allow_only_digit(this);">
							<?php
							} else { ?>
								<input type="hidden" class="form-control cng_quantity" min="1" max="999" id="qty-<?=$tid?>" name="qty[<?=$order_item_list_data['id']?>]" value="<?=$order_item_list_data['quantity']?>" data-qtyprice="<?=$order_item_list_data['quantity_price']?>"data-qtyid="<?=$order_item_list_data['id']?>" autocomplete="nope" style="width:80px;" onkeyup="allow_only_digit(this);">
								&nbsp;&nbsp;1
							<?php
							} ?>
						</div>
						<div class="table-cell price d-flex align-items-center">
							<span class="price-item">
								<span>
									<?=amount_fomat($order_item_list_data['price'])?>
								</span>
							</span>
						</div>  
						<div class="table-cell actions price action_price_detail">
							<div class="clearfix">
								<a href="<?=$mdl_details_url?>?item_id=<?=$order_item_list_data['access_token']?>" class="edit-icon"><i class="fas fa-pencil-alt"></i></a>
								<a href="<?=SITE_URL?>?controller=cart&r_order_id=<?=$order_item_list_data['access_token']?>" onclick="return confirm('Are you sure you want to remove this item?');" class="remove-icon"><i class="fa fa-times" aria-hidden="true"></i></a>
							</div>
						</div>
					</div> 
					<?php
					$tid++;
					$item_price_array[] = amount_fomat($order_item_list_data['price']);
					} ?> 

					<div class="no-bg border-top clearfix"> 
						<div class="row" style="margin-top:12px;">   
							<div class="col-md-6 col-12">
								<div class="empty-card-detail">
									<a href="<?=SITE_URL?>?controller=cart&emptycart" onclick="return confirm('Are you sure you want to empty cart?');" class="btn btn-outline-danger rounded-pill  btn-sm px-3 mt-2 mb-2 empty_card_btn"><?=_lang('empty_button_text','cart')?></a>  
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="card_device_quantity">  
									<a href="<?=$sell_page_link?>" class="btn btn-lg btn-outline-dark rounded-pill mt-2 mr-1 add-device"><?=_lang('add_device_button_text','cart')?></a>
									<?php
									if($is_allow_multi_quantity == '1') { ?>
									<button type="button" class="btn btn-outline-dark rounded-pill btn-lg px-3 mt-2 update" name="update_cart" id="update_cart" onclick="return check_update_cart('upt_qty');"><?=_lang('update_qty_button_text','cart')?> <span id="updt_cart_spining_icon"></span></button>
									<?php
									} ?>
							    </div>
							</div>
						</div>
					</div>

					<?php /*?><div class="table-row no-bg d-md-flex clearfix">
						<div class="table-cell w-65 cart-total-cell">
							<h5 class="title"><?=_lang('total_amount_heading_text','cart')?></h5>
							<?php
							$expected_payments = '';
							if(count($item_price_array)==1) {
								$expected_payments = '<span>'.amount_fomat($sum_of_orders).'</span>';
							} else {
								$expected_payments = implode(" + ",$item_price_array).' = <span class="total-price_section">'.amount_fomat($sum_of_orders).'</span>';
							}
							echo $expected_payments; ?> <span id="showhide_promocode_row" <?php if($promocode_amt<=0) {echo 'style="display:none;"';}?>> + <span id="promocode_amt_label"><?=$discount_amt_label?></span> <span id="promocode_amt"><?=amount_fomat($promocode_amt)?></span>&nbsp;(Coupon)</span>
							</p>
							<div class="row">
								<div class="col-md-4 col-lg-6 col-xl-6">
									<?php
									$bonus_data = get_bonus_data_info_by_user($user_id);
									$bonus_percentage = $bonus_data['bonus_data']['percentage'];
									if($user_id>0 && $bonus_percentage>0) {
										$bonus_amount = ($sum_of_orders * $bonus_percentage / 100); ?>
										<p class="bonus"><img src="<?=SITE_URL?>media/images/icons/gift.png" alt="gift"> <?=_lang('bonus_amount_heading_text','cart').' '.$bonus_percentage?>% = <?=amount_fomat($bonus_amount)?></p>
										<input type="hidden" name="bonus_percentage" id="bonus_percentage" value="<?=$bonus_percentage?>"/>
										<input type="hidden" name="bonus_amount" id="bonus_amount" value="<?=$bonus_amount?>"/>
									<?php
									} ?>
								</div>
								<div class="col-md-6 col-lg-6 col-xl-6">
									<?php if($settings['promocode_section']=='1') { ?>
									<h5 class="price-coupon">
										<div>
											<input type="text" name="promo_code" id="promo_code" class="form-control promo_code" placeholder="<?=_lang('apply_coupon_place_holder_text','cart')?>" autocomplete="nope" value="<?=$order_data['promocode']?>" <?php if($order_data['promocode']!=""){echo 'readonly="readonly"';}?> required>
											<button class="btn btn-link close-icon" type="reset"><img src="<?=SITE_URL?>media/images/icons/close-circle.png" alt=""></button>
											<a href="javascript:void(0);" name="apl_promo_code" id="apl_promo_code" class="apl_promo_code rounded-pill get-paid mr-0" onclick="getPromoCode();" <?php if($order_data['promocode']!=""){echo 'style="display:none;"';}?>><?=_lang('apply_coupon_button_text','cart')?></a><span id="apl_promo_spining_icon"></span>
											<a class="promocode_removed" href="javascript:void(0);" id="promocode_removed" <?php if($promocode_amt<=0) {echo 'style="display:none;"';}?>>X</a>
										</div>
									</h5>
									<span class="showhide_promocode_msg" style="display:none;"><span class="promocode_msg"></span></span>
									<p class="note"><?=_lang('apply_coupon_offer_text','cart')?></p>
									<?php
									} ?>
								</div>
							</div>
						</div>
				
						<div class="table-cell w-35 text-right d-flex align-items-center justify-content-end">
							<button type="button" class="btn btn-primary btn-lg rounded-pill get-paid mr-0 paid_detail" data-toggle="modal" <?php if($user_id>0){echo 'data-target="#ShippingFields"';}else{echo 'data-target="#SignInRegistration"';}?>><?=_lang('get_paid_button_text','cart')?></button>							
						</div>
					</div><?php */?>

				</div>
				<div class="row mt-4">
					 <div class="col-md-6 text-center">
					 	<?php 
						if($settings['promocode_section']=='1') { ?>
						<div class="table-row no-bg clearfix check_order_detail">
						   <div class="table-cell cart-total-cell">
							  <div class="row">
								 <div class="col-md-12 col-lg-12 col-xl-12">
									<h5 class="price-coupon">
									   <div>
										  <input type="text" name="promo_code" id="promo_code" class="form-control promo_code" placeholder="<?=_lang('apply_coupon_place_holder_text','cart')?>" autocomplete="nope" value="<?=$order_data['promocode']?>" <?php if($order_data['promocode']!=""){echo 'readonly="readonly"';}?> required>
										  <p class="note"><?=_lang('apply_coupon_offer_text','cart')?></p>
										  <button class="btn btn-link promocode_removed" id="promocode_removed" type="button" <?php if($order_data['promocode']!=""){echo 'style="display:block;"';} else {echo 'style="display:none;"';}?>><img src="<?=SITE_URL?>media/images/icons/close-circle.png" alt="close circle"></button>
										  <a href="javascript:void(0);" name="apl_promo_code" id="apl_promo_code" class="apl_promo_code rounded-pill get-paid mr-0" onclick="getPromoCode();" <?php if($order_data['promocode']!=""){echo 'style="display:none;"';}?>><?=_lang('apply_coupon_button_text','cart')?></a><span id="apl_promo_spining_icon"></span>
									   </div>
									</h5>
									<span class="showhide_promocode_msg" style="display:none;"><span class="promocode_msg"></span></span>
								 </div>
							  </div>
						   </div>
						</div>
						<?php
						} ?>
					 </div>
				
					 <div class="col-md-6">
						<div class="total-cart-summary">
						   <h3><?=_lang('order_summary_heading_text','cart')?></h3>
						   <div class="row">
							  <div class="col-md-6 col-6">
								 <h4 class="sub_total_label"><?php if($promocode_amt<=0){echo _lang('total_amount_heading_text','cart');}else{echo _lang('sub_total_amount_heading_text','cart');}?></h4>
							  </div>
							  <div class="col-md-6 col-6">
								 <span><?=amount_fomat($sum_of_orders)?></span>
							  </div>
						   </div>
						   <div class="border-divider showhide_promocode_row" <?php if($promocode_amt<=0){echo 'style="display:none;"';}?>></div>
						   <div class="row showhide_promocode_row" <?php if($promocode_amt<=0){echo 'style="display:none;"';}?>>
							  <div class="col-md-6 col-6">
								 <h4 id="promocode_amt_label"><?=$discount_amt_label?></h4>
							  </div>
							  <div class="col-md-6 col-6">
								 <span id="promocode_amt"><?=amount_fomat($promocode_amt)?></span>
							  </div>
						   </div>
							
						   <div class="border-divider showhide_total_row" <?php if($promocode_amt<=0){echo 'style="display:none;"';}?>></div>
						   <div class="row showhide_total_row" <?php if($promocode_amt<=0){echo 'style="display:none;"';}?>>
							  <div class="col-md-6 col-6">
								 <h4><?=_lang('total_amount_heading_text','cart')?></h4>
							  </div>
							  <div class="col-md-6 col-6">
								 <span class="totla-price total_amt"><?=amount_fomat($total_of_order)?></span>
							  </div>
						   </div>
						   <div class="row">
							  <div class="col-md-12">
								 <div class="checkout-button">
									<?php
									if($accept_new_order == '1') {
										if($checkout_form_type == "normal") { ?>
											<a href="<?=SITE_URL?>checkout" class="btn btn-primary btn-lg get-paid mr-0 float-right"><?=_lang('get_paid_button_text','cart')?></a>
										<?php
										} else { ?>
											<button type="button" class="btn btn-primary btn-lg  get-paid mr-0 float-right" data-toggle="modal" <?php if($user_id>0 || $enable_login_register != '1'){echo 'data-target="#ShippingFields"';}else{echo 'data-target="#SignInRegistration"';}?>><?=_lang('get_paid_button_text','cart')?></button>
										<?php
										}
									} else { ?>
										<button type="button" class="btn btn-primary btn-lg get-paid mr-0 float-right" id="accept_new_order_btn"><?=_lang('get_paid_button_text','cart')?></button>
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
		  </div>
		</div>
	</section>
	<input id="order_id" name="order_id" value="<?=$order_id?>" type="hidden">
	<input type="hidden" name="controller" value="cart/cart">
	<input type="hidden" name="csrf_token" value="<?=$a_j_csrf_token?>">
</form>

  <div class="modal fade" id="ShippingFields" tabindex="-1" role="dialog" aria-labelledby="ShippingFields" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title shipping_payment_label"><?=_lang('payment_method_title','cart')?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
          </button>
        </div>

        <div class="modal-body pt-3 text-center shipping_form_section" style="display:none;">
			<?php
			$shipping_first_name = $order_data['shipping_first_name'];
			$shipping_last_name = $order_data['shipping_last_name'];
			$shipping_company_name = $order_data['shipping_company_name'];
			if($user_data['first_name']) {
				$shipping_first_name = $user_data['first_name'];
			}
			if($user_data['last_name']) {
				$shipping_last_name = $user_data['last_name'];
			}
			if($user_data['company_name']) {
				$shipping_company_name = $user_data['company_name'];
			}
			
			$shipping_address = $order_data['shipping_address1'];
			$shipping_house_number = $order_data['shipping_house_number'];
			$shipping_address2 = $order_data['shipping_address2'];
			$shipping_city = $order_data['shipping_city'];
			$shipping_state = $order_data['shipping_country'];
			$shipping_postcode = $order_data['shipping_postcode'];
			$shipping_phone = $order_data['shipping_phone'];
			$shipping_country_code = $order_data['shipping_country_code'];
			if($user_data['use_shipping_adddress_prefilled'] == '1' || $guest_user_id > 0) {
				if($user_data['address']) {
					$shipping_address = $user_data['address'];
				}
				if($user_data['house_number']) {
					$shipping_house_number = $user_data['house_number'];
				}
				if($user_data['address2']) {
					$shipping_address2 = $user_data['address2'];
				}
				if($user_data['city']) {
					$shipping_city = $user_data['city'];
				}
				if($user_data['state']) {
					$shipping_state = $user_data['state'];
				}
				if($user_data['postcode']) {
					$shipping_postcode = $user_data['postcode'];
				}
				if($user_data['phone']) {
					$shipping_phone = $user_data['phone'];
				}
				if($user_data['country_code']) {
					$shipping_country_code = $user_data['country_code'];
				}
			} ?>
			<form method="post" class="sign-in needs-validation" id="shipping_form" novalidate>
				<?php
				if(!empty(array_filter($shipping_option))) { ?>
				<h5><?=_lang('shipping_method_title','cart')?></h5>
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
								<input type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_post_me_a_prepaid_label" name="shipping_method" value="post_me_a_prepaid_label">
								<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div> 
							<?php
							}
							if($shipping_option['print_a_prepaid_label'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_print_a_prepaid_label" name="shipping_method" value="print_a_prepaid_label">
								<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
							if($shipping_option['use_my_own_courier'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_use_my_own_courier" name="shipping_method" value="use_my_own_courier">
								<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
							if($shipping_option['we_come_for_you'] == $sooa_v) { ?>
							<div class="custom-control custom-radio">
								<label>
								<input type="radio" data-show_address_fields="<?=$is_show_address_fields?>" id="sm_we_come_for_you" name="shipping_method" value="we_come_for_you">
								<span><?=$shipping_option[$sooa_v.'_name']?></span></label>
								<?php
								if($shipping_option[$sooa_v.'_image']!="") {
									echo '<img src="'.SITE_URL.'/media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
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
									echo '<img src="'.SITE_URL.'/media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
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
									echo '<img src="'.SITE_URL.'/media/images/'.$shipping_option[$sooa_v.'_image'].'" width="30">';
								} ?>
							</div>
							<?php
							}
						} ?>
					</div>
					<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

					<div class="col-md-6 pickup_date_fields" style="display:none;">
						<div class="form-group mt-3 with-icon">
							<img src="<?=SITE_URL?>media/images/icons/date-gray.png" alt="" width="20">
							<input type="text" class="form-control pickup_date_picker" name="shipping_pickup_date" id="shipping_pickup_date" placeholder="<?=_lang('shipping_pickup_date_place_holder_text','cart')?>" autocomplete="nope">
							<div id="shipping_pickup_date_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
						</div>
					</div>
					<div class="col-md-6 pickup_time_list" style="display:none;"></div>
				</div>
				<?php
				} else { ?>
				<div class="custom-control custom-radio" style="display:none;">
					<input type="radio" id="sm_post_me_a_prepaid_label" name="shipping_method" value="none" checked="checked">
					<label><span>None</span></label>
					<div id="shipping_method_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				</div>
				<?php
				} ?>
				
				<div class="shipping-instruction-list">
					<?php
					foreach($shipping_option_instruction_arr as $shipping_option_instruction_dt) { ?>
						<div class="shipping-instruction" id="shipping-instruction-<?=$shipping_option_instruction_dt['shipping_option']?>" style="display:none;"><?=$shipping_option_instruction_dt['shipping_instruction']?></div>
					<?php
					} ?>
				</div>

				<div class="pickup_date_fields"></div>
				<div class="shipping_method_locations"></div>
				<div class="shipping_method_dates">
					<div class="form-row">
						<div class="form-group col-md-12">
							<input type="text" name="date" placeholder="<?=_lang('shipping_method_date_place_holder_text','cart')?>" class="form-control repair_appt_date" id="date" autocomplete="off">
							<small id="date_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
						</div>
					</div>
				</div>
				<div class="form-row shipping_method_times"></div>
				
				<h5 class="address_label"></h5>
				<div class="form-row">
				  <div class="form-group mt-3 col-md-4 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="">
					<input type="text" class="form-control" name="shipping_first_name" id="shipping_first_name" placeholder="<?=_lang('shipping_first_name_place_holder_text','cart')?>" value="<?=$shipping_first_name?>" autocomplete="nope">
					<div id="shipping_first_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  <div class="form-group mt-3 col-md-4 with-icon">
					 <img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt=""> 
					 <input type="text" class="form-control" name="shipping_last_name" id="shipping_last_name" value="<?=$shipping_last_name?>" autocomplete="nope" placeholder="<?=_lang('shipping_last_name_place_holder_text','cart')?>" required>
					<div id="shipping_last_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  <div class="form-group mt-3 col-md-4 with-icon telephone-form">
					<img src="<?=SITE_URL?>media/images/icons/phone_dial.png" alt="">
					<input type="tel" id="shipping_phone" name="shipping_phone" class="form-control" placeholder="<?=_lang('shipping_phone_place_holder_text','cart')?>">
					<input type="hidden" name="shipping_phone_c_code" id="shipping_phone_c_code" value="<?=$shipping_country_code?>"/>
					<div id="shipping_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				</div>
				
				<?php
				if($enable_login_register != '1') { ?>
				<div class="form-row">
				  <div class="form-group mt-3 col-md-12 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="">
					<input type="text" class="form-control" name="shipping_email" id="shipping_email" placeholder="<?=_lang('email_field_placeholder_text','signup_form')?>" value="<?=(isset($email_while_add_to_cart)?$email_while_add_to_cart:'')?>" autocomplete="nope">
					<div id="shipping_email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				</div>
				<?php
				} ?>
				
				<div class="form-row shipping_address_fields address-fields-showhide">
				  <div class="form-group mt-3 col-md-4 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/place-marker.png" alt="">
					<input type="text" class="form-control" name="shipping_address" id="shipping_address" value="<?=$shipping_address?>" autocomplete="nope" placeholder="<?=_lang('shipping_street_address_place_holder_text','cart')?>" required>
					<div id="shipping_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  
				  <?php
				  if($show_house_number_field == '1') { ?>
				  <div class="form-group mt-3 col-md-4 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/place-marker.png" alt="">
					<input type="text" class="form-control" name="shipping_house_number" id="shipping_house_number" value="<?=$shipping_house_number?>" autocomplete="nope" placeholder="<?=_lang('shipping_street_house_number_place_holder_text','cart')?>" required>
					<div id="shipping_house_number_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				  <?php
				  } ?>
				  
				  <div class="form-group mt-3 col-md-4 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/place-marker.png" alt="">
					<input type="text" class="form-control" name="shipping_address2" id="shipping_address2"  value="<?=$shipping_address2?>" autocomplete="nope" placeholder="<?=_lang('shipping_street_address_2_place_holder_text','cart')?>">
				  </div>
				</div>
				<div class="form-row shipping_address_fields address-fields-showhide">
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/people.png" alt="">
					<input type="text" class="form-control" name="shipping_company_name" id="shipping_company_name"  value="<?=$shipping_company_name?>" autocomplete="nope" placeholder="<?=_lang('shipping_company_place_holder_text','cart')?>">
				  </div>
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/home.png" alt="">
					<input type="text" class="form-control" name="shipping_city" id="shipping_city" value="<?=$shipping_city?>" autocomplete="nope" placeholder="<?=_lang('shipping_city_place_holder_text','cart')?>" required>
					<div id="shipping_city_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				</div>
				<div class="form-row shipping_address_fields address-fields-showhide">
				   <?php
				   if($hide_state_field != '1') { ?>
				   <div class="form-group mt-3 col-md-6 with-icon">
					 <img src="<?=SITE_URL?>media/images/icons/state.png" alt="">
					 <input type="text" class="form-control" name="shipping_state" id="shipping_state" value="<?=$shipping_state?>" autocomplete="nope" placeholder="<?=_lang('shipping_state_place_holder_text','cart')?>" required>
					 <div id="shipping_state_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				   </div>
				   <?php
				   } ?>
				  <div class="form-group mt-3 col-md-6 with-icon">
					<img src="<?=SITE_URL?>media/images/icons/envelop.png" alt="">
					<input type="text" class="form-control" name="shipping_postcode" id="shipping_postcode" value="<?=$shipping_postcode?>" autocomplete="nope" placeholder="<?=_lang('shipping_zipcode_place_holder_text','cart')?>">
					<div id="shipping_postcode_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
				  </div>
				</div>

				<?php
				if($guest_user_id<=0 && $enable_login_register == '1') { ?>
				<div class="form-row shipping_address_fields">
				  <div class="form-group mt-3 col-md-6">
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" name="save_as_primary_address" id="save_as_primary_address" value="1"/>
					  <label class="custom-control-label" for="save_as_primary_address"><?=_lang('shipping_save_as_my_primary_address_text','cart')?></label>
					</div>
				  </div>
				</div>
				<?php
				} ?>

				<div class="form-group double-btn pt-5 text-center">
				  <button type="button" class="btn btn-lg btn-outline-dark mr-lg-3 bk_payment_form"><?=_lang('back_button_text')?></button>
				  <button type="button" class="btn btn-primary btn-lg ml-lg-3 shipping_submit_btn"><?=($is_confirm_sale_terms?_lang('continue_button_text'):_lang('place_order_button_text'))?></button>
				</div>
				<?php
				if(!$is_confirm_sale_terms) {
					echo '<input type="hidden" name="is_show_address_fields" id="is_show_address_fields" value="1">';
					echo '<span id="place_order_spining_icon"></span>';
				} else {
					echo '<span id="shipping_method_spining_icon"></span>';
				} ?>
				<input type="hidden" name="sbt_checkout_order" value="yes"/>
				<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
				<input type="hidden" name="controller" value="cart/cart">
				<input type="hidden" name="csrf_token" value="<?=$a_j_csrf_token?>">
			</form>
        </div>

		<div class="modal-body text-center payment_form_section">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
		  	<?php
			$o_payment_method_details = json_decode($order_data['payment_method_details'],true);
			$account_holder_name = (!empty($o_payment_method_details['account_holder_name'])?$o_payment_method_details['account_holder_name']:'');
			$account_number = (!empty($o_payment_method_details['account_number'])?$o_payment_method_details['account_number']:'');
			$short_code = (!empty($o_payment_method_details['short_code'])?$o_payment_method_details['short_code']:'');
			$cash_name = (!empty($o_payment_method_details['cash_name'])?$o_payment_method_details['cash_name']:'');
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
				$cash_name = !empty($payment_method_details['data']['cash']['cash_name'])?$payment_method_details['data']['cash']['cash_name']:'';
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
					$payment_icon_img = '<img src="'.SITE_URL.'media/images/payment/'.$payment_icon[$pooa_v.'_icon'].'" width="30" alt="'.$pooa_v.'">';
				}
				
				if($choosed_payment_option['bank']=="bank" && $pooa_v == "bank") { ?>
				<li class="nav-item <?php if($default_payment_option=="bank"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="bank"){echo 'active';}?>" id="bank-tab" data-toggle="tab" href="#bank" role="tab" aria-controls="bank" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['paypal']=="paypal" && $pooa_v == "paypal") { ?>
				<li class="nav-item <?php if($default_payment_option=="paypal"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="paypal"){echo 'active';}?>" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['cheque']=="cheque" && $pooa_v == "cheque") { ?>
				<li class="nav-item <?php if($default_payment_option=="cheque"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="cheque"){echo 'active';}?>" id="cheque-tab" data-toggle="tab" href="#cheque" role="tab" aria-controls="cheque" aria-selected="false">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['coupon']=="coupon" && $pooa_v == "coupon") { ?>
				<li class="nav-item <?php if($default_payment_option=="coupon"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="coupon"){echo 'active';}?>" id="coupon-tab" data-toggle="tab" href="#coupon" role="tab" aria-controls="coupon" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['zelle']=="zelle" && $pooa_v == "zelle") { ?>
				<li class="nav-item <?php if($default_payment_option=="zelle"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="zelle"){echo 'active';}?>" id="zelle-tab" data-toggle="tab" href="#zelle" role="tab" aria-controls="zelle" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['cash']=="cash" && $pooa_v == "cash") { ?>
				<li class="nav-item <?php if($default_payment_option=="cash"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="cash"){echo 'active';}?>" id="cash-tab" data-toggle="tab" href="#cash" role="tab" aria-controls="cash" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['venmo']=="venmo" && $pooa_v == "venmo") { ?>
				<li class="nav-item <?php if($default_payment_option=="venmo"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="venmo"){echo 'active';}?>" id="venmo-tab" data-toggle="tab" href="#venmo" role="tab" aria-controls="venmo" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['amazon_gcard']=="amazon_gcard" && $pooa_v == "amazon_gcard") { ?>
				<li class="nav-item <?php if($default_payment_option=="amazon_gcard"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="amazon_gcard"){echo 'active';}?>" id="amazon_gcard-tab" data-toggle="tab" href="#amazon_gcard" role="tab" aria-controls="amazon_gcard" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				
				if($choosed_payment_option['cash_app']=="cash_app" && $pooa_v == "cash_app") { ?>
				<li class="nav-item <?php if($default_payment_option=="cash_app"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="cash_app"){echo 'active';}?>" id="cash_app-tab" data-toggle="tab" href="#cash_app" role="tab" aria-controls="cash_app" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['apple_pay']=="apple_pay" && $pooa_v == "apple_pay") { ?>
				<li class="nav-item <?php if($default_payment_option=="apple_pay"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="apple_pay"){echo 'active';}?>" id="apple_pay-tab" data-toggle="tab" href="#apple_pay" role="tab" aria-controls="apple_pay" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['google_pay']=="google_pay" && $pooa_v == "google_pay") { ?>
				<li class="nav-item <?php if($default_payment_option=="google_pay"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="google_pay"){echo 'active';}?>" id="google_pay-tab" data-toggle="tab" href="#google_pay" role="tab" aria-controls="google_pay" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['coinbase']=="coinbase" && $pooa_v == "coinbase") { ?>
				<li class="nav-item <?php if($default_payment_option=="coinbase"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="coinbase"){echo 'active';}?>" id="coinbase-tab" data-toggle="tab" href="#coinbase" role="tab" aria-controls="coinbase" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div>
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
				if($choosed_payment_option['facebook_pay']=="facebook_pay" && $pooa_v == "facebook_pay") { ?>
				<li class="nav-item <?php if($default_payment_option=="facebook_pay"){echo 'active';}?>">
				  <a class="nav-link <?php if($default_payment_option=="facebook_pay"){echo 'active';}?>" id="facebook_pay-tab" data-toggle="tab" href="#facebook_pay" role="tab" aria-controls="facebook_pay" aria-selected="true">
					<div class="arrow"><i class="fas fa-check"></i></div> 
					<p>
						<?=$payment_icon_img?>
						<span class="name"><?=$payment_icon[$pooa_v.'_name']?></span>
					</p>
				  </a>
				</li>
				<?php
				}
			} ?>
          </ul>
		  <form method="post" id="payment_form">
          <div class="tab-content" id="myTabContent">	
			<input class="r_payment_method" name="payment_method" value="<?=$default_payment_option?>" type="hidden">
			<input type="hidden" name="sbt_checkout_order" value="yes"/>
			<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
			<input type="hidden" name="controller" value="cart/cart">
			<input type="hidden" name="csrf_token" value="<?=$a_j_csrf_token?>">
			
			<span id="payment_method_spining_icon"></span>
		    <?php
			if($choosed_payment_option['bank']=="bank") { ?>
			<div class="bank-fields tab-pane fade <?php if($default_payment_option=="bank"){echo 'show active';}?>" id="bank" role="tabpanel" aria-labelledby="bank-tab">
			  <p><?=$payment_instruction['bank']?></p>
                <div class="form-group">
					<input type="text" class="form-control" id="act_name" name="act_name" placeholder="<?=_lang('payment_method_act_name_place_holder_text','cart')?>" autocomplete="nope" value="<?=$account_holder_name?>">
					<div id="act_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
                <div class="form-group">
					<input type="text" class="form-control" id="act_number" name="act_number" placeholder="<?=_lang('payment_method_act_number_place_holder_text','cart')?>" autocomplete="nope" value="<?=$account_number?>">
					<div id="act_number_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				<div class="form-group">
					<input type="text" class="form-control" id="act_short_code" name="act_short_code" placeholder="<?=_lang('payment_method_act_short_code_place_holder_text','cart')?>" autocomplete="nope" value="<?=$short_code?>">
					<div id="act_short_code_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['paypal']=="paypal") { ?>
			<div class="paypal-fields tab-pane fade <?php if($default_payment_option=="paypal"){echo 'show active';}?>" id="paypal" role="tabpanel" aria-labelledby="paypal-tab">
			  <p><?=$payment_instruction['paypal']?></p>
                <div class="form-group">
					<input type="text" class="form-control" id="paypal_address" name="paypal_address" value="<?=$paypal_address?>" autocomplete="nope" placeholder="<?=_lang('payment_method_paypal_adr_place_holder_text','cart')?>">
					<div id="paypal_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
					<div id="exist_paypal_address_msg" class="invalid-feedback text-center" style="display:none;"></div>
                </div>
                <div class="form-group">
					<input type="text" class="form-control" id="confirm_paypal_address" name="confirm_paypal_address" value="<?=$paypal_address?>" autocomplete="nope" placeholder="<?=_lang('payment_method_paypal_adr_repeat_place_holder_text','cart')?>">
					<div id="confirm_paypal_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg  payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['cheque']=="cheque") { ?>
            <div class="tab-pane fade <?php if($default_payment_option=="cheque"){echo 'show active';}?>" id="cheque" role="tabpanel" aria-labelledby="cheque-tab">
			  <p><?=$payment_instruction['cheque']?></p>
              <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['coupon']=="coupon") { ?>
            <div class="tab-pane fade <?php if($default_payment_option=="coupon"){echo 'show active';}?>" id="coupon" role="tabpanel" aria-labelledby="cheque-tab">
			  <p><?=$payment_instruction['coupon']?></p>
              <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['venmo']=="venmo") { ?>
			<div class="venmo-fields tab-pane fade <?php if($default_payment_option=="venmo"){echo 'show active';}?>" id="venmo" role="tabpanel" aria-labelledby="venmo-tab">
			  <p><?=$payment_instruction['venmo']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_venmo_adr_place_holder_text','cart')?>" id="venmo_address"  name="venmo_address" autocomplete="nope" value="<?=$venmo_address?>">
					<div id="venmo_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
			<div class="amazon_gcard-fields tab-pane fade <?php if($default_payment_option=="amazon_gcard"){echo 'show active';}?>" id="amazon_gcard" role="tabpanel" aria-labelledby="amazon_gcard-tab">
			  <p><?=$payment_instruction['amazon_gcard']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_amazon_gcard_adr_place_holder_text','cart')?>" id="amazon_gcard_address"  name="amazon_gcard_address" autocomplete="nope" value="<?=$amazon_gcard_address?>">
					<div id="amazon_gcard_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['cash']=="cash") { ?>
			<div class="cash-fields tab-pane fade <?php if($default_payment_option=="cash"){echo 'show active';}?>" id="cash" role="tabpanel" aria-labelledby="cash-tab">
			  <p><?=$payment_instruction['cash']?></p>
                <div class="form-group">
					<input type="text" class="form-control" id="cash_name" name="cash_name" placeholder="<?=_lang('payment_method_cash_name_place_holder_text','cart')?>" value="<?=$cash_name?>">
					<div id="cash_name_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
                <div class="form-group">
					<input type="tel" class="form-control" id="cash_phone" name="cash_phone" placeholder="<?=_lang('payment_method_cash_phone_place_holder_text','cart')?>">
					<input type="hidden" name="f_cash_phone" id="f_cash_phone" />
					<div id="cash_phone_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['zelle']=="zelle") { ?>
			<div class="zelle-fields tab-pane fade <?php if($default_payment_option=="zelle"){echo 'show active';}?>" id="zelle" role="tabpanel" aria-labelledby="zelle-tab">
			  <p><?=$payment_instruction['zelle']?></p>
                <div class="form-group">
					<input type="email" class="form-control" id="zelle_address" name="zelle_address" placeholder="<?=_lang('payment_method_zelle_adr_place_holder_text','cart')?>" value="<?=$zelle_address?>">
					<div id="zelle_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			
			if($choosed_payment_option['cash_app']=="cash_app") { ?>
			<div class="cash_app-fields tab-pane fade <?php if($default_payment_option=="cash_app"){echo 'show active';}?>" id="cash_app" role="tabpanel" aria-labelledby="cash_app-tab">
			  <p><?=$payment_instruction['cash_app']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_cash_app_adr_place_holder_text','cart')?>" id="cash_app_address"  name="cash_app_address" autocomplete="nope" value="<?=$cash_app_address?>">
					<div id="cash_app_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
			<div class="apple_pay-fields tab-pane fade <?php if($default_payment_option=="apple_pay"){echo 'show active';}?>" id="apple_pay" role="tabpanel" aria-labelledby="apple_pay-tab">
			  <p><?=$payment_instruction['apple_pay']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_apple_pay_adr_place_holder_text','cart')?>" id="apple_pay_address"  name="apple_pay_address" autocomplete="nope" value="<?=$apple_pay_address?>">
					<div id="apple_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['google_pay']=="google_pay") { ?>
			<div class="google_pay-fields tab-pane fade <?php if($default_payment_option=="google_pay"){echo 'show active';}?>" id="google_pay" role="tabpanel" aria-labelledby="google_pay-tab">
			  <p><?=$payment_instruction['google_pay']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_google_pay_adr_place_holder_text','cart')?>" id="google_pay_address"  name="google_pay_address" autocomplete="nope" value="<?=$google_pay_address?>">
					<div id="google_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['coinbase']=="coinbase") { ?>
			<div class="coinbase-fields tab-pane fade <?php if($default_payment_option=="coinbase"){echo 'show active';}?>" id="coinbase" role="tabpanel" aria-labelledby="coinbase-tab">
			  <p><?=$payment_instruction['coinbase']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_coinbase_adr_place_holder_text','cart')?>" id="coinbase_address"  name="coinbase_address" autocomplete="nope" value="<?=$coinbase_address?>">
					<div id="coinbase_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			}
			if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
			<div class="facebook_pay-fields tab-pane fade <?php if($default_payment_option=="facebook_pay"){echo 'show active';}?>" id="facebook_pay" role="tabpanel" aria-labelledby="facebook_pay-tab">
			  <p><?=$payment_instruction['facebook_pay']?></p>
                <div class="form-group">
					<input type="text" class="form-control" placeholder="<?=_lang('payment_method_facebook_pay_adr_place_holder_text','cart')?>" id="facebook_pay_address"  name="facebook_pay_address" autocomplete="nope" value="<?=$facebook_pay_address?>">
					<div id="facebook_pay_address_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
                </div>
				
                <button type="submit" class="btn btn-primary btn-lg payment_submit_btn"><?=_lang('continue_button_text')?></button>
            </div>
			<?php
			} ?>
          </div>
		  </form>
        </div>

		<div class="modal-body text-center terms_form_section" style="display:none;">
		  <form method="post" onSubmit="return confirm_sale_validation(this);">
			<?php
			if($is_confirm_sale_terms) { ?>
			<div class="form-group" style="text-align:center;">
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="cs_terms_conditions" id="p_cs_terms_conditions" value="1"/>
					<label class="custom-control-label" for="p_cs_terms_conditions"><?=_lang('terms_and_conditions_link_before_text','cart')?> <a href="javascript:void(0)" class="help-icon click_terms_of_website_use"><?=_lang('terms_and_conditions_link_text','cart')?></a></label>
				</div>
				<div id="p_cs_terms_conditions_error_msg" class="invalid-feedback text-center m_validations_showhide" style="display:none;"></div>
			</div>
			<?php
			} else {
				echo '<input type="hidden" name="cs_terms_conditions" id="p_cs_terms_conditions" value="1"/>';
			} ?>
			<button type="button" class="btn btn-lg btn-outline-dark mr-lg-3 bk_shipping_form"><?=_lang('back_button_text')?></button>
			<button type="submit" class="btn btn-primary btn-lg confirm_sale_btn" name="confirm_sale_btn"><?=_lang('place_order_button_text')?></button>
			<?php
			if($is_confirm_sale_terms) {
				echo '<input type="hidden" name="is_show_address_fields" id="is_show_address_fields" value="1">';
				echo '<span id="place_order_spining_icon"></span>';
			} ?>
			<input type="hidden" name="sbt_checkout_order" value="yes"/>
			<input type="hidden" name="num_of_item" id="num_of_item" value="<?=count($order_item_ids);?>"/>
			<input type="hidden" name="controller" value="cart/cart">
			<input type="hidden" name="csrf_token" value="<?=$a_j_csrf_token?>">
		  </form>
        </div>

      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade common_popup" id="accept_new_order_popup" role="dialog">
	<div class="modal-dialog modal-lg">
      <div class="modal-content">
	    <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
          </button>
        </div>
        <div class="modal-body">
		  <div class="content"><?=_lang('not_accepting_new_order_popup_text','cart')?></div>
        </div>
      </div>
    </div>
</div>

<?php
if($place_api_key && $place_api_key_status == '1') {
	echo '<script src="https://maps.googleapis.com/maps/api/js?key='.$place_api_key.'&callback=initAutocomplete&libraries=places&v=weekly" async></script>';
} ?>

<script>
var autocomplete;
var address1;
var city;
var state;
var zipcode;
var tpj=jQuery;

var iti_ipt;
var iti_ipt2;

(function( $ ) {
	$(function() {
		$('#accept_new_order_btn').on('click',function() {
			$('#accept_new_order_popup').modal('show');
		});

		<?php
		if($choosed_payment_option['cash']=="cash") { ?>
		var telInput_cash_phone = document.querySelector("#cash_phone");
		iti_ipt = window.intlTelInput(telInput_cash_phone, {
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>assets/js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});
		iti_ipt.setNumber("<?=($cash_phone?'+'.$shipping_country_code.$cash_phone:'')?>");
		<?php
		} ?>

		var telInput_shipping_phone = document.querySelector("#shipping_phone");
		iti_ipt2 = window.intlTelInput(telInput_shipping_phone, {
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
		iti_ipt2.setNumber("<?=($shipping_phone?'+'.$shipping_country_code.$shipping_phone:'')?>");
	});
})(jQuery);

function getPromoCode()
{
	var promo_code = document.getElementById('promo_code').value.trim();
	if(promo_code=="") {
		tpj("#promo_code").focus();
		return false;
	}

	post_data = "promo_code="+promo_code+"&amt=<?=$sum_of_orders?>&order_id=<?=$order_id?>&csrf_token=<?=$a_j_csrf_token?>&token=<?=unique_id()?>";
	tpj(document).ready(function($) {
		tpj("#apl_promo_spining_icon").html('<i class="fa fa-spinner fa-spin" style="font-size:16px;"></i>');
		tpj.ajax({
			type: "POST",
			url:"<?=SITE_URL?>ajax/promocode_verify.php",
			data:post_data,
			success:function(data) {
				$("#apl_promo_spining_icon").html('');
				if(data!="") {
					var resp_data = JSON.parse(data);
					if(resp_data.msg!="" && (resp_data.mode == "expired" || resp_data.mode == "invalid_token")) {
						$("#promo_code").val('');
						$(".showhide_promocode_row").hide();
						$(".showhide_total_row").hide();
						$("#promocode_removed").hide();
						$(".showhide_promocode_msg").show();
						$(".promocode_msg").html('<div class="alert alert-warning alert-dismissable d-inline-block">'+resp_data.msg+'</div>');
					} else {
						$("#promocode_removed").show();
						$(".showhide_promocode_msg").hide();
						$(".promocode_msg").html('');
						$(".showhide_promocode_row").show();
						$(".showhide_total_row").show();
						if(resp_data.coupon_type=='percentage') {
							$("#promocode_amt_label").html("<?=$discount_heading_text?> ("+resp_data.percentage_amt+"%)");
							$("#promocode_amt").html(resp_data.discount_of_amt);
						} else {
							$("#promocode_amt_label").html("<?=$discount_heading_text?> ");
							$("#promocode_amt").html(resp_data.discount_of_amt);
						}
						
						$(".sub_total_label").html('<?=_lang('sub_total_amount_heading_text','cart')?>');
						$(".total_amt").html(resp_data.total);
						
						$("#apl_promo_code").attr("disabled", true);
						$("#promo_code").attr("readonly", true);
						$("#apl_promo_code").hide();
						check_update_cart('promo');
					}
				}
			}
		});
	});
}

function check_shipping_form() {
	tpj(".m_validations_showhide").hide();
	var is_show_address_fields = tpj("#is_show_address_fields").val();

	var shipping_method = tpj("input[name='shipping_method']:checked").val();
	if(typeof shipping_method === 'undefined') {
		tpj("#shipping_method_error_msg").show().text('<?=_lang('shipping_method_validation_text','cart')?>');
		return false;
	}
	
	if(shipping_method == "store" || shipping_method == "starbucks") {
		if(document.getElementById("location_id").value.trim()=="") {
			tpj("#location_id_error_msg").show().text('<?=_lang('shipping_location_validation_text','cart')?>');
			return false;
		}
		
		var show_appt_datetime_selection_in_place_order = tpj('#location_id option:selected').data('show_appt_datetime_selection_in_place_order');
		if(document.getElementById("date") != null) {
			var l_date = document.getElementById("date").value.trim();
			if(l_date=="" && show_appt_datetime_selection_in_place_order == 1) {
				tpj("#date_error_msg").show().text('<?=_lang('shipping_date_validation_text','cart')?>');
				return false;
			}
		}
		if(document.getElementById("time_slot") != null) {
			var time_slot = document.getElementById("time_slot").value.trim();
			if(time_slot=="" && show_appt_datetime_selection_in_place_order == 1) {
				tpj("#time_slot_error_msg").show().text('<?=_lang('shipping_time_validation_text','cart')?>');
				return false;
			}
		}
	} else if(shipping_method == "we_come_for_you") {
		if(document.getElementById("pickup_time_slot") != null) {
			var pickup_time_slot = document.getElementById("pickup_time_slot").value.trim();
			if(pickup_time_slot=="") {
				tpj("#pickup_time_slot_error_msg").show().text('<?=_lang('shipping_time_validation_text','cart')?>');
				return false;
			}
		}
	}
	
	if(document.getElementById("shipping_first_name").value.trim()=="") {
		tpj("#shipping_first_name_error_msg").show().text('<?=_lang('shipping_first_name_validation_text','cart')?>');
		return false;
	} else if(document.getElementById("shipping_last_name").value.trim()=="") {
		tpj("#shipping_last_name_error_msg").show().text('<?=_lang('shipping_last_name_validation_text','cart')?>');
		return false;
	} else if(document.getElementById("shipping_phone").value.trim()=="") {
		tpj("#shipping_phone_error_msg").show().text('<?=_lang('shipping_phone_validation_text','cart')?>');
		return false;
	}

	tpj("#shipping_phone_c_code").val(iti_ipt2.getSelectedCountryData().dialCode);
	if(!iti_ipt2.isValidNumber()) {
		tpj("#shipping_phone_error_msg").show().text('<?=_lang('shipping_valid_phone_validation_text','cart')?>');
		return false;
	}

	<?php
	if($enable_login_register != '1') { ?>
	var shipping_email = document.getElementById("shipping_email").value.trim();
	if(shipping_email=="") {
		tpj("#shipping_email_error_msg").show().text('<?=_lang('email_field_validation_text','signup_form')?>');
		return false;
	} else if(!shipping_email.match(mailformat)) {
		tpj("#shipping_email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','signup_form')?>');
		return false;
	}
	<?php
	} ?>
		
	if(document.getElementById("shipping_address").value.trim()=="" && is_show_address_fields == '1') {
		tpj("#shipping_address_error_msg").show().text('<?=_lang('shipping_street_address_validation_text','cart')?>');
		return false;
	}
	<?php
    if($show_house_number_field == '1') { ?>
	else if(document.getElementById("shipping_house_number").value.trim()=="" && is_show_address_fields == '1') {
		tpj("#shipping_house_number_error_msg").show().text('<?=_lang('shipping_street_house_number_validation_text','cart')?>');
		return false;
	}
    <?php
    } ?>
	 else if(document.getElementById("shipping_city").value.trim()=="" && is_show_address_fields == '1') {
		tpj("#shipping_city_error_msg").show().text('<?=_lang('shipping_city_validation_text','cart')?>');
		return false;
	}
	<?php
	if($hide_state_field != '1') { ?>
	 else if(document.getElementById("shipping_state").value.trim()=="" && is_show_address_fields == '1') {
		tpj("#shipping_state_error_msg").show().text('<?=_lang('shipping_state_validation_text','cart')?>');
		return false;
	}
	<?php
	} ?>
	 else if(document.getElementById("shipping_postcode").value.trim()=="" && is_show_address_fields == '1') {
		tpj("#shipping_postcode_error_msg").show().text('<?=_lang('shipping_zipcode_validation_text','cart')?>');
		return false;
	}
}

function check_payment_form() {
	tpj(".m_validations_showhide").hide();				
	var payment_method = tpj(".r_payment_method").val();

	<?php
	if($choosed_payment_option['bank']=="bank") { ?>
	if(payment_method=="bank") {
		if(document.getElementById("act_name").value.trim()=="") {
			tpj("#act_name_error_msg").show().text('<?=_lang('payment_method_act_name_validation_text','cart')?>');
			return false;
		} else if(document.getElementById("act_number").value.trim()=="") {
			tpj("#act_number_error_msg").show().text('<?=_lang('payment_method_act_number_validation_text','cart')?>');
			return false;
		} else if(document.getElementById("act_short_code").value.trim()=="") {
			tpj("#act_short_code_error_msg").show().text('<?=_lang('payment_method_act_short_code_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['paypal']=="paypal") { ?>
	if(payment_method=="paypal") {
		var paypal_address = document.getElementById("paypal_address").value.trim();
		var confirm_paypal_address = document.getElementById("confirm_paypal_address").value.trim();
		if(paypal_address=="") {
			tpj("#paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_adr_validation_text','cart')?>');
			return false;
		} else if(!paypal_address.match(mailformat)) {
			tpj("#paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_valid_adr_validation_text','cart')?>');
			return false;
		} else if(confirm_paypal_address=="") {
			tpj("#confirm_paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_adr_repeat_validation_text','cart')?>');
			return false;
		} else if(paypal_address!=confirm_paypal_address) {
			tpj("#paypal_address_error_msg").show().text('<?=_lang('payment_method_paypal_and_confirm_paypal_address_not_match_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['cash']=="cash") { ?>
	if(payment_method=="cash") {
		if(document.getElementById("cash_name").value.trim()=="") {
			tpj("#cash_name_error_msg").show().text('<?=_lang('payment_method_cash_name_validation_text','cart')?>');
			return false;
		}
		
		tpj("#f_cash_phone").val(iti_ipt.getNumber());
		
		var cash_phone = document.getElementById("cash_phone").value.trim();
		if(cash_phone=="") {
			tpj("#cash_phone_error_msg").show().text('<?=_lang('payment_method_cash_phone_validation_text','cart')?>');
			return false;
		} else if(!iti_ipt.isValidNumber()) {
			tpj("#cash_phone_error_msg").show().text('<?=_lang('payment_method_cash_valid_phone_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['zelle']=="zelle") { ?>
	if(payment_method=="zelle") {
		var zelle_address = document.getElementById("zelle_address").value.trim();
		if(zelle_address=="") {
			tpj("#zelle_address_error_msg").show().text('<?=_lang('payment_method_zelle_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['venmo']=="venmo") { ?>
	if(payment_method=="venmo") {
		var venmo_address = document.getElementById("venmo_address").value.trim();
		if(venmo_address=="") {
			tpj("#venmo_address_error_msg").show().text('<?=_lang('payment_method_venmo_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['amazon_gcard']=="amazon_gcard") { ?>
	if(payment_method=="amazon_gcard") {
		var amazon_gcard_address = document.getElementById("amazon_gcard_address").value.trim();
		if(amazon_gcard_address=="") {
			tpj("#amazon_gcard_address_error_msg").show().text('<?=_lang('payment_method_amazon_gcard_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['cash_app']=="cash_app") { ?>
	if(payment_method=="cash_app") {
		var cash_app_address = document.getElementById("cash_app_address").value.trim();
		if(cash_app_address=="") {
			tpj("#cash_app_address_error_msg").show().text('<?=_lang('payment_method_cash_app_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['apple_pay']=="apple_pay") { ?>
	if(payment_method=="apple_pay") {
		var apple_pay_address = document.getElementById("apple_pay_address").value.trim();
		if(apple_pay_address=="") {
			tpj("#apple_pay_address_error_msg").show().text('<?=_lang('payment_method_apple_pay_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['google_pay']=="google_pay") { ?>
	if(payment_method=="google_pay") {
		var google_pay_address = document.getElementById("google_pay_address").value.trim();
		if(google_pay_address=="") {
			tpj("#google_pay_address_error_msg").show().text('<?=_lang('payment_method_google_pay_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['coinbase']=="coinbase") { ?>
	if(payment_method=="coinbase") {
		var coinbase_address = document.getElementById("coinbase_address").value.trim();
		if(coinbase_address=="") {
			tpj("#coinbase_address_error_msg").show().text('<?=_lang('payment_method_coinbase_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	}
	if($choosed_payment_option['facebook_pay']=="facebook_pay") { ?>
	if(payment_method=="facebook_pay") {
		var facebook_pay_address = document.getElementById("facebook_pay_address").value.trim();
		if(facebook_pay_address=="") {
			tpj("#facebook_pay_address_error_msg").show().text('<?=_lang('payment_method_facebook_pay_adr_validation_text','cart')?>');
			return false;
		}
	}
	<?php
	} ?>
}

function check_form() {
	tpj(".m_validations_showhide").hide();				
	var p_cs_terms_conditions = document.getElementById('p_cs_terms_conditions').checked;
	if(p_cs_terms_conditions == false) {
		tpj("#p_cs_terms_conditions_error_msg").show().text('<?=_lang('terms_and_conditions_validation_text','cart')?>');
		return false;
	}
}

$(".bank-fields, .paypal-fields, .zelle-fields, .cash-fields, .venmo-fields, .amazon_gcard-fields, .cash_app-fields, .apple_pay-fields, .google_pay-fields, .coinbase-fields, .facebook_pay-fields").on('blur keyup change paste', 'input, select, textarea', function(event) {
	check_payment_form();
});

$(".terms_form_section").on('blur keyup change paste', 'input, select, textarea', function(event) {
	check_form();
});

function confirm_sale_validation() {
	var ok = check_form();
	if(ok == false) {
		return false;
	} else {
		tpj("#place_order_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin" style="font-size:100px;"></i></div></div>');
		tpj("#place_order_spining_icon").show();
		tpj(".confirm_sale_btn").attr("disabled", true);
	}
}

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
						alert('<?=_lang('something_went_wrong_message_text')?>');
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
						tpj(".shipping_submit_btn").attr("disabled", "disabled");
						tpj(".time-slot-msg").show();
						tpj(".time-slot-msg").html(resp_data.msg);
					} else {
						tpj(".shipping_submit_btn").removeAttr("disabled");
						tpj(".time-slot-msg").hide();
					}
				} else {
					return false;
				}
			}
		});
	}
}

function getTimeSlotListByPickupDate()
{
	tpj(".pickup_time_list").show();
	var date = tpj("#shipping_pickup_date").val();
	post_data = "&date="+date+"&option=1&token=<?=get_unique_id_on_load()?>";
	tpj(document).ready(function($){
		tpj.ajax({
			type: "POST",
			url:"<?=SITE_URL?>ajax/get_pickup_timeslot_list.php",
			data:post_data,
			success:function(data) {
				if(data!="") {
					var resp_data = JSON.parse(data);
					if(resp_data.html!="") {
						tpj(".pickup_time_list").html(resp_data.html);
					}
				} else {
					alert('<?=_lang('something_went_wrong_message_text')?>');
					return false;
				}
			}
		});
	});
}

(function( $ ) {
	$(function() {

		$('.pickup_date_picker').datepicker({
			autoclose: true,
			startDate: jscurrent_date, //for today use "today"
			todayHighlight: true,
			daysOfWeekDisabled: [0,6],
			//format: js_date_format,
			format: '<?=$js_date_format?>'
		}).on('changeDate', function(e) {
			getTimeSlotListByPickupDate();
		});
			
		$("#shipping_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_shipping_form();
		});
		$(".shipping_submit_btn").click(function() {
			var ok = check_shipping_form();
			if(ok == false) {
				return false;
			}

			<?php
			if($is_confirm_sale_terms) { ?>
			$("#shipping_method_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#shipping_method_spining_icon").show();
			<?php
			} else { ?>
			$("#place_order_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#place_order_spining_icon").show();
			<?php
			} ?>

			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/order_shipping_method.php',
				data: $('#shipping_form').serialize(),
				success: function(data) {
					var resp_data = JSON.parse(data);
					console.log(resp_data);
					if(resp_data.success == true) {
						<?php
						if(!$is_confirm_sale_terms) {
							echo "$('#shipping_form').submit();";
						} else { ?>
							$(".shipping_form_section").hide();
							$(".terms_form_section").show();
							$(".shipping_payment_label").html('<?=_lang('terms_and_conditions_title','cart')?>');
							$(".address_label").html('');
							
							$("#shipping_method_spining_icon").html('');
							$("#shipping_method_spining_icon").hide();
						<?php
						} ?>
					} else {
						<?php
						if($is_confirm_sale_terms) { ?>
						$("#shipping_method_spining_icon").html('<?=$ajax_warning_msg_html?>');
						$("#shipping_method_spining_icon").show();
						<?php
						} else { ?>
						$("#place_order_spining_icon").html('<?=$ajax_warning_msg_html?>');
						$("#place_order_spining_icon").show();
						<?php
						} ?>
					}
				}
			});
			return false;
		});

		$(".bk_payment_form").click(function() {
			$(".shipping_form_section").hide();
			$(".payment_form_section").show();
			$(".shipping_payment_label").html('<?=_lang('payment_method_title','cart')?>');
			$(".address_label").html('');
		});

		$(".payment_submit_btn").click(function() {
			var ok = check_payment_form();
			if(ok == false) {
				return false;
			}
			
			$("#payment_method_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#payment_method_spining_icon").show();

			$(".shipping_payment_label").html('<?=_lang('shipping_method_title','cart')?>');
			$(".address_label").html('<?=_lang('shipping_method_sub_title','cart')?>');
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/order_payment_method.php',
				data: $('#payment_form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						console.log(resp_data);
						if(resp_data.success == true) {
							$(".shipping_form_section").show();
							$(".payment_form_section").hide();
							$("#payment_method_spining_icon").html('');
							$("#payment_method_spining_icon").hide();

							<?php
							/*if(!$is_confirm_sale_terms) { 
								echo "$('#payment_form').submit();";
							}*/ ?>
						} else {
							$("#payment_method_spining_icon").html('<?=$ajax_warning_msg_html?>');
							$("#payment_method_spining_icon").show();
						}
					} else {
						$("#payment_method_spining_icon").html('<?=$ajax_warning_msg_html?>');
						$("#payment_method_spining_icon").show();
					}
				}
			});
			return false;
		});

		$(".bk_shipping_form").click(function() {
			$(".shipping_form_section").show();
			$(".terms_form_section").hide();
			$(".shipping_payment_label").html('<?=_lang('shipping_method_title','cart')?>');
			$(".address_label").html('');
		});

		$("#bank-tab").click(function() {
			$(".r_payment_method").val('bank');
		});
		$("#paypal-tab").click(function() {
			$(".r_payment_method").val('paypal');
		});
		$("#cheque-tab").click(function() {
			$(".r_payment_method").val('cheque');
		});
		$("#coupon-tab").click(function() {
			$(".r_payment_method").val('coupon');
		});
		$("#zelle-tab").click(function() {
			$(".r_payment_method").val('zelle');
		});
		$("#cash-tab").click(function() {
			$(".r_payment_method").val('cash');
		});
		$("#venmo-tab").click(function() {
			$(".r_payment_method").val('venmo');
		});
		$("#amazon_gcard-tab").click(function() {
			$(".r_payment_method").val('amazon_gcard');
		});
		$("#cash_app-tab").click(function() {
			$(".r_payment_method").val('cash_app');
		});
		$("#apple_pay-tab").click(function() {
			$(".r_payment_method").val('apple_pay');
		});
		$("#google_pay-tab").click(function() {
			$(".r_payment_method").val('google_pay');
		});
		$("#coinbase-tab").click(function() {
			$(".r_payment_method").val('coinbase');
		});
		$("#facebook_pay-tab").click(function() {
			$(".r_payment_method").val('facebook_pay');
		});
		
		$("input[name='shipping_method']").click(function() {
			$(".shipping_method_locations").hide();
			$(".shipping_method_dates").hide();
			$(".shipping_method_times").html('');
			$(".pickup_date_fields").hide();
			$(".pickup_time_list").hide();
			
			var id_show_address_fields = $(this).data("show_address_fields");
			$("#is_show_address_fields").val(id_show_address_fields);
			if(id_show_address_fields == '1') {
				$(".address-fields-showhide").show();
			} else {
				$(".address-fields-showhide").hide();
			}
			
            var shipping_method = $("input[name='shipping_method']:checked").val();
			if(shipping_method == "we_come_for_you") {
				$(".pickup_date_fields").show();
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
        });
		$(".shipping_method_dates").hide();

		$("#promocode_removed").click(function() {
			$("#promo_code").val('');
			$(".showhide_promocode_row").hide();
			$(".showhide_total_row").hide();
			$("#apl_promo_code").attr("disabled", false);
			$("#promo_code").attr("readonly", false);
			$("#apl_promo_code").show();
			check_update_cart('promo');
			$(this).hide();
		});

		$("#promo_code").on('keyup',function() {
			var promo_code = document.getElementById('promo_code').value.trim();
			if(promo_code!="") {
				$(".showhide_promocode_msg").hide();
				$(".promocode_msg").html('');
				$(".promocode_removed").show();
			} else {
				$(".promocode_removed").hide();
			}
		});

		<?php
		if($guest_user_id > 0) { ?>
		$("#paypal_address").on('keyup',function() {
			var paypal_address = $(this).val();
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/check_paypal_address.php',
				data: {email:paypal_address},
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.msg!="" && resp_data.exist == true) {
							$("#exist_paypal_address_msg").show();
							$("#exist_paypal_address_msg").html(resp_data.msg);
							$(".confirm_sale_btn").attr("disabled", true);
						} else {
							$("#exist_paypal_address_msg").hide();
							$("#exist_paypal_address_msg").html('');
							$(".confirm_sale_btn").attr("disabled", false);
						}
					}
				}
			});
		});
		$(document).on('click', '.paypal_address_login', function() {
			$("#ShippingFields").modal('hide');
			$("#SignInRegistration").modal();
		});
		<?php
		}

		if($open_shipping_popup) {
			echo '$("#ShippingFields").modal();';
		} ?>

		$('.cng_quantity').bind('keyup change', function(event) {
			var qty = $(this).val();
			if(qty<=0) {
				$(this).val('');
			}
			if(qty>999) {
				var tmp_qty = qty.slice(0,3);
				$(this).val(tmp_qty);
			}
		});
		
	});
})(jQuery);

function check_update_cart(type) {
	tpj(document).ready(function($) {
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/upt_qty_promo_bonus.php?type='+type,
			data: $('#revieworder_form').serialize(),
			success: function(data) {
				if(type == "upt_qty") {
					window.location.href = "<?=SITE_URL?>cart";
				}
				return false;
			}
		});
	});
}
check_update_cart('load');

<?php
if($place_api_key && $place_api_key_status == '1') { ?>
function initAutocomplete() {
	address1 = document.querySelector("#shipping_address");
	city = document.querySelector("#shipping_city");
	state = document.querySelector("#shipping_state");
	zipcode = document.querySelector("#shipping_postcode");
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
		// After filling the form with address components from the Autocomplete
		// prediction, set cursor focus on the second address line to encourage
		// entry of subpremise information such as apartment, unit, or floor number.
	}
}
<?php
} ?>
</script>