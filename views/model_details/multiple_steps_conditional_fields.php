<style>
.phone-details-m-steps {
    display: none;
}
.custom-control-label .condition-block {
   display: none;
}
</style>	

<div class="block phone-details position-relative m-detail clearfix pb-0 multi_step_uniform_section conditional_multi_step_uniform_section">
	<div class="card">
		<?php 
		if($model_upto_price>0) {
			echo '<h6 class="btn btn-secondary upto-price-button rounded-pill">'._lang('upto_price_text','model_details').' '.amount_fomat($model_upto_price).'</h6>';
		} ?>
		<div class="row">
			<div class="col-md-4 phone-image-block text-center">
				<?php
				if($model_data['model_img']) {
					$md_img_path = SITE_URL.'media/images/model/'.$model_data['model_img'];
					echo '<img class="phone-image" src="'.$md_img_path.'" alt="'.$model_data['title'].'">';
				}
				echo '<h4 class="device-name-dt"><span class="device_brand_name">'.$model_data['title'].'</span> <span class="device-name"></span></h4>'; ?>
			</div>
			<div class="col-md-8">
                <div class="step-details" id="device-prop-area">
					<?php
					$fld_num = 0;
					$sql_cus_fld = "SELECT * FROM product_fields WHERE product_id = '".$model_id."' ORDER BY sort_order";
					$exe_cus_fld = mysqli_query($db,$sql_cus_fld);
					while($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {
						$input_type = $row_cus_fld['input_type'];

						if(($input_type == "text" && $text_field_of_model_fields == '0') || ($input_type == "textarea" && $text_area_of_model_fields == '0') || ($input_type == "datepicker" && $calendar_of_model_fields == '0') || ($input_type == "file" && $file_upload_of_model_fields == '0')) {
							continue;
						}

						$fld_title = $row_cus_fld['title'];
						$fld_title_slug = createSlug($fld_title);
						$fld_id = $row_cus_fld['id'];
						$fld_num = ($fld_num+1);
						$is_condition = '0';
						$fld_css_class = "";
						$fld_css_sub_class = "";
						$fld_title_css_class = "";
						if($fld_num == '1') {
							$fld_title_css_class = "";
						}
						if($row_cus_fld['type'] == "condition") {
							$fld_css_class = "condition";
							$fld_css_sub_class = "conditions";
							$is_condition = '1';
						}
						
						$exclude_fields_arr = json_decode($row_cus_fld['exclude_fields'],true);
						$exclude_fields_opt_ids_arr = array();
						if(!empty($exclude_fields_arr)) {
							foreach($exclude_fields_arr as $e_f_k=>$e_f_arr) {
								if(!empty($e_f_arr)) {
									foreach($e_f_arr as $e_f_s_k=>$e_f_s_v) {
										//$exclude_fields_opt_ids_arr[$e_f_s_v] = $e_f_s_v;
										$exclude_fields_opt_ids_arr[] = $e_f_s_v;
									}
								}
							}
						}
						$exclude_fields_opt_ids_json = "";
						if(!empty($exclude_fields_opt_ids_arr)) {
							$exclude_fields_opt_ids_json = json_encode($exclude_fields_opt_ids_arr);
						} ?>

						<div class="phone-details-m-steps model-details-panel <?=$fld_css_class?>" id="fld-<?=$fld_id?>" data-row_type="<?=$input_type?>" data-required="<?=$row_cus_fld['is_required']?>" data-is_condition="<?=$is_condition?>" data-exclude_fields='<?=$exclude_fields_opt_ids_json?>'>
							<div class="h4 <?=$fld_title_css_class?>">
								<?php
								echo $row_cus_fld['title'];
								if($row_cus_fld['icon'] != "" && $icons_of_model_fields == '1') {
									echo '<img src="' . SITE_URL . 'media/images/model/fields/' . $row_cus_fld['icon'] . '" width="27px" class="field-icon" />';
								}
								if($row_cus_fld['tooltip']!="" && $tooltips_of_model_fields == '1') {
									$tooltips_data_array[] = array('tooltip'=>$row_cus_fld['tooltip'], 'id'=>'p'.$row_cus_fld['id'], 'name'=>$row_cus_fld['title']); ?>
									<span class="tips" data-toggle="modal" data-target="#info_popup<?='p'.$row_cus_fld['id']?>"><i class="ml-1 fas fa-question-circle"></i></span></span>
								<?php
								} ?>:
							</div>
							<span class="validation-msg text-danger" style="display:none;"></span>
							<div class="storage-options">
							<?php
							if($input_type=="select" || $input_type=="radio") {
								$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$fld_id."' ORDER BY sort_order";
								$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
								$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
								if($no_of_dd_options>0) {
									$tooltip_tabs = array();
									$cond_tooltips_arr_list = array();
									echo '<div class="'.$fld_css_sub_class.'" data-input-type="'.$input_type.'">';
									if($row_cus_fld['type'] == "condition") {
										while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
											$checked_prms = '';
											$cond_selected_opt_id = '';
											if(isset($opt_id_array) && in_array($row_cus_opt['id'],$opt_id_array)) {
												$checked_prms = 'checked="checked"';
												$cond_selected_opt_id = $row_cus_opt['id'];
											}
											elseif($row_cus_opt['is_default'] == '1') {
												$checked_prms = 'checked="checked"';
												$cond_selected_opt_id = $row_cus_opt['id'];
											} ?>
											<div class="custom-control custom-radio radios conditions_list_s_h custom-control-inline">
												<input type="radio" name="<?=$fld_title.':'.$fld_id?>" id="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" value="<?=$row_cus_opt['label'].':'.$row_cus_opt['id']?>" autocomplete="off" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?> <?=$checked_prms?> class="custom-control-input m-fields-input radio_select_con_buttons">
												<label class="custom-control-label" for="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" id="label-<?=$fld_title_slug.'-'.$row_cus_opt['id']?>">
													<div class="condition-tab">
														<?php
														if($row_cus_opt['icon']!="" && $icons_of_model_field_options == '1') {
															echo '<img src="'.SITE_URL.'media/images/model/fields/'.$row_cus_opt['icon'].'" id="'.$row_cus_opt['id'].'" />';
														} else {
															echo '<span>'.$row_cus_opt['label'].'</span>';
														} ?>
													</div>

													<?php
													if($tooltips_of_model_field_options == '1') {
														$field_option_tooltip_data = get_field_option_tooltip($row_cus_opt['id']);
														if($field_option_tooltip_data['tooltip']) {
															$cond_tooltips_arr_list[] = array('id'=>$row_cus_opt['id'], 'tooltip'=>$field_option_tooltip_data['tooltip'], 'tooltip_type'=>$row_cus_opt['tooltip_type'],'selected_opt_id'=>$cond_selected_opt_id);
														}
													} ?>
												</label>
											</div>
										<?php
										}
									} else {
										while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
											$checked_prms = '';
											if(isset($opt_id_array) && in_array($row_cus_opt['id'],$opt_id_array)) {
												$checked_prms = 'checked="checked"';
											}
											elseif($row_cus_opt['is_default'] == '1') {
												$checked_prms = 'checked="checked"';
											} ?>
											  <div class="custom-control custom-radio radios custom-control-inline">
												<input type="radio" name="<?=$fld_title.':'.$fld_id?>" id="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" value="<?=$row_cus_opt['label'].':'.$row_cus_opt['id']?>" autocomplete="off" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?> <?=$checked_prms?> class="custom-control-input m-fields-input radio_select_buttons">
												<label class="custom-control-label" for="<?=$fld_title_slug.'-'.$row_cus_opt['id']?>" id="label-<?=$fld_title_slug.'-'.$row_cus_opt['id']?>">
													<?php
													if($row_cus_opt['icon']!="" && $icons_of_model_field_options == '1') {
														echo '<img src="'.SITE_URL.'media/images/model/fields/'.$row_cus_opt['icon'].'" id="'.$row_cus_opt['id'].'" />';
													} else {
														echo '<span>'.$row_cus_opt['label'].'</span>';
													}
													
													if($tooltips_of_model_field_options == '1') {
														$field_option_tooltip_data = get_field_option_tooltip($row_cus_opt['id']);
														if($field_option_tooltip_data['tooltip']) {
															echo '&nbsp;<span class="tooltip-icon condition-tooltips" data-id="'.$row_cus_opt['id'].'"><i class="fa fa-info-circle"></i></span>';
														}
													} ?>
												</label>
											  </div>
											<?php
										}
									}
									echo '</div>';
									
									if(!empty($cond_tooltips_arr_list)) {
										foreach($cond_tooltips_arr_list as $cond_tooltips_arr_data) { ?>
											<div class="condition-block condition_tooltips condition-tooltip-block-<?=$cond_tooltips_arr_data['id']?>" <?php if($cond_tooltips_arr_data['id']==$cond_tooltips_arr_data['selected_opt_id']){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
												<?php
												if($enabled_any_all_in_condition_heading == '1') {
													if($cond_tooltips_arr_data['tooltip_type']=="any") {
														echo '<h3>'._lang('any_condition_heading_text','model_details').'</h3>';
													} elseif($cond_tooltips_arr_data['tooltip_type']=="all") {
														echo '<h3>'._lang('all_condition_heading_text','model_details').'</h3>';
													}
												}
												echo $cond_tooltips_arr_data['tooltip']; ?>
											</div>	
										<?php
										}
									}
								}
							}

							elseif($input_type=="checkbox") {
								$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '".$fld_id."' ORDER BY sort_order";
								$exe_cus_opt = mysqli_query($db,$sql_cus_opt);
								$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
								if($no_of_dd_options>0) {
									echo '<div class="'.$fld_css_sub_class.' checkboxes clearfix" data-input-type="'.$input_type.'">';
									while($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
										$chk_lab = $row_cus_opt['label'];
										$chk_lab_slug = createSlug($chk_lab);
										$checked_prms = '';
										if(isset($opt_id_array) && in_array($row_cus_opt['id'],$opt_id_array)) {
											$checked_prms = 'checked="checked"';
										}
										elseif($row_cus_opt['is_default'] == '1') {
											$checked_prms = 'checked="checked"';
										} ?>
										  <div class="custom-control custom-radio custom-control-inline">
											<input type="checkbox" name="<?=$fld_title.':'.$fld_id?>[]" id="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" <?=$checked_prms?> value="<?=$chk_lab.':'.$row_cus_opt['id']?>" data-default="<?=$row_cus_opt['is_default']?>" <?php if($row_cus_opt['is_default'] == '1'){echo 'checked="checked"';}?> class="custom-control-input m-fields-input checkbox_select_buttons">
											<label class="custom-control-label" for="<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>" id="label-<?=$chk_lab_slug.'-'.$row_cus_opt['id']?>">
												<?php
												if($row_cus_opt['icon']!="" && $icons_of_model_field_options == '1') {
													echo '<img src="'.SITE_URL.'media/images/model/fields/'.$row_cus_opt['icon'].'" width="50px" id="'.$row_cus_opt['id'].'" />';
												} else {
													echo '<span>'.$chk_lab.'</span>';
												} ?>
											</label>
										  </div>
										<?php
										if($tooltips_of_model_field_options == '1') {
											$field_option_tooltip_data = get_field_option_tooltip($row_cus_opt['id']);
											if($field_option_tooltip_data['tooltip']) {
												echo '&nbsp;<span class="tooltip-icon condition-tooltips" data-id="'.$row_cus_opt['id'].'"><i class="fa fa-info-circle"></i></span>';
											}
										}
									}
									echo '</div>';
								}
							}
							elseif($input_type=="text") { ?>
								<div class="<?=$fld_css_sub_class?> clearfix">
									<input type="text" name="<?=$fld_title.':'.$fld_id?>" class="form-control input" value="<?=isset($opt_name_array[$row_cus_fld['id']])?$opt_name_array[$row_cus_fld['id']]:''?>" data-input-type="<?=$input_type?>"/>
								</div>
							<?php

							}
							elseif($input_type=="textarea") { ?>
								<div class="<?=$fld_css_sub_class?> clearfix">
									<textarea name="<?=$fld_title.':'.$fld_id?>" class="form-control input" data-input-type="<?=$input_type?>" rows="3"><?=isset($opt_name_array[$row_cus_fld['id']])?$opt_name_array[$row_cus_fld['id']]:''?></textarea>
								</div>
							<?php
							}
							elseif($input_type=="datepicker") { ?>
								<div class="<?=$fld_css_sub_class?> clearfix">
									<input type="text" class="form-control input datepicker" name="<?=$fld_title.':'.$fld_id?>" value="<?=isset($opt_name_array[$row_cus_fld['id']])?$opt_name_array[$row_cus_fld['id']]:''?>" data-input-type="<?=$input_type?>" autocomplete="nope"/>
								</div>
							<?php
							}
							elseif($input_type=="file") { ?>
								<div class="<?=$fld_css_sub_class?> custom-file clearfix w-50">
									<input name="<?=$fld_title.':'.$fld_id?>" id="<?=$fld_title_slug?>" type="file" class="custom-file-input" data-input-type="<?=$input_type?>" onChange="changefile(this);"/>
									<?=(isset($opt_name_array[$row_cus_fld['id']]) && $opt_name_array[$row_cus_fld['id']]?'<img src="'.SITE_URL.'media/images/order/'.$opt_name_array[$row_cus_fld['id']].'" width="25">':'')?>
									<label class="custom-file-label" for="<?=$fld_title_slug?>">Choose file</label>
								</div>
							<?php
							} ?>
							</div>
						</div>
					<?php
					} ?>

					<div class="phone-details-m-steps model-details-panel" id="get-offer" data-row_type="offer" data-required="0">
						<div class="row">
							<div class="col-md-12 text-center get-offer_section">
								<h1><?=_lang('device_value_text','model_details')?></h1>
							</div>
						</div>
						<div class="row pt-2 pb-2"> 
							<div class="col-md-12 col-lg-12 col-xl-12 text-center">
								<h4 class="price-total show_final_amt">$0<span>.00</span></h4>
								<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
							</div>
							<?php
							if($is_allow_multi_quantity == '1') { ?>
							<div class="col-md-12 col-lg-12 col-xl-12 text-center quantity_detail_main">
							   <div class="number">
									<span class="quantity_detail"><?=_lang('quantity_text','model_details')?></span>
									<span class="minus qty-minus"><p>-</p></span>
									<input type="text" id="pc_quantity" value="<?=$saved_quantity?>" onkeyup="allow_only_digit(this);"/>
									<span class="plus qty-plus"><p>+</p></span>
								</div>
							</div>
							<?php
							}
							
							if($is_show_accept_offer_and_add_another_device_button || ($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') || $quote_post_to_whatsapp_button == '1') { ?>
							<div class="col-md-12 col-lg-12 col-xl-12 text-center">
								<p>
								<?php
								if($is_show_accept_offer_and_add_another_device_button) { ?>
									<button type="submit" class="btn btn-lg rounded-pill btn-outline-light accept-btn" name="accept_offer"><?=_lang('accept_offer_button_text','model_details')?></button>
								<?php
								}
								if($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') { ?>
								<button type="button" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" id="post_to_fb_messenger"><img src="<?=SITE_URL?>media/images/messanger.png" class="img-fluid social-mnedia" alt="messanger" /> <?=_lang('post_quote_to_facebook_messenger_button_text','model_details')?> <span class="post_to_fb_messenger_spining_icon"></span></button>
								<?php
								}	
								if($quote_post_to_whatsapp_button == '1') { ?>
								<button type="button" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" id="post_to_whatsapp"><img src="<?=SITE_URL?>media/images/whatsapp.png" class="img-fluid social-mnedia" alt="whatsapp" /> <?=_lang('post_quote_to_whatsapp_button_text','model_details')?> <span class="post_to_whatsapp_spining_icon"></span></button>
								<?php
								} ?></p>
							</div>
							<?php
							} ?>
						</div>

						<div class="row all_device_price_detail_section">
							<div class="col-md-12">
								<?php
								if($fld_num > 0) { ?>
								<a href="javascript:void(0)" id="prevBtnFCart" class="float-left btn btn-lg btn-secondary "><?=_lang('back_button_text')?></a>
								<?php
								}
								
								if($ask_for_email_address_while_item_add_to_cart=='1' || $check_imei) { ?>
								<button type="button" id="addToCart" class="float-right btn btn-lg btn-primary show-price-popup"><strong><?=_lang('get_paid_button_text','model_details')?></strong></button>
								<?php
								} else { ?>
								<button type="submit" id="addToCart" name="sell_this_device" class="float-right btn btn-lg btn-primary"><strong><?=_lang('get_paid_button_text','model_details')?></strong></button>
								<?php
								} ?>
							</div>		
						</div>
					</div>

					<?php
					if($show_instant_price_on_model_criteria_selections == '1' && $fld_num > 0) { ?>
					<div class="row show_device_value_section">
						<div class="col-xl-12 col-lg-12 col-md-12 device_value_style">
							<h3 class="text-uppercase"><?=_lang('device_value_text','model_details')?></h3>
							<h4 class="total-price show_final_amt">$0<span>.00</span></h4>
							<h4 class="total-price apr-spining-icon" style="display:none;"></h4>
						</div>
					</div>
					<?php
					}
					
					if($fld_num > 0) { ?>
					<div class="step-navigation clearfix" style="display:none;">
						<a href="javascript:void(0)" id="prevBtn" class="float-left btn btn-lg btn-secondary"><?=_lang('back_button_text')?></a>
						<a href="javascript:void(0)" id="nextBtn" class="float-right btn btn-lg btn-primary"><?=_lang('next_button_text')?></a>
						<?php /*?><a href="javascript:void(0)" id="getOfferBtn" class="float-right btn btn-lg btn-primary"><strong><?=($show_instant_price_on_model_criteria_selections == '1'?_lang('next_button_text'):_lang('get_offer_button_text','model_details'))?></strong></a><?php */?>
					</div>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
var tpj=jQuery;
var show_instant_price_on_model_criteria_selections = '<?=$show_instant_price_on_model_criteria_selections?>';

<?php
if($ask_for_email_address_while_item_add_to_cart=='1' && $start_your_order_with == "phone") { ?>
var iti_ipt_pwc;
tpj(document).ready(function($) {
	var telInput_pwc = document.querySelector("#phone_while_add_to_cart");
	iti_ipt_pwc = window.intlTelInput(telInput_pwc, {
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
	iti_ipt_pwc.setNumber("<?=(!empty($phone_while_add_to_cart_c_code)?$phone_while_add_to_cart_c_code.$phone_while_add_to_cart:'')?>");
});
<?php
}

if($check_imei) { ?>
function check_imei_number_form() {
	tpj(".m_validations_showhide").hide();
	var imei_number = document.getElementById("imei_number").value.trim();
	if(imei_number=="") {
		tpj("#imei_number_error_msg").show().text('<?=_lang('imei_number_field_validation_text','model_details')?>');
		return false;
	}
}
<?php
}

if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
function check_email_while_add_to_cart_form() {
	tpj(".m_validations_showhide").hide();
	<?php
	if($start_your_order_with == "email") { ?>
		var email_while_add_to_cart = document.getElementById("email_while_add_to_cart").value.trim();
		if(email_while_add_to_cart=="") {
			tpj("#email_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_email_address_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		} else if(!email_while_add_to_cart.match(mailformat)) {
			tpj("#email_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_valid_email_address_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}
	<?php
	} else { ?>
		if(document.getElementById("phone_while_add_to_cart").value.trim()=="") {
			tpj("#phone_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_phone_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}

		tpj("#phone_while_add_to_cart_c_code").val(iti_ipt_pwc.getSelectedCountryData().dialCode);
		if(!iti_ipt_pwc.isValidNumber()) {
			tpj("#phone_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_valid_phone_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}
	<?php
	} ?>
}
<?php
} ?>

function check_m_details_validations(type) {
	<?php
	if($check_imei) { ?>
		if(type != "show-price-popup") {
			var ok = check_imei_number_form();
			if(ok == false) {
				return false;
			}
		}
	<?php
	}
	if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
		if(type != "show-price-popup") {
			var ok = check_email_while_add_to_cart_form();
			if(ok == false) {
				return false;
			}
		}
	<?php
	} ?>
	
	if(document.getElementById("quantity").value<=0) {
		alert('<?=_lang('quantity_validation_text','model_details')?>');
		return false;
	}
}

function get_price() {
	tpj.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>ajax/get_model_price.php',
		data: tpj('#model_details_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);
				var total_price = resp_data.payment_amt;
				var total_price_html = resp_data.payment_amt_html;
				
				tpj(".show_final_amt").show();
				
				if(resp_data.order_items) {
					tpj(".show_final_amt").html(total_price_html);
					//tpj(".show_final_amt_val").html(total_price);
					//tpj("#payment_amt").val(total_price);
				} else {
					tpj(".show_final_amt").html('00<span>.00</span>');
					//tpj(".show_final_amt_val").html(0);
					//tpj("#payment_amt").val(0);
				}

				tpj(".device-name-dt").show();
				tpj(".device-name").html(resp_data.order_items);

				tpj(".apr-spining-icon").html('');
				tpj(".apr-spining-icon").hide();
				
				tpj("#addToCart").attr("disabled", false);
				tpj(".get_offer_section_showhide").show();
				/*if(show_instant_price_on_model_criteria_selections == '1') {
					tpj('.show_device_value_section').show();
				}*/
			}
		}
	});
}

function price_updt_spining_icon() {
	tpj(".apr-spining-icon").html('<div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div>');
	tpj(".apr-spining-icon").show();
	tpj(".show_final_amt").hide();
}

function field_next_step(is_next_step) {
	var next_step = tpj(".model-details-panel:visible").next(".model-details-panel");
	var next_id = tpj(next_step).attr("id");

	var last_step = tpj(".model-details-panel").last(".model-details-panel");
	var last_id = tpj(last_step).attr("id");

	var nextall_step = tpj(".model-details-panel:visible").nextAll(".model-details-panel");
	console.log('Next All Step Length: ',nextall_step.length);

	var selected_field_ids_arr = [];

	tpj(".checkbox_select_buttons, .radio_select_con_buttons, .radio_select_buttons").each(function () {
		if(tpj(this).is(':checked')) {
			var prevall_val = tpj(this).val();
			if(prevall_val) {
				var spl_prevall_val = prevall_val.split(':');
				var prevall_f_val = spl_prevall_val[1];
				selected_field_ids_arr[prevall_f_val] = prevall_f_val;
			}
		}
	});
	console.log('Selected Option Ids: ',selected_field_ids_arr);

	var allow_fields_id_arr = [];
	
	var is_exclude_fields = false;
	for(nl_s = 0; nl_s < nextall_step.length; nl_s++) {
		var nextall_id = tpj(nextall_step[nl_s]).attr("id");
		var nextall_exclude_fields = tpj(nextall_step[nl_s]).attr("data-exclude_fields");
		console.log('Next All Id: ',nextall_id);
		console.log('Next All Exclude Fields: ',nextall_exclude_fields);

		var is_exclude_field = false;
		if(nextall_exclude_fields!="" && typeof nextall_exclude_fields !== 'undefined') {
			var nextall_exclude_fields = JSON.parse(nextall_exclude_fields);
			for(nl_ef = 0; nl_ef < nextall_exclude_fields.length; nl_ef++) {
				var exclude_fields_id = nextall_exclude_fields[nl_ef];
				if(selected_field_ids_arr[exclude_fields_id]) {
					console.log("Exist...");
					is_exclude_field = true;
				}
			}
			is_exclude_fields = true;
		}

		if(!is_exclude_field) {
			allow_fields_id_arr.push(nextall_id);
		}
	}
	
	console.log('Allow Next Fields Length: ',allow_fields_id_arr.length);
	console.log('Is Exclude Fields: ',is_exclude_fields);
	if(allow_fields_id_arr.length > 0) {
		console.log('Allow Fields Id: ',allow_fields_id_arr);
		next_id = allow_fields_id_arr[0];
	}

	console.log('next_id: ',next_id);
	console.log('last_id: ',last_id);
	if(allow_fields_id_arr.length > 0) {
	tpj('#nextBtn').show();
	tpj('#addToCart').hide();
	} else {
	tpj('#nextBtn').hide();
	tpj('#addToCart').show();
	}
	
	if(show_instant_price_on_model_criteria_selections == '1') {
		tpj('.show_device_value_section').hide();
		tpj(".device_value_style").css("margin-top", "-50px");
	}
	
	if(nextall_step.length == 1 && allow_fields_id_arr.length > 0) {
		if(is_next_step == '1') {
			tpj(".model-details-panel").hide();
			tpj("#"+next_id).show();
			tpj("#"+next_id).addClass("model-details-panel-back");
			tpj('#nextBtn').hide();
			tpj('#addToCart').show();
			if(show_instant_price_on_model_criteria_selections == '1') {
				tpj('.show_device_value_section').show();
			}
		}
	} else if((nextall_step.length > 0 && allow_fields_id_arr.length > 0) || (nextall_step.length > 0 && !is_exclude_fields)) {
		if(is_next_step == '1') {
			tpj(".model-details-panel").hide();
			tpj("#"+next_id).show();
			tpj("#"+next_id).addClass("model-details-panel-back");
			tpj('#nextBtn').show();
		}
	} else {
		if(is_next_step == '1') {
			tpj('#addToCart').show();
			if(show_instant_price_on_model_criteria_selections == '1') {
				tpj('.show_device_value_section').show();
			}
			tpj('#nextBtn').hide();
		}
	}

	var current_step = tpj(".model-details-panel:visible");
	var current_id = tpj(current_step).attr("id");
	console.log('current_id: ',current_id);
	
	if(current_id == last_id) {
		tpj('#addToCart').show();
		if(show_instant_price_on_model_criteria_selections == '1') {
			tpj('.show_device_value_section').show();
		}
		tpj('#nextBtn').hide();
	}
	
	if(show_instant_price_on_model_criteria_selections == '1') {
		tpj('.show_device_value_section').show();
		tpj(".device_value_style").css("margin-top", "-50px");
	}
	
	if(next_id == 'get-offer') {
		tpj('.step-navigation').hide();
		if(show_instant_price_on_model_criteria_selections == '1') {
			tpj('.show_device_value_section').hide();
		}
	}

	tpj("#prevBtn").show();
	tpj(".device-name-dt").show();
}

function field_prev_step() {
	var first_step = tpj(".model-details-panel").first(".model-details-panel-back");
	var first_id = tpj(first_step).attr("id");

	var last_step = tpj(".model-details-panel").last(".model-details-panel-back");
	var last_id = tpj(last_step).attr("id");

	var current_step = tpj(".model-details-panel:visible");
	var current_id = tpj(current_step).attr("id");
	
	var selected_field_ids_arr = [];

	tpj("#"+current_id+" .checkbox_select_buttons, #"+current_id+" .radio_select_con_buttons, #"+current_id+" .radio_select_buttons").each(function () {
		if(tpj(this).is(':checked')) {
			var prevall_val = tpj(this).val();
			if(prevall_val) {
				tpj(this).prop("checked", false);
				
				var spl_prevall_val = prevall_val.split(':');
				var prevall_f_val = spl_prevall_val[1];
				selected_field_ids_arr[prevall_f_val] = prevall_f_val;
			}
		}
	});
	console.log('Current Option Ids: ',selected_field_ids_arr);
	
	var prevall_step = tpj(".model-details-panel:visible").prevAll(".model-details-panel-back");
	console.log('Prev All Step Length: ',prevall_step.length);
	
	var allow_prev_fields_id_arr = [];

	for(pl_s = 0; pl_s < prevall_step.length; pl_s++) {
		var prevall_id = tpj(prevall_step[pl_s]).attr("id");
		console.log('Prev All Id: ',prevall_id);
		allow_prev_fields_id_arr.push(prevall_id);
	}

	if(allow_prev_fields_id_arr.length > 0) {
		console.log('Allow Prev Fields Id: ',allow_prev_fields_id_arr);
		prev_id = allow_prev_fields_id_arr[0];
	}

	console.log('current_id: ',current_id);
	console.log('prev_id: ',prev_id);
	console.log('first_id: ',first_id);
	console.log('last_id: ',last_id);

	if(prev_id == first_id) {
		tpj('#prevBtn').hide();
		//tpj(".device_value_style").css("margin-top", "0px");
	} else {
		tpj("#"+current_id).removeClass("model-details-panel-back");
	}

	tpj(".model-details-panel").hide();
	tpj("#"+prev_id).show();

	tpj('#addToCart').hide();
	if(show_instant_price_on_model_criteria_selections == '1') {
		tpj('.show_device_value_section').show();
		//tpj(".device_value_style").css("margin-top", "0px");
	}
	tpj('#nextBtn').show();
}

function check_step_validations() {
	tpj(".validation-msg").hide();
	var is_true = "yes";
	tpj('.model-details-panel:visible .radios').each(function(i, element) {
		var html = tpj(this).html();
		var data_input_type = tpj(this).parent().attr("data-input-type");
		if(data_input_type=="radio" || data_input_type == "select") {
			var crt_row_type = tpj(this).parent().parent().parent().attr("data-row_type");
			var is_required = tpj(this).parent().parent().parent().attr("data-required");
			if(is_required=="1"){
				if(crt_row_type=="radio" || crt_row_type=="select"){
					var cc = tpj(this).parent().parent().parent().find("input:checked").length;
					if(cc==0){
						tpj(this).parent().parent().parent().find(".validation-msg").show().html('<?=_lang('fields_validation_text','model_details')?>');
						is_true = "no";
					}
				}
			} 
		}
	});

	tpj('.model-details-panel:visible .checkboxes').each(function(i, element) {
		var html = tpj(this).html();
		var data_input_type = tpj(this).attr("data-input-type");
		if(data_input_type=="checkbox"){
			var crt_row_type = tpj(this).parent().parent().attr("data-row_type");
			var is_required = tpj(this).parent().parent().attr("data-required");
			if(is_required=="1"){
				var cc = tpj(this).parent().parent().find("input:checked").length;
				if(cc==0){
					tpj(this).parent().parent().find(".validation-msg").show().html('<?=_lang('fields_validation_text','model_details')?>');
					is_true = "no";
				}
			}
		}
	});

	if(is_true == "no") {
		return false;	
	} else {
		return true;
	}
}

tpj(document).ready(function($) {
	$('#addToCart').on('click', function() {
		var ok = check_step_validations();
		if(ok == false) {
			return false;
		}
		<?php
		if($check_imei) { ?>
			$("#imei_popup").modal();
			return false;
		<?php
		} ?>
	});
	
	<?php
	if($check_imei) { ?>
	$('#imei_number').on('change keyup paste', function() {
		if($('#imei_number').val().length > 15) {
			$('#imei_number').val($('#imei_number').val().substr(0,15));
		}
	});

	$('.imei_number_check_btn').on('click', function(e) {
		var ok = check_imei_number_form();
		if(ok == false) {
			return false;
		}

		var imei_number = $("#imei_number").val();
		$(".imei_number_spining_icon").html('<?=$spining_icon_html?>');
		$(".imei_number_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/check_imei_number.php',
			data: {imei_number:imei_number, model_id:'<?=$model_long_id?>', edit_item_id:'<?=$order_item_long_id?>', cat_id:'<?=$model_data['cat_id']?>'},
			success: function(data) {
				$(".imei_number_spining_icon").html('');
				$(".imei_number_spining_icon").hide();
				var resp_data = JSON.parse(data);
				var success = resp_data.success;
				if(success) {
					$("#device_check_info").val(resp_data.html);
					<?php
					if($is_both_ask_for_email_address_and_check_imei_exist) { ?>
						$(".check_imei_showhide").hide();
						$(".email_while_add_to_cart_showhide").show();
					<?php
					} else { ?>
						$("#model_details_form").submit();
					<?php
					} ?>
				} else {
					tpj("#imei_number_error_msg").show().text(resp_data.msg);
					return false;
				}
			}
		});
		return false;
	});
	<?php
	}
	if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
	$(".email_while_add_to_cart_popup").on('blur keyup change paste', 'input, select, textarea', function(event) {
		check_email_while_add_to_cart_form();
	});
	<?php
	}
	
	if($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') { ?>
	$('#post_to_fb_messenger').on('click', function(e) {
		//$("#payment_amt").val($(".show_final_amt_val").html());
		$(".post_to_fb_messenger_spining_icon").html('<?=$spining_icon_html?>');
		$(".post_to_fb_messenger_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/get_register_quote.php?type=fb_messenger',
			data: $('#model_details_form').serialize(),
			success: function(data) {
				$(".post_to_fb_messenger_spining_icon").html('');
				$(".post_to_fb_messenger_spining_icon").hide();
				var resp_data = JSON.parse(data);
				var status = resp_data.status;
				var url = resp_data.url;
				if(status && url) {
					window.open(url, '_blank');
				} else {
					alert('<?=_lang('something_went_wrong_message_text')?>');
					return false;
				}
			}
		});
	});
	<?php
	}
	if($quote_post_to_whatsapp_button == '1') { ?>
	$('#post_to_whatsapp').on('click', function(e) {
		//$("#payment_amt").val($(".show_final_amt_val").html());
		$(".post_to_whatsapp_spining_icon").html('<?=$spining_icon_html?>');
		$(".post_to_whatsapp_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/get_register_quote.php?type=whatsapp',
			data: $('#model_details_form').serialize(),
			success: function(data) {
				$(".post_to_whatsapp_spining_icon").html('');
				$(".post_to_whatsapp_spining_icon").hide();

				var resp_data = JSON.parse(data);
				var status = resp_data.status;
				var url = resp_data.url;
				if(status) {
					window.open(url, '_blank');
				} else {
					alert('<?=_lang('something_went_wrong_message_text')?>');
					return false;
				}
			}
		});
	});
	<?php
	} ?>

	$('.show-price-popup').on('click', function() {
		var ok = check_m_details_validations('show-price-popup');
		if(ok == false) {
			return false;
		}
		$("#ModalPriceShow").modal();
	});
	
	if(show_instant_price_on_model_criteria_selections == '1') {
		tpj('.show_device_value_section').show();
	}
	
	$('.step-navigation').show();
	$(".model-details-panel:first").show();

	var num_of_step = $(".model-details-panel").length;
	var current_step = $(".model-details-panel").first(".model-details-panel");
	var current_id = $(current_step).attr("id");
	$("#"+current_id).addClass("model-details-panel-back");
	
	var is_condition = $(current_step).attr("data-is_condition");
	var row_type = $(current_step).attr("data-row_type");
	if(row_type == "radio" || row_type == "select") {
		var showhide_next_btn = false;
		$('.model-details-panel:visible .radio_select_buttons').each(function(i, element) {
			if($(this).is(':checked')) {
				showhide_next_btn = true;
			}
		});

		if(showhide_next_btn) {
			$('#nextBtn').show();
		} else {
			$('#nextBtn').hide();
		}
		//$('#nextBtn').hide();
	}

	$("#prevBtn").hide();
	
	if(num_of_step == 0) {
		if(show_instant_price_on_model_criteria_selections == '1') {
			$('.show_device_value_section').show();
		}
	} else if(num_of_step>2) {
		$("#addToCart").hide();
		if(show_instant_price_on_model_criteria_selections == '1') {
			$('.show_device_value_section').hide();
		}
	} else if(num_of_step==2) {
		$("#nextBtn").hide();
		$('#addToCart').hide();
		if(show_instant_price_on_model_criteria_selections == '1') {
			$('.show_device_value_section').hide();
		}
	}

	$("#nextBtn").click(function() {
		var ok = check_step_validations();
		if(ok == false) {
			return false;
		}
		
		field_next_step(1);
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$("#prevBtn").click(function() {
		field_prev_step();
	});

	$("#prevBtnFCart").click(function() {
		tpj('.step-navigation').show();
		field_prev_step();
	});

	$('#device-prop-area .radio_select_buttons').bind('click', function() {
		//field_spining_icon();
		price_updt_spining_icon();
		field_next_step(1);
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$('#device-prop-area .radio_select_con_buttons').bind('click keyup', function() {
		var id = $(this).attr('id');
		var splt_id = id.split('-');
		tpj('.condition_tooltips').hide();
		tpj('.condition-tooltip-block-'+splt_id[1]).show();
		
		//tpj('#addToCart').hide();
		//tpj('#nextBtn').show();
		//field_next_step(0);
		price_updt_spining_icon();
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$('#device-prop-area .checkbox_select_buttons').bind('click keyup', function() {
		//tpj('#addToCart').hide();
		//tpj('#nextBtn').show();
		//field_next_step(0);
		price_updt_spining_icon();
		setTimeout(function(){
			get_price();
		}, 500);
	});

	$("#device_terms").click(function() {
		$("#device_terms_error_msg").hide();
	});
	
	<?php
	if($is_allow_multi_quantity == '1') { ?>
	$('.qty-minus').on('click', function(e) {
		var qty = $("#pc_quantity").val();
		if(qty<=0) {
			$('#pc_quantity').val(1);
			$('#quantity').val(1);
		} else if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#pc_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} 

		if(qty>=2) {
			var f_qty = (Number(qty) - 1);
			$('#pc_quantity').val(f_qty);
			$('#quantity').val(f_qty);
		}

		price_updt_spining_icon();
		setTimeout(function() {
			get_price();
		}, 500);
	});

	$('.qty-plus').on('click', function(e) {
		var qty = $("#pc_quantity").val();
		if(qty<=0) {
			$('#pc_quantity').val(1);
			$('#quantity').val(1);
		} else if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#pc_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} 

		if(qty<=998) {
			var f_qty = (Number(qty) + 1);
			$('#pc_quantity').val(f_qty);
			$('#quantity').val(f_qty);
		}

		price_updt_spining_icon();
		setTimeout(function() {
			get_price();
		}, 500);
	});

	$('#pc_quantity').bind('keyup change', function(e) {
		var qty = $(this).val();
		if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#pc_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} else {
			if(qty.trim() == "") {
				$('#pc_quantity').val(1);
				$('#quantity').val(1);
			} else {
				$('#pc_quantity').val(qty);
				$('#quantity').val(qty);
			}
		}

		price_updt_spining_icon();
		setTimeout(function() {
			get_price();
		}, 500);
	});

	$('#pc_quantity').bind('blur', function(e) {
		var qty = $(this).val();
		if(qty.trim() == "") {
			$('#pc_quantity').val(1);
			$('#quantity').val(1);
			
			price_updt_spining_icon();
			setTimeout(function() {
				get_price();
			}, 500);
		}
	});
	<?php
	} ?>

	$(document).on('click', '.condition-tooltips', function() {
		var id = $(this).attr("data-id");
		$('#condition_tooltip_model').modal('show');
		$("#condition_tooltip_model_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin" style="font-size:34px;"></i></div></div>');
		$("#condition_tooltip_model_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/get_condition_tooltip_content.php?id='+id,
			success: function(data) {
				if(data!="") {
					$('#condition_tooltip_model_content').html(data);
				}
				$("#condition_tooltip_model_spining_icon").html('');
				$("#condition_tooltip_model_spining_icon").hide();
			}
		});
		return false;
	});
	get_price();
});
</script>