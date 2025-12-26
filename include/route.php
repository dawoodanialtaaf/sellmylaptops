<?php
if(!empty($post_data) || !empty($get_data['controller'])) {
	require_once("controllers/controllers.php");
} else {
	$model_series_id = 0;
	$model_series_id = 0;
	$brand_id = 0;
	$cat_id = 0;
	$category_id = 0;
	$model_type_source = "";
	$custom_schema = "";

	//START get url params
	$path_info = parse_path();
	
	$url_first_param = '';
	if(isset($path_info['call_parts'][0])) {
		$url_first_param = $path_info['call_parts'][0];
	}
	
	$url_second_param = '';
	if(isset($path_info['call_parts'][1])) {
		$url_second_param = $path_info['call_parts'][1];
	}
	
	$url_third_param = '';
	if(isset($path_info['call_parts'][2])) {
		$url_third_param = $path_info['call_parts'][2];
	}
	
	$url_four_param = '';
	if(isset($path_info['call_parts'][3])) {
		$url_four_param = $path_info['call_parts'][3];
	}
	$curr_full_url = SITE_URL.$url_first_param;
	//END get url params
	
	//START for get custom/inbuild page menu list
	$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.url AS menu_url, m.menu_name, m.css_body_class AS m_css_body_class FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND (p.url='".$url_first_param."' || p.url='".$curr_full_url."') ORDER BY p.id, m.id ASC");
	if($url_first_param=="") {
		$p_query=mysqli_query($db,"SELECT p.*, m.id AS menu_id, m.url AS menu_url, m.menu_name FROM pages AS p LEFT JOIN menus AS m ON m.page_id=p.id WHERE p.published='1' AND p.slug='home' ORDER BY p.id, m.id ASC");
	}
	
	$active_page_data=mysqli_fetch_assoc($p_query);

	
	
	if(isset($active_page_data['menu_id']) && $active_page_data['menu_id']<=0) {
		if($active_page_data['title']) {
			$active_page_data['menu_name'] = $active_page_data['title'];
		}
	}
	
	if(empty($active_page_data)) {
		$m_query=mysqli_query($db,"SELECT m.*, m.css_body_class AS m_css_body_class FROM menus AS m WHERE m.status='1' AND m.url='".$curr_full_url."'");
		$active_page_data=mysqli_fetch_assoc($m_query);
	}
	$page_body_class=(isset($active_page_data['css_body_class']) && $active_page_data['css_body_class']?$active_page_data['css_body_class']:@$active_page_data['m_css_body_class']);

	//Header image text for inner pages
	$head_graphics_css = '';
	$header_text_color = (!empty($active_page_data['header_text_color'])?$active_page_data['header_text_color']:'');
	if($header_text_color!='') {
		$head_graphics_css = '<style>#head-graphics h1, #head-graphics p, #head-graphics .image_text{color:#'.$header_text_color.' !important;}</style>';
	}

	$is_custom_or_inbuild_page = mysqli_num_rows($p_query);
	if($is_custom_or_inbuild_page>0) {
		$page_url = $active_page_data['url'];
		$meta_title = $active_page_data['meta_title'];
		$meta_desc = $active_page_data['meta_desc'];
		$meta_keywords = $active_page_data['meta_keywords'];
		$meta_canonical_url = $active_page_data['meta_canonical_url'];
		$custom_schema = $active_page_data['custom_schema'];
        $custom_schema_title = !empty($active_page_data['title'])?$active_page_data['title']:"";

		$blog_url = trim($url_second_param);
		if($blog_url) {
			$blg_q = mysqli_query($db,'SELECT * FROM blog_posts_seo WHERE postSlug = "'.$blog_url.'" AND postSlug!=""');
			$blog_s_data = mysqli_fetch_assoc($blg_q);
			$meta_title = !empty($blog_s_data['meta_title'])?$blog_s_data['meta_title']:"";
			$meta_desc = !empty($blog_s_data['meta_desc'])?$blog_s_data['meta_desc']:"";
			$meta_keywords = !empty($blog_s_data['meta_keywords'])?$blog_s_data['meta_keywords']:"";
			$meta_canonical_url = !empty($blog_s_data['meta_canonical_url'])?$blog_s_data['meta_canonical_url']:"";
			$custom_schema = !empty($blog_s_data['custom_schema'])?$blog_s_data['custom_schema']:"";
			$custom_schema_title = !empty($blog_s_data['postTitle'])?$blog_s_data['postTitle']:"";
		}

		$schema_patterns = array('{$page_title}');
        $schema_replacements = array($custom_schema_title);
        $custom_schema = str_replace($schema_patterns, $schema_replacements, $custom_schema);
		$custom_schema = str_replace($company_constants_patterns, $company_constants_replacements, $custom_schema);
		
		$inbuild_page_array = array('home', 'affiliates', 'contact', 'reviews', 'signup', 'login', 'terms-and-conditions', 'review-form', 'bulk-order-form', 'order-track','offers', 'instant-sell-model', 'sell', 'why_choose_us', 'how_it_works', 'faqs', 'lost_password');
		if(in_array($active_page_data['slug'],$inbuild_page_array)) {
			if($active_page_data['slug'] == "affiliates" && isset($_GET['shop']) && $_GET['shop']!="") {
				include 'views/widget_iframe.php';
			} else {
				include("include/header.php");
				include 'views/'.str_replace('-','_',$active_page_data['slug']).'.php';
			}
		} elseif($active_page_data['cat_id']) {
			$category_id = $active_page_data['cat_id'];
			if($category_id == "all") {
				include 'views/categories.php';
			} else {
				$brand_id = $active_page_data['brand_id'];
				if($brand_id > 0) {
					$cat_single_data_resp = get_cat_single_data_by_id($category_id);
					$model_series_id = "";

					
					include 'views/models.php';
				} else {
					include 'views/category_brands.php';
				}
			}
		} elseif($active_page_data['brand_id']) {
			$model_series_id = "";
			$brand_id = $active_page_data['brand_id'];
			if($brand_id == "all") {
				include 'views/brands.php';
			} else {
				$cat_data_list = get_brand_categories_data_list($brand_id);
				if(count($cat_data_list) <= 1) {

					var_dump("22");
					include 'views/models.php';
				} else {
					include 'views/brand_categories.php';
				}
			}
		} elseif($active_page_data['model_series_id']) {
			$model_series_id = $active_page_data['model_series_id'];
			if($model_series_id == "all") {
				include 'views/model_series.php';
			} else {

				var_dump("33");
				include 'views/models.php';
			}
		} elseif($active_page_data['slug']=="blog") {
			if($blog_url) {
				include("include/header.php");
				include 'views/blog/blog_view.php';
			} else {
				include("include/header.php");
				include 'views/blog/blog.php';
			}
		} else {
			include("include/header.php");
			include 'views/page.php';
		}
	} //END for get custom/inbuild page menu list
	else
	{
		$other_single_page_array = array('cart', 'enterdetails', 'reset-password', 'order-completion', 'profile', 'account', 'change-password', 'search', 'order_offer', 'widget-order-complete', 'brand', 'coupons', 'statistics', 'bonus-system', 'checkout');

		//START for model series, brands, categories, models, model details page...
		$device_single_data_resp = get_device_single_data($url_first_param);
		$cat_single_data_resp = get_cat_single_data_by_sef_url($url_first_param);
		$brand_single_data_resp = get_brand_single_data_by_sef_url($url_first_param);

		if(trim($folder_name)) {
			$server_data['REQUEST_URI'] = str_replace($folder_name, "", $server_data['REQUEST_URI']);
		}
		
		$model_sef_url = parse_url($server_data['REQUEST_URI'], PHP_URL_PATH);




		$model_sef_url = ltrim($model_sef_url, '/');
		$model_sef_url = str_replace($model_details_page_slug, "", $model_sef_url);
		$model_single_data_resp = get_model_single_data_by_url_id($model_sef_url, '');

		/*if(trim($model_details_page_slug)) {
		$model_single_data_resp = get_model_single_data_by_url_id($url_second_param, $url_third_param);
		} else {
		$model_single_data_resp = get_model_single_data_by_url_id($url_first_param, $url_second_param);
		}*/



		if($cat_single_data_resp['num_of_category']>0) {
			$category_id = $cat_single_data_resp['category_single_data']['id'];
			$brand_single_data_resp = get_brand_single_data_by_sef_url($url_second_param);
			if($brand_single_data_resp['num_of_brand']>0) {
				$brand_id=$brand_single_data_resp['brand_single_data']['id'];
	
				if($url_third_param == "other") {
					$model_series_id = "other";
				} else {
					$device_single_data_resp = get_device_single_data($url_third_param);
					$model_series_id = !empty($device_single_data_resp['device_single_data']['model_series_id'])?$device_single_data_resp['device_single_data']['model_series_id']:'';
				}

	
				// new condition start
				// salman
				if( $cat_single_data_resp['num_of_category']>0 && $brand_single_data_resp['num_of_brand']>0 && $url_third_param && $url_third_param != "other"){

					$model_single_data_resp = get_model_single_data_by_url_id($url_third_param, '');


					if($model_single_data_resp['num_of_model']>0) {
						$model_sef_url = $url_third_param;
						$model_sef_url = str_replace($model_details_page_slug, "", $model_sef_url);
						$model_single_data_resp = get_model_single_data_by_url_id($model_sef_url, '');
						include 'views/model_details.php';
					}else{
						setRedirect(SITE_URL);
						exit();
					}
				}else{
					include 'views/models.php';
				}
				// new condition end

			} else {
				include 'views/category_brands.php';
			}
		} elseif($brand_single_data_resp['num_of_brand']>0) {
			$brand_id = $brand_single_data_resp['brand_single_data']['id'];
			$cat_single_data_resp = get_cat_single_data_by_sef_url($url_second_param);
			if($cat_single_data_resp['num_of_category']>0) {
				$model_type_source = "brand";
				if($url_second_param == "other") {
					$model_series_id = "other";
				} else {
					$device_single_data_resp = get_device_single_data($url_second_param);
					$model_series_id = !empty($device_single_data_resp['device_single_data']['model_series_id'])?$device_single_data_resp['device_single_data']['model_series_id']:'';
				}

				var_dump("55");
				include 'views/models.php';
			} else {
				$device_single_data_resp = get_device_single_data($url_second_param);
				$model_series_id = !empty($device_single_data_resp['device_single_data']['model_series_id'])?$device_single_data_resp['device_single_data']['model_series_id']:'';
				if($brand_id > 0 && $model_series_id > 0) {

					var_dump("66");
					include 'views/models.php';
				} else {
					include 'views/brand_categories.php';
				}
			}
		} elseif($device_single_data_resp['num_of_device']>0 && $model_single_data_resp['num_of_model']<=0) {
			$device_single_data=$device_single_data_resp['device_single_data'];
			$model_series_id = $device_single_data['d_model_series_id'];

			var_dump("77");
			include 'views/models.php';

			
		} elseif($model_single_data_resp['num_of_model']>0) {

			var_dump($model_single_data_resp['num_of_model']);

			include 'views/model_details.php';
		} //END for model series, brands, categories, models, model details page...
	
		//START for other menu
		elseif(in_array($url_first_param,$other_single_page_array)) {
			include 'views/'.str_replace('-','_',$url_first_param).'.php';
		} elseif($url_first_param=="verify_account" && $url_second_param!='' && $url_third_param!='') {
			include 'controllers/user/verify_account_by_link.php';
		} elseif($url_first_param=="verify_account" && $url_second_param!='') {
			include 'views/verify_account.php';
		} elseif($url_first_param=="order" && $url_second_param!='' && $url_third_param!='') {
			$order_id = $url_second_param;
			$access_token = $url_third_param;
			include 'views/order.php';
		} elseif($url_first_param=="category") {
			$cat_url = trim($url_second_param);
			$blg_cat_q = mysqli_query($db,'SELECT * FROM blog_cats WHERE catSlug = "'.$cat_url.'" AND catSlug!=""');
			$blog_cat_data = mysqli_fetch_assoc($blg_cat_q);
			$meta_title = $blog_cat_data['meta_title'];
			$meta_desc = $blog_cat_data['meta_desc'];
			$meta_keywords = $blog_cat_data['meta_keywords'];
	
			include 'views/blog/cat_view.php';
		} elseif($url_first_param=="offer-status") {
			include 'controllers/offer_status.php';
		} elseif($url_first_param=="unsubscribe") {
			include 'controllers/unsubscribe_user.php';
		} else {
			setRedirect(SITE_URL);
			exit();
		} //END for other menu
	}
} ?>