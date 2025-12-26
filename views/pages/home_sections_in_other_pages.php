<?php
if($active_page_data['disp_why_us_section'] == '1' || $active_page_data['disp_how_it_work_section'] == '1' || $active_page_data['disp_review_section'] == '1') {
	$home_page_settings_list = get_home_page_data();
	foreach($home_page_settings_list as $home_page_settings_data) {
		$home_page_settings_data['sub_title'] = str_replace("<p><br></p>","",$home_page_settings_data['sub_title']);
		$home_page_settings_data['intro_text'] = str_replace("<p><br></p>","",$home_page_settings_data['intro_text']);
		$home_page_settings_data['description'] = str_replace("<p><br></p>","",$home_page_settings_data['description']);
		$section_color = $home_page_settings_data['section_color'];
		$background_type = $home_page_settings_data['background_type'];
	
		$section_bg_imagevideo_path = '';
		$section_bg_styles = '';
		$section_bg_video = '';
		$section_image = $home_page_settings_data['section_image'];
		$section_image_ext = pathinfo($section_image,PATHINFO_EXTENSION);
		
		if($section_color && $background_type == "color") {
			$section_bg_styles .= "background-color:#".$section_color.";";
		}
		if($section_image && $background_type == "image") {
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
		
		if($home_page_settings_data['section_name'] == "how_it_works" && $active_page_data['disp_how_it_work_section'] == '1') {
			$items_data_array = json_decode($home_page_settings_data['items'],true);
			if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
				<section id="how-it-works" class="service-section mt-1" <?=$section_bg_styles?>>
					<?=$section_bg_video?>
					<a name="how-it-works"></a>
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-md-12 col-xl-11">
								<div class="card">
									<div class="card-body">
										<?php
										if(($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') || ($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') || ($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
											<div class="block heading text-center clearfix">
											  <?php
											  if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') {
												 echo '<h2 class="main-heading">'.$home_page_settings_data['title'].'</h2>';
											  }
											  if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') {
												 echo ' <h3 class="main-subheading" '.$heading_text_color_style.'>'.$home_page_settings_data['sub_title'].'</h3>';
											  }
											  if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
												 echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$home_page_settings_data['intro_text'].'</div>';
											  }
											  if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
												 echo $home_page_settings_data['description'];
											  } ?>
											</div>
										<?php
										} ?>
										<div class="row text-center">
										<?php
										array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
										foreach($items_data_array as $ik=>$items_data) {
											$item_fa_item = "";
											$item_icon_type = $items_data['item_icon_type'];
											if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
												$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
											} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
												$item_fa_item = '<img src="media/images/home_section/'.$items_data['item_image'].'" class="img-fluid" alt="">';
											} ?>
											<div class="col-sm-12 col-md-4">
												<?php
												if($item_fa_item) {
													echo '<div class="image">'.$item_fa_item.'</div>';
												}
												if($items_data['item_title']) {
													echo '<a href="javascript:void(0)" class="btn btn-light" '.$text_color_style.'>'.$items_data['item_title'].'</a>';
												}
												if($items_data['item_description']) {
													echo '<h6 '.$text_color_style.'>'.$items_data['item_description'].'</h6>';
												} ?>
											</div>
										<?php
										} ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			<?php
			}
		}
		elseif($home_page_settings_data['section_name'] == "why_choose_us" && $active_page_data['disp_why_us_section'] == '1') {
			$items_data_array = json_decode($home_page_settings_data['items'],true);
			if(!empty($items_data_array) || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
				<section id="whyChoose" class="why-choose" <?=$section_bg_styles?>>
				   <?=$section_bg_video?>
				   <a name="why-us"></a>
				   <div class="container">
					  <div class="row justify-content-center">
						 <div class="col-md-12 col-xl-11">
							<div class="block heading text-center clearfix">
							  <?php
							  if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') {
								 echo '<h2 class="main-heading">'.$home_page_settings_data['title'].'</h2>';
							  }
							  if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') {
								 echo ' <h3 class="main-subheading" '.$heading_text_color_style.'>'.$home_page_settings_data['sub_title'].'</h3>';
							  }
							  if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
								 echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$home_page_settings_data['intro_text'].'</div>';
							  }
							  if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
								 echo $home_page_settings_data['description'];
							  } ?>
							</div>
							<div class="card">
							 <div class="card-body">
								  <div class="row text-center">
									 <?php
									 array_multisort(array_column($items_data_array, 'item_ordering'), SORT_ASC, $items_data_array);
									 foreach($items_data_array as $items_data) {
										$item_fa_item = "";
										$item_icon_type = $items_data['item_icon_type'];
										if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
											$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
										} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
											$item_fa_item = '<img src="'.SITE_URL.'media/images/home_section/'.$items_data['item_image'].'" class="img-fluid" alt="'.$items_data['item_title'].'">';
										} ?>
										<div class="col-6 col-lg-3">
										   <?php
										   if($item_fa_item) {
											 echo $item_fa_item;
										   }
										   if($items_data['item_title']) {
											 echo '<h5 class="card-title" '.$text_color_style.'>'.$items_data['item_title'].'</h5>';
										   }
										   if($items_data['item_description']) {
											 echo '<p class="mb-4 mb-lg-0" '.$text_color_style.'>'.$items_data['item_description'].'</p>';
										   } ?>
										</div>
									 <?php
									 } ?>
								  </div>
							</div>
						</div>
				   </div>
				   </div>
				   </div>
				</section>
			<?php
			}
		}
		elseif($home_page_settings_data['section_name'] == "reviews" && $active_page_data['disp_review_section'] == '1') {
			$review_list_data = get_review_list_data(1,$number_of_item_show); 
			if(!empty($review_list_data)) { ?>
				<section class="review-section" <?=$section_bg_styles?>>  
					<?=$section_bg_video?>
					<div class="container">
					  <div class="row">
						 <div class="col-md-12">
							<?php
							if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1' || $home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1' || ($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') || ($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1')) { ?>
								<div class="block heading pb-0 dark text-center">
									<?php
									if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1' || $home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') { ?>
										<h3 class="mb-0" <?=$heading_text_color_style?>>
											<?php
											if($home_page_settings_data['title'] && $home_page_settings_data['show_title'] == '1') {
												echo $home_page_settings_data['title'];
											}
											if($home_page_settings_data['sub_title'] && $home_page_settings_data['show_sub_title'] == '1') {
												echo ' <span '.$heading_text_color_style.'>'.$home_page_settings_data['sub_title'].'</span>';
											} ?>
										</h3>
									<?php
									}
									if($home_page_settings_data['intro_text'] && $home_page_settings_data['show_intro_text'] == '1') { 
										echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$home_page_settings_data['intro_text'].'</div>';
									}
									if($home_page_settings_data['description'] && $home_page_settings_data['show_description'] == '1') { 
										echo $home_page_settings_data['description'];
									} ?>
								</div>
							<?php
							}
	
							if($home_page_settings_data['is_snippet_code'] == '1' && $home_page_settings_data['snippet_code']) {
								echo '<div class="snippet-code">'.$home_page_settings_data['snippet_code'].'</div>';
							} else { ?>
								<div id="review" class="owl-carousel">
									<?php
									$rev_read_more_arr = array();
									foreach($review_list_data as $key => $review_data) {
										$review_days_ago = round(abs(strtotime(date('F dS Y, h:i a'))-strtotime($review_data['date']))/60/60/24);
										$review_day_ago_display = "Today";
										if($review_days_ago > 0) {
											$review_day_ago_display = $review_days_ago.' days ago';
										} ?>
										<div class="item">
										  <div class="card">
											 <div class="card-body">
												<div class="d-flex justify-content-between align-items-center mb-3">
												   <?php
												   if($review_data['stars']) {
													  echo '<div class="rating">';
														echo get_review_stars($review_data['stars'],"");
													  echo '</div>';
												   }
												   if($review_day_ago_display) {
													  echo '<small>'.$review_day_ago_display.'</small>';
												   } ?>
												</div>
												<?php
												if($review_data['title']) { ?>
													<h6 <?=$text_color_style?>><?=$review_data['title']?></h6>
												<?php
												}
												
												$rev_content = '';
												$rev_con_words = str_word_count($review_data['content']);
												$rev_content = limit_words($review_data['content'],20);
												if($rev_con_words>20) {
													$rev_content .= ' <a href="javascript;" data-toggle="modal" data-target="#reviewModal'.$review_data['id'].'">'._lang('readmore_link_text','home').'</a>';
													$rev_read_more_arr[] = array('id'=>$review_data['id'],'name'=>$review_data['name'],'content'=>$review_data['content']);
												} ?>
												<p <?=$text_color_style?>><?=$rev_content?></p>
												<span class="name" <?=$text_color_style?>><?=$review_data['name']?></span>
											 </div>
										  </div>
									   </div>
									<?php
									} ?>
								</div>
							<?php
							} ?>
							</div>
							<?php
							$reviews_avg_text = _lang('reviews_avg_text','home');
							$reviews_brand_text = _lang('reviews_brand_text','home');
							if($reviews_avg_text && $reviews_brand_text && $home_page_settings_data['is_snippet_code'] != '1') {
								$avg_review_data = get_avg_review_data();
								if($avg_review_data['total_reviews'] > 0) {
									if($avg_review_data['total_reviews'] > 0) {
										$reviews_avg_text = str_replace(array('{$avg_star}','{$total_reviews}'),array($avg_review_data['avg_star'],$avg_review_data['total_reviews']),$reviews_avg_text); ?>
										<div class="col-md-12 text-center mt-4 pt-md-3">
											<h4 class="main-heading mb-3 mb-md-4"><?=$reviews_avg_text?></h4>
											<?php
											if($reviews_brand_text) { ?>
											<h4 class="main-heading"><?=$reviews_brand_text?></h4>
											<?php
											} ?>
										</div>
									<?php
									}
								}
							} ?>
						</div>
						<?php
						if($home_page_settings_data['is_more_data_button_show'] == '1' && $home_page_settings_data['button_text'] && $home_page_settings_data['button_url']) { ?>
							<div class="row">
								<div class="col-md-12">
									<div class="block text-center">
										<a class="btn btn-primary bg-gradient px-5 mt-3" href="<?=$home_page_settings_data['button_url']?>"><?=$home_page_settings_data['button_text']?></a>
									</div>
								</div>
							</div>
						<?php
						} ?>
					</div>
				</section>
				<?php
				if(!empty($rev_read_more_arr)) {
					foreach($rev_read_more_arr as $rev_read_more_data) { ?>
						<div class="modal fade" id="reviewModal<?=$rev_read_more_data['id']?>" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel<?=$rev_read_more_data['id']?>" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header border-0">
									  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
									  <span aria-hidden="true">&times;</span>
									  </button>
									</div>
									<div class="modal-body pt-0">
										<h5 class="modal-title" id="reviewModalLabel<?=$rev_read_more_data['id']?>"><?=$rev_read_more_data['name']?></h5>
										<p><?=$rev_read_more_data['content']?></p>
									</div>
								</div> 
							</div>
						</div>
					<?php
					}
				}
			}
		}
	}
} ?>