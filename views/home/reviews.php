<section id="review" class="slider_review_section" <?=$section_bg_styles?>>  
    <?=$section_bg_video?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="block heading pb-0 dark text-center">
                    <?php
                    if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
                        <h4 class="mb-0" style="color:#e13006;">
                            <?php
                            if($section_title && $section_show_title == '1') {
                                echo $section_title;
                            }
                            if($section_sub_title && $section_show_sub_title == '1') {
                                echo ' <span>'.$section_sub_title.'</span>';
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
                if($review_sec_is_snippet_code == '1' && $review_sec_snippet_code) {
                    echo '<div class="snippet-code">'.$review_sec_snippet_code.'</div>';
                } else { ?>
                    <div class="block review-slide">
                        <div class="row slider-nav">
                            <?php
                            $rev_read_more_arr = array();
                            foreach($review_list_data as $key => $review_data) { ?>
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
} ?>