<script>
<?php
if($ask_for_email_address_while_item_add_to_cart=='1' && $start_your_order_with == "phone") { ?>
var iti_ipt_pwc;
jQuery(document).ready(function($) {
	var telInput_pwc = document.querySelector("#phone_while_add_to_cart");
	iti_ipt_pwc = window.intlTelInput(telInput_pwc, {
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
	iti_ipt_pwc.setNumber("<?=(!empty($phone_while_add_to_cart_c_code)?$phone_while_add_to_cart_c_code.$phone_while_add_to_cart:'')?>");
});
<?php
} ?>

function check_imei_number_form() {
	jQuery(".m_validations_showhide").hide();
	var imei_number = document.getElementById("imei_number").value.trim();
	if(imei_number=="") {
		jQuery("#imei_number_error_msg").show().text('<?=_lang('imei_number_field_validation_text','model_details')?>');
		return false;
	}
}

<?php
if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
function check_email_while_add_to_cart_form() {
	jQuery(".m_validations_showhide").hide();
	<?php
	if($start_your_order_with == "email") { ?>
		var email_while_add_to_cart = document.getElementById("email_while_add_to_cart").value.trim();
		if(email_while_add_to_cart=="") {
			jQuery("#email_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_email_address_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		} else if(!email_while_add_to_cart.match(mailformat)) {
			jQuery("#email_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_valid_email_address_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}
	<?php
	} else { ?>
		if(document.getElementById("phone_while_add_to_cart").value.trim()=="") {
			jQuery("#phone_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_phone_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}

		jQuery("#phone_while_add_to_cart_c_code").val(iti_ipt_pwc.getSelectedCountryData().dialCode);
		if(!iti_ipt_pwc.isValidNumber()) {
			jQuery("#phone_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_valid_phone_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}
	<?php
	} ?>
}
<?php
} ?>

var tooltips_of_model_fields = '<?=$tooltips_of_model_fields?>';
var tooltips_of_model_field_options = '<?=$tooltips_of_model_field_options?>';
var ask_for_email_address_while_item_add_to_cart = '<?=$ask_for_email_address_while_item_add_to_cart?>';
var fade_in_out_time=1000;
var fields_list_data=[];

function show_first_welcome_message(){
	setTimeout(function(){
		var _div=jQuery("#first_welcome");
		_div.show();
		var spinner_div=_div.find("div#spinner");
		spinner_div.show();
		var _msg_div=_div.find("div#msg_div");
		spinner_div.fadeOut( fade_in_out_time, function(){
			_msg_div.show();
			show_second_wlecome_message();
		});
	},500)
}

function show_second_wlecome_message(){
	var _div=jQuery("#second_welcome");
	_div.show();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	var _msg_div=_div.find("div#msg_div");
	spinner_div.fadeOut( fade_in_out_time, function(){
		_msg_div.show();
		show_device_category_list_div();
	});
}

function show_device_category_list_div(){
	var _div=jQuery("#device_category_list_div");
	_div.fadeIn();
}

function show_brand_question_div(){
	var _div=jQuery("#brand_question_div");
	_div.fadeIn();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	
	var selected_device_category_name=jQuery("input[name=device_category_id]:checked").attr("data-value");
	
	var _msg_div=_div.find("div#msg_div");
	_msg_div.hide();
	_msg_div.html('<?=_lang('brand_heading_text','instant_sell_model_chat_page')?> '+ selected_device_category_name);
	spinner_div.fadeOut(fade_in_out_time, function(){
		_msg_div.show();
	});
}

function show_brand_list_div(){
	jQuery.scrollTo(jQuery('#brand_question_div'), {
		hash: false,
		offset: -150,
		duration: '500',
		onAfter: function() { 
			var _div=jQuery("#brand_list_div");
			_div.fadeIn();
		}
	});
}

function hide_brand_list_div(){
	var _div=jQuery("#brand_list_div");
	_div.hide();
	jQuery("#brand_list_data").html("");
}


function show_model_list_div(){
	jQuery.scrollTo(jQuery('#model_question_div'), {
		hash: false,
		offset: -100,
		duration: '500',
		onAfter: function() {
			var _div=jQuery("#model_list_div");
			_div.fadeIn();
		}
	});
}

function hide_modal_list_div(){
	var _div=jQuery("#model_list_div");
	_div.hide();
	jQuery("#model_list_data").html("");
	
	clear_model_fields_html();
	
	var _div=jQuery("#model_question_div");
	_div.hide();
}

function clear_model_fields_html(){
	jQuery("#model_dfields").html("");
	fields_list_data=[];
	
	jQuery("#show_final_amt").html('');
	jQuery("#final_offer_div").html('').hide();
}

function show_model_question_div(type) {
	var _div=jQuery("#model_question_div");
	_div.fadeIn();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	
	if(type == "cat") {
		var selected_brand_id_name=jQuery("input[name=device_category_id]:checked").attr("data-value");
	} else if(type == "brand") {
		var selected_brand_id_name=jQuery("input[name=brand_id]:checked").attr("data-value");
	} else {
		var selected_brand_id_name=jQuery("input[name=model_series_id]:checked").attr("data-value");
	}
	
	var _msg_div=_div.find("div#msg_div");
	_msg_div.hide();
	_msg_div.html('<?=_lang('model_heading_text','instant_sell_model_chat_page')?> '+ selected_brand_id_name);
	spinner_div.fadeOut( fade_in_out_time, function(){
		_msg_div.show();
	});
}

function show_model_series_question_div(type){
	var _div=jQuery("#model_series_question_div");
	_div.fadeIn();
	var spinner_div=_div.find("div#spinner");
	spinner_div.show();
	
	if(type == "cat") {
		var selected_brand_id_name=jQuery("input[name=device_category_id]:checked").attr("data-value");
	} else {
		var selected_brand_id_name=jQuery("input[name=brand_id]:checked").attr("data-value");
	}
	
	var _msg_div=_div.find("div#msg_div");
	_msg_div.hide();
	_msg_div.html('<?=_lang('device_heading_text','instant_sell_model_chat_page')?> '+ selected_brand_id_name);
	spinner_div.fadeOut( fade_in_out_time, function(){
		_msg_div.show();
	});
}

function show_model_series_list_div(){
	jQuery.scrollTo(jQuery('#model_series_question_div'), {
		hash: false,
		offset: -100,
		duration: '500',
		onAfter: function() {
			var _div=jQuery("#model_series_list_div");
			_div.fadeIn();
		}
	});
}

function hide_model_series_list_div(){
	var _div=jQuery("#model_series_list_div");
	_div.hide();
	jQuery("#device_list_data").html("");
	var _div=jQuery("#model_series_question_div");
	_div.hide();
}

function create_model_fields(){
	var show_first_model_question_index="null";
	var $nn="0";
	if(fields_list_data && fields_list_data.length>0){
		var total_field_count=fields_list_data.length;
		console.log(total_field_count,fields_list_data);
		var first_field_id = '';
		fields_list_data.forEach(function(item,i){
			$nn = Number($nn)+1;
			
			var field_id=item['id'];
			
			if($nn == '1') {
				first_field_id = field_id;
			}
			
			if(show_first_model_question_index=='null'){
				show_first_model_question_index=i;
			}
			
			var $last_next_button = "";
			if(total_field_count == $nn) {
				$last_next_button = "yes";
			}
			
			var qdiv_id='model_question_div_'+i;
			var field_name=item['field_name'];
			var question_title=item['title'];
			var field_tooltip=item['tooltip'];
			
			var input_type=item['input_type'];
			var is_required=item['is_required'];
			var product_options_list=item['product_options_list'];
			var selected_checkbox_values=item['selected_checkbox_values'];
			var selected_radio_dropdown_value=item['selected_radio_dropdown_value'];
			var type=item['type'];
			
			var exclude_fields = '['+item['exclude_fields']+']';
			
			var _new_field_name=field_name+':'+field_id;

			var field_tooltip_html = '';
			if(field_tooltip && tooltips_of_model_fields == '1') {
				field_tooltip_html = '&nbsp;<span class="tooltip-icon field-tooltips" data-id="'+field_id+'"><i class="fa fa-info-circle"></i></span>';
			}
			
			var adiv_id='model_ans_div_'+i;
			var ans_div='<div id="'+adiv_id+'" style="display:none" class="model_fields model_fields_ans model-details-panel fld-'+field_id+'" f_c_id="fld-'+field_id+'" data-field_id="'+field_id+'" data-input_type="'+input_type+'" data-required="'+is_required+'" data-row_type="'+input_type+'" data-field_id="'+field_id+'" data-exclude_fields="'+exclude_fields+'">';
				
				ans_div+='<div id="'+qdiv_id+'" class="model_fields model_fields_q question-fld-'+field_id+'">';
					ans_div+='<div class="row">';
						ans_div+='<div class="col-md-12">';
							ans_div+='<div class="clearfix">';
								ans_div+='<div class="question assistant d-flex float-left">';
									ans_div+='<div class="image text-center">';
									ans_div+='<img class="assistant" src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">';
									ans_div+='<p><small><?=SITE_NAME?></small></p>';
									ans_div+='</div>';
									ans_div+='<div class="loading" id="spinner" style="display:none"></div>';
									ans_div+='<div id="msg_div" style="display:none">';
										ans_div+='<span>'+question_title+''+field_tooltip_html+'</span>';
									ans_div+='</div>';
								ans_div+='</div>';
							ans_div+='</div>';
						ans_div+='</div>';
					ans_div+='</div>';
				ans_div+="</div>";
				
				ans_div+='<div class="row">';
					ans_div+='<div class="col-md-12">';
					ans_div+='<div class="question client float-right">';
						ans_div+='<div id="m_ans_div" class="modern-block__content block-content-base">';
							
							if(input_type=="select" || input_type=="radio" || input_type=="checkbox"){
								if(product_options_list && product_options_list.length>0){
									product_options_list.forEach(function(option_item,io){
										
										var product_opt_id=option_item['id'];
										var label=option_item['label'];
										var add_sub=option_item['add_sub'];
										var checked=option_item['checked'];
										var icon=option_item['icon'];
										var is_default=option_item['is_default'];
										var price=option_item['price'];
										var price_type=option_item['price_type'];
										var tooltip=option_item['tooltip'];
										
										var tooltip_html = '';
										if(tooltip && tooltips_of_model_field_options == '1') {
											tooltip_html = '&nbsp;<span class="tooltip-icon condition-tooltips" data-id="'+product_opt_id+'"><i class="fa fa-info-circle"></i></span>';
										}

										var _new_field_value=label+':'+product_opt_id;

										ans_div+='<span class="options_values">';
											if(input_type=="select" || input_type=="radio") {
												if(type == "condition") {
													ans_div+='<button data-issubmit="'+$last_next_button+'" class="btn btn-sm capacity-row model_radio_select_btn radio_select_con_buttons" data-opt_id="'+product_opt_id+'" type="button" data-input_type="'+input_type+'" data-current_i="'+i+'" data-opt_id="'+product_opt_id+'" data-field_id="'+field_id+'">'+label+'</button>';
													ans_div+=' <input class="radioele" name="'+_new_field_name+'" value="'+_new_field_value+'" type="radio" style="display:none;" data-price="'+price+'" data-add_sub="'+add_sub+'" data-price_type="'+price_type+'" data-default="'+is_default+'" data-issubmit="'+$last_next_button+'" data-input_type="'+input_type+'" data-current_i="'+i+'" id="'+label+'" data-opt_id="'+product_opt_id+'" data-field_id="'+field_id+'"';
													/*if (checked){
														ans_div += ' checked="checked"';
													}*/
													ans_div += '/>';
												} else {
													ans_div+='<button data-issubmit="'+$last_next_button+'" class="btn btn-sm capacity-row model_radio_select_btn" type="button" data-input_type="'+input_type+'" data-current_i="'+i+'" data-opt_id="'+product_opt_id+'" data-field_id="'+field_id+'">'+label+''+tooltip_html+'</button>';
													ans_div+=' <input class="radioele" name="'+_new_field_name+'" value="'+_new_field_value+'" type="radio" style="display:none;" data-price="'+price+'" data-add_sub="'+add_sub+'" data-price_type="'+price_type+'" data-default="'+is_default+'" data-issubmit="'+$last_next_button+'" data-input_type="'+input_type+'" data-current_i="'+i+'" id="'+label+'" data-opt_id="'+product_opt_id+'" data-field_id="'+field_id+'"';
													/*if (checked){
														ans_div += ' checked="checked"';
													}*/
													ans_div += '/>';
												}
											} else {
												ans_div+='<div class="custom-control custom-radio custom-control-inline checkbox checkbox-success"><input class="checkboxele custom-control-input" name="'+_new_field_name+'[]" id="'+label+'" value="'+_new_field_value+'" type="checkbox" data-price="'+price+'" data-add_sub="'+add_sub+'" data-price_type="'+price_type+'" data-default="'+is_default+'" data-field_id="'+field_id+'" data-current_i="'+i+'"/>';
													ans_div+='<label class="custom-control-label btn" for="'+label+'"> ';
												/*if ( checked ) {
													ans_div += ' checked="checked"';
												}*/

												ans_div += label+' '+tooltip_html+'</label>';	
												ans_div+='</div>';
											}
										ans_div+='</span>';
			
									});
									
									if(input_type=="checkbox"){
										ans_div+='<div class="clearfix">';
										ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+$last_next_button+'" data-current_i="'+i+'">Next &nbsp;<i class="fa fa-forward"></i></a>';
										ans_div+='<span class="text-danger error_part"></span>';
										ans_div+='</div>';
									}
								}
							}
							else if(input_type=="text"){
								ans_div+='<input name="'+_new_field_name+'" class="form-control input" type="text"/>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+$last_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i></a>';
							}
							else if(input_type=="textarea"){
								ans_div+='<textarea name="'+_new_field_name+'" class="form-control textarea input"></textarea>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+$last_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i></a>';
							}
							else if(input_type=="datepicker"){
								ans_div+='<input name="'+_new_field_name+'" class="form-control input datepicker" id="datepicker" type="text" autocomplete="off" readonly=""/>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+$last_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i></a>';
							}
							else if(input_type=="file"){
								ans_div+='<span></span><div class="clearfix fileupload"><input name="'+_new_field_name+'" class="form-control input" type="file" class="input" onChange="changefile(this)"/><div class="filenamebox">No file choosen</div></div>';
								ans_div+='<a href="javascript:void(0);" class="capacity-row model_next_btn float-right mr-0" data-issubmit="'+$last_next_button+'" data-current_i="'+i+'"><i class="fa fa-forward"></i></a>';
							}
							
							if(type == "condition") {
								if(product_options_list && product_options_list.length>0) {
									product_options_list.forEach(function(option_item,io) {
										var product_opt_id=option_item['id'];
										var tooltip=option_item['tooltip'];
										
										ans_div+='<div class="condition-block model-condation-section condition_tooltips condition-tooltip-block-'+product_opt_id+'" style="display:none;">';
											ans_div+=tooltip;
										ans_div+='</div>';
									});
								}
							}
		
						ans_div+='</div>';
						ans_div+='</div>';
					ans_div+='</div>';
				ans_div+='</div>';
				ans_div+='</div>';
			ans_div+="</div>";

			jQuery("#model_dfields").append(ans_div);
		
		});
	}
			
	if(show_first_model_question_index!='null'){
		show_model_question_ans_field("fld-"+first_field_id);
	}
	
	jQuery(".datepicker").datepicker();
}

function show_model_question_ans_field(field_id,force_fully="0"){
	var _div=jQuery("."+field_id);
	
	if(_div.length == 0) {
	}
	else{
		_div.show();
		if(force_fully=="0"){
			var spinner_div=_div.find("div#spinner");
			spinner_div.show();
			var _msg_div=_div.find("div#msg_div");
			
			jQuery.scrollTo(_div, {
				hash: false,
				offset: -100,
				duration: '500',
				onAfter: function() {
					console.log('reached');
				}
			});
			
			spinner_div.fadeOut( fade_in_out_time, function(){
				_msg_div.show();
				setTimeout(function() {
					var adiv_id='model_ans_div_'+field_id;
					var _div=jQuery("#"+adiv_id);
					_div.show();
				}, 500);
			});
		}
		else{
			jQuery.scrollTo(_div, {
				hash: false,
            	offset: -100,
				duration: '500',
				onAfter: function() {
					console.log('reached');
				}
			});
		}
	}
}

function changefile(obj){
	var str  = obj.value;
	jQuery(obj).next().html(str);
}

function create_final_offer_div(cback=""){
	var selected_device_category_name=jQuery("input[name=device_category_id]:checked").attr("data-value");
	var check_imei=jQuery("input[name=device_category_id]:checked").attr("data-check_imei");
	
	var selected_brand_id_name=jQuery("input[name=brand_id]:checked").attr("data-value");
	var brand_list=jQuery("input[name=device_category_id]:checked").attr("data-brand_list");
	if(brand_list == '1') {
	var selected_brand_id_name=jQuery("input[name=device_category_id]:checked").attr("data-cat_brand_title");
	}
	
	var selected_model_series_id_name=jQuery("input[name=model_series_id]:checked").attr("data-value");
	
	var selected_device_model_name=jQuery("input[name=model_id]:checked").attr("data-value");
	var selected_dropdown_device_model_name=jQuery(".dropdown_device_model_id").find(':selected').data("value");
	if(selected_dropdown_device_model_name) {
		selected_device_model_name = selected_dropdown_device_model_name;
	}

	var show_final_amt_val=''; //jQuery("#show_final_amt_val").val();
	
	var selected_device_model_image=jQuery("input[name=model_id]:checked").attr("data-model_image");
	var selected_dropdown_device_model_image=jQuery(".dropdown_device_model_id").find(':selected').data("model_image");
	if(selected_dropdown_device_model_image) {
		selected_device_model_image = selected_dropdown_device_model_image;
	}
	
	if(ask_for_email_address_while_item_add_to_cart == '1' && check_imei == '1') {
		jQuery(".check_imei_showhide").show();
		jQuery(".email_while_add_to_cart_showhide").hide();
		jQuery(".imei_number_check_btn").html('<?=_addslashes(_lang('next_button_text'))?>');
	} else if(ask_for_email_address_while_item_add_to_cart == '1') {
		jQuery(".check_imei_showhide").hide();
		jQuery(".email_while_add_to_cart_showhide").show();
	} else if(check_imei == '1') {
		jQuery(".check_imei_showhide").show();
		jQuery(".email_while_add_to_cart_showhide").hide();
	}

	var selected_fields_data_list=[];
	
	if(fields_list_data && fields_list_data.length>0){
		var total_field_count=fields_list_data.length;
		fields_list_data.forEach(function(item,i){
			
			var field_id=item['id'];
			var field_name=item['field_name'];
			var field_title=item['title'];
			var input_type=item['input_type'];
			var field_label_name=item['field_label_name'];
			var _new_field_name=field_name+':'+field_id;
			
			var field_value="";
			var is_valid_to_add=true;
			var this_field_value_array=[];
			if(input_type=="text" || input_type=="textarea" || input_type=="datepicker"){
				var this_field_value=jQuery('[name="'+_new_field_name+'"]').val();
				if(this_field_value && this_field_value!=''){
					this_field_value_array=this_field_value.split(':');
				}
				field_value=this_field_value_array['0'];
			} else if(input_type=="select" || input_type=="radio"){
				var this_field_value=jQuery('input[name="'+_new_field_name+'"]:checked').val();
				if(this_field_value && this_field_value!=''){
					this_field_value_array=this_field_value.split(':');
				}
				field_value=this_field_value_array['0'];
			} else if(input_type=="checkbox"){
				var checkbox_values=[];
				jQuery('input[name="'+_new_field_name+'[]"]:checked').each(function(){
					var this_field_value=this.value;
					if(this_field_value && this_field_value!=''){
						this_field_value_array=this_field_value.split(':');
					}
					checkbox_values.push(this_field_value_array['0']);
				});
				field_value=checkbox_values.join(", ");
			} else {
				is_valid_to_add=false;
			}

			if(is_valid_to_add && typeof field_value !== 'undefined' && typeof field_value !== 'null') {
				selected_fields_data_list.push({'field_name':field_title,'field_label_name':field_label_name,'field_value':field_value,'current_field_index':i});
			}
		});
	}
	
	var offer_html='<div class="row">';
			offer_html+='<div class="col-md-12">';
				offer_html+='<div class="clearfix">';
					offer_html+='<div class="question assistant final float-left">';
						offer_html+='<div class="top d-flex">';	
							offer_html+='<div class="image text-center">';	
								offer_html+='<img class="assistant" src="<?=SITE_URL?>media/images/assistantForQuestion-small.svg" alt="">';
								offer_html+='<p class="pl-2"><small><?=SITE_NAME?></small></p>';
							offer_html+='</div>';
							offer_html+='<div class="description">';
								offer_html+='<h4><?=_lang('offer_section_heading_text','instant_sell_model_chat_page')?></h4>';
							offer_html+='</div>';
						offer_html+='</div>';
						offer_html+='<div id="msg_div">';
								offer_html+='<div class="row">';
										offer_html+='<div class="col-md-3">';
											if(selected_device_model_image!=''){
												offer_html+='<div class="image">';
													offer_html+='<img class="assistant" src="'+selected_device_model_image+'" alt="">';
												offer_html+='</div>';
											}
												offer_html+='<div>';
												offer_html+='';
												offer_html+='</div>';
										offer_html+='</div>';
										offer_html+='<div class="col-md-9">';
											offer_html+='<div class="row">';
											
												offer_html+='<div class="col-md-6">';
													offer_html+='<p><strong><?=_lang('offer_section_brand_title','instant_sell_model_chat_page')?></strong> ';
														offer_html+='&nbsp;'+selected_brand_id_name;
														offer_html+='<button type="button" class="btn btn-link" onClick=\'show_brand_list_div()\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
													offer_html+='</p>';
												offer_html+='</div>';
												
												if(selected_model_series_id_name!=null && selected_model_series_id_name!='' && selected_model_series_id_name!='null'){
													offer_html+='<div class="col-md-6">';
														offer_html+='<p><strong><?=_lang('offer_section_device_title','instant_sell_model_chat_page')?></strong> ';
															offer_html+='&nbsp;'+selected_model_series_id_name;
															offer_html+='<button type="button" class="btn btn-link" onClick=\'show_model_series_list_div()\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
														offer_html+='</p>';
													offer_html+='</div>';
												}
												
												offer_html+='<div class="col-md-6">';
													offer_html+='<p><strong><?=_lang('offer_section_model_title','instant_sell_model_chat_page')?></strong> ';
														offer_html+='&nbsp;'+selected_device_model_name;
														offer_html+='<button type="button" class="btn btn-link" onClick=\'show_model_list_div()\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
													offer_html+='</p>';
												offer_html+='</div>';
												if(selected_fields_data_list && selected_fields_data_list.length>0){
													selected_fields_data_list.forEach(function(data,i){
														offer_html+='<div class="col-md-6">';
															offer_html+='<p><strong>'+data['field_label_name']+':</strong> ';
															offer_html+='&nbsp;'+data['field_value'];
															offer_html+='<button type="button" class="btn btn-link" onClick=\'show_model_question_ans_field("'+data['current_field_index']+'","1")\'><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
														offer_html+='</p>';
														offer_html+='</div>';
													});
												}
												offer_html+='<div class="col-md-12 total-device-value">';
													offer_html+='<h3><?=_lang('device_value_text','model_details')?></h3><strong class="show_final_amt"><span id="show_final_amt">'+show_final_amt_val+'</span></strong>';	
												offer_html+='</div>';		
											offer_html+='</div>';												
										offer_html+='</div>'; 

								offer_html+='</div>';

								offer_html+='<div class="row">';  
									offer_html+='<div class="col-md-12 main_center_section">';
										if(ask_for_email_address_while_item_add_to_cart == '1' || check_imei == '1') {
                                       		offer_html+='<button type="button" class="btn btn-lg device_sell mb-3 btn-primary show-price-popup"><?=_addslashes(_lang('sell_now_button_text'))?> </button>&nbsp;';
										} else {
											offer_html+='<button type="submit" class="btn btn-lg device_sell mb-3 btn-primary"><?=_addslashes(_lang('sell_now_button_text'))?> </button>&nbsp;';
										}
									offer_html+='</div>';
								offer_html+='</div>';
								
								<?php	
								if(($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') || $quote_post_to_whatsapp_button == '1') { ?>
								offer_html+='<div class="row">';  
									offer_html+='<div class="col-md-12 main_center_section">';
										<?php	
										if($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') { ?>
										offer_html+='<p class="social-btn-group"><button type="button" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" id="post_to_fb_messenger"><img src="<?=SITE_URL?>media/images/messanger.png" class="img-fluid social-mnedia" alt="messanger" /> <?=_addslashes(_lang('post_quote_to_facebook_messenger_button_text','model_details'))?> <span class="post_to_fb_messenger_spining_icon"></span></button>';
										<?php
										}
										if($quote_post_to_whatsapp_button == '1') { ?>
										offer_html+='<button type="button" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" id="post_to_whatsapp"><img src="<?=SITE_URL?>media/images/whatsapp.png" class="img-fluid social-mnedia" alt="whatsapp" /> <?=_addslashes(_lang('post_quote_to_whatsapp_button_text','model_details'))?> <span class="post_to_whatsapp_spining_icon"></span></button></p>';
										<?php
										} ?>
									offer_html+='</div>';
								offer_html+='</div>';
								<?php
								} ?>
								
								 <?php /*?>offer_html+='<p><span><?=_lang('offer_section_heading_text','instant_sell_model_chat_page')?></span> <?=$amount_sign_with_prefix?><span id="show_final_amt">'+show_final_amt_val+'</span><?=$amount_sign_with_postfix?></p>';
								
								 offer_html+='<div class="col-md-12 text-right">';
								 	offer_html+='<button type="submit" class="btn btn-primary step5next"><?=_addslashes(_lang('sell_now_button_text'))?></button>';
								 offer_html+='</div>';<?php */?>
							
						offer_html+='</div>';
					offer_html+='</div>';
				offer_html+='</div>';
			offer_html+='</div>';
	offer_html+='</div>';
	
	jQuery("#final_offer_div").html(offer_html);
	if(cback!='' && typeof cback === "function"){
		cback();
	}
}	

function final_show_model_details(){
	var cback=function(){
		/*jQuery("#final_offer_div").fadeIn(300);
		jQuery.scrollTo(jQuery("#final_offer_div"), {
			hash: false,
			duration: '1000',
			onAfter: function() {
				console.log(jQuery("#final_offer_div"));
			}
		});*/
	};
	
	create_final_offer_div(cback);
	jQuery("#final_offer_div").fadeIn(300);
	jQuery.scrollTo(jQuery("#final_offer_div"), {
		hash: false,
		offset: -100,
		duration: '1000',
		onAfter: function() {
			console.log(jQuery("#final_offer_div"));
		}
	});
}

function get_price() {
	jQuery.ajax({
		type: 'POST',
		url: '<?=SITE_URL?>ajax/get_model_price.php',
		data: jQuery('#sell_my_device_form').serialize(),
		success: function(data) {
			if(data!="") {
				var resp_data = JSON.parse(data);
				var total_price = resp_data.payment_amt;

				var total_price_html = resp_data.payment_amt_html;
				jQuery("#show_final_amt").html(total_price_html);
				//jQuery("#show_final_amt_val").val(total_price);
				//jQuery("#payment_amt").val(total_price);
			}
		}
	});
}

function field_next_step(is_next_step,field_id) {
	var next_step = jQuery(".fld-"+field_id+":visible").next(".model-details-panel");
	var next_id = jQuery(next_step).attr("f_c_id");
	//console.log('testtest:'+field_id+':'+next_id);
	
	var last_step = jQuery(".model-details-panel").last(".model-details-panel");
	var last_id = jQuery(last_step).attr("f_c_id");

	var nextall_step = jQuery(".fld-"+field_id+":visible").nextAll(".model-details-panel");
	console.log('Next All Step Length: ',nextall_step.length);

	var selected_field_ids_arr = [];

	jQuery(".checkboxele, .radio_select_con_buttons, .model_radio_select_btn").each(function () {
		if(jQuery(this).next().is(':checked')) {
			var prevall_val = jQuery(this).next().val();
			if(prevall_val) {
				var spl_prevall_val = prevall_val.split(':');
				var prevall_f_val = spl_prevall_val[1];
				selected_field_ids_arr[prevall_f_val] = prevall_f_val;
			}
		}
	});
	console.log('Selected Option Ids: ',selected_field_ids_arr);

	var allow_fields_id_arr = [];
	
	var is_exclude_fields = false;
	for(nl_s = 0; nl_s < nextall_step.length; nl_s++) {
		var nextall_id = jQuery(nextall_step[nl_s]).attr("f_c_id");
		var nextall_exclude_fields = jQuery(nextall_step[nl_s]).attr("data-exclude_fields");
		console.log('Next All Id: ',nextall_id);
		console.log('Next All Exclude Fields: ',nextall_exclude_fields);
		
		jQuery('.'+nextall_id+' .model_radio_select_btn').each(function() {
		    this.checked = false;
	    });
   		
		jQuery('.'+nextall_id+' .radio_select_con_buttons').each(function() {
		    this.checked = false;
	    });
		
		jQuery('.'+nextall_id+' .checkboxele').each(function() {
		    this.checked = false;
	    });
		
		jQuery("."+nextall_id).hide();
		jQuery("#final_offer_div").hide();
		
		var is_exclude_field = false;
		if(nextall_exclude_fields!="" && typeof nextall_exclude_fields !== 'undefined') {
			var nextall_exclude_fields = JSON.parse(nextall_exclude_fields);
			for(nl_ef = 0; nl_ef < nextall_exclude_fields.length; nl_ef++) {
				var exclude_fields_id = nextall_exclude_fields[nl_ef];
				if(selected_field_ids_arr[exclude_fields_id]) {
					console.log("Exist...");
					is_exclude_field = true;
				}
			}
			is_exclude_fields = true;
		}

		if(!is_exclude_field) {
			allow_fields_id_arr.push(nextall_id);
		}
	}
	
	console.log('Allow Next Fields Length: ',allow_fields_id_arr.length);
	console.log('Is Exclude Fields: ',is_exclude_fields);
	if(allow_fields_id_arr.length > 0) {
		console.log('Allow Fields Id: ',allow_fields_id_arr);
		next_id = allow_fields_id_arr[0];
	}

	console.log('next_id: ',next_id);
	console.log('last_id: ',last_id);
	if(allow_fields_id_arr.length > 0) {
	//jQuery('#nextBtn').show();
	//jQuery('#addToCart').hide();
	} else {
	//jQuery('#nextBtn').hide();
	//jQuery('#addToCart').show();
	final_show_model_details();
	}
	
	/*if(show_instant_price_on_model_criteria_selections == '1') {
		jQuery('.show_device_value_section').hide();
		//jQuery(".device_value_style").css("margin-top", "-50px");
	}*/
	
	if(nextall_step.length == 1 && allow_fields_id_arr.length > 0) {
		if(is_next_step == '1') {
			//jQuery(".model-details-panel").hide();
			show_model_question_ans_field(next_id);
			jQuery("."+next_id).show();
			jQuery("."+next_id).addClass("model-details-panel-back");
			//jQuery('#nextBtn').hide();
			//jQuery('#addToCart').show();
			//final_show_model_details();
			/*if(show_instant_price_on_model_criteria_selections == '1') {
				jQuery('.show_device_value_section').show();
			}*/
		}
	} else if((nextall_step.length > 0 && allow_fields_id_arr.length > 0) || (nextall_step.length > 0 && !is_exclude_fields)) {
		if(is_next_step == '1') {
			//jQuery(".model-details-panel").hide();
			show_model_question_ans_field(next_id);
			jQuery("."+next_id).show();
			jQuery("."+next_id).addClass("model-details-panel-back");
			//jQuery('#nextBtn').show();
		}
	} else {
		if(is_next_step == '1') {
			//jQuery('#addToCart').show();
			//final_show_model_details();
			/*if(show_instant_price_on_model_criteria_selections == '1') {
				jQuery('.show_device_value_section').show();
			}*/
			//jQuery('#nextBtn').hide();
		}
	}

	var current_step = jQuery(".fld-"+field_id+":visible");
	var current_id = jQuery(current_step).attr("f_c_id");
	console.log('current_id: ',current_id);
	
	if(current_id == last_id) {
		final_show_model_details();
		//jQuery('#addToCart').show();
		/*if(show_instant_price_on_model_criteria_selections == '1') {
			jQuery('.show_device_value_section').show();
		}*/
		//jQuery('#nextBtn').hide();
	}
	
	/*if(show_instant_price_on_model_criteria_selections == '1') {
		jQuery('.show_device_value_section').show();
		//jQuery(".device_value_style").css("margin-top", "-50px");
	}*/
	
	if(next_id == 'get-offer') {
		//jQuery('.step-navigation').hide();
		/*if(show_instant_price_on_model_criteria_selections == '1') {
			jQuery('.show_device_value_section').hide();
		}*/
	}

	//jQuery("#prevBtn").show();
	//jQuery(".device-name-dt").show();
}

(function( $ ) {
	jQuery(function() {

		jQuery(document).on('click', '.device_category_id', function() {
			hide_brand_list_div();
			hide_model_series_list_div();
			hide_modal_list_div();
			//show_brand_question_div();
			jQuery("#brand_question_div").hide();
			
			var brand_list=jQuery(this).attr("data-brand_list");
			var device_list=jQuery(this).attr("data-device_list");
			
			var ajax_method="model_list";
			if(brand_list>1) {
				ajax_method="brand_list";
				show_brand_question_div();
			} else if(device_list>1) {
				ajax_method="device_list";
				show_model_series_question_div('cat');
			} else {
				show_model_question_div('cat');
			}
			
			var device_category_id = jQuery(this).val();
		    post_data = "device_category_id="+device_category_id+"&token=<?=get_unique_id_on_load()?>&m="+ajax_method;
			jQuery(document).ready(function($){
				$.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/instant_sell_model/get_devices_dt_list.php",
					data:post_data,
					success:function(data) {
						if(brand_list>1) {
							jQuery("#brand_list_div").hide();
							jQuery("#brand_list_data").html(data);
							show_brand_list_div();
						} else if(device_list>1) {
							jQuery("#model_series_list_div").hide();
							jQuery("#device_list_data").html(data);
							show_model_series_list_div();
						} else {
							jQuery("#model_list_div").hide();
							jQuery("#model_list_data").html(data);
							show_model_list_div();
						}
					}
				});
			});
		});
		
		jQuery(document).on('click', '.brand_id', function() {
			
			hide_modal_list_div();
			hide_model_series_list_div();

			
			var device_list=jQuery(this).attr("data-device_list");
			var ajax_method="model_list";
			if(device_list>1){
				ajax_method="device_list";
				show_model_series_question_div('brand');
			} else {
				show_model_question_div('brand');
			}

			var brand_id = jQuery(this).val();
			var device_category_id=jQuery("input[name=device_category_id]:checked").val();
		    post_data = "brand_id="+brand_id+"&device_category_id="+device_category_id+"&token=<?=get_unique_id_on_load()?>&m="+ajax_method;
			jQuery(document).ready(function($){
				$.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/instant_sell_model/get_devices_dt_list.php",
					data:post_data,
					success:function(data) {
						if(device_list>1) {
							jQuery("#model_series_list_div").hide();
							jQuery("#device_list_data").html(data);
							show_model_series_list_div();
						} else {
							jQuery("#model_list_div").hide();
							jQuery("#model_list_data").html(data);
							show_model_list_div();
						}
					}
				});
			});
		});
		
		jQuery(document).on('click', '.model_series_id', function() {
			var ajax_method="model_list";
			
			hide_modal_list_div();
			show_model_question_div('model_series');
		
			var model_series_id = jQuery(this).val();
			var brand_id = jQuery("input[name=brand_id]:checked").val();
			var device_category_id=jQuery("input[name=device_category_id]:checked").val();
		    post_data = "brand_id="+brand_id+"&model_series_id="+model_series_id+"&device_category_id="+device_category_id+"&token=<?=get_unique_id_on_load()?>&m="+ajax_method;
			jQuery(document).ready(function($){
				$.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/instant_sell_model/get_devices_dt_list.php",
					data:post_data,
					success:function(data) {
						jQuery("#model_list_div").hide();
						jQuery("#model_list_data").html(data);
						show_model_list_div();
					}
				});
			});
		});
		
		jQuery(document).on('click', '.device_model_id', function() {
			clear_model_fields_html();
			var model_id = jQuery(this).val();
			
			post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>&m=get_model_field_list";
			jQuery(document).ready(function($){
				$.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/instant_sell_model/get_devices_dt_list.php",
					data:post_data,
					success:function(result) {
						if(result.status=="success"){
							var data=result.data;
							fields_list_data=data.fields_list_data;
							
							var price=data.price;
							var model_series_id=data.model_series_id;
						} else {
							fields_list_data=[];
						}
						create_model_fields();
					}
				});
			});
		});

		jQuery(document).on('change', '.dropdown_device_model_id', function() {
			clear_model_fields_html();
			var model_id = jQuery(this).val();

			post_data = "model_id="+model_id+"&token=<?=get_unique_id_on_load()?>&m=get_model_field_list";
			jQuery(document).ready(function($){
				$.ajax({
					type: "POST",
					url:"<?=SITE_URL?>ajax/instant_sell_model/get_devices_dt_list.php",
					data:post_data,
					success:function(result) {
						if(result.status=="success"){
							var data = result.data;
							fields_list_data = data.fields_list_data;
							if(fields_list_data && fields_list_data.length<=0) {
								setTimeout(function() {
									get_price();
								}, 500);
								final_show_model_details();
							}

							var price=data.price;
							var model_series_id=data.model_series_id;
						} else {
							fields_list_data=[];
						}
						create_model_fields();
					}
				});
			});
		});

		jQuery(document).on('click', '.model_next_btn', function() {
			var is_submit = jQuery(this).attr("data-issubmit");
			var data_input_type = jQuery(this).attr("data-input_type");
			var current_i= jQuery(this).attr("data-current_i");
			var next_show_i=Number(current_i)+1;
			
			var current_ans_row=jQuery("#model_ans_div_"+current_i);
			var crt_row_type = current_ans_row.attr("data-input_type");
            var is_required = current_ans_row.attr("data-required");
			
			if(is_required=="1"){
				if(jQuery(this).prev().hasClass("input")){
					if(jQuery(this).prev().val()==""){
						if(crt_row_type=="file"){
							jQuery(this).prev().prev().html("Please Choose File");
						}else{
							jQuery(this).prev().attr("placeholder","Please Enter Value");
						}
						return false;
					}
				}
				else if(crt_row_type=="radio" || crt_row_type=="select"){
					var cc = current_ans_row.find("input:checked").length;
					if(cc==0){
						jQuery(this).next().html("<br />Please choose an option");
						return false;
					}
					else{
						jQuery(this).next().html("");
					}
				}
				else if(crt_row_type=="checkbox"){
					var cc = current_ans_row.find("input:checked").length;
					if(cc==0){
						jQuery(this).next().html("<br />Please choose an option");
						return false;
					}
					else{
						jQuery(this).next().html("");
					}
				}
			}
			
			var field_id = jQuery(current_ans_row).attr("data-field_id");
			field_next_step(1,field_id);
			
			setTimeout(function() {
				get_price();
			}, 500);
			
			/*if(is_submit==""){
				show_model_question_ans_field(next_show_i);
				create_final_offer_div();
				
				setTimeout(function() {
					get_price();
				}, 500);
			}
			else if(is_submit=="yes"){
				final_show_model_details();
			}*/
		});

		jQuery(document).on('click', '.radio_select_con_buttons', function() {
			var opt_id = $(this).attr('data-opt_id');
			$('.condition_tooltips').hide();
			
			var condition_tooltip_text = $('.condition-tooltip-block-'+opt_id).html();
			if(condition_tooltip_text.trim()) {
				$('.condition-tooltip-block-'+opt_id).show();
			}
		});

		jQuery(document).on('click', '.model_radio_select_btn', function() {
			jQuery(this).parent().siblings().each(function(){
                jQuery(this).find(".capacity-row").removeClass("sel");
            });
            jQuery(this).next().click();
            jQuery(this).addClass("sel");
			/*var is_submit = jQuery(this).attr("data-issubmit");
			var data_input_type = jQuery(this).attr("data-input_type");
			var current_i= jQuery(this).attr("data-current_i");
			var next_show_i=Number(current_i)+1;
			if(is_submit==""){
				show_model_question_ans_field(next_show_i);
				create_final_offer_div();
			}
			else if(is_submit=="yes"){
				final_show_model_details();
			}*/

			var field_id = jQuery(this).attr("data-field_id");
			field_next_step(1,field_id);

			setTimeout(function() {
				get_price();
			}, 500);
		});
		
		show_first_welcome_message();
		
		jQuery(document).on('click', '.condition-tooltips', function() {
			var id = $(this).attr("data-id");
			$('#field_tooltip_model').modal('show');

			$("#field_tooltip_model_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin" style="font-size:34px;"></i></div></div>');
			$("#field_tooltip_model_spining_icon").show();

			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/get_condition_tooltip_content.php?id='+id,
				success: function(data) {
					if(data!="") {
						$('#field_tooltip_model_content').html(data);
					}
					$("#field_tooltip_model_spining_icon").html('');
					$("#field_tooltip_model_spining_icon").hide();
				}
			});
			return false;
		});
		
		jQuery(document).on('click', '.field-tooltips', function() {
			var id = $(this).attr("data-id");
			$('#field_tooltip_model').modal('show');

			$("#field_tooltip_model_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin" style="font-size:34px;"></i></div></div>');
			$("#field_tooltip_model_spining_icon").show();

			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/get_field_tooltip_content.php?id='+id,
				success: function(data) {
					if(data!="") {
						$('#field_tooltip_model_content').html(data);
					}
					$("#field_tooltip_model_spining_icon").html('');
					$("#field_tooltip_model_spining_icon").hide();
				}
			});
			return false;
		});

		$('#imei_number').on('change keyup paste', function() {
			if($('#imei_number').val().length > 15) {
				$('#imei_number').val($('#imei_number').val().substr(0,15));
			}
		});
		
		$('.imei_number_check_btn').on('click', function(e) {
			var ok = check_imei_number_form();
			if(ok == false) {
				return false;
			}
		
			var imei_number = $("#imei_number").val();
			$(".imei_number_spining_icon").html('<?=$spining_icon_html?>');
			$(".imei_number_spining_icon").show();
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/check_imei_number.php',
				data: {imei_number:imei_number},
				success: function(data) {
					$(".imei_number_spining_icon").html('');
					$(".imei_number_spining_icon").hide();
					var resp_data = JSON.parse(data);
					var success = resp_data.success;
					if(success) {
						$("#device_check_info").val(resp_data.html);
						if(ask_for_email_address_while_item_add_to_cart == '1') {
							$(".check_imei_showhide").hide();
							$(".email_while_add_to_cart_showhide").show();
						} else {
							$("#sell_my_device_form").submit();
						}
					} else {
						$("#imei_number_error_msg").show().text(resp_data.msg);
						return false;
					}
				}
			});
			return false;
		});
		
		$(".email_while_add_to_cart_popup").on('blur keyup change paste', 'input, select, textarea', function(event) {
			check_email_while_add_to_cart_form();
		});
		$('.email_while_add_to_cart_btn').on('click', function(e) {
			var ok = check_email_while_add_to_cart_form();
			if(ok == false) {
				return false;
			} else {
				$("#sell_my_device_form").submit();
			}
		});
		
		jQuery(document).on('click', '.show-price-popup', function() {
			$("#ModalPriceShow").modal();
		});
		
		<?php
		if($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') { ?>
		jQuery(document).on('click', '#post_to_fb_messenger', function() {
			$(".post_to_fb_messenger_spining_icon").html('<?=$spining_icon_html?>');
			$(".post_to_fb_messenger_spining_icon").show();
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/get_register_quote.php?type=fb_messenger',
				data: $('#sell_my_device_form').serialize(),
				success: function(data) {
					$(".post_to_fb_messenger_spining_icon").html('');
					$(".post_to_fb_messenger_spining_icon").hide();
					var resp_data = JSON.parse(data);
					var status = resp_data.status;
					var url = resp_data.url;
					if(status && url) {
						window.open(url, '_blank');
					} else {
						alert('<?=_lang('something_went_wrong_message_text')?>');
						return false;
					}
				}
			});
		});
		<?php
		}
		if($quote_post_to_whatsapp_button == '1') { ?>
		jQuery(document).on('click', '#post_to_whatsapp', function() {
			$(".post_to_whatsapp_spining_icon").html('<?=$spining_icon_html?>');
			$(".post_to_whatsapp_spining_icon").show();
			$.ajax({
				type: 'POST',
				url: '<?=SITE_URL?>ajax/get_register_quote.php?type=whatsapp',
				data: $('#sell_my_device_form').serialize(),
				success: function(data) {
					$(".post_to_whatsapp_spining_icon").html('');
					$(".post_to_whatsapp_spining_icon").hide();
					var resp_data = JSON.parse(data);
					var status = resp_data.status;
					var url = resp_data.url;
					if(status) {
						window.open(url, '_blank');
					} else {
						alert('<?=_lang('something_went_wrong_message_text')?>');
						return false;
					}
				}
			});
		});
		<?php
		} ?>
		
	});
})(jQuery);
</script>