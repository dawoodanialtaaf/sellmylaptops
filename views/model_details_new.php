<?php
$csrf_token = generateFormToken('model_details');

$brand_data = get_single_brand_data($brand_id);
$category_single_data = array();
$category_sef_url = "";
if($category_id>0) {
	$category_single_data = $cat_single_data_resp['category_single_data'];
	$category_sef_url = $category_single_data['sef_url'];
}

//Url params
$model_id=$model_single_data_resp['model_data']['id'];
$model_long_id=$model_single_data_resp['model_data']['long_id'];

//Get data from functions.php, get_single_model_data function
$model_data = get_single_model_data($model_id);
$meta_title = $model_data['meta_title'];
$meta_desc = $model_data['meta_desc'];
$meta_keywords = $model_data['meta_keywords'];
$meta_canonical_url = $model_data['meta_canonical_url'];
$custom_schema = !empty($model_data['custom_schema'])?$model_data['custom_schema']:"";
$custom_schema_title = !empty($model_data['title'])?$model_data['title']:"";

$schema_patterns = array(
	'{$model_title}',
	'{$model_image}',
	'{$model_desc}',
	'{$model_sku}',
	'{$model_url}',
	'{$currency}',
	'{$base_price}',
	'{$site_name}'
);
$schema_replacements = array(
	$model_data['title'],
	($model_data['model_img']?SITE_URL.'media/images/model/'.$model_data['model_img']:""),
	$model_data['description'],
	$model_data['sef_url'],
	($model_data['sef_url']?SITE_URL.$model_details_page_slug.$model_data['sef_url']:""),
	$currency_symbol,
	$model_data['price'],
	SITE_NAME,
);
$custom_schema = str_replace($schema_patterns, $schema_replacements, $custom_schema);
$custom_schema = str_replace($company_constants_patterns, $company_constants_replacements, $custom_schema);

$category_data = get_category_data($model_data['cat_id']);
$fields_options_tooltips_arr = json_decode($category_data['fields_options_tooltips'],true);
$cat_defect_fields_options_arr = json_decode($category_data['defect_fields_options'],true);
$defect_fields_options_arr = json_decode($model_data['defect_fields_options'],true);

$pre_defect_percentage_arr = [];
foreach($defect_fields_options_arr as $defect_fields_options_dt) {
	$pre_defect_percentage_arr[$defect_fields_options_dt['title']] = $defect_fields_options_dt['percentage'];
	//$defect_percentage_arr[$cat_defect_fields_options_dt['title']] = $pre_defect_percentage_arr[$cat_defect_fields_options_dt['title']];
}

// Create array based on category title => model percentage
$defect_percentage_arr = array();
$defect_description_arr = array();
$cus_opt_tooltips_data_arr = array();
if(!empty($cat_defect_fields_options_arr)) {
	foreach($cat_defect_fields_options_arr as $cat_defect_fields_options_k => $cat_defect_fields_options_dt) {
		if(!empty($cat_defect_fields_options_dt["description"])) {
			$defect_description_arr[$cat_defect_fields_options_dt['title']] = $cat_defect_fields_options_dt["description"];
		}

		if($pre_defect_percentage_arr[$cat_defect_fields_options_dt['title']] > 0) {
			$defect_percentage_arr[$cat_defect_fields_options_dt['title']] = $pre_defect_percentage_arr[$cat_defect_fields_options_dt['title']];
		} elseif($cat_defect_fields_options_dt['percentage']>0) {
			$defect_percentage_arr[$cat_defect_fields_options_dt['title']] = $cat_defect_fields_options_dt['percentage'];
		}

		/*if(empty($defect_fields_options_arr)) {
			$defect_percentage_arr[$cat_defect_fields_options_dt['title']] = $cat_defect_fields_options_dt['percentage'];
		} else {
			foreach($defect_fields_options_arr as $defect_fields_options_dt) {
				if($cat_defect_fields_options_dt['title'] == $defect_fields_options_dt['title']) {
					if($defect_fields_options_dt['percentage'] > 0) {
						$defect_percentage_arr[$cat_defect_fields_options_dt['title']] = $defect_fields_options_dt['percentage'];
					} else {
						$defect_percentage_arr[$cat_defect_fields_options_dt['title']] = $cat_defect_fields_options_dt['percentage'];
					}
				}
			}
		}*/
	}
}

/*print_r($defect_percentage_arr);
exit;*/

$check_imei = $category_data['check_imei'];
if($check_imei) {
	$is_allow_multi_quantity = 0;
}

//Header section
include("include/header_product.php");

$edit_item_id = "";
$imei_number = "";
$saved_quantity = 1;
$order_item_long_id = isset($_GET['item_id'])?$_GET['item_id']:'';
$order_item_data = array();
if(!empty($order_item_long_id)) {
	$order_item_data = get_order_item('','',$order_item_long_id);
	$order_item_data = $order_item_data['data'];
	$edit_item_id = $order_item_data['id'];
	$saved_quantity = !empty($order_item_data['quantity'])?$order_item_data['quantity']:'1';
	$imei_number = !empty($order_item_data['imei_number'])?$order_item_data['imei_number']:"";
}

$opt_nm_arr = array();
$opt_id_array = array();
$tooltips_data_array = array();

$item_name_array = json_decode((isset($order_item_data['item_name'])?$order_item_data['item_name']:''),true);
if(!empty($item_name_array)) {
	foreach($item_name_array as $ei_k => $item_name_data) {	
		$fld_id_array[] = $ei_k;
		$items_opt_name = "";
		foreach($item_name_data['opt_data'] as $opt_data) {
			if(!empty($opt_data['opt_name'])) {
				$opt_nm_arr[] = $opt_data['opt_name'];
			}
			
			if($opt_data['opt_id']>0) {
				$items_opt_name .= $opt_data['opt_name'].', ';
				$opt_id_array[] = $opt_data['opt_id'];
			} else {
				$items_opt_name .= $opt_data['opt_name'].', ';
			}
		}
		if(!empty($items_opt_name)) {
			$opt_name_array[$ei_k] .= rtrim($items_opt_name,', ');
		}		
	}
}

$image_name_array = json_decode((isset($order_item_data['images'])?$order_item_data['images']:''),true);
if(!empty($image_name_array)) {
	foreach($image_name_array as $eim_k => $image_name_data) {
		$fld_id_array[] = $eim_k;
		$opt_name_array[$eim_k] = $image_name_data['img_name'];
	}
}

$pro_fld_o_q = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$model_id."' AND type != 'condition' AND input_type NOT IN('text','textarea','datepicker','file') ORDER BY sort_order");
$exist_others_pro_fld = mysqli_num_rows($pro_fld_o_q);

$pro_fld_c_q = mysqli_query($db,"SELECT * FROM product_fields WHERE product_id = '".$model_id."' AND type = 'condition' AND input_type NOT IN('text','textarea','datepicker','file') ORDER BY sort_order");
$exist_con_pro_fld = mysqli_num_rows($pro_fld_c_q);
$con_pro_fld_data = mysqli_fetch_assoc($pro_fld_c_q);

$model_upto_price = 0;
$model_upto_price_data = get_model_upto_price($model_id, $model_data['price'], $fields_options_tooltips_arr);
$model_upto_price = $model_upto_price_data['price'];

$email_while_add_to_cart = $user_data['email'];
$sess_email_while_add_to_cart = (isset($_SESSION[$session_front_email_while_add_to_cart])?$_SESSION[$session_front_email_while_add_to_cart]:'');
if($sess_email_while_add_to_cart) {
	$email_while_add_to_cart = $sess_email_while_add_to_cart;
}

if($email_while_add_to_cart) {
	$ask_for_email_address_while_item_add_to_cart = '0';
}

$phone_while_add_to_cart = $user_data['phone'];
$sess_phone_while_add_to_cart = (isset($_SESSION[$session_front_phone_while_add_to_cart])?$_SESSION[$session_front_phone_while_add_to_cart]:'');
$phone_while_add_to_cart_c_code = (isset($_SESSION[$session_front_phone_while_add_to_cart_c_code])?$_SESSION[$session_front_phone_while_add_to_cart_c_code]:'');
if($sess_phone_while_add_to_cart) {
	$phone_while_add_to_cart = $sess_phone_while_add_to_cart;
}

if($phone_while_add_to_cart) {
	$ask_for_email_address_while_item_add_to_cart = '0';
}

$is_both_ask_for_email_address_and_check_imei_exist = false;
if($ask_for_email_address_while_item_add_to_cart=='1' && $check_imei) {
	$is_both_ask_for_email_address_and_check_imei_exist = true;
}

$sql_cus_fld_params = "AND type != 'condition'";
if($display_condition_in_bottom != '1') {
	$exist_con_pro_fld = 0;
	$exist_others_pro_fld = 1;
	$con_pro_fld_data = array();
	$sql_cus_fld_params = "";
}



$exist_others_pro_fld = 1; ?>

<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
    <div class="container-fluid">
        <div class="row">     
            <div class="col-md-12">
                <div class="block breadcrumb clearfix">
                    <ul class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="<?=SITE_URL?>">Home</a>
                        </li>

                        <?php 
                        // Check if category data is available
                        if (!empty($category_data) && !empty($category_data['title']) && !empty($category_data['sef_url'])): ?>
                            <li class="breadcrumb-item">
                                <a href="<?=SITE_URL . $category_data['sef_url']?>"><?=htmlspecialchars($category_data['title'])?></a>
                            </li>
                        <?php endif; ?>

							<?php if (!empty($brand_data['title'])): ?>
								<li class="breadcrumb-item">
									
									 <a href="<?=SITE_URL . $category_single_data['sef_url'] . '/' . $brand_data['sef_url']?>"><?=htmlspecialchars($brand_data['title'])?></a>
								</li>
							<?php endif; ?>

                        <li class="breadcrumb-item active">
                            <a href="<?= "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"><?=htmlspecialchars($model_data['title'])?></a>
                        </li>
                    </ul>
                </div>
			</div>
		</div>
    </div>
</div>
</section>

<form method="post" enctype="multipart/form-data" <?=($show_instant_price_on_model_criteria_selections=='1' || $ask_for_email_address_while_item_add_to_cart=='1' || $check_imei?'onSubmit="return check_m_details_validations(\'submit\');"':'')?> id="model_details_form">
<section id="model_details" class="product-detail">
    <div class="container-fluid">
        <?php
        if($model_fields_layout == "multi" && $enable_conditional_fields == '1') {
            include("views/model_details/multiple_steps_conditional_fields.php");
        } elseif($model_fields_layout == "multi" && $enable_conditional_fields != '1') {
            include("views/model_details/multiple_steps_fields.php");
        } else {
            include("views/model_details/single_page_fields.php");
        }
        ?>
    </div>
</section>

<?php
if($show_instant_price_on_model_criteria_selections!='1' || $ask_for_email_address_while_item_add_to_cart=='1' || $check_imei) { ?>
<div class="modal fade common_popup email_while_add_to_cart_popup" id="ModalPriceShow" role="dialog">
	<div class="modal-dialog small_dialog">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal"><img src="<?=SITE_URL?>media/images/payment/close.png" alt="Popup Close"></button>
			<div class="modal-body">
				<?php
				if($ask_for_email_address_while_item_add_to_cart!='1' && !$check_imei) { ?>
					<div class="price_box">
						<span class="price">
							<?=_lang('price_popup_value_heading_text','model_details')?> <strong class="show_final_amt"></strong>
							<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
						</span>
					</div>
					<div class="text-right">
						<div class="device-part-section">
							<?php
							if($is_show_accept_offer_and_add_another_device_button) { ?>
							<button type="submit" class="btn btn-lg btn-outline-light accept-btn mt-3" name="accept_offer"><?=_lang('accept_offer_button_text','model_details')?></button>
							<?php
							} ?>
							<button type="submit" class="btn btn-lg btn-primary"><?=_lang('get_paid_button_text','model_details')?></button>
						</div>	
					</div>
				<?php
				} else {
					if($check_imei) { ?>
						<div class="check_imei_showhide">
							 <div class="price_box">
								<span class="price">
									<?=_lang('price_popup_value_heading_text','model_details')?> <strong class="show_final_amt"></strong>
									<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
								</span>
								<div class="trade-in-detail-section">	 	
									<p><?=_lang('imei_number_field_label_text','model_details')?></p>
									<input type="number" class="textbox" name="imei_number" id="imei_number" placeholder="<?=_lang('imei_number_field_place_holder_text','model_details')?>" value="<?=$imei_number?>" autocomplete="nope" maxlength="15">
									<small id="imei_number_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									<input type="hidden" name="device_check_info" id="device_check_info">
								</div>
							</div>
							
							<div class="text-right">
								<div class="device-part-section">
									<?php
									if($is_show_accept_offer_and_add_another_device_button) { ?>
									<button type="submit" class="btn btn-lg btn-outline-light accept-btn mt-3" name="accept_offer"><?=_lang('accept_offer_button_text','model_details')?></button>
									<?php
									} ?>
									<button type="submit" class="btn btn-lg btn-primary imei_number_check_btn"><?=($is_both_ask_for_email_address_and_check_imei_exist?_lang('next_button_text'):_lang('get_paid_button_text','model_details'))?> <span class="imei_number_spining_icon"></span></button>
								</div>	
							</div>
						</div>
					<?php
					}
					if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
						<div class="email_while_add_to_cart_showhide" <?=($is_both_ask_for_email_address_and_check_imei_exist?'style="display:none"':'')?>>
							<div class="price_box">
								<span class="price">
									<?=_lang('price_popup_value_heading_text','model_details')?> <strong class="show_final_amt"></strong>
									<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
								</span>
								<div class="trade-in-detail-section">
									<?php
									if($start_your_order_with == "email") { ?>
									<p><?=_lang('ask_for_email_address_while_item_add_to_cart_field_label_text','model_details')?> </p>
									<input type="text" class="textbox" name="email_while_add_to_cart" id="email_while_add_to_cart" placeholder="<?=_lang('ask_for_email_address_while_item_add_to_cart_field_validation_text','model_details')?>" value="<?=$email_while_add_to_cart?>" autocomplete="nope" data-bv-field="email">
									<small id="email_while_add_to_cart_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									<?php
									} else { ?>
									<p><?=_lang('ask_for_phone_while_item_add_to_cart_field_label_text','model_details')?> </p>
									<input type="tel" class="textbox" name="phone_while_add_to_cart" id="phone_while_add_to_cart" placeholder="<?=_lang('ask_for_phone_while_item_add_to_cart_field_validation_text','model_details')?>" value="<?=$phone_while_add_to_cart?>" autocomplete="nope" data-bv-field="phone">
									<input type="hidden" name="phone_while_add_to_cart_c_code" id="phone_while_add_to_cart_c_code" value="<?=$phone_while_add_to_cart_c_code?>"/>
									<small id="phone_while_add_to_cart_error_msg" class="help-block m_validations_showhide" style="display:none;"></small>
									<?php
									} ?>
								</div>
							</div>
							<div class="text-right">
								<div class="device-part-section">
									<?php
									if($is_show_accept_offer_and_add_another_device_button) { ?>
									<button type="submit" class="btn btn-lg btn-outline-light accept-btn mt-3" name="accept_offer"><?=_lang('accept_offer_button_text','model_details')?></button>
									<?php
									} ?>
									<button type="submit" class="btn btn-lg btn-primary"><?=_lang('get_paid_button_text','model_details')?></button>
								</div>	
							</div>
						</div>
					<?php
					}
				}

				if($show_instant_price_on_model_criteria_selections!='1' && $model_fields_layout == "single") { ?>
				<div class="text-right">
					<div class="device-part-section">
						<?php
						if($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') { ?>
						<p class="social-btn-group"><button type="button" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" id="post_to_fb_messenger"><img src="<?=SITE_URL?>media/images/messanger.png" class="img-fluid social-mnedia" alt="messanger" /> <?=_lang('post_quote_to_facebook_messenger_button_text','model_details')?> <span class="post_to_fb_messenger_spining_icon"></span></button>
						<?php
						}
						if($quote_post_to_whatsapp_button == '1') { ?>
						<button type="button" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" id="post_to_whatsapp"><img src="<?=SITE_URL?>media/images/whatsapp.png" class="img-fluid social-mnedia" alt="whatsapp" /> <?=_lang('post_quote_to_whatsapp_button_text','model_details')?> <span class="post_to_whatsapp_spining_icon"></span></button></p>
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
<?php
} ?>

<input type="hidden" name="sell_this_device" value="1">
<input type="hidden" name="quantity" id="quantity" value="<?=$saved_quantity?>"/>
<input type="hidden" name="model_id" id="model_id" value="<?=$model_long_id?>"/>
<input type="hidden" name="edit_item_id" id="edit_item_id" value="<?=$order_item_long_id?>"/>
<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
<input type="hidden" name="is_condition_appear" id="is_condition_appear" value="0"/>
<input type="hidden" name="is_get_offer_page" id="is_get_offer_page" value="0"/>
<input type="hidden" name="is_amt_appear" id="is_amt_appear" value="0"/>
<input type="hidden" name="controller" value="model">

<?php
if($email_while_add_to_cart && $ask_for_email_address_while_item_add_to_cart == '0') { ?>
<input type="hidden" name="email_while_add_to_cart" id="email_while_add_to_cart" value="<?=$email_while_add_to_cart?>">
<?php
}
if($phone_while_add_to_cart && $ask_for_email_address_while_item_add_to_cart == '0') { ?>
<input type="hidden" name="phone_while_add_to_cart" id="phone_while_add_to_cart" value="<?=$phone_while_add_to_cart?>">
<input type="hidden" name="phone_while_add_to_cart_c_code" id="phone_while_add_to_cart_c_code" value="<?=$phone_while_add_to_cart_c_code?>"/>
<?php
} ?>
</form>

<?php
//for sections
$is_review_sec_show = $review_sec_show_in_model_details;
$is_why_choose_us_sec_show = $why_choose_us_sec_show_in_model_details;
$is_how_it_works_sec_show = $how_it_works_sec_show_in_model_details;
require_once('views/sections/sections.php');

if($model_data['cat_id']>0) {
	$faqs_groups_data_html = get_faqs_groups_with_html(array(),$model_data['cat_id'],'model_details');
	if($faqs_groups_data_html['html']!="") { ?>
		<section class="faq_page model-faq">	 
			<div class="container">
				<div class="block setting-page clearfix">
					<div class="wrap">
						<?=$faqs_groups_data_html['html']?>
					</div>
				</div>
			</div>		
		</section>
	<?php	
	}
}

$model_description = preg_replace([
    '/<br\s*\/?>/i',
    '/<p>\s*<\/p>/i'
], '', $model_data['description']);


if(!empty($model_description)) { ?>
	<section> 
		<div class="container-fluid">
			<div class="block setting-page clearfix">
				<div class="wrap">
					<?php // nl2br($model_description); ?>
					<?=$model_description?>
				</div>
			</div>
		</div>		
	</section>
<?php
}
?>