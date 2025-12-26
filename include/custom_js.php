<script>
var mailformat = /[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{2,3}/;
var js_date_format="<?=$js_date_format?>";
var jscurrent_date = "<?=format_date(date('Y-m-d'),"m/d/Y")?>";
var login_form_captcha="<?=$login_form_captcha?>";
var signup_form_captcha="<?=$signup_form_captcha?>";
var contact_form_captcha="<?=$contact_form_captcha?>";
var show_house_number_field="<?=$show_house_number_field?>";

var g_c_login_wdt_id;
var g_c_signup_wdt_id;
var g_c_contact_wdt_id;

var validations_data = {"signup_form":{"email_field_validation_text":"<?=_lang('email_field_validation_text','signup_form')?>", "valid_email_field_validation_text":"<?=_lang('valid_email_field_validation_text','signup_form')?>", "valid_phone_field_validation_text":"<?=_lang('valid_phone_field_validation_text','signup_form')?>", "first_name_field_validation_text":"<?=_lang('first_name_field_validation_text','signup_form')?>", "last_name_field_validation_text":"<?=_lang('last_name_field_validation_text','signup_form')?>", "password_field_validation_text":"<?=_lang('password_field_validation_text','signup_form')?>", "terms_and_conditions_field_validation_text":"<?=_lang('terms_and_conditions_field_validation_text','signup_form')?>", "captcha_field_validation_text":"<?=_lang('captcha_field_validation_text','signup_form')?>", "is_review_order_page_with_cart_items":"<?=(!empty($is_review_order_page_with_cart_items)?$is_review_order_page_with_cart_items:'')?>", "verification_type":"<?=$verification_type?>", "enable_signup_first_name_field":"<?=$enable_signup_first_name_field?>", "enable_signup_last_name_field":"<?=$enable_signup_last_name_field?>", "enable_signup_address_fields":"<?=$enable_signup_address_fields?>", "hide_state_field":"<?=$hide_state_field?>", "enable_signup_phone_field":"<?=$enable_signup_phone_field?>", "address_field_validation_text":"<?=_lang('address_field_validation_text','signup_form')?>", "house_number_field_validation_text":"<?=_lang('house_number_field_validation_text','signup_form')?>", "address2_field_validation_text":"<?=_lang('address2_field_validation_text','signup_form')?>", "city_field_validation_text":"<?=_lang('city_field_validation_text','signup_form')?>", "postcode_field_validation_text":"<?=_lang('postcode_field_validation_text','signup_form')?>"},"contact_us_form":{"name_field_validation_text":"<?=_lang('name_field_validation_text','contact_us_form')?>", "valid_phone_field_validation_text":"<?=_lang('valid_phone_field_validation_text','contact_us_form')?>", "email_field_validation_text":"<?=_lang('email_field_validation_text','contact_us_form')?>", "valid_email_field_validation_text":"<?=_lang('valid_email_field_validation_text','contact_us_form')?>", "subject_field_validation_text":"<?=_lang('subject_field_validation_text','contact_us_form')?>", "message_field_validation_text":"<?=_lang('message_field_validation_text','contact_us_form')?>", "captcha_field_validation_text":"<?=_lang('captcha_field_validation_text','contact_us_form')?>"},"login_form":{"email_field_validation_text":"<?=_lang('email_field_validation_text','login_form')?>", "valid_email_field_validation_text":"<?=_lang('valid_email_field_validation_text','login_form')?>", "password_field_validation_text":"<?=_lang('password_field_validation_text','login_form')?>", "captcha_field_validation_text":"<?=_lang('captcha_field_validation_text','login_form')?>"}}

var SITE_URL="<?=SITE_URL?>";
var offer_popup_delay_time_in_ms="<?=$offer_popup_delay_time_in_ms?>";

var currency_symbol="<?=$currency_symbol?>";
var disp_currency="<?=$disp_currency?>";
var is_space_between_currency_symbol="<?=$is_space_between_currency_symbol?>";
var thousand_separator="<?=$thousand_separator?>";
var decimal_separator="<?=$decimal_separator?>";
var decimal_number="<?=$decimal_number?>";

function format_amount(amount) {
    var symbol_space="";
	if(is_space_between_currency_symbol == "1") {
		symbol_space=" "
	} else {
		symbol_space=""
	}

	if(disp_currency =="prefix") {
		return currency_symbol + symbol_space +amount;
	} else { 
	  return amount +symbol_space +currency_symbol;
	}
}

function formatMoney(n, c, d, t) {
	var c = isNaN(c = Math.abs(c)) ? decimal_number: c,
	d = d == undefined ?decimal_separator : d,
	t = t == undefined ? thousand_separator : t,
	s = n < 0 ? "-" : "",
	i = String(parseInt(n = Math.abs(Number(n)
 || 0).toFixed(c))),
	j = (j = i.length) > 3 ? j % 3 : 0;
	
	return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function removeLastComma(strng) {        
	var n=strng.lastIndexOf(",");
	var a=strng.substring(0,n);
	return a;
}
</script>
