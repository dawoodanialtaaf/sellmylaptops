<section id="whyChoose" <?=$section_bg_styles?>>
   <?=$section_bg_video?>
   <a name="why-us"></a>
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <div class="block heading text-center clearfix">
              <?php
              if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
               <h3 <?=$heading_text_color_style?>>
                 <?php
				 if($section_title && $section_show_title == '1') {
					echo $section_title;
				 }
				 if($section_sub_title && $section_show_sub_title == '1') {
					echo ' <span '.$heading_text_color_style.'>'.$section_sub_title.'</span>';
				 } ?>
               </h3>
              <?php
              }
			  if($section_intro_text && $section_show_intro_text == '1') { 
				echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$section_intro_text.'</div>';
			  }
			  if($section_description && $section_show_description == '1') { 
				echo $section_description;
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
									echo '<h5 class="card-title" '.$text_color_style.'>'.$items_data['item_title'].'</h5>';
								}
								if($items_data['item_description']) {
									echo '<p '.$text_color_style.'>'.$items_data['item_description'].'</p>';
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