<?php
function _lang($const = '', $page = 'general') {
	global $lang_patterns_arr, $lang_replacements_arr, $language_arr;

	$lang_arr = array();
	if(!empty($language_arr)) {
		$lang_arr = $language_arr;
	}

	//$page_const = '';
	if(!empty($lang_arr[$page][$const])) {
		$page_const = $lang_arr[$page][$const];
	} else {
		$default_lang_arr = _lang_list();
		$page_const = !empty($default_lang_arr[$page][$const])?$default_lang_arr[$page][$const]:"";
	}

	$return_lang_str = '';
	if(!empty($const) && !empty($page)) {
		$return_lang_str = str_replace($lang_patterns_arr, $lang_replacements_arr, $page_const);
	} elseif(!empty($const)) {
		foreach($lang_arr as $lang_arr_dt) {
			foreach($lang_arr_dt as $lang_sub_arr_k=>$lang_sub_arr_v) {
				if($lang_sub_arr_k == $const) {
					$return_lang_str = str_replace($lang_patterns_arr, $lang_replacements_arr, $lang_sub_arr_v);
				}
			}
		}
	} else {
		return $lang_arr;
	}

	if(preg_match('/<a href=/', $return_lang_str) || preg_match('/heading_text/', $const) || preg_match('/placeholder_text/', $const) || preg_match('/label_text/', $const) || preg_match('/link_text/', $const) || preg_match('/button_text/', $const) || preg_match('/place_holder_text/', $const) || preg_match('/title_text/', $const) || $page == 'form_action_message') {
		return $return_lang_str;
	} else {
		return addslashes($return_lang_str);
	}
}
?>