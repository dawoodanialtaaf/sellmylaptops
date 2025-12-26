<section id="join_news_letter" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <div class="container-fluid"> 
        <div class="row justify-content-center mt-0">
            <div class="col-md-10 col-lg-8 col-xl-6">
                <div class="block newsletter new_newsletter">
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
                    <form method="post" id="newsletter_form" class="form-inline">
                        <div class="form-group">
                            <input type="email" name="ftr_signup_email" id="ftr_signup_email" placeholder="<?=_lang('newsletter_email_field_placeholder_text','home')?>" class="form-control text-left border-bottom border-top-0 border-right-0 border-left-0 center">
                            <button type="button" class="btn btn-primary btn-lg" id="clk_ftr_signup_btn"><?=_lang('submit_button_text')?></button>
                        </div>
                        <?php
                        $newsletter_csrf_token = generateFormToken('newsletter'); ?>
                        <input type="hidden" name="csrf_token" value="<?=$newsletter_csrf_token?>">
                        <input type="hidden" name="controller" value="newsletter" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>