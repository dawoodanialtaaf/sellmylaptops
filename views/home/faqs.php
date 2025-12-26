<section class="faq_page padding-60" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <div class="container">
        <div class="block setting-page clearfix">
            <div class="wrap">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block heading text-center clearfix">
                            <?php
                            if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
                                <h4 style="color: #e13006 !important">
                                    <?php
                                    if($section_title && $section_show_title == '1') {
                                        echo $section_title;
                                    }
                                    if($section_sub_title && $section_show_sub_title == '1') {
                                        echo ' <span '.$heading_text_color_style.'>'.$section_sub_title.'</span>';
                                    } ?>
                                </h4>
                            <?php
                            }
                            if($section_intro_text && $section_show_intro_text == '1') { 
                                echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$section_intro_text.'</div>';
                            }
                            if($section_description && $section_show_description == '1') { 
                                echo $section_description;
                            } ?>
                        </div>

                        <?php
                        $n_f = 0;
                        $faqs_html = '';
                        $faqs_html .= '<div class="accordion" id="accordion">';
                            foreach($faqs_list_data as $faq_data) {
                              $n_f = $n_f+1;
                              $faqs_html .= '<div class="card">
                                <div class="card-header" id="headingOne-s-'.$n_f.'">
                                  <h5 class="mb-0">
                                    <button class="btn btn-link '.($n_f == 1?'collapsed':'collapsed').'" type="button" data-toggle="collapse" data-target="#collapseOne-s-'.$n_f.'" aria-expanded="'.($n_f == 1?'true':'true').'" aria-controls="collapseOne-s-'.$n_f.'" '.$text_color_style.'>'.$faq_data['title'].'<span><img class="plus" src="'.SITE_URL.'media/images/icons/plus_icon.png" alt="plus icon"><img class="minus" src="'.SITE_URL.'media/images/icons/minus_icon.png" alt="minus icon"></span>
                                    </button>
                                  </h5>
                                </div>
                                <div id="collapseOne-s-'.$n_f.'" class="collapse '.($n_f == 1?'show-no':'').'" aria-labelledby="headingOne" data-parent="#accordion">
                                  <div class="card-body" '.$text_color_style.'>';
                                    $faqs_html .= $faq_data['description'];
                                  $faqs_html .= '</div>
                                </div>
                              </div>';
                            }
                        $faqs_html .= '</div>';
                        echo $faqs_html; ?>
                    </div>
                </div>
                <?php
                if($home_page_settings_data['is_more_data_button_show'] == '1') { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block text-center faq_page_button">
                                <a class="btn btn-outline btn-primary px-4" href="<?=$home_page_settings_data['more_data_button_url']?>"><?=_lang('more_faqs_link_text','home')?></a>
                            </div>
                        </div>							
                    </div>
                <?php
                } ?>
            </div>
        </div>	
    </div>  
</section>