<?php
$csrf_token = generateFormToken('contact');

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$header_text_color = $active_page_data['header_text_color'];
$page_title = $active_page_data['title'];

//Url encode for embed map
if($account_created_in_google_my_business == '1') {
	$business_address = trim(urlencode($company_name.' '.$company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode));
} else {
	$business_address = trim(urlencode($company_address.' '.$company_city.' '.$company_state.' '.$company_zipcode));
}

$service_hours_data = get_service_hours_data();
$open_time = json_decode($service_hours_data['open_time'],true);
$open_time_zone = json_decode($service_hours_data['open_time_zone'],true);
$hours_opening = @array_merge_recursive($open_time, $open_time_zone);
$close_time = json_decode($service_hours_data['close_time'],true);
$close_time_zone = json_decode($service_hours_data['close_time_zone'],true);
$hours_closing = @array_merge_recursive($close_time, $close_time_zone);
$opening_slot = @array_merge_recursive($hours_opening, $hours_closing);
$closed = json_decode($service_hours_data['is_close'],true);

$new_array = array();
if($open_time > 0) {
	foreach($open_time as $k => $v) {
		if($k!='' && $v!='') {
			switch($k) {
				case "sunday":
					$day_order=7;
					break;
				case "monday":
					$day_order=1;
					break;	
				case "tuesday":
					$day_order=2;
					break;
				case "wednesday":
					$day_order=3;
					break;
				case "thursday":
					$day_order=4;
					break;
				case "friday":
					$day_order=5;
					break;
				case "saturday":
					$day_order=6;
					break;
			}
			if(array_key_exists($k, $open_time_zone)) {
				$new_array1_day[$k] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td><a href="javascript:void(0)" class="time_box"> '.$v.$open_time_zone[$k].' - '.$close_time[$k].$close_time_zone[$k].'</a></td></tr>';
				$new_array1[$day_order] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td>'.$v.$open_time_zone[$k].' - '.$close_time[$k].$close_time_zone[$k].'</td></tr>';
			}
		}
	}
}

if(!empty($closed) && count($closed) > 0) {
	foreach($closed as $k => $v) {
		if($k!='' && $v!='') {
			switch($k) {
				case "sunday":
					$day_order=7;
					break;
				case "monday":
					$day_order=1;
					break;	
				case "tuesday":
					$day_order=2;
					break;
				case "wednesday":
					$day_order=3;
					break;
				case "thursday":
					$day_order=4;
					break;
				case "friday":
					$day_order=5;
					break;
				case "saturday":
					$day_order=6;
					break;
			}
			$new_array1_day[$k] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td><a href="javascript:void(0)" class="time_box">Closed</a></td></tr>';
			$new_array1[$day_order] = '<tr><td><strong>'.ucfirst(substr($k,0,3)).'</strong></td><td>Closed</td></tr>';
		}
	}
}

$is_office_open = 'yes';
$office_open_close_status = "";
$servertime = date('H:i');
$server_time = strtotime($servertime);
$server_timeday = strtolower(date('l',$server_time));
if(!empty($open_time) && count($open_time) > 0) {
	foreach($open_time as $k => $v) {
		if($k==$server_timeday) {
			$opentimezone = $v;
			$opentimezone_label = $v.' '.$open_time_zone[$k];
			$closetimezone = $close_time[$k];
			
			$exp_opentimezone = explode(':',$v);
			if($v!='00:00' && $exp_opentimezone[0]!='00')
				$opentimezone = $v.' '.$open_time_zone[$k];
			if($close_time[$k]!='00:00')
				$closetimezone = $close_time[$k].' '.$close_time_zone[$k];

			$server_time=date('H:i',$server_time);
			$opening_time=date('H:i',strtotime($opentimezone));
			$closing_time=date('H:i',strtotime($closetimezone));

			if($v=="") {
				$is_office_open = 'no';
				$office_open_close_status = 'Today: Closed On '.ucfirst($server_timeday).' <span class="opennow">Closed Now</span>';
			} elseif($opening_time <= $server_time && $closing_time >= $server_time) {
				$is_office_open = 'yes';
				$office_open_close_status = 'Today: '.$opentimezone_label.' - '.$closetimezone.'<br><span class="opennow">Open Now</span>';	
			} else {
				$is_office_open = 'no';
				$office_open_close_status = 'Today: '.$opentimezone_label.' - '.$closetimezone.'<br><span class="opennow">Closed Now</span>';		
			}
		}
	}
}

if(!empty($closed) && count($closed) > 0) {
	foreach($closed as $k => $v) {
		if($k!="" && $v!="" && $k==$server_timeday) {
			$is_office_open = 'no';
			$office_open_close_status = 'Today: Closed On '.ucfirst($server_timeday).'<br><span class="opennow">Closed Now</span>';	
		}
	}
}
							
$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
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

<?php
//Header Image


if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center" style='background:#cdc9c9;'>
					<h1 style="color:#ff4900  !important;"><?=$page_title?></h1>
					<?php
					if($office_open_close_status) { ?>
						<p class="<?=($is_office_open=='no'?'office_close':'')?>"><?=$office_open_close_status?></p>
					<?php
					} ?>
				</div>
			</div>
		</div>
	</section>
<?php 
}

$sub_title_text = _lang('sub_title_text','contact_us_form'); ?>

<section id="contact-detail" class="<?=$active_page_data['css_page_class']?> white-bg">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<div class="contact_block py-4" >
					<div class="inner">
						<div class="img_box"><img src="<?=SITE_URL?>media/images/ico_map.png" class="img-fluid"></div>
						<h5><?=_lang('our_address_title_text','contact_us_form')?></h5>
						<p>
						<?php
						if($company_name) {
							echo '<strong>'.$company_name.'</strong>';
						}
						if($company_address) {
							echo '<br />'.$company_address;
						}
						if($company_city) {
							echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode.' '.$company_country;
						} ?></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="contact_block py-4">
					<div class="inner">
						<div class="img_box"><img src="<?=SITE_URL?>media/images/ico_phone.png" class="img-fluid"></div>
						<h5><?=_lang('phone_email_title_text','contact_us_form')?></h5>
						<p>
						<?php
						if($site_phone) {
							echo '<a href="tel:'.$site_phone.'">Phone: '.$site_phone.'</a>';
						}
						if($site_email) {
							echo '<br><a href="mailto:'.$site_email.'">Email: '.$site_email.'</a>';
						} ?></p>
					</div>
				</div>
			</div>
			<div class="col-sm-4">
				<div class="contact_block py-4">
					<div class="inner">
						<div class="img_box"><img src="<?=SITE_URL?>media/images/ico_clock.png" class="img-fluid"></div>
						<h5><?=_lang('working_hours_title_text','contact_us_form')?></h5>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#working_hours_model"><?=_lang('show_hours_button_text','contact_us_form')?></button>
					</div>
				</div>
			  </div>
			</div>
		</div> 
	</div>
</section>

<div class="modal fade" id="working_hours_model" tabindex="-1" role="dialog" aria-labelledby="working_hours_model_label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="working_hours_model_label"><?=_lang('working_hours_title_text','contact_us_form')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
				</button>
			</div>
			<div class="modal-body pt-0">
				<table class="table">
					<?php
					if(!empty($new_array1_day[strtolower(date('l'))])) {
						//echo $new_array1_day[strtolower(date('l'))];
					}

					if(!empty($new_array1)) {
						ksort($new_array1);
						foreach($new_array1 as $k => $v) {
							echo $v;
						}
					} ?>  
				</table>
			</div>
		</div>
	</div>
</div>

<section id="map" class="<?=$active_page_data['css_page_class']?> white-bg">
	<div class="google-map">
		<?php
		if(!empty($settings['google_embeded_map'])) {
			echo $settings['google_embeded_map'];
		} elseif($business_address && $map_key) { ?>
			<iframe width="100%" height="425px" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/search?q=<?=$business_address?>&key=<?=$map_key?>" allowfullscreen></iframe>
		<?php
		} ?>
	</div>
</section>

<form class="phone-sell-form" method="post" id="contact_form">
	<section id="contact-form" class="<?=$active_page_data['css_page_class']?> clearfix">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" style='background:#c9c9c9;border-radius:6px;'>
					<div class="block">
						<?php
						if($sub_title_text) {
							echo '<h3>'.$sub_title_text.'</h3>';
						}
						if($active_page_data['content']) {
							echo '<p class="para">'.$active_page_data['content'].'</p>';
						} ?>
						<div class="form-outer">
							<div class="row">
								<div class="col-sm-6">
									<div class="form_group form-group">
										<input type="text" class="form-control" name="name" id="name" placeholder="<?=_lang('name_field_placeholder_text','contact_us_form')?>">
										<div id="name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form_group form-group">
										<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="">
										<input type="hidden" name="phone" id="phone" />
										<div id="cell_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="form_group form-group">
										<input type="text" class="form-control" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','contact_us_form')?>">
										<div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
									<div class="form_group form-group">
										<input type="text" class="form-control" name="order_id" id="order_id" placeholder="<?=_lang('order_id_field_placeholder_text','contact_us_form')?>">
										<div id="order_id_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
									<div class="form_group form-group">
										<input type="text" class="form-control" name="subject" id="subject" placeholder="<?=_lang('subject_field_placeholder_text','contact_us_form')?>">
										<div id="subject_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
			
								<div class="col-sm-6">
									<div class="form_group form-group">
										<textarea class="form-control" name="message" id="message" placeholder="<?=_lang('message_field_placeholder_text','contact_us_form')?>"></textarea>
										<div id="message_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
							</div>
							<?php
							if($contact_form_captcha == '1') { ?>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<div id="g_form_gcaptcha"></div>
											<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
											<div id="captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
										</div>
									</div>
								</div>
							<?php
							} else {
								echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';
							} ?>
							<div class="row">
								<div class="col-sm-12 btn_row">
									<button class="btn btn-primary contact_form_sbmt_btn" type="submit"><?=_lang('submit_button_text')?> <span id="contact_form_spining_icon"></span></button>
									<input type="hidden" name="submit_form" id="submit_form" />
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	  </div>
	</section>
	<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
    <input type="hidden" name="controller" value="contact" />
</form>
  
<?php
if($contact_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($contact_form_captcha == '1') { ?>
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
		//jQuery("#submit_form").removeAttr("disabled");
		jQuery("#g_captcha_token").val('yes');
		check_contactus_form();
	}
};
<?php
} ?>

var contact_form_captcha = '<?=$contact_form_captcha?>';

var iti_ipt;
(function( $ ) {
	$(function() {
		var telInput = document.querySelector("#cell_phone");
		iti_ipt = window.intlTelInput(telInput, {
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

		$("#contact_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_contactus_form();
		});
		$(".contact_form_sbmt_btn").click(function() {
			var ok = check_contactus_form();
			if(ok == false) {
				return false;
			} else {
				$("#contact_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#contact_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#contact_form").submit();
			}
		});
	});
})(jQuery);

function check_contactus_form() {
	jQuery(".m_validations_showhide").hide();				

	var name = jQuery("#name").val();
	var cell_phone = jQuery("#cell_phone").val();
	var email = jQuery("#email").val();
	var subject = jQuery("#subject").val();
	var message = jQuery("#message").val();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(name=="") {
		jQuery("#name_error_msg").show().text('<?=_lang('name_field_validation_text','contact_us_form')?>');
		return false;
	} else if(cell_phone=="") {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('phone_field_validation_text','contact_us_form')?>');
		return false;
	}

	jQuery("#phone").val(iti_ipt.getNumber());
	if(!iti_ipt.isValidNumber()) {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','contact_us_form')?>');
		return false;
	}
	//var phone_c_code = iti_ipt.getSelectedCountryData().dialCode;
	
	if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','contact_us_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','contact_us_form')?>');
		return false;
	} else if(subject=="") {
		jQuery("#subject_error_msg").show().text('<?=_lang('subject_field_validation_text','contact_us_form')?>');
		return false;
	} else if(message=="") {
		jQuery("#message_error_msg").show().text('<?=_lang('message_field_validation_text','contact_us_form')?>');
		return false;
	} else if(contact_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','contact_us_form')?>');
		return false;
	}
}
</script>
