<section class="home-custom-section <?=$section_css_class?>" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="heading thin-title text-center">
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
                } ?>
            </div>
            <div <?=$text_color_style?>>
            <?php
            if($section_description && $section_show_description == '1') { 
                echo $section_description;
            } ?>
            </div>
        </div>
    </div>
</section>