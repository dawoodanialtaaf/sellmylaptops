<?php
$csrf_token = generateFormToken('model_details');

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$header_text_color = $active_page_data['header_text_color'];
$page_title = $active_page_data['title'];

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
						<li class="breadcrumb-item active">
							<a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background: url('.SITE_URL.'media/images/pages/'.$header_image.')"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
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
<?php
$is_show_title = false;
}

if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h1><?=$page_title?></h1>
				</div>
			</div>
		</div>
	</section>
<?php
}

if(trim($active_page_data['content'])) { ?>
<section class="pt-5 pb-0">
	<div class="container-fluid <?=$active_page_data['css_page_class']?>">
	    <div class="row">
			<div class="col-md-12">
				<div class="block mt-0 pt-0">
					<?=$active_page_data['content']?>
				</div>
			</div>
	    </div>
	</div>
</section>
<?php
} ?>

<section class="py-4">
	<div class="container instant-sell-model" id="sell_my_device_container">
		<div class="row">
		<!--New Code-->
		<div class="col-md-12">
			<form method="post" id="sell_my_device_form" enctype="multipart/form-data">
				<div class="wrapAnswersBeta clearfix">
					<div id="first_welcome" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question assistant float-left d-flex">
										<div class="image text-center">
											<img src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">
											<p><small><?=SITE_NAME?></small></p>
										</div>
										
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span><?=_lang('first_line_text','instant_sell_model_chat_page')?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="clearfix" id="second_welcome" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question assistant float-left d-flex">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">
											<p><small><?=SITE_NAME?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span><?=_lang('device_type_heading_text','instant_sell_model_chat_page')?></span>
										</div>
									</div>
								</div>
							</div>			
						</div>
					</div>
				
					<div id="device_category_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question client d-flex float-right">
										<div id="msg_div">
											<div class="mobileScrollY clearfix">
												<ul class="clearfix">
													<?php
													$device_category_list=get_category_data_list();
													$num_of_device_category_list = count($device_category_list);
													if($num_of_device_category_list>0) {
														foreach($device_category_list as $device_category_data) {
															$brand_data_list = get_brand_data_list($device_category_data['id']);
											
															$d_num_query = mysqli_query($db,"SELECT d.id FROM model_series AS d LEFT JOIN model AS m ON m.model_series_id=d.id LEFT JOIN brand AS b ON b.id=m.brand_id WHERE d.published=1 AND m.cat_id='".$device_category_data['id']."' GROUP BY m.model_series_id ORDER BY d.ordering DESC");
															$num_of_model_series = mysqli_num_rows($d_num_query); ?>
															<li class="device_cate_type custom-control custom-radio custom-control-inline" id="device_cate_type">
																<input type="radio" class="device_category_id custom-control-input" name="device_category_id" id="device_category_id_<?=$device_category_data['id']?>" value="<?=$device_category_data['id']?>" data-value="<?=$device_category_data['title']?>" data-check_imei="<?=$device_category_data['check_imei']?>" data-brand_list="<?=count($brand_data_list)?>" data-cat_brand_title="<?=(!empty($brand_data_list['0']['brand_title'])?$brand_data_list['0']['brand_title']:'')?>" data-device_list="<?=$num_of_model_series?>">
																<label class="custom-control-label" for="device_category_id_<?=$device_category_data['id']?>" value="<?=$device_category_data['id']?>">
																	<div class="imgbox"><i class="fa <?=$device_category_data['fa_icon']?>"></i></div>
																	<div class="btnbox"><?=$device_category_data['title']?></div>
																</label>
															</li>
														<?php
														}
													} ?>
												</ul>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="brand_question_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question assistant float-left d-flex">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">
											<p><small><?=SITE_NAME?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="brand_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question client float-right">
										<div id="brand_list_data" style="display:block"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="model_series_question_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question assistant d-flex float-left">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">
											<p><small><?=SITE_NAME?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="model_series_list_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="question client float-right">
									<div id="device_list_data" style="display:block"></div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="model_question_div" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="clearfix">
									<div class="question assistant d-flex float-left">
										<div class="image text-center">
											<img class="assistant" src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">
											<p><small><?=SITE_NAME?></small></p>
										</div>
										<div class="loading" id="spinner" style="display:none"></div>
										<div id="msg_div" style="display:none">
											<span></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="model_list_div" class="model-detail-list" style="display:none">
						<div class="row">
							<div class="col-md-12">
								<div class="question client float-right">
									<div id="model_list_data" style="display:block"></div>
								</div>
							</div>
						</div>
					</div>
				
					<div id="model_dfields"></div>
					<div id="final_offer_div" style="display:none"></div>
				</div>

				<div class="modal fade common_popup email_while_add_to_cart_popup" id="ModalPriceShow" role="dialog">
					<div class="modal-dialog small_dialog">
						<div class="modal-content">
							<button type="button" class="close" data-dismiss="modal"><img src="<?=SITE_URL?>media/images/payment/close.png" alt="Popup Close"></button>
							<div class="modal-body">
								<div class="check_imei_showhide">
									 <div class="price_box">
										<div class="trade-in-detail-section">	 	
											<p><?=_lang('imei_number_field_label_text','model_details')?></p>
											<input type="number" class="textbox" name="imei_number" id="imei_number" placeholder="<?=_lang('imei_number_field_place_holder_text','model_details')?>" autocomplete="nope" maxlength="15">
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
											<button type="submit" class="btn btn-lg btn-primary imei_number_check_btn"><?=_lang('get_paid_button_text','model_details')?> <span class="imei_number_spining_icon"></span></button>
										</div>	
									</div>
								</div>
								
								<div class="email_while_add_to_cart_showhide">
									<div class="price_box">
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
											<button type="button" class="btn btn-lg btn-primary email_while_add_to_cart_btn"><?=_lang('get_paid_button_text','model_details')?></button>
										</div>	
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<input type="hidden" name="sell_my_device_new" value="1">
				<input type="hidden" name="quantity" id="quantity" value="1"/>
				<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                <input type="hidden" name="controller" value="model">
			</form>
		</div>
		<!--END-->
		
		</div>
	</div>
</section>

<div class="modal fade common_popup" id="field_tooltip_model" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=_lang('field_tooltip_popup_heading_text')?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
			</button>
		</div>
		<div class="modal-body">
			<span id="field_tooltip_model_spining_icon"></span>
			<div id="field_tooltip_model_content"></div>
		</div>	
    </div>
  </div>
</div> 

<?php
if($model_fields_layout == "multi" && $enable_conditional_fields == '1') {
	include("instant_sell_model/multiple_steps_conditional_fields.php");
} else {
	include("instant_sell_model/single_page_fields.php");
} ?>

<style>
.loading {
    margin: 20px;
    font-size: 36px;
    font-family: sans-serif;
}

.loading:after {
  display: inline-block;
  animation: dotty steps(1,end) 1s infinite;
  content: '';
}

@keyframes dotty {
  0%   { content: ''; }
  25%  { content: '.'; }
  50%  { content: '..'; }
  75%  { content: '...'; }
  100% { content: ''; }
}
</style>