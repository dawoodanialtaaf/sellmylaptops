<?php
//If already loggedin and try to access lost password page, it will redirect to account
if($user_id>0) {
	setRedirect(SITE_URL.'account');
	exit();
}

$csrf_token = generateFormToken('lost_password');

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
} ?>

<form method="post" id="lost_psw_form" role="form">
  <section class="user_form_section py-5">
	<div class="container">   
	  <div class="row justify-content-center"> 
		<div class="col-md-8 col-sm-12 col-lg-6 col-xl-6"> 
		  <div class="card-body ufs_inner">  
		  	<div class="head user-area-head text-center">
				<?=($is_show_title && $show_title == '1'?'<h1 class="h2"><strong>'.$page_title.'</strong></h1>':'')?>
				<?=($active_page_data['content']?'<p>'.$active_page_data['content'].'</p>':'')?>
		  	</div>
			<div class="form-horizontal form-login" role="form">
			  <div class="form-wrap clearfix">  
				<div class="form-group">
				    <label for="email"><?=_lang('email_field_label_text','lost_password_form')?></label>
					<input type="text" class="form-control" id="email" name="email" autocomplete="off" placeholder="<?=_lang('email_field_placeholder_text','lost_password_form')?>">
					<div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display: none;"></div>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary btn-lg lost_psw_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="lost_psw_form_spining_icon"></span></button>
					<input type="hidden" name="reset" id="reset" />
					<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
				</div>
			  </div>
			  <div class="form-group text-center mb-0"> 
				  <a href="<?=$login_link?>"><?=_lang('return_to_login_button_text','lost_password_form')?></a> 
			  </div>
			</div>
		  </div>
		</div>
	  </div>  
	</div>
  </section>
  <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
  <input type="hidden" name="controller" value="user/lost_password">
</form>

<script>
function check_lost_psw_form() {
	jQuery(".m_validations_showhide").hide();				

	var email = jQuery("#email").val();
	email = email.trim();

	if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','lost_password_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','lost_password_form')?>');
		return false;
	}
}

(function( $ ) {
	$(function() {
		$("#lost_psw_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_lost_psw_form();
		});
		$(".lost_psw_form_sbmt_btn").click(function() {
			var ok = check_lost_psw_form();
			if(ok == false) {
				return false;
			} else {
				$("#lost_psw_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#lost_psw_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#lost_psw_form").submit();
			}
		});
	});
})(jQuery);
</script>