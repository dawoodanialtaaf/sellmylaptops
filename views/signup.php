<?php
//If already loggedin and try to access signup page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('signup');

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
			</div>
		</div>
	</div>
</section>

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background: url('.SITE_URL.'media/images/pages/'.$header_image.') no-repeat; background-size:cover; width: 100%;"';}?>> 
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
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?> pt-5 pb-0">
		<div class="container">
			<div class="col-md-12">
				<div class="heading page-heading text-center">
					<h1 class="mb-0"><?=$page_title?></h1>
				</div>
			</div>
		</div>
	</section>
<?php
}

$sub_title_text = _lang('sub_title_text','signup_form'); ?>

<section class="user_form_section py-5">
	<div class="container">
		<div class="row justify-content-center">  
			<div class="col-md-12 col-sm-12 col-lg-8 col-xl-8">    
				<div class="card ufs_inner">    
					<div class="card-body">  
						<div class="head user-area-head text-center">
							<?=($sub_title_text?'<div class="h2"><strong>'.$sub_title_text.'</strong></div>':'')?>
							<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
						</div>
						<div class="form-signup">
							<form method="post" id="signup_form" role="form">
							  <div class="row clearfix">
							    <?php
								if($enable_signup_first_name_field == '1') { ?>
								<div class="form-group col-md-6">
								    <label for="first_name" class="control-label"><?=_lang('first_name_field_label_text','signup_form')?></label>
								    <input type="text" class="form-control" name="first_name" id="first_name">
									<div id="first_name_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<?php
								}
								if($enable_signup_last_name_field == '1') { ?>
								<div class="form-group col-md-6">
								    <label for="last_name" class="control-label"><?=_lang('last_name_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="last_name" id="last_name">
									<div id="last_name_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<?php
								}
								if($enable_signup_phone_field == '1') { ?>
								<div class="form-group col-md-6">
								    <label for="cell_phone" class="control-label"><?=_lang('phone_field_label_text','signup_form')?></label>
									<input type="tel" id="cell_phone" name="cell_phone" class="form-control">
									<input type="hidden" name="phone_c_code" id="phone_c_code" />
									<div id="cell_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<?php
								} ?>
								<div class="form-group col-md-6">
								    <label for="email" class="control-label"><?=_lang('email_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="email" id="email" autocomplete="off">
									<div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<div class="form-group col-md-6">
								    <label for="password" class="control-label"><?=_lang('password_field_label_text','signup_form')?></label>
									<input type="password" class="form-control" name="password" id="password" autocomplete="off">
									<div id="password_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<div class="form-group col-md-6">
								    <label for="confirm_password" class="control-label"><?=_lang('confirm_password_field_label_text','signup_form')?></label>
									<input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="off">
									<div id="confirm_password_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>

								<?php
								if($enable_signup_address_fields == "1") { ?>
								<div class="form-group col-md-6">
								    <label for="address" class="control-label"><?=_lang('address_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="address" id="address" autocomplete="off">
									<div id="address_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								
								<?php
								if($show_house_number_field == '1') { ?>
								<div class="form-group col-md-6">
								    <label for="house_number" class="control-label"><?=_lang('house_number_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="house_number" id="house_number" autocomplete="off">
									<div id="house_number_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<?php
								} ?>
								
								<div class="form-group col-md-6">
								    <label for="address2" class="control-label"><?=_lang('address2_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="address2" id="address2" autocomplete="off">
									<div id="address2_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								
								<div class="form-group col-md-6">
								    <label for="city" class="control-label"><?=_lang('city_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="city" id="city" autocomplete="off">
									<div id="city_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								
								<?php
								if($hide_state_field != '1') { ?>
								<div class="form-group col-md-6">
								    <label for="state" class="control-label"><?=_lang('state_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="state" id="state" autocomplete="off">
									<div id="state_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<?php
								} ?>
								
								<div class="form-group col-md-6">
								    <label for="postcode" class="control-label"><?=_lang('postcode_field_label_text','signup_form')?></label>
									<input type="text" class="form-control" name="postcode" id="postcode" autocomplete="off">
									<div id="postcode_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
								<?php
								} ?>
							  </div>
							  
							  <?php
							  if($signup_form_captcha == '1') { ?>
							  <div class="row">
								<div class="form-group col-md-12">
								  <div id="g_form_gcaptcha"></div>
								  <input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
								  <div id="captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
								</div>
							  </div>
							  <?php
							  } else {
							  	  echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';
							  } ?>

							  <div class="form-group clearfix">
								<div class="checkbox signup-checkbox clearfix">
									<?php
									if($display_terms_array['ac_creation']=="ac_creation") { ?>
										<label for="terms_conditions">
											<input type="checkbox" name="terms_conditions" id="terms_conditions" value="1"/>
											<span class="checkmark"></span>
											I accept <a href="javascript:void(0)" class="help-icon click_terms_of_website_use"><?=_lang('terms_and_conditions_link_text','signup_form')?></a>
										</label>
									<?php
									} else {
										echo '<input type="hidden" name="terms_conditions" id="terms_conditions" value="1" checked="checked"/>';
									} ?>
								</div>
								<div id="terms_conditions_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
							  </div>
							  
							  <div class="form-group text-center">
								<button type="submit" class="btn btn-primary signup_form_sbmt_btn"><?=_lang('signup_button_text')?> <span id="signup_form_spining_icon"></span></button>
								<input type="hidden" name="submit_form" id="submit_form" />
							  </div>
							
							  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                              <input type="hidden" name="controller" value="user/signup" />
							</form>
							<div class="form-group-full clearfix">
								<div class="form-group text-center">
									<a href="<?=$login_link?>"><?=_lang('already_member_link_text','signup_form')?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	  
		<?php
		//For social signup/signin
		if($social_login=='1') { ?>
			<div id="signupbox2">
				<div class="row justify-content-center">
					<div class="col-md-7">
						<div class="text-center">
							<div id="signupbox">
								<div class="orsignup">
									<div class="row">
										<div class="btn_box dis_table_cell col-sm-12">
											<?php
											if($social_login_option=="g_f") { ?>
												<a class="btn btn_md btn_fb s_facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/fb_img.png" alt="Facebook Auth"><span class="s_facebook_auth_spining_icon"></span></a>
												<a id="google_auth_btn" class="btn btn_md btn_gplus" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/google_plus.png" alt="Google Auth"> <span class="google_auth_btn_spining_icon"></span></a>
											<?php
											} elseif($social_login_option=="g") { ?>
												<a id="google_auth_btn" class="btn btn_md btn_gplus" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/google_plus.png" alt="Google Auth"> <span class="google_auth_btn_spining_icon"></span></a>
											<?php
											} elseif($social_login_option=="f") { ?>
												<a class="btn btn_md btn_fb s_facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/fb_img.png" alt="Facebook Auth"><span class="s_facebook_auth_spining_icon"></span></a>
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
		<?php
		} //END for social login ?>
	</div>
</section>

<?php
if($signup_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($signup_form_captcha == '1') { ?>
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
		check_signup_form();
	}
};
<?php
} ?>

var signup_form_captcha = '<?=$signup_form_captcha?>';
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
	});
})(jQuery);

function check_signup_form() {
	jQuery(".m_validations_showhide").hide();				

	var email = jQuery("#email").val();
	email = email.trim();
	var password = jQuery("#password").val();
	password = password.trim();
	var confirm_password = jQuery("#confirm_password").val();
	confirm_password = confirm_password.trim();
	var terms_conditions = document.getElementById("terms_conditions").checked;
	var captcha_token = jQuery("#g_captcha_token").val();
	
	<?php
	if($enable_signup_first_name_field == '1') { ?>
	var first_name = jQuery("#first_name").val();
	first_name = first_name.trim();
	if(first_name=="") {
		jQuery("#first_name_error_msg").show().text('<?=_lang('first_name_field_validation_text','signup_form')?>');
		return false;
	} 
	<?php
	}
	
	if($enable_signup_last_name_field == '1') { ?>
	var last_name = jQuery("#last_name").val();
	last_name = last_name.trim();
	if(last_name=="") {
		jQuery("#last_name_error_msg").show().text('<?=_lang('last_name_field_validation_text','signup_form')?>');
		return false;
	} 
	<?php
	}
	
	if($enable_signup_phone_field == '1') { ?>
	var cell_phone = jQuery("#cell_phone").val();
	cell_phone = cell_phone.trim();
	if(cell_phone=="") {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','signup_form')?>');
		return false;
	}

	jQuery("#phone_c_code").val(iti_ipt.getSelectedCountryData().dialCode);
	if(!iti_ipt.isValidNumber()) {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','signup_form')?>');
		return false;
	} 
	<?php
	} ?>

	if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','signup_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','signup_form')?>');
		return false;
	} else if(password=="") {
		jQuery("#password_error_msg").show().text('<?=_lang('password_field_validation_text','signup_form')?>');
		return false;
	} else if(confirm_password=="") {
		jQuery("#confirm_password_error_msg").show().text('<?=_lang('confirm_password_field_validation_text','signup_form')?>');
		return false;
	} else if(password!=confirm_password) {
		jQuery("#confirm_password_error_msg").show().text('<?=_lang('password_and_confirm_password_not_match_validation_text','signup_form')?>');
		return false;
	} 
		
	<?php
	if($enable_signup_address_fields == "1") { ?>
		var address = jQuery("#address").val();
		address = address.trim();
		if(address=="") {
			jQuery("#address_error_msg").show().text('<?=_lang('address_field_validation_text','signup_form')?>');
			return false;
		}
		
		<?php
		if($show_house_number_field == '1') { ?>
		var house_number = jQuery("#house_number").val();
		house_number = house_number.trim();
		if(house_number=="") {
			jQuery("#house_number_error_msg").show().text('<?=_lang('house_number_field_validation_text','signup_form')?>');
			return false;
		}
		<?php
		} ?>
		
		var address2 = jQuery("#address2").val();
		address2 = address2.trim();
		if(address2=="") {
			jQuery("#address2_error_msg").show().text('<?=_lang('address2_field_validation_text','signup_form')?>');
			return false;
		}
		
		var city = jQuery("#city").val();
		city = city.trim();
		if(city=="") {
			jQuery("#city_error_msg").show().text('<?=_lang('city_field_validation_text','signup_form')?>');
			return false;
		}
		
		<?php
		if($hide_state_field != '1') { ?>
		var state = jQuery("#state").val();
		state = state.trim();
		if(state=="") {
			jQuery("#state_error_msg").show().text('<?=_lang('state_field_validation_text','signup_form')?>');
			return false;
		}
		<?php
		} ?>
		
		var postcode = jQuery("#postcode").val();
		postcode = postcode.trim();
		if(postcode=="") {
			jQuery("#postcode_error_msg").show().text('<?=_lang('postcode_field_validation_text','signup_form')?>');
			return false;
		}
	<?php
	} ?>

	if(terms_conditions==false) {
		jQuery("#terms_conditions_error_msg").show().text('<?=_lang('terms_and_conditions_field_validation_text','signup_form')?>');
		return false;
	} else if(signup_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','signup_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#signup_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_signup_form();
		});
		$(".signup_form_sbmt_btn").click(function() {
			var ok = check_signup_form();
			if(ok == false) {
				return false;
			} else {
				$("#signup_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#signup_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#signup_form").submit();
			}
		});
	});
})(jQuery);
</script>
