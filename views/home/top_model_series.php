<section id="showTopDevices" class="device-brand" <?=$section_bg_styles?>>
    <?=$section_bg_video?> 
    <a name="top-model_series-section"></a> 
    <div class="container-fluid">   
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="heading search_section text-center">
                    <?php
                    if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
                        <h3 <?=$heading_text_color_style?>>
                            <?php
                            if($section_title && $section_show_title == '1') {
                                echo $section_title;
                            } ?>
                        </h3>
                        <?php 
                        if($section_sub_title && $section_show_sub_title == '1') {
                            echo ' <span class="inner-title">'.$section_sub_title.'</span>';
                        }
                    }
                    if($section_intro_text && $section_show_intro_text == '1') {   
                        echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$section_intro_text.'</div>';
                    }
                    if($section_description && $section_show_description == '1') { 
                        echo $section_description;
                    } ?>
                </div>	
                <div class="devices category-card start-selling h_img clearfix">
                    <ul class="row category center_content">
                        <?php
                        foreach($model_series_data_list as $model_series_data) { ?>
                            <div class="col-md-4 col-sm-6 col-xl-3 col-lg-3 col-12 device_category">
                                <a href="<?=$model_series_data['sef_url']?>" >
                                    <div class="image">
                                        <?php
                                        if($model_series_data['device_icon']) {
                                            $device_icon_path = SITE_URL.'media/images/model_series/'.$model_series_data['device_icon']; ?>
                                            <img src="<?=$device_icon_path?>" alt="<?=$model_series_data['title']?>">
                                        <?php 
                                        } ?>
                                    </div>
                                    <h5 <?=$text_color_style?>><?=$model_series_data['title']?></h5>
                                </a>
                            </div>	
                        <?php
                        } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>