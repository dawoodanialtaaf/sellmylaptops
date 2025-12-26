<section id="select_brand" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <div class="container-fluid">
        <div class="block heading text-center">
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
        <div class="block brands-slider clearfix home_brand_section">
            <div class="block device-brands clearfix">
         
                <div class="brand-roll">
                    <?php
                    foreach($brand_data_list as $brand_data) { ?>
                        <div class="brand">
                            <a href="<?=SITE_URL.$brand_data['sef_url']?>">
                                <div class="arrow"><i class="fa fa-check"></i></div>
                                <?php
                                if($brand_data['image']) {
                                    echo '<img src="'.SITE_URL.'media/images/brand/'.$brand_data['image'].'" class="img-fluid" alt="'.$brand_data['title'].'">';
                                }
                                if($brand_data['show_title'] == '1') {
                                    echo '<h5 '.$text_color_style.'>'.$brand_data['title'].'</h5>';
                                } ?>
                            </a>
                        </div>
                    <?php
                    } ?>
                </div>
            </div>  
        </div>
    </div>
</section>