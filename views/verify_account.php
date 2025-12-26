<?php
$meta_title = "Verify Your Account";

//Fetching data from model
require_once("helpers/user/verify_account.php");
if($user_id>0) {
	$msg='You have already loggedin with other user so please first logout from current session then you will able to verify you account.';
	setRedirectWithMsg(SITE_URL,$msg,'danger');
	exit();
}
  
//Header section
include("include/header.php");
?>

<section class="user_form_section py-5">    
	<div class="container"> 
	  	<div class="row justify-content-center"> 
			<div class="col-md-8 col-sm-12 col-lg-6 col-xl-6">  
				<div class="card ufs_inner">     
					<div class="card-body">  
						<div class="text-center clearfix">
							<div class="form-horizontal form-login" role="form">
								<div class="head user-area-head text-center">
									<div class="h2"><strong><?=_lang('heading_text','verify_account_form')?></strong></div>
								</div>
								<div class="form-wrap clearfix">
									<form method="post" id="verify_ac_form" role="form">
										<div class="form-group">
											<label for="verification_code" class="control-label"><?=_lang('verification_code_field_label_text','verify_account_form')?></label>
											<input type="number" class="form-control text-center" name="verification_code" id="verification_code" placeholder="<?=_lang('verification_code_field_placeholder_text','verify_account_form')?>">
											<div id="verification_code_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
										</div>
										<div class="form-group">
											<button type="submit" class="btn btn-primary btn-lg verify_ac_form_smbt_btn"><?=_lang('verify_button_text')?> <span id="verify_ac_form_spining_icon"></span></button>
											<input type="hidden" name="submit_form" id="submit_form" />
											<input type="hidden" name="user_id" id="user_id" value="<?=$url_user_id?>" />
                                            <input type="hidden" name="controller" value="user/verify_account" />
										</div>
									</form>
									
									<form method="post" id="resend_veri_form">
										<?php
										if($user_data['verification_type']=="email") { ?>
											<div class="form-group">
												<label><?=_lang('resend_email_heading_text','verify_account_form')?></label>
												<button type="submit" id="resend_veri" class="btn btn-primary btn-lg"><?=_lang('resend_button_text')?> <span id="resend_veri_form_spining_icon"></span></button>
												<input type="hidden" name="resend_veri" />
											</div>
										<?php
										}
										if($user_data['verification_type']=="sms") { ?>
											<div class="form-group">
												<label><?=_lang('resend_phone_heading_text','verify_account_form')?></label>
												<button type="submit" id="resend_veri" class="btn btn-primary btn-lg"><?=_lang('resend_button_text')?> <span id="resend_veri_form_spining_icon"></span></button>
												<input type="hidden" name="resend_veri" />
											</div>
										<?php
										} ?>
										<input type="hidden" name="user_id" id="user_id" value="<?=$url_user_id?>" />
										
										<?php
										$csrf_token = generateFormToken('verify_account'); ?>
										<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                                        <input type="hidden" name="controller" value="user/verify_account" />
									</form>
								</div>
							</div>
						</div> 
					</div> 
				</div>
			</div> 
	 	</div>
	</div>
</section> 

<script>
function check_verify_ac_form() {
	jQuery(".m_validations_showhide").hide();				

	var verification_code = jQuery("#verification_code").val();
	verification_code = verification_code.trim();

	if(verification_code=="") {
		jQuery("#verification_code_error_msg").show().text('<?=_lang('verification_code_field_validation_text','verify_account_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#verify_ac_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_verify_ac_form();
		});
		$(".verify_ac_form_smbt_btn").click(function() {
			var ok = check_verify_ac_form();
			if(ok == false) {
				return false;
			} else {
				$("#verify_ac_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#verify_ac_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#verify_ac_form").submit();
			}
		});

		$("#resend_veri").click(function() {
			$("#resend_veri_form_spining_icon").html('<?=$spining_icon_html?>');
			$("#resend_veri_form_spining_icon").show();
			$(this).attr("disabled", "disabled");
			$("#resend_veri_form").submit();
		});
	});
})(jQuery);
</script>