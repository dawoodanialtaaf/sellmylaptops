<?php
//For slider section
$home_slider_data = get_home_page_data('','slider');
if(!empty($home_slider_data)) {
   	$section_sub_title = str_replace("<p><br></p>","",$home_slider_data['sub_title']);
   	$section_intro_text = str_replace("<p><br></p>","",$home_slider_data['intro_text']);
   	$section_description = str_replace("<p><br></p>","",$home_slider_data['description']);
   	$section_color = $home_slider_data['section_color'];
	$section_background_type = $home_slider_data['background_type'];

	$section_bg_imagevideo_path = '';
	$section_bg_styles = ''; 	
	$section_bg_video = '';	
	$section_image = $home_slider_data['section_image'];  
	$section_image_ext = pathinfo($section_image,PATHINFO_EXTENSION);

	if($section_color && $section_background_type == "color") {
		$section_bg_styles .= "background-color:#".$section_color.";";
	}
	if($section_image && $section_background_type == "image") {
		$section_bg_imagevideo_path = SITE_URL."media/images/home_section/".$section_image;
		if($section_image && $section_image_ext=="png" || $section_image_ext=="jpg" || $section_image_ext=="jpeg" || $section_image_ext=="gif") {
			$section_bg_styles .= "background:url('$section_bg_imagevideo_path') no-repeat 0 0;background-size: cover;";	
		} elseif($section_image) {
			$section_bg_video = '<video class="background-video" autoplay="" loop=""  muted="" playsinline="" data-wf-ignore="true" controls><source src="'.$section_bg_imagevideo_path.'" data-wf-ignore="true"></video>';
		}
	}
	
	if($section_bg_styles) {
		$section_bg_styles = 'style="'.$section_bg_styles.'"';
	}

	$text_color=$home_slider_data['text_color'];
	
	$text_color_style = '';
	if($text_color != '') {
		$text_color_style = 'style="color:#'.$text_color.' !important;"';
	}
	
	$is_show_search_box = $home_slider_data['is_show_search_box'];
	
   	$items_data_array = json_decode($home_slider_data['items'],true);
   	if(!empty($items_data_array)) {
   		array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
		include('home/slider.php');
   }
}

//For others section
$home_page_settings_list = get_home_page_data();
foreach($home_page_settings_list as $home_page_settings_data) {
	$section_title = $home_page_settings_data['title'];
	$section_show_title = $home_page_settings_data['show_title'];
	$section_sub_title = str_replace("<p><br></p>","",$home_page_settings_data['sub_title']);
	$section_show_sub_title = $home_page_settings_data['show_sub_title'];
	$section_intro_text = str_replace("<p><br></p>","",$home_page_settings_data['intro_text']);
	$section_show_intro_text = $home_page_settings_data['show_intro_text'];
	$section_description = str_replace("<p><br></p>","",$home_page_settings_data['description']);
	$section_show_description = $home_page_settings_data['show_description'];
	$section_color = $home_page_settings_data['section_color'];
	$section_background_type = $home_page_settings_data['background_type'];

	$section_bg_imagevideo_path = '';
	$section_bg_styles = '';
	$section_bg_video = '';
	$section_image = $home_page_settings_data['section_image'];
	$section_image_ext = pathinfo($section_image,PATHINFO_EXTENSION);
	
	if($section_color && $section_background_type == "color") {
		$section_bg_styles .= "background-color:#".$section_color.";";
	}
	if($section_image && $section_background_type == "image") {
		$section_bg_imagevideo_path = SITE_URL."media/images/home_section/".$section_image;
		if($section_image && $section_image_ext=="png" || $section_image_ext=="jpg" || $section_image_ext=="jpeg" || $section_image_ext=="gif") {
			$section_bg_styles .= "background:url('$section_bg_imagevideo_path') no-repeat 0 0;background-size: cover;";
		} elseif($section_image) {
			$section_bg_video = '<video class="review_background-video" autoplay="" loop=""  muted="" playsinline="" data-wf-ignore="true" controls><source src="'.$section_bg_imagevideo_path.'" data-wf-ignore="true"></video>';
		}
	}

	if($section_bg_styles) {
		$section_bg_styles = 'style="'.$section_bg_styles.'"';
	}
	
	$number_of_item_show = 0;
	$number_of_item_show = $home_page_settings_data['number_of_item_show'];
	
	$display_popular_model_series_only = 0;
	$display_popular_model_series_only = $home_page_settings_data['display_popular_model_series_only'];
	
	$is_show_search_box = $home_page_settings_data['is_show_search_box'];
	
	$heading_text_color=$home_page_settings_data['heading_text_color'];
	$text_color=$home_page_settings_data['text_color'];
	
	$heading_text_color_style = '';
	if($heading_text_color != '') {
		$heading_text_color_style = 'style="color:#'.$heading_text_color.' !important;"';
	}
	
	$text_color_style = '';
	if($text_color != '') {
		$text_color_style = 'style="color:#'.$text_color.' !important;"';
	}
	
	$section_css_class = $home_page_settings_data['section_css_class'];
	
	if($home_page_settings_data['section_name'] == "how_it_works") {
		$how_it_works_page_data = get_inbuild_page_data('how_it_works');
		$items_data_array = json_decode($how_it_works_page_data['data']['items'],true);
		
		$f_items_data_array = array();
		foreach($items_data_array as $p_items_data) {
			if($p_items_data['display_in_page_section'] == '1') {
				$f_items_data_array[] = $p_items_data;
			}
		}

		if(!empty($f_items_data_array) || ($section_description && $section_show_description == '1')) {
			include('home/how_it_works.php');
		}
	}
	elseif($home_page_settings_data['section_name'] == "top_model_series") {
		//Get data from admin/_config/functions.php, get_model_series_data_list function
		$model_series_data_list = get_model_series_data_list('',$display_popular_model_series_only);
		if(!empty($model_series_data_list)) {
			include('home/top_model_series.php');
		}
	}
	elseif($home_page_settings_data['section_name'] == "categories") {
		//Get data from admin/_config/functions.php, get_category_data_list function
		$category_data_list = get_category_data_list();
		if(!empty($category_data_list)) {
			include('home/categories.php');
		}
	}
	elseif($home_page_settings_data['section_name'] == "model_series") {
	   //Get data from admin/_config/functions.php, get_model_series_data_list function
	   $model_series_data_list = get_model_series_data_list('',$display_popular_model_series_only);
	   if(!empty($model_series_data_list)) {
	   		$num_of_device = count($model_series_data_list);
			include('home/model_series.php');
		}
	}
	elseif($home_page_settings_data['section_name'] == "brands") {
		//Get data from admin/_config/functions.php, get_brand_data function
		$brand_data_list = get_brand_data();
		if(!empty($brand_data_list)) {
			include('home/brands.php');
		} //END for brand section
	}
	elseif($home_page_settings_data['section_name'] == "why_choose_us") {
		$why_choose_us_page_data = get_inbuild_page_data('why_choose_us');
		$items_data_array = json_decode($why_choose_us_page_data['data']['items'],true);
		
		$f_items_data_array = array();

		if(!empty($items_data_array)) {
			foreach($items_data_array as $p_items_data) {
				if($p_items_data['display_in_page_section'] == '1') {
					$f_items_data_array[] = $p_items_data;
				}
			}
		}
		
		if(!empty($f_items_data_array) || ($section_description && $section_show_description == '1')) {
			include('home/why_choose_us.php');
		}
	}
	elseif($home_page_settings_data['section_name'] == "get_a_quote") {
		$quick_s_category_list = quick_search_category_list()['category_list'];
		include('home/get_a_quote.php');
	}
	elseif($home_page_settings_data['section_name'] == "newsletter") {
		if($newslettter_section == '1') {
			include('home/newsletter.php');
		}
	}
	elseif($home_page_settings_data['section_name'] == "reviews") {
		$review_list_data = get_review_list_data(1,0,true); 
		if(!empty($review_list_data)) {
			include('home/reviews.php');
		}
	} elseif($home_page_settings_data['section_name'] == "call_to_action") {
		include('home/call_to_action.php');
	} elseif($home_page_settings_data['section_name'] == "ready_to_start") {
		include('home/ready_to_start.php');
	} elseif($home_page_settings_data['section_name'] == "faqs") {
		$faqs_list_data = get_faqs_list($limit = 0, $is_show_in_home_page = 1, $is_rand = 0);
		if(!empty($faqs_list_data)) {
			include('home/faqs.php');
		}
	} elseif($home_page_settings_data['section_name'] == "shipping_options") {
		if(!empty(array_filter($shipping_option))) {
			include('home/shipping_options.php');
		}
	} elseif($home_page_settings_data['section_name'] == "payment_options") {
		if(!empty(array_filter($choosed_payment_option))) {
			include('home/payment_options.php');
		}
	} else {
		include('home/custom.php');
	}
} ?>
