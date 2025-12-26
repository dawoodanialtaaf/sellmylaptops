<?php
$csrf_token = generateFormToken('affiliate');

if(isset($_SESSION['affiliate_prefill_data'])) {
	$affiliate_prefill_data = $_SESSION['affiliate_prefill_data'];
	unset($_SESSION['affiliate_prefill_data']);
}

$affiliate_form_link = SITE_URL.get_inbuild_page_url('affiliates');

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

				<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						} 
						?>
					</div>
			</div>
		</div>
	</div>
</section> 



<section class="<?=$active_page_data['css_page_class']?>" style="background:#b1a8a8;">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="block">
					<form method="post" id="affiliate_form">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="name" id="name" placeholder="<?=_lang('name_field_placeholder_text','affiliate_form')?>">
									<div id="name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="web_address" id="web_address" placeholder="<?=_lang('web_address_field_placeholder_text','affiliate_form')?>">
									<div id="web_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<input class="form-control" type="tel" id="cell_phone" name="cell_phone">
									<input type="hidden" name="phone_c_code" id="phone_c_code" />
									<div id="cell_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<input type="text" class="form-control" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','affiliate_form')?>">
									<div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div>
							<?php /*?><div class="col-sm-4">
								<div class="form-group">
									<input type="text" class="form-control" name="company" id="company" placeholder="<?=_lang('company_name_field_placeholder_text','affiliate_form')?>">
									<div id="company_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group mb0">
									<textarea class="form-control" name="message" id="message" placeholder="<?=_lang('message_field_placeholder_text','affiliate_form')?>"></textarea>
									<div id="message_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div><?php */?>
							<div class="col-sm-12">
								<div class="form-group mb0">	
									<?=$affiliate_form_link.'/?shop='?><input type="text" class="form-control rounded-0 w-25 d-inline-block border-top-0 border-right-0 border-left-0" name="iframe_url_slug" id="iframe_url_slug" placeholder="<?=_lang('shop_name_field_placeholder_text','affiliate_form')?>" value="<?=(isset($affiliate_prefill_data['iframe_url_slug'])?$affiliate_prefill_data['shop_name']:'')?>">
									<div id="shop_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
								</div>
							</div>
							
							<?php
							if($affiliate_form_captcha == '1') { ?>
								<div class="col-md-12">
									<div class="form-group">
										<div id="g_form_gcaptcha"></div>
										<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
										<div id="captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
								</div>
							<?php
							} else {
								echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';
							} ?>

							<div class="col-sm-12 btn_row">
								<button type="submit" class="btn btn-primary affiliate_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="affiliate_form_spining_icon"></span></button>
								<input type="hidden" name="submit_form" id="submit_form" />
							</div>
						</div>
						<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                        <input type="hidden" name="controller" value="affiliates">
					</form>
				</div>
			</div>
			<div class="col-md-4">
				<div class="block">
					<?=$active_page_data['content']?>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
if($affiliate_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>

<script>
<?php
if($affiliate_form_captcha == '1') { ?>
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
		check_affiliate_form();
	}
};
<?php
} ?>

var affiliate_form_captcha = '<?=$affiliate_form_captcha?>';

var iti_ipt;

(function ($) {
	$(function () {
		var telInput = document.querySelector("#cell_phone");
		iti_ipt = window.intlTelInput(telInput, {
		  initialCountry: "<?=$phone_country_short_code?>",
		  allowDropdown: false,
		  geoIpLookup: function(callback) {
			jQuery.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
			  var countryCode = (resp && resp.country) ? resp.country : "";
			  callback(countryCode);
			});
		  },
		  utilsScript: "<?=SITE_URL?>assets/js/intlTelInput-utils.js" //just for formatting/placeholders etc
		});
	});
})(jQuery);

<?php
if(isset($affiliate_prefill_data['phone']) && $affiliate_prefill_data['phone']) { ?>
	iti_ipt.setNumber("<?=$affiliate_prefill_data['phone']?>");
<?php
} ?>

function check_affiliate_form() {
	jQuery(".m_validations_showhide").hide();				

	var name = jQuery("#name").val();
	name = name.trim();
	var cell_phone = jQuery("#cell_phone").val();
	var email = jQuery("#email").val();
	email = email.trim();
	/*var message = jQuery("#message").val();
	message = message.trim();*/
	var iframe_url_slug = jQuery("#iframe_url_slug").val();
	iframe_url_slug = iframe_url_slug.trim();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(name=="") {
		jQuery("#name_error_msg").show().text('<?=_lang('name_field_validation_text','affiliate_form')?>');
		return false;
	}
	if(cell_phone=="") {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','affiliate_form')?>');
		return false;
	}

	jQuery("#phone_c_code").val(iti_ipt.getSelectedCountryData().dialCode);
	if(!iti_ipt.isValidNumber()) {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','affiliate_form')?>');
		return false;
	}

	if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','affiliate_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','affiliate_form')?>');
		return false;
	} <?php /*?> else if(message=="") {
		jQuery("#message_error_msg").show().text('<?=_lang('message_field_validation_text','affiliate_form')?>');
		return false;
	}<?php */?> else if(iframe_url_slug=="") {
		jQuery("#shop_name_error_msg").show().text('<?=_lang('shop_name_field_validation_text','affiliate_form')?>');
		return false;
	} else if(affiliate_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','affiliate_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#affiliate_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_affiliate_form();
		});
		$(".affiliate_form_sbmt_btn").click(function() {
			var ok = check_affiliate_form();
			if(ok == false) {
				return false;
			} else {
				$("#affiliate_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#affiliate_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#affiliate_form").submit();
			}
		});
	});
})(jQuery);
</script>