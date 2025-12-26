<section style="background: url('https://img.freepik.com/premium-photo/flat-lay-various-modern-electronic-devices-including-laptop-tablet-smartphone-camera-more_14117-660404.jpg') no-repeat center center; background-size: cover; background: #e9e9e9;">
    <div class="container-fluid" id="home_bannner">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-4">
            <div class="block heading search_section text-center ">
                <?php
                if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
                    <h1 class="pb-2" style="display:block;">
                        <?php
                        if($section_title && $section_show_title == '1') {
                            echo $section_title;
                        }
                        ?>
                    </h1>
                    
                    <p style="font-size: 27px;">
                     <?php
                    if($section_sub_title && $section_show_sub_title == '1') {
                            echo ' <span class="text-white" style="color: #000 !important;display:block !important;font-weight: 100;">'.$section_sub_title.'</span>';
                        } 
                          ?>
                    </p>
                  
                    <?php
                    if($is_show_search_box == '1') { ?>
                        <form class="form-inline" action="<?=SITE_URL?>search" method="post">
                            <div class="form-group">
                                <input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>" autocomplete="off" tabindex="-1">
                            </div>
                        </form>
                    <?php
                    }
                }
                if($section_intro_text && $section_show_intro_text == '1') {   
                    echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$section_intro_text.'</div>';
                }
                if($section_description && $section_show_description == '1') { 
                    echo $section_description;
                } ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section id="showCategory" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <a name="category-section"></a>
    <div class="container-fluid">
        <div class="">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-4 home">
              <h1 class="font-bold py-4" id="cat_title" style="font-weight: 600">Select Your Device Category</h1>
                <div class="block devices category-card h_img clearfix">
                    <div class="row category center_content">
                    <!-- <div class="category center_content"> -->
                        <?php
                        foreach($category_data_list as $category_data) { ?>
                            <!-- <div class="col-md-4 col-sm-4 col-xl-3 col-lg-4 col-6 p-2 device_category device-model-category"> -->
                            <div class="device_category device-model-category">
                                <a href="<?=$category_data['sef_url']?>" class="card">
                                    <div class="image">
                                        <?php
                                        if($category_data['icon_type']=="fa" && $category_data['fa_icon']!="") {
                                            echo '<i class="fa '.$category_data['fa_icon'].'"></i>';
                                        } elseif($category_data['icon_type']=="custom" && $category_data['image']!="") {
                                            $ct_img_path = SITE_URL.'media/images/categories/'.$category_data['image'];
                                            $ct_h_img_path = SITE_URL.'media/images/categories/'.$category_data['hover_image'];
                                            echo '<img class="main_img" width="300" height="300" src="'.$ct_img_path.'" alt="">';
                                            echo '<img class="main_hover_img" width="300" height="300" src="'.$ct_h_img_path.'" alt="">';
                                        } ?>
                                    </div>
                                    <h2><?=$category_data['title']?></h2>
                                </a>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</section>