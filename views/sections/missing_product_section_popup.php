<?php
if($settings['missing_product_section']=='1') { ?>

<div class="modal fade common_popup" id="MissingProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

	<div class="modal-dialog modal-md" role="document">

	  <div class="modal-content">

		<div class="modal-header">

		  <h5 class="modal-title"><?=_lang('heading_text','quote_request_popup')?></h5>

		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

			<img src="<?=SITE_URL?>media/images/payment/close.png" alt="">

		  </button>

		</div>

		<div class="modal-body pt-3 text-center">

			<form method="post" id="req_quote_form" class="sign-in">

				<h2><?=_lang('sub_heading_text','quote_request_popup')?></h2>

				<p><?=_lang('description','quote_request_popup')?></p>

				<div class="form-row">

				  <div class="form-group col-md-6">

					<?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt=""><?php */?>

					<input type="text" class="form-control" name="name" id="name" placeholder="<?=_lang('name_field_placeholder_text','quote_request_popup')?>">

					<div id="name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

				  </div>

				  <div class="form-group mt-0 col-md-6">

					<?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt=""><?php */?>

					<input type="tel" id="cell_phone" name="cell_phone" class="form-control" placeholder="<?=_lang('phone_field_placeholder_text','quote_request_popup')?>">

					<input type="hidden" name="phone" id="phone" />

					<div id="cell_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

				  </div>

				</div>

				<div class="form-row">

				  <div class="form-group col-md-6">

					<?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt=""><?php */?>

					<input type="text" class="form-control" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','quote_request_popup')?>">

					<div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

				  </div>

				  <div class="form-group mt-0 col-md-6">

					<?php /*?><img src="<?=SITE_URL?>media/images/icons/user-items.png" alt=""><?php */?>

					<input type="text" class="form-control" name="item_name" id="item_name" placeholder="<?=_lang('item_field_placeholder_text','quote_request_popup')?>">

					<div id="item_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

				  </div>

				</div>

				<div class="form-row">

				  <div class="form-group col-md-12">

					<?php /*?><img src="<?=SITE_URL?>media/images/icons/user-comment.png" alt=""><?php */?>

					<textarea name="message" id="message" placeholder="<?=_lang('message_field_placeholder_text','quote_request_popup')?>" class="form-control"></textarea>

					<div id="message_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

				  </div>

				</div>

				<?php

				if($missing_product_form_captcha == '1') { ?>

				<div class="form-row">

					<div class="form-group col-md-12">

						<div id="g_form_gcaptcha"></div>

						<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>

						<div id="captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>

					</div>

				</div>

				<?php

				} else {

					echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';

				} ?>



				<div class="form-group double-btn pt-5 text-center">

				  <button type="submit" class="btn btn-primary btn-lg rounded-pill ml-lg-3 req_quote_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="req_quote_form_spining_icon"></span></button>

				  <input type="hidden" name="missing_product" id="missing_product" />

				</div>

				<?php

				$csrf_token = generateFormToken('missing_product_form'); ?>

				<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                <input type="hidden" name="controller" value="model">

			</form>

		</div>

	  </div>

	</div>

</div>

<?php
if($missing_product_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($missing_product_form_captcha == '1') { ?>
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
		check_req_quote_form();
	}
};
<?php
} ?>

var missing_product_form_captcha = '<?=$missing_product_form_captcha?>';

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

function check_req_quote_form() {
	jQuery(".m_validations_showhide").hide();				

	var name = jQuery("#name").val();
	name = name.trim();
	var cell_phone = jQuery("#cell_phone").val();
	var email = jQuery("#email").val();
	email = email.trim();
	var message = jQuery("#message").val();
	message = message.trim();
	var item_name = jQuery("#item_name").val();
	item_name = item_name.trim();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(name=="") {
		jQuery("#name_error_msg").show().text('<?=_lang('name_field_validation_text','quote_request_popup')?>');
		return false;
	}
	if(cell_phone=="") {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('phone_field_validation_text','quote_request_popup')?>');
		return false;
	}
	
	jQuery("#phone").val(iti_ipt.getNumber());
	if(!iti_ipt.isValidNumber()) {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('phone_field_validation_text','quote_request_popup')?>');
		return false;
	}

	if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','quote_request_popup')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','quote_request_popup')?>');
		return false;
	} else if(item_name=="") {
		jQuery("#item_name_error_msg").show().text('<?=_lang('item_field_validation_text','quote_request_popup')?>');
		return false;
	} else if(message=="") {
		jQuery("#message_error_msg").show().text('<?=_lang('message_field_validation_text','quote_request_popup')?>');
		return false;
	} else if(missing_product_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','quote_request_popup')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#req_quote_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_req_quote_form();
		});

		$(".req_quote_form_sbmt_btn").click(function() {
			var ok = check_req_quote_form();
			if(ok == false) {
				return false;
			} else {
				$("#req_quote_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#req_quote_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#req_quote_form").submit();
			}
		});
	});
})(jQuery);
</script>
<?php
} ?>