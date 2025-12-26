<?php
$csrf_token = generateFormToken('review');

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
	<div id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="heading page-heading faq-heading text-center pt-5">
				<h1 class=""><?=$page_title?></h1>
			</div>
		</div>
	</div>
<?php
}

$contact_us_heading_text = _lang('contact_us_heading_text','review_form');
$rating_star_field_heading_text = _lang('rating_star_field_heading_text','review_form'); ?>

<section class="<?=$active_page_data['css_page_class']?> review_detail_form">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">
				<div class="block mx-0 px-0 mt-0">
					<form method="post" id="review_form" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="name" id="name" placeholder="<?=_lang('name_field_placeholder_text','review_form')?>">
								<div id="name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','review_form')?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="state" id="state" placeholder="<?=_lang('state_field_placeholder_text','review_form')?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<input type="text" class="form-control" name="city" id="city" placeholder="<?=_lang('city_field_placeholder_text','review_form')?>">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<?php
								/*if($rating_star_field_heading_text) {
									echo '<label for="rating">'.$rating_star_field_heading_text.'</label>';
								}*/ ?>
								<select name="rating" id="rating" class="form-control">
									<option value=""><?=_lang('rating_star_default_option_text','review_form')?></option>
									<?php
									for($si = 5; $si >= 1; $si--) { ?>
										<option value="<?=$si?>" <?php if($si == '5'){echo 'selected="selected"';}?>><?=$si?></option>
									<?php
									} ?>
								</select>
								<div id="rating_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
							</div>
						</div>
						
						<div class="col-sm-6">
							<?php /*?><label for="rating">&nbsp;</label><?php */?> 
							<div class="form-group">
								<input type="text" class="form-control" name="title" id="title" placeholder="<?=_lang('title_field_placeholder_text','review_form')?>">
							</div>
						</div>
					
						<div class="col-sm-12">
							<div class="form-group mb0">
								<textarea class="form-control" name="content" id="content" placeholder="<?=_lang('content_field_placeholder_text','review_form')?>"></textarea>
								<div id="content_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
							</div>
						</div>
						
						<?php
						if($write_review_form_captcha == '1') { ?>
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
							<button type="submit" class="btn btn-primary review_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="review_form_spining_icon"></span></button>
							<input type="hidden" name="submit_form" id="submit_form" />
						</div>
					</div>
					<input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
                    <input type="hidden" name="controller" value="review_form">
					</form>
				</div>
			</div>
			
			<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 sidebar">
				<div class="sectionbox mt-2">
					<?=$active_page_data['content']?>
					<div class="address_box">
						<?=($contact_us_heading_text?'<h5>'.$contact_us_heading_text.'</h5>':'')?>
						<div class="inner">
							<p class="location">
								<?php
								if($company_name) {
									echo '<strong>'.$company_name.'</strong>';
								}
								if($company_address) {
									echo '<br />'.$company_address;
								}
								if($company_city) {
									echo '<br />'.$company_city.' '.$company_state.' '.$company_zipcode;
								}
								if($company_country) {
									echo '<br />'.$company_country;
								} ?>
							</p>
							<?php
							if($site_phone) {
								echo '<p class="phone"><strong>'._lang('phone_label_text','review_form').'</strong><a href="tel:'.$site_phone.'"> '.$site_phone.'</a></p>'; 
							}
							if($site_email) {
								echo '<p class="email"><strong>'._lang('email_label_text','review_form').'</strong><a href="mailto:'.$site_email.'"> '.$site_email.'</a></p>';
							} ?>
						</div>  
					</div>
				</div>
			</div>
			
		</div>
	</div>
</section>

<?php
if($write_review_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>

<script>
<?php
if($write_review_form_captcha == '1') { ?>
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
		check_review_form();
	}
};
<?php
} ?>

function changefile(obj) {
	var str  = obj.value;
	$(".upload_filename").html(str);
}

var write_review_form_captcha = '<?=$write_review_form_captcha?>';

function check_review_form() {
	jQuery(".m_validations_showhide").hide();				

	var name = jQuery("#name").val();
	name = name.trim();
	var rating = jQuery("#rating").val();
	rating = rating.trim();
	var content = jQuery("#content").val();
	content = content.trim();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(name=="") {
		jQuery("#name_error_msg").show().text('<?=_lang('name_field_validation_text','review_form')?>');
		return false;
	} else if(rating=="") {
		jQuery("#rating_error_msg").show().text('<?=_lang('rating_star_field_validation_text','review_form')?>');
		return false;
	} else if(content=="") {
		jQuery("#content_error_msg").show().text('<?=_lang('content_field_validation_text','review_form')?>');
		return false;
	} else if(write_review_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','review_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#review_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_review_form();
		});
		$(".review_form_sbmt_btn").click(function() {
			var ok = check_review_form();
			if(ok == false) {
				return false;
			} else {
				$("#review_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#review_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#review_form").submit();
			}
		});
	});
})(jQuery);
</script>