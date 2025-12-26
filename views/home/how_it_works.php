<section id="how-it-works" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <a name="how-it-works"></a>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="block heading black text-center clearfix">
                <?php
                if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
                    <h3 style="color: black;text-align:center;">
                        <?php
                        if($section_title && $section_show_title == '1') {
                            echo $section_title;
                        }?>
                    </h3>

                      <?php
                        if($section_sub_title && $section_show_sub_title == '1') {
                            echo ' <span style="font-size: 24px;font-weight: 400;" class="py-4">'.$section_sub_title.'</span>';
                        } ?>
                <?php
                }
                if($section_intro_text && $section_show_intro_text == '1') { 
                    echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$section_intro_text.'</div>';
                }
                if($section_description && $section_show_description == '1') { 
                    echo $section_description;
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
									$item_fa_item = '<img src="media/images/pages/'.$items_data['item_image'].'" class="img-fluid" alt="">';
								} ?>
                                <div class="col-md-4">
								<div class="card">
                                    <div class="card-header">
                                        <?php
                                            if($items_data['item_title']) {
                                                echo '<h4 class="card-heading" '.$text_color_style.'>'.$items_data['item_title'].'</h4>';
                                                        
                                            }
                                        ?>
                                    </div>
									<div class="card-body">
										<?php
										if($item_fa_item) {
											echo '<div class="image '.($ik==0?'laptop':'').'">'.$item_fa_item.'</div>';
										}
										
                                         
                                       
										if($items_data['item_description']) {
											echo '<p '.$text_color_style.'>'.$items_data['item_description'].'</p>';
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