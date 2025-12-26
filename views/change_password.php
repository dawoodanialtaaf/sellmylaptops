<?php
$meta_title = "Change Password";
$active_menu = "change_password";

$csrf_token = generateFormToken('change_psw');

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} elseif($user_data['status'] == '0' || empty($user_data)) {
	$is_include = 1;
	$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
	setRedirectWithMsg(SITE_URL.'?controller=logout',$msg,'warning');
	exit();
} ?>

<form method="post" id="chg_psw_form" autocomplete="off">
  <section id="showAccount" class="py-0">
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
            <?php require_once('views/account_menu.php');?>
          </div>
          <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
            <div class="block heading page-heading setting-heading clearfix">
                <h3 class="float-left"><?=_lang('heading_text','change_password')?></h3>
            </div>
            <div class="block">
              <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                  <div class="card mt-3">
                    <div class="card-body">
                        <div class="form-group row">
                          <div class="col-sm-6">
						  	<label for="password" class="col-form-label"><?=_lang('new_password_field_label_text','change_password')?></label>
						    <input type="password" class="form-control" name="password" id="password" autocomplete="none">
							<div id="password_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                          </div>
                          <div class="col-sm-6">
                          	<label for="password2" class="col-form-label"><?=_lang('repeat_password_field_label_text','change_password')?></label>
						    <input type="password" class="form-control" name="password2" id="password2" autocomplete="none">
							<div id="password2_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                          </div>
                        </div>
						<div class="form-group row">
							<button type="submit" class="btn btn-primary ml-2 chg_psw_form_sbmt_btn"><?=_lang('save_button_text')?> <span id="chg_psw_form_spining_icon"></span></button>
							<input type="hidden" name="submit_form" id="submit_form" />
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
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
  <input type="hidden" name="controller" value="user/change_password">
</form>

<script>
function check_chg_psw_form() {
	jQuery(".m_validations_showhide").hide();				

	var password = jQuery("#password").val();
	password = password.trim();
	var password2 = jQuery("#password2").val();
	password2 = password2.trim();

	if(password=="") {
		jQuery("#password_error_msg").show().text('<?=_lang('new_password_validation_text','change_password')?>');
		return false;
	} else if(password2=="") {
		jQuery("#password2_error_msg").show().text('<?=_lang('repeat_password_validation_text','change_password')?>');
		return false;
	} else if(password!=password2) {
		jQuery("#password2_error_msg").show().text('<?=_lang('not_match_new_password_and_repeat_password_validation_text','change_password')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#chg_psw_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_chg_psw_form();
		});
		$(".chg_psw_form_sbmt_btn").click(function() {
			var ok = check_chg_psw_form();
			if(ok == false) {
				return false;
			} else {
				$("#chg_psw_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#chg_psw_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#chg_psw_form").submit();
			}
		});
	});
})(jQuery);
</script>