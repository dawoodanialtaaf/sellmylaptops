<?php
$csrf_token = generateFormToken('reset_password');

//Header section
include("include/header.php");

//Fetching data from model
require_once('helpers/user/reset_password.php'); ?>

<form method="post" id="reset_psw_form" role="form">
  <section>
	<div class="container">
	  <div class="row">
		<div class="col-md-12">
		  <div class="head user-area-head text-center">
			<div class="h2"><strong><?=_lang('heading_text','reset_password_form')?></strong></div>
		  </div>
		</div>
	  </div>
	  <div class="row justify-content-center">
		<div class="col-md-6">
		  <div class="block login clearfix">
			<div class="card">
				<div class="card-body">
					<div class="form-horizontal form-login" role="form">
						<div class="form-wrap clearfix">
							<div class="form-group with-icon password-field">
								<label for="new_password"><?=_lang('new_password_field_label_text','reset_password_form')?></label>
								<input type="password" class="form-control" id="new_password" name="new_password" placeholder="<?=_lang('new_password_field_placeholder_text','reset_password_form')?>" autocomplete="off">
								<div id="new_password_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
							</div>
							<div class="form-group with-icon password-field">
								<label for="confirm_password"><?=_lang('confirm_password_field_label_text','reset_password_form')?></label>
								<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="<?=_lang('confirm_password_field_placeholder_text','reset_password_form')?>" autocomplete="off">
								<div id="confirm_password_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-block btn-primary reset_psw_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="reset_psw_form_spining_icon"></span></button>
								<input type="hidden" name="reset" id="reset" />
								<input type="hidden" name="t" id="t" value="<?=$post['t']?>" />
                                <input type="hidden" name="controller" value="user/reset_password" />
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
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
</form>

<script>
function check_reset_psw_form() {
	jQuery(".m_validations_showhide").hide();				

	var password = jQuery("#new_password").val();
	password = password.trim();
	var confirm_password = jQuery("#confirm_password").val();
	confirm_password = confirm_password.trim();

	if(password=="") {
		jQuery("#new_password_error_msg").show().text('<?=_lang('new_password_field_validation_text','reset_password_form')?>');
		return false;
	} else if(confirm_password=="") {
		jQuery("#confirm_password_error_msg").show().text('<?=_lang('confirm_password_field_validation_text','reset_password_form')?>');
		return false;
	} else if(password!=confirm_password) {
		jQuery("#confirm_password_error_msg").show().text('<?=_lang('new_password_and_confirm_password_not_match_validation_text','reset_password_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#reset_psw_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_reset_psw_form();
		});
		$(".reset_psw_form_sbmt_btn").click(function() {
			var ok = check_reset_psw_form();
			if(ok == false) {
				return false;
			} else {
				$("#reset_psw_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#reset_psw_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#reset_psw_form").submit();
			}
		});
	});
})(jQuery);
</script>
