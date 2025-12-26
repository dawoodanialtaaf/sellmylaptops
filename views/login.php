<?php
//If already loggedin and try to access login page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

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

$sub_title_text = _lang('sub_title_text','login_form'); ?>

  <section class="user_form_section py-5">
	<div class="container">
	  <div class="row justify-content-center">
		<div class="col-md-8 col-sm-12 col-lg-6 col-xl-6">  
			<div class="card ufs_inner">
				<div class="card-body">
					<div class=" clearfix">
						<div class="form-horizontal form-login" role="form">
							<div class="head user-area-head text-center">
								<?=($sub_title_text?'<div class="h2"><strong>'.$sub_title_text.'</strong></div>':'')?>
								<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
							</div>
							<form method="post" id="login_form">
								<div class="form-wrap clearfix">
									<div class="signin-f-form-msg" style="display:none;"></div>
									<span id="signin_f_spining_icon"></span>
						
									<div class="form-group">
										<label><?=_lang('email_field_label_text','login_form')?></label>
										<input type="text" class="form-control" id="s_username" name="username" placeholder="<?=_lang('email_field_placeholder_text','login_form')?>" autocomplete="off">
										<div id="username_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
									<div class="form-group">
										<label><?=_lang('password_field_label_text','login_form')?></label>
										<input type="password" class="form-control" id="s_password" name="password" placeholder="<?=_lang('password_field_placeholder_text','login_form')?>" autocomplete="off">
										<div id="password_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
									</div>
	
									<?php
									if($login_form_captcha == '1') { ?>
										<div class="form-group">
											<div id="g_form_gcaptcha"></div>
											<input type="hidden" id="g_captcha_token" name="g_captcha_token" value=""/>
											<div id="captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
										</div>
									<?php
									} else {
										echo '<input type="hidden" id="g_captcha_token" name="g_captcha_token" value="yes"/>';
									} ?>
	
									<div class="form-group text-center">
										<button type="button" class="btn btn-primary btn-lg signin_form_sbmt_btn"><?=_lang('login_link_text')?></button>
										<input type="hidden" name="submit_form" id="submit_form" />
									</div>
								</div>
								
								<?php
								$csrf_token = generateFormToken('ajax');
								echo '<input type="hidden" name="csrf_token" value="'.$csrf_token.'">'; ?>

								<div class="form-group text-center">
									<p class="mb-1"><a href="<?=$signup_link?>"><?=_lang('already_not_member_link_text','login_form')?></a></p>
									<p class="mb-1"><a href="<?=$lost_password_link?>"><?=_lang('forgotten_password_link_text','login_form')?></a></p>
								</div>
							</form>
							
						  <?php
						  if($settings['login_verification']=="email" || $settings['login_verification']=="sms") { ?>
						  <form class="sign-in needs-validation login-f-verifycode-form" style="display:none;" novalidate>
							<div class="login-f-verifycode-form-msg" style="display:none;"></div>
							<span id="resend_login_f_verifycode_p_spining_icon"></span>
							<div class="form-group">
							  <input type="text" class="form-control" name="login_verification_code" id="login_f_verification_code" placeholder="<?=_lang('verification_code_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" onkeyup="this.value=this.value.replace(/[^\d]/,'');" required>
							  <div class="invalid-feedback">
								<?=_lang('verification_code_field_validation_text','signin_register_popup')?>
							  </div>
							</div>
			
							<div class="form-group pt-3 text-center">
							  <button type="submit" class="btn btn-primary btn-lg rounded-pill login_f_verifycode_form_btn"><?=_lang('verify_button_text')?></button>
							  <input type="hidden" name="submit_form" id="submit_form" />
							  <input type="hidden" name="user_id" id="login_f_verifycode_user_id" />
			
							  <button type="button" class="btn btn-primary btn-lg rounded-pill resend_login_f_verifycode_btn"><?=_lang('resend_button_text')?></button>
							</div>
							
							<?php
							$l_v_a_csrf_token = generateFormToken('ajax');
							echo '<input type="hidden" name="csrf_token" value="'.$l_v_a_csrf_token.'">'; ?>
						  </form>
						  <?php
						  } ?>
						</div>  
					</div>
				</div>
			</div>
		</div>
	  </div>

	  <?php
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
											<a class="btn btn_md btn_fb s_facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/fb_img.png" alt=""><span class="s_facebook_auth_spining_icon"></span></a>
											<a id="google_auth_btn" class="btn btn_md btn_gplus" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/google_plus.png" alt=""> <span class="google_auth_btn_spining_icon"></span></a>
										<?php
										} elseif($social_login_option=="g") { ?>
											<a id="google_auth_btn" class="btn btn_md btn_gplus" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/google_plus.png" alt=""> <span class="google_auth_btn_spining_icon"></span></a>
										<?php
										} elseif($social_login_option=="f") { ?>
											<a class="btn btn_md btn_fb s_facebook_auth" href="javascript:void(0);"><img src="<?=SITE_URL?>media/images/fb_img.png" alt=""><span class="s_facebook_auth_spining_icon"></span></a>
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
	  } ?>
	</div>
  </section>

<?php
if($login_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
var g_c_login_f_wdt_id;
var g_c_signup_f_wdt_id;
<?php
if($login_form_captcha == '1') { ?>
var CaptchaCallback = function() {
	if(jQuery('#g_form_gcaptcha').length) {
		g_c_login_f_wdt_id = grecaptcha.render('g_form_gcaptcha', {
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
		check_login_form();
	}
};
<?php
} ?>

var login_form_captcha = '<?=$login_form_captcha?>';

function check_login_form() {
	jQuery(".m_validations_showhide").hide();				
	jQuery('.f-signin-form-msg').hide().html('');
	
	var username = jQuery("#s_username").val();
	var password = jQuery("#s_password").val();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(username=="") {
		jQuery("#username_error_msg").show().text('<?=_lang('email_field_validation_text','login_form')?>');
		return false;
	} else if(!username.match(mailformat)) {
		jQuery("#username_error_msg").show().text('<?=_lang('valid_email_field_validation_text','login_form')?>');
		return false;
	} else if(password=="") {
		jQuery("#password_error_msg").show().text('<?=_lang('password_field_validation_text','login_form')?>');
		return false;
	} else if(login_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','login_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$('.login_f_verifycode_form_btn').click(function() {
			var login_verification_code = $("#login_f_verification_code").val();
			if(login_verification_code=='') {
				$(".login-f-verifycode-form").addClass('was-validated');
				return false;
			}
			
			$("#resend_login_f_verifycode_p_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#resend_login_f_verifycode_p_spining_icon").show();
			
			$.ajax({
				type: 'POST',
				url: SITE_URL+'ajax/verify_login_account.php',
				data: $('.login-f-verifycode-form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.status == "invalid" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						} else if(resp_data.status == "success" && resp_data.msg != "") {
							window.location.href = resp_data.redirect_url;
						}
					}
					$("#resend_login_f_verifycode_p_spining_icon").html('');
					$("#resend_login_f_verifycode_p_spining_icon").hide();
				}
			});
			return false;
		});
		
		$('.resend_login_f_verifycode_btn').click(function() {
			$("#resend_login_f_verifycode_p_spining_icon").html('<?=$full_spining_icon_html?>');
			$("#resend_login_f_verifycode_p_spining_icon").show();

			$.ajax({
				type: 'POST',
				url: SITE_URL+'ajax/verify_login_account.php?is_resend_verify=1',
				data: $('.login-f-verifycode-form').serialize(),
				success: function(data) {
					if(data!="") {
						var resp_data = JSON.parse(data);
						if(resp_data.status == "invalid" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						} else if(resp_data.status == "success" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						} else if(resp_data.status == "resend" && resp_data.msg != "") {
							$('.login-f-verifycode-form-msg').html(resp_data.msg);
							$('.login-f-verifycode-form-msg').show();
						}
					}
					$("#resend_login_f_verifycode_p_spining_icon").html('');
					$("#resend_login_f_verifycode_p_spining_icon").hide();
				}
			});
			return false;
		});
		
		$("#login_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_login_form();
		});
		$(".signin_form_sbmt_btn").click(function() {
			var ok = check_login_form();
			if(ok == false) {
				return false;
			} else {
				$("#signin_f_spining_icon").html('<?=$full_spining_icon_html?>');
				$("#signin_f_spining_icon").show();

				$.ajax({
					type: 'POST',
					url: SITE_URL+'ajax/login.php',
					data: $('#login_form').serialize(),
					success: function(data) {
						if(data!="") {
							var resp_data = JSON.parse(data);
							if(resp_data.status == "invalid" && resp_data.msg != "") {
								$('.signin-f-form-msg').html(resp_data.msg);
								$('.signin-f-form-msg').show();
								
								$('#s_username').val('');
								$('#s_password').val('');

								if(g_c_login_f_wdt_id == '0' || g_c_login_f_wdt_id > 0) {
									grecaptcha.reset(g_c_login_f_wdt_id);
								}
							} else if(resp_data.status == "success" && resp_data.msg != "") {
								window.location.href = resp_data.redirect_url;
							} else if(resp_data.status == "resend" && resp_data.msg != "") {
								$('#login_form').hide();
								$('.link-forgot-pass').hide();
								$('.login-f-verifycode-form').show();
								$('#login_f_verifycode_user_id').val(resp_data.user_id);
							}
							$("#signin_f_spining_icon").html('');
							$("#signin_f_spining_icon").hide();
						}
					}
				});	
			}
		});
	});
})(jQuery);
</script>