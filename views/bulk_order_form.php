<?php
$csrf_token = generateFormToken('bulk_order');

$bonus_data_list = get_bonus_data_list();
$upto_percentage = (!empty($bonus_data_list[0]['percentage'])?$bonus_data_list[0]['percentage']:'');

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
<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background: url('.SITE_URL.'media/images/pages/'.$header_image.')no-repeat; background-size:cover; width: 100%;"';}?>> 
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
            <h1><?=$page_title?></h1>
         </div>
      </div>
   </div>
</section>
<?php
} ?>

<section class="py-5">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="order-details cart clearfix">
               <table class="table table-borderless bulk-table parent mb-0">
                  <tr>
                     <td class="image bulk_order_form_section"><img src="<?=SITE_URL?>media/images/device_bulk.png" alt="bulk device"></td>
                     <td class="description" align="center">
                        <form class="quantity-form form-inline"> 
                           <label for="qty"><?=$active_page_data['content']?></label>
                        </form>
						<button class="btn btn-primary btn-lg get-paid"><?=_lang('get_quote_button_text')?></button>
                     </td>
                     <td class="price">&nbsp;</td>
                     <td class="action">
                     </td>
                  </tr>
               </table>
               <div class="clearfix text-center d-block d-md-none">
                  <button class="btn btn-primary btn-lg get-paid mt-3"><?=_lang('get_paid_button_text')?></button>
               </div>
            </div>
         </div>
      </div>
      <?php /*?><div class="row">
         <div class="col-md-7">
            <div class="block heading page-heading wholesalers_customers">
               <h3>For wholesalers and regular customers</h3>
            </div>
            <div class="block mt-0 pt-0 page-content">
               <p>Valued customers.</p>
               <p>We are appriciate our bussiness with every our customer. We are doing our work honest. We try to be the best company in the industry of used cell phones. Our offers for used electronics is best on the market and we have for you more!</p>
               <p>If you are wholesaller or regular customer we'll pay you more. Please, check out our bonus system that works fully automated and will allow you to get up to <?=$upto_percentage?>% bonus for your orders.</p>
               <p>Thank you four your bussines!</p>

            </div>
         </div>

          <div class="col-md-5">
          	<div class="bonus_parsantage">
	            <table class="table table-stripped table-percentage">
	                <tr>
	                   <th>Bonus</th>
	                   <th>Paid devices</th>
	                </tr>
	                <?php
	                   if(!empty($bonus_data_list)) {
	                   foreach($bonus_data_list as $bonus_data) { ?>
	                <tr>
	                   <td><?=$bonus_data['percentage']?> %</td>
	                   <td><?=$bonus_data['paid_device']?></td>
	                </tr>
	                <?php
	                   }
	                    } ?>
	            </table>
	        </div>    
          </div>
      </div><?php */?>

       <?php /*?><div class="row pt-4 pb-4">
           <div class="col-md-6 bonus-up">
           	  <h4>Up your <strong>bonus to</strong> <br /><span><?=$upto_percentage?>%</span></h4>
           </div>
          <div class="col-md-6">
            <div class=" bonus_detail">
             	<p>We are appriciate our bussiness with every our customer. We are doing our work honest. We try to be the best company in the industry of used cell phones. Our offers for used electronics is best on the market and we have for you more!</p>
            </div> 	
          </div>
       </div><?php */?>
   </div>
</section>
<div class="modal fade" id="bulkOrderForm" tabindex="-1" role="dialog" aria-labelledby="bulk_order_form" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title"><?=$page_title?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
            </button>
         </div>
         <div class="modal-body pt-3 text-center">
            <form method="post" class="sign-in" id="bulk_order_form">
               <div class="form-row">
                  <div class="form-group col-md-6 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="Name">
                     <input type="text" class="form-control" name="name" id="name" placeholder="<?=_lang('name_field_placeholder_text','bulk_order_form')?>" required>
					 <div id="name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>

                  <div class="form-group col-md-6 mt-0 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/people.png" alt="Company name">
                     <input type="text" class="form-control" name="company_name" id="company_name" placeholder="<?=_lang('company_name_field_placeholder_text','bulk_order_form')?>">
					 <div id="company_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>

                  <div class="form-group mt-0 col-md-6 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="Email">
                     <input type="email" class="form-control" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','bulk_order_form')?>" required>
					 <div id="email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>
				  <div class="form-group mt-0 col-md-6 with-icon">
                   <img src="<?=SITE_URL?>media/images/icons/phone_dial.png" alt="Phone">
                     <input class="form-control" type="tel" id="cell_phone" name="cell_phone">
					 <input type="hidden" name="phone" id="phone" />
					 <div id="cell_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>
               </div>

                <div class="form-row">
                  <div class="form-group col-md-6 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/home.png" alt="City">
                     <input type="text" class="form-control" name="city" id="city" placeholder="<?=_lang('city_field_placeholder_text','bulk_order_form')?>" required>
					 <div id="city_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>
                  <div class="form-group mt-0 col-md-6 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/envelop.png" alt="Zip code">
                     <input type="text" class="form-control" name="zip_code" id="zip_code" placeholder="<?=_lang('zip_code_field_placeholder_text','bulk_order_form')?>" required>
					 <div id="zip_code_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>
               </div>

               <div class="form-row">
                  <div class="form-group mt-0 col-md-6 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/state.png" alt="State">
                     <input type="text" class="form-control" name="state" id="state" placeholder="<?=_lang('state_field_placeholder_text','bulk_order_form')?>" required>
					 <div id="state_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>

                   <div class="form-group mt-0 col-md-6 with-icon">
                     <img src="<?=SITE_URL?>media/images/icons/quantity.png" alt="quantity" width="20px">
                     <input class="form-control" placeholder="<?=_lang('qty_field_placeholder_text','bulk_order_form')?>" type="text" name="quantity" id="quantity" onkeyup="this.value=this.value.replace(/[^\d]/,'');" maxlength="5">
					 <div id="quantity_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>
               </div>
              
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <textarea class="form-control" name="content" id="content" placeholder="<?=_lang('message_field_placeholder_text','bulk_order_form')?>" required></textarea>
					 <div id="content_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                  </div>
               </div>

               <?php
               if($bulk_order_form_captcha == '1') { ?>
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
                  <button type="submit" class="btn btn-primary btn-lg ml-lg-3 bulk_order_form_sbmt_btn"><?=_lang('submit_button_text')?> <span id="bulk_order_form_spining_icon"></span></button>
                  <input type="hidden" name="submit_form" id="submit_form" />		
               </div>
               <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
               <input type="hidden" name="controller" value="bulk_order_form">
            </form>
         </div>
      </div>
   </div>
</div>

<?php
if($bulk_order_form_captcha == '1') {
	echo '<script src="https://www.google.com/recaptcha/api.js?onload=CaptchaCallback&render=explicit"></script>';
} ?>
<script>
<?php
if($bulk_order_form_captcha == '1') { ?>
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
	jQuery("#g_captcha_token").val('yes');
	check_bulk_order_form();
}
};
<?php
} ?>

var bulk_order_form_captcha = '<?=$bulk_order_form_captcha?>';

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

function check_bulk_order_form() {
	jQuery(".m_validations_showhide").hide();				

	var name = jQuery("#name").val();
	name = name.trim();
	var company_name = jQuery("#company_name").val();
	company_name = company_name.trim();
	var email = jQuery("#email").val();
	email = email.trim();
	var cell_phone = jQuery("#cell_phone").val();
	var city = jQuery("#city").val();
	city = city.trim();
	var zip_code = jQuery("#zip_code").val();
	zip_code = zip_code.trim();
	var state = jQuery("#state").val();
	state = state.trim();
	var quantity = jQuery("#quantity").val();
	quantity = quantity.trim();
	var content = jQuery("#content").val();
	content = content.trim();
	var captcha_token = jQuery("#g_captcha_token").val();

	if(name=="") {
		jQuery("#name_error_msg").show().text('<?=_lang('name_field_validation_text','bulk_order_form')?>');
		return false;
	} else if(email=="") {
		jQuery("#email_error_msg").show().text('<?=_lang('email_field_validation_text','bulk_order_form')?>');
		return false;
	} else if(!email.match(mailformat)) {
		jQuery("#email_error_msg").show().text('<?=_lang('valid_email_field_validation_text','bulk_order_form')?>');
		return false;
	}
	
	if(cell_phone=="") {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','bulk_order_form')?>');
		return false;
	}

	jQuery("#phone").val(iti_ipt.getNumber());
	if(!iti_ipt.isValidNumber()) {
		jQuery("#cell_phone_error_msg").show().text('<?=_lang('valid_phone_field_validation_text','bulk_order_form')?>');
		return false;
	}

	if(city=="") {
		jQuery("#city_error_msg").show().text('<?=_lang('city_field_validation_text','bulk_order_form')?>');
		return false;
	} else if(zip_code=="") {
		jQuery("#zip_code_error_msg").show().text('<?=_lang('zip_code_field_validation_text','bulk_order_form')?>');
		return false;
	} else if(state=="") {
		jQuery("#state_error_msg").show().text('<?=_lang('state_field_validation_text','bulk_order_form')?>');
		return false;
	} else if(content=="") {
		jQuery("#content_error_msg").show().text('<?=_lang('message_field_validation_text','bulk_order_form')?>');
		return false;
	} else if(bulk_order_form_captcha == '1' && captcha_token == "") {
		jQuery("#captcha_error_msg").show().text('<?=_lang('captcha_field_validation_text','bulk_order_form')?>');
		return false;
	}
}

(function ($) {
	$(function () {
		$('.get-paid').click(function() {
			/*var qty = $("#qty").val();
			if(qty=='') {
				alert('Please enter QTY');
				$("#qty").focus();
				return false;
			}*/
			/*if(qty=='' || qty<10 || qty>50) {
				alert('Min QTY is 10 and max is 50');
				$("#qty").focus();
				return false;
			}*/
			//$("#quantity").val(qty);
			$("#bulkOrderForm").modal();
		});

		$("#bulk_order_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_bulk_order_form();
		});
		$(".bulk_order_form_sbmt_btn").click(function() {
			var ok = check_bulk_order_form();
			if(ok == false) {
				return false;
			} else {
				$("#bulk_order_form_spining_icon").html('<?=$spining_icon_html?>');
				$("#bulk_order_form_spining_icon").show();
				$(this).attr("disabled", "disabled");
				$("#bulk_order_form").submit();
			}
		});
	});
})(jQuery);
</script>