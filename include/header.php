<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<meta name="keywords" content="<?=$meta_keywords?>" />
	<meta name="description" content="<?=$meta_desc?>" />
	<title><?=$meta_title?></title>

	<?php
	//$ajax_csrf_token = generateFormToken('ajax');
	//echo '<meta name="csrf-token" content="'.$ajax_csrf_token.'" />'.PHP_EOL;
	
	if($meta_canonical_url) {
		echo '<link href="'.$meta_canonical_url.'" rel="canonical" />'.PHP_EOL;
	}
	
	// Facebook Open Graph Tags 
	if($facebook_og_title) {
		echo '<meta property="og:title" content="'.$facebook_og_title.'"/>'.PHP_EOL;
	}
	
	if($facebook_og_description) {
		echo '<meta property="og:description" content="'.$facebook_og_description.'"/>'.PHP_EOL;
	}
	
	if($facebook_og_image) {
		echo '<meta property="og:image" content="'.SITE_URL.'media/images/open_graph_tags/'.$facebook_og_image.'"/>'.PHP_EOL;
	}
	
	if($facebook_og_title || $facebook_og_description || $facebook_og_image) {
		echo '<meta property="og:url" content="'.SITE_URL.'"/>'.PHP_EOL;
	}
	
	// Twitter Open Graph Tags
	if($twitter_og_title) {
		echo '<meta property="twitter:title" content="'.$twitter_og_title.'"/>'.PHP_EOL;
	}
	
	if($twitter_og_description) {
		echo '<meta property="twitter:description" content="'.$twitter_og_description.'"/>'.PHP_EOL;
	}
	
	if($twitter_og_image) {
		echo '<meta property="twitter:image" content="'.SITE_URL.'media/images/open_graph_tags/'.$twitter_og_image.'"/><meta name="twitter:card" content="summary_large_image">'.PHP_EOL;
	}
	
	// custom meta tags here
	echo $custom_meta_tags.PHP_EOL; ?>
	
	<!-- Jquery Data Table -->
	<link rel="stylesheet" type="text/css" href="<?=SITE_URL?>assets/css/jquery.dataTables.css">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/style-new.min.css?v=4">

	<!-- <link rel="stylesheet" href="<?=SITE_URL?>assets/css/styles/style-bootstrap-4.min.css?v=1">
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/styles/style-font-awesom-5.min.css?v=4">
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/styles/style-animate.min.css?v=1">
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/styles/style-style.min.css?v=2.9"> -->
	
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/color.min.css?v=1.1">
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/intlTelInput.min.css?v=1">
	<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css"/>
	<link rel="stylesheet" href="<?=SITE_URL?>assets/css/style_new.min.css?v=1.1">
	<link rel="stylesheet" href="<?= SITE_URL ?>assets/css/sml-enhance.css?v=5.11">
	<!--<link rel="stylesheet" href="<?= SITE_URL ?>assets/css/custom.css?v=2">-->
	
	<?php
	echo (!empty($head_graphics_css)?$head_graphics_css:'');
	
	if($favicon_icon) {
		echo '<link rel="shortcut icon" href="'.SITE_URL.'media/images/'.$favicon_icon.'" />'.PHP_EOL;
	} ?>
	
	<script src="<?=SITE_URL?>assets/js/jquery-3.3.1.min.js"></script>
	<?php /*?><script src="<?=SITE_URL?>assets/js/css3-animate-it.js"></script><?php */?> 
	<script src="<?=SITE_URL?>assets/js/jquery.scrollTo.min.js"></script>
	<script src="<?=SITE_URL?>assets/js/jquery.matchHeight-min.js"></script>
	<!-- <script src="<?=SITE_URL?>assets/js/bootstrap-datepicker.min.js"></script> -->
	
	<?php
	echo $custom_js_code;

	$is_review_order_page_with_cart_items = false;
	if(!empty($basket_item_count_sum_data['basket_item_count']) && $allow_guest_user_order == '1' && $url_first_param == "cart" && $basket_item_count_sum_data['basket_item_count']>0) {
		$is_review_order_page_with_cart_items = true;
	}

	require_once("include/custom_js.php");
	
	$body_class = "";
	if($page_body_class) {
		$body_class=$page_body_class;
	} elseif($url_first_param=="cart") {
		$body_class="inner bg-no-repeat";
	} elseif($url_first_param=="sell") { 
		$body_class="no-bg inner";
	} elseif($url_first_param!="") {
		$body_class="inner";
	}
	
	$inner_pages_bg_image_style = "";
	if($url_first_param!="") {
		$inner_pages_bg_image = $settings['inner_pages_bg_image'];
		if($inner_pages_bg_image) {
			$inner_pages_bg_image_style = 'style="background:url('.SITE_URL.'media/images/'.$inner_pages_bg_image.');"';
		}
	} ?>
    
    <?=$custom_schema?>
	<script src="<?=SITE_URL?>assets/js/sml-aurora.js?v=9" defer></script>
</head>

<body class="<?=$body_class?>" <?=$inner_pages_bg_image_style?>> 

	<?php
	echo $after_body_js_code;
	if($url_first_param!="order-completion") {
		//START for confirm message
		$confirm_message = getConfirmMessage()['msg'];
		echo $confirm_message;
		//END for confirm message
	} ?>

  <header style="background:black !important; " class="<?=($theme_header_type=="transparent"?'transparent_header_bg':'fix_header_bg')?>"> 

    <div class="container-fluid">

      <div class="row align-items-center">

        <div class="col-md-12 col-lg-3 left_h_section">

          <div class="block logo clearfix">

            <a class="logo-link" <?=(trim($url_first_param)!=""?'':'')?> href="<?=SITE_URL?>">

				<?php

				if($logo_url) {

        			echo '<img class="desktop_logo" width="'.$logo_width.'" height="'.$logo_height.'" src="'.$logo_url.'" alt="'.SITE_NAME.'">';

				}

				if($logo_fixed_url) {

            		echo '<img width="'.$fixed_logo_width.'" height="'.$fixed_logo_height.'" src="'.$logo_fixed_url.'" class="logo-mobile" alt="'.SITE_NAME.'">';

				} ?>

            </a>

            <a class="menu-toggle">

              <span></span>

              <span></span>

              <span></span>   

            </a>

            <div class="head_login">

            <ul class="mobile-user-menu">  

				<li>

					<?php

					if(isset($_SESSION[$session_front_user_id]) && $_SESSION[$session_front_user_id]>0) { ?>

						<a class="dropdown-toggle " data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user" aria-hidden="true"></i></a>

						<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">

							<i class="fas fa-caret-up"></i>

							<a class="dropdown-item first-item text-center hello-text">Hello <?=$user_data['name']?></a>

							<div class="dropdown-divider"></div>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item last-item" href="<?=SITE_URL?>account"><?=_lang('orders_menu_name','account_menu')?></a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item last-item" href="<?=SITE_URL?>coupons"><?=_lang('coupons_menu_name','account_menu')?></a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item last-item" href="<?=SITE_URL?>profile"><?=_lang('settings_menu_name','account_menu')?></a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item last-item" href="<?=SITE_URL?>change-password"><?=_lang('change_password_menu_name','account_menu')?></a>

							<div class="dropdown-divider"></div>

							<a class="dropdown-item last-item" href="<?=SITE_URL?>statistics"><?=_lang('statistics_menu_name','account_menu')?></a>

							<div class="dropdown-divider"></div>

							<?php /*?><a class="dropdown-item last-item" href="<?=SITE_URL?>bonus-system">Bonus System</a>

							<div class="dropdown-divider"></div><?php */?>

							<a class="dropdown-item last-item" href="<?=SITE_URL?>?controller=logout"><?=_lang('logout_link_text')?></a>

						</div>

					<?php

					} elseif($hide_header_login_button != '1') { ?>
                        <? if($hide_header_search != '1') { ?>
							<li class="position-relative">
									<a class="site_search"><i class="fas fa-search"></i><i class="fas fa-close"></i></a>
									<div class="block site-search-nav-block showcase-text calculate-cost py-0">
										<form class="form-inline from-mobile" action="<?= SITE_URL ?>search" method="post">
											<div class="form-group">
												<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?= _lang('searchbox_placeholder_text') ?>">
											</div>
										</form>
									</div>
								</li>
                        <?php } ?>
						<li>
						   <a id="" data-toggle="modal" data-target="#SignInRegistration"><i class="fa fa-user" aria-hidden="true" style="color:white !important;"></i></a>
						</li>

					<?php

					} ?>

				</li>

				<?php

			    if($hide_header_cart_icon != '1') { ?>

				<li>

					<a href="<?=SITE_URL?>cart">

						<i class="fa fa-shopping-cart" aria-hidden="true"></i>

						<?php

						if(isset($basket_item_count_sum_data['basket_item_count']) && $basket_item_count_sum_data['basket_item_count']>0) {

							echo '<span class="badge badge-danger">'.$basket_item_count_sum_data['basket_item_count'].'</span>';

						} ?>

					</a>

				</li>

				<?php

				} ?>

            </ul>

        </div>

            <a class="close-icon menu-toggle">
			<i class="fa fa-times text-white" aria-hidden="true"></i>
          </div>

        </div>

        <div class="col-md-12 col-lg-7 center_h_section">

		  <?php

		  if($is_act_header_menu == '1') { ?>

          <div class="block main-menu home">

            <ul>

			  <?php

			  $is_private_menu_show = false;

			  if(isset($active_menu) && ($active_menu == "account" || $active_menu == "coupons" || $active_menu == "track_order" || $active_menu == "profile" || $active_menu == "statistics" || $active_menu == "bonus-system")) {

			  	$is_private_menu_show = true;

			  }

		  

			  $header_menu_list = get_menu_list('header');

			  foreach($header_menu_list as $header_menu_data) {

				  $is_open_new_window = $header_menu_data['is_open_new_window'];

				  if($header_menu_data['page_id']>0) {

					  $menu_url = $header_menu_data['p_url'];

				  } else {

					  $menu_url = $header_menu_data['url'];

				  }

				  $is_custom_url = $header_menu_data['is_custom_url'];

				  $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);

				  $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');

				  

				  $menu_fa_icon = "";

				  if($header_menu_data['css_menu_fa_icon']) {

					  $menu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';

				  }

				  

				  $active_m_menu_class = "";

				  if(isset($active_page_data['menu_id']) && $active_page_data['menu_id']>0 && $active_page_data['menu_id']==$header_menu_data['id']) {

					$active_m_menu_class .= " active";

				  }

				  if($is_private_menu_show) {

				    // $active_m_menu_class .= " d-none d-lg-block";

				    $active_m_menu_class .= "";

				  }

				  $fix_menu_popup = "";

				  /*if($header_menu_data['page_slug'] == "order-track") {

					  $fix_menu_popup = 'data-toggle="modal" data-target="#trackOrderForm"';

				  } else*/if($header_menu_data['page_slug'] == "bulk-order-form") {

					 // $fix_menu_popup = 'data-toggle="modal" data-target="#bulkOrderForm"';

				  } ?>



				  <li class="dropdown <?=(count($header_menu_data['submenu'])>0?'submenu':'').$active_m_menu_class?> ">

					<a href="<?=$menu_url?>" class="dropdown-toggle <?=$header_menu_data['css_menu_class']?>" <?=$is_open_new_window.$fix_menu_popup?> <?php if(count($header_menu_data['submenu'])>0){ ?>data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"<?php } ?>><?=$header_menu_data['menu_name'].$menu_fa_icon?></a>	

					<?php

					if(count($header_menu_data['submenu'])>0) {

						$header_submenu_list = $header_menu_data['submenu'];

						echo '<ul class="droupdown dropdown-menu">';

							foreach($header_submenu_list as $header_submenu_data) {

								$s_is_open_new_window = $header_submenu_data['is_open_new_window'];

								if($header_submenu_data['page_id']>0) {

									$s_menu_url = $header_submenu_data['p_url'];

								} else {

									$s_menu_url = $header_submenu_data['url'];

								}

								$s_is_custom_url = $header_submenu_data['is_custom_url'];

								$s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);

								$s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');

								

								$submenu_fa_icon = "";

								if($header_menu_data['css_menu_fa_icon']) {

									$submenu_fa_icon = '&nbsp;<i class="'.$header_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';

								}

								

								$active_s_menu_class = "";

								if(isset($active_page_data['menu_id']) && $active_page_data['menu_id']>0 && $active_page_data['menu_id']==$header_submenu_data['id']) {

								   $active_s_menu_class = " active";

								} ?>

								<li class="<?=$active_s_menu_class?>"><a href="<?=$s_menu_url?>" class="<?=$header_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$header_submenu_data['menu_name'].$submenu_fa_icon?></a></li>

							<?php

							}

						echo '</ul>';

					} ?>

				  </li>
			  <?php
			  }

			   ?>
				 <? if($hide_header_search != '1') { ?>
								<li class="position-relative d-block d-md-none">
                	<a class="site_search mx-0"><i class="fas fa-search"></i><i class="fas fa-close"></i></a>
                    <div class="block site-search-nav-block showcase-text calculate-cost py-0">
                        <form class="form-inline" action="<?= SITE_URL ?>search" method="post">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?= _lang('searchbox_placeholder_text') ?>">
                            </div>
                        </form>
                    </div>
                </li>
              <?php } ?>
            </ul>
          </div>
		  <?php
		  } ?>

        </div>

        <div class="col-md-5 col-lg-2 right_h_section">  

          <div class="block user-menu pt-0 pr-0 clearfix head_login">

            <ul class="justify-content-end">
			<? if($hide_header_search != '1') { ?>
			<li class="position-relative">
                	<a class="site_search"><i class="fas fa-search"></i><i class="fas fa-close"></i></a>
                    <div class="block site-search-nav-block showcase-text calculate-cost py-0">
                        <form class="form-inline" action="<?= SITE_URL ?>search" method="post">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?= _lang('searchbox_placeholder_text') ?>">
                            </div>
                        </form>
                    </div>
                </li>
              <?php } ?>

              <li>

				<?php

				if(isset($_SESSION[$session_front_user_id]) && $_SESSION[$session_front_user_id]>0) { ?>

					<a class="dropdown-toggle " data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><?php /*?><?=_lang('client_area_link_text')?><?php */?></a>

					<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-left">

					  <i class="fas fa-caret-up"></i>

					  <a class="dropdown-item first-item text-center hello-text">Hello <?=$user_data['name']?></a>

					  <div class="dropdown-divider"></div>

					  <a class="dropdown-item last-item" href="<?=SITE_URL?>account"><?=_lang('my_account_link_text')?></a>

					  <div class="dropdown-divider"></div>

					  <a class="dropdown-item last-item" href="<?=SITE_URL?>?controller=logout"><?=_lang('logout_link_text')?> <i class="fas fa-sign-out-alt"></i></a>

					</div>

				<?php

				} elseif($hide_header_login_button != '1') { ?>

				  <a class="" data-toggle="modal" data-target="#SignInRegistration"><i class="fa fa-user" aria-hidden="true"></i></a>

				<?php

				} ?>

              </li>

			  <?php

			  if($hide_header_cart_icon != '1') { ?>

              <li>

                <a href="<?=SITE_URL?>cart">

                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>

				  	<?php

					if(isset($basket_item_count_sum_data['basket_item_count']) && $basket_item_count_sum_data['basket_item_count']>0) {

						echo '<span class="badge badge-danger">'.$basket_item_count_sum_data['basket_item_count'].'</span>';

					} ?>

                </a>

              </li>

			  <?php

			  } ?>

            </ul>

          </div>			

        </div>

      </div>

    </div>

  </header>