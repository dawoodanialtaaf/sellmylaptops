<?php
foreach($page_sections_arr_list as $ps_k => $ps_v) {
	if($ps_k == "why_choose_us_sec" && $is_why_choose_us_sec_show == '1') {
		$why_choose_us_page_data = get_inbuild_page_data('why_choose_us');
		$items_data_array = json_decode($why_choose_us_page_data['data']['items'],true);
		
		$f_items_data_array = array();
		foreach($items_data_array as $p_items_data) {
			if($p_items_data['display_in_page_section'] == '1') {
				$f_items_data_array[] = $p_items_data;
			}
		}

		if(!empty($f_items_data_array)) { ?>
            <section id="whyChoose">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="block heading text-center clearfix">
                           <?php
                           if($why_choose_us_page_data['data']['title']) { ?>
                           	  <h3><?=$why_choose_us_page_data['data']['title']?></h3>
                           <?php
                           } ?>
                        </div>
                        <div class="block why-choose">
                           <div class="card-group">
                              <?php
                                 array_multisort(array_column($f_items_data_array, 'item_ordering'), SORT_ASC, $f_items_data_array);
                                 foreach($f_items_data_array as $items_data) {
                                    if($items_data['display_in_page_section'] == '1') {
                                        $item_fa_item = "";
                                        $item_icon_type = $items_data['item_icon_type'];
                                        if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
                                            $item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
                                        } elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
                                            $item_fa_item = '<img src="'.SITE_URL.'media/images/pages/'.$items_data['item_image'].'" class="img-fluid" alt="">';
                                        } ?>
                                        <div class="card">
                                         <div class="card-body">
                                            <?php
                                            if($item_fa_item) {
                                                echo $item_fa_item;
                                            }
                                            if($items_data['item_title']) {
                                                echo '<h5 class="card-title">'.$items_data['item_title'].'</h5>';
                                            }
                                            if($items_data['item_description']) {
                                                echo '<p>'.$items_data['item_description'].'</p>';
                                            } ?>
                                         </div>
                                        </div>
                                    <?php
                                    }
                                } ?>
                           </div>
                        </div>
                        <?php /*?><div class="block text-center clearfix">
                           <a href="<?=SITE_URL?>#category-section" class="btn btn-primary btn-lg mr-0 my-2"><?=_lang('get_started_button_text')?></a>
                        </div><?php */?>
                     </div>
                  </div>
				  
					<?php
					if($why_choose_us_sec_is_more_data_button == '1' && $why_choose_us_sec_button_text) {
						$why_choose_us_sec_button_f_url = "";
						$why_choose_us_sec_button_url = get_inbuild_page_url('why_choose_us');
						if($why_choose_us_sec_button_url) {
							$why_choose_us_sec_button_f_url = SITE_URL.$why_choose_us_sec_button_url;
						} ?>
						<div class="row">
							<div class="col-md-12">
								<div class="block text-center">
									<a class="btn btn-primary btn-lg mr-0 my-2" href="<?=$why_choose_us_sec_button_f_url?>"><?=$why_choose_us_sec_button_text?></a>
								</div>
							</div>
						</div>
					<?php
					} ?>
               </div>
            </section>
        <?php
		}
	}
	
	if($ps_k == "how_it_works_sec" && $is_how_it_works_sec_show == '1') {
		$how_it_works_page_data = get_inbuild_page_data('how_it_works');
		$items_data_array = json_decode($how_it_works_page_data['data']['items'],true);
		
		$f_items_data_array = array();
		foreach($items_data_array as $p_items_data) {
			if($p_items_data['display_in_page_section'] == '1') {
				$f_items_data_array[] = $p_items_data;
			}
		}
		
		if(!empty($f_items_data_array)) { ?>
            <section id="how-it-works">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block heading text-center clearfix">
							   <?php
                               if($how_it_works_page_data['data']['title']) { ?>
                                  <h3><?=$how_it_works_page_data['data']['title']?></h3>
                               <?php
                               } ?>
                            </div>
                            <div class="block easy-steps clearfix">
                                <div class="card-group">
                                    <?php
                                    array_multisort(array_column($f_items_data_array, 'item_ordering'), SORT_ASC, $f_items_data_array);
                                    foreach($f_items_data_array as $ik=>$items_data) {
                                        if($items_data['display_in_page_section'] == '1') {
                                            $item_fa_item = "";
                                            $item_icon_type = $items_data['item_icon_type'];
                                            if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
                                                $item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
                                            } elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
                                                $item_fa_item = '<img src="'.SITE_URL.'media/images/pages/'.$items_data['item_image'].'" class="img-fluid" alt="">';
                                            } ?>
											<div class="col-md-4">
                                              <div class="card">
											    <div class="card-header">
														<?php
															if($items_data['item_title']) {
                                                            echo '<h5 class="card-title">'.$items_data['item_title'].'</h5>';
                                                           }
														 ?>
												 </div>
                                                <div class="card-body">
													
                                                    <?php
                                                    if($item_fa_item) {
                                                        echo '<div class="image '.($ik==0?'laptop':'').'">'.$item_fa_item.'</div>';
                                                    }
                                                    
                                                    if($items_data['item_description']) {
                                                        echo '<p>'.$items_data['item_description'].'</p>';
                                                    } ?>
                                                </div>
                                              </div>
											</div>
                                        <?php
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<?php
					if($how_it_works_sec_is_more_data_button == '1' && $how_it_works_sec_button_text) {
						$how_it_works_sec_button_f_url = "";
						$how_it_works_sec_button_url = get_inbuild_page_url('how_it_works');
						if($how_it_works_sec_button_url) {
							$how_it_works_sec_button_f_url = SITE_URL.$how_it_works_sec_button_url;
						} ?>
						<div class="row">
							<div class="col-md-12">
								<div class="block text-center">
									<a class="btn btn-primary btn-lg mr-0 my-2" href="<?=$how_it_works_sec_button_f_url?>"><?=$how_it_works_sec_button_text?></a>
								</div>
							</div>
						</div>
					<?php
					} ?>
                </div>
            </section>
        <?php
		}
	}
	
	if($ps_k == "review_sec" && $is_review_sec_show == '1') {
		$review_list_data = get_review_list_data(1,0,true);
		$home_reviews_sec_data = get_home_page_data('','reviews');
		$section_title = $home_reviews_sec_data['title'];
		$section_show_title = $home_reviews_sec_data['show_title'];
		$section_sub_title = str_replace("<p><br></p>","",$home_reviews_sec_data['sub_title']);
		$section_show_sub_title = $home_reviews_sec_data['show_sub_title'];
		if(!empty($review_list_data) && $home_reviews_sec_data['status'] == '1') { ?>
			<section id="review" class="slider_review_section">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="block heading pb-0 dark text-center">
								<?php
								if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
									<h3 class="mb-0">
										<?php
										if($section_title && $section_show_title == '1') {
											echo $section_title;
										}
										if($section_sub_title && $section_show_sub_title == '1') {
											echo ' <span>'.$section_sub_title.'</span>';
										} ?>
									</h3>
								<?php
								} ?>
							</div>
							
							<?php
							if($review_sec_is_snippet_code == '1' && $review_sec_snippet_code) {
								echo '<div class="snippet-code">'.$review_sec_snippet_code.'</div>';
							} else { ?>
								<div class="block review-slide">
									<div class="row slider-nav">
										<?php
										$rev_read_more_arr = array();
										foreach($review_list_data as $key => $review_data) {
											if($review_data['display_in_page_section'] == '1') { ?>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <?php
                                                                if($review_data['photo']) {
                                                                    echo '<div class="image"><img src="'.SITE_URL.'media/images/review/'.$review_data['photo'].'" class="rounded-circle"></div>';
                                                                } else {
                                                                    echo '<div class="image"><img src="'.SITE_URL.'media/images/placeholder_avatar.jpg" class="rounded-circle"></div>';
                                                                }
                
                                                                if($review_data['title']) { ?>
                                                                    <div class="media_detail">
                                                                        <div class="media">
                                                                            <div class="media-body">
                                                                                <h4><?=$review_data['title']?></h4>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                } ?>
                
                                                                <div class="content_detail">
                                                                    <?php
                                                                    $rev_content = '';
                                                                    $rev_con_words = str_word_count($review_data['content']);
                                                                    $rev_content = limit_words($review_data['content'],20);
                                                                    if($rev_con_words>20) {
                                                                        $rev_content .= ' <a href="javascript;" data-toggle="modal" data-target="#reviewModal'.$review_data['id'].'">'._lang('readmore_link_text','home').'</a>';
                                                                        $rev_read_more_arr[] = array('id'=>$review_data['id'],'name'=>$review_data['name'],'content'=>$review_data['content']);
                                                                    } ?>
                                                                    <p><?=$rev_content?></p>
                                                                    <div class="rev-name"><?=$review_data['name'].($review_data['city']?' ('.$review_data['city'].($review_data['state']?', '.$review_data['state']:'').')':' ')?></div>
                                                                    <?php
                                                                    if($review_data['stars']) {
                                                                        echo '<div class="review-stars">';
                                                                            echo get_review_stars($review_data['stars'],"");
                                                                        echo '</div>';
                                                                    } ?>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
											<?php
											}
										} ?>
									</div>
								</div>
							<?php
							} ?>
						</div>
					</div>
					<?php
					if($review_sec_is_more_data_button == '1' && $review_sec_button_text && $review_sec_button_url) { ?>
						<div class="row">
							<div class="col-md-12">
								<div class="block text-center">
									<a class="btn btn-primary btn-lg mr-0 my-2" href="<?=$review_sec_button_url?>"><?=$review_sec_button_text?></a>
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
								<div class="modal-header">
									<h5 class="modal-title" id="reviewModalLabel<?=$rev_read_more_data['id']?>"><?=$rev_read_more_data['name']?></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body pt-0">
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