<section id="new_devicesection" <?=$section_bg_styles?>>
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
      <div class="device-card">
         <div class="block dc_inner_r">
            <?php
            $t_dd_n = 0;$t_dd_sn = 0;
            $num_d_row_arr = array();
            foreach($model_series_data_list as $model_series_data) {
                $t_dd_n = ($t_dd_n+1);
                $t_dd_sn = ($t_dd_sn+1);
                $num_d_row_arr[$t_dd_n] = $t_dd_sn;
                if($t_dd_n%6==0){$t_dd_sn = 0;}
            }
            
            $dd_n = 0;$dd_sn = 0;
            foreach($model_series_data_list as $model_series_data) {
                $device_img_htm = '';
                if($model_series_data['device_img']) {
                    $device_img_path = SITE_URL.'media/images/model_series/'.$model_series_data['device_img'];
                    $device_img_htm = '<img src="'.$device_img_path.'" class="img-fluid" alt="'.$model_series_data['title'].'">';
                }
                
                $dd_n = ($dd_n+1);
                $dd_sn = ($dd_sn+1);

                $p_dd_sn = '';//'-'.$dd_sn.'='.$dd_n;
                if($dd_sn == 1) {
                echo '<div class="row">'; ?>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 dc_section">
                        <a href="<?=$model_series_data['sef_url']?>" class="dc_inner_img">
                            <div class="dc_img">
                                <h5 <?=$text_color_style?>><?=$model_series_data['title'].$p_dd_sn?></h5>
                                <?=$device_img_htm?>
                            </div>
                        </a>
                    </div>
                <?php
                }

                if($dd_sn == 2 || $dd_sn == 3) {
                    if($dd_sn == 2) {
                    echo '<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 dc_second"><div class="row">'; ?>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-6 col-12">
                            <a href="<?=$model_series_data['sef_url']?>" class="dc_inner_img">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 v-aligh">
                                        <div class="dc_img">
                                            <h5 <?=$text_color_style?>><?=$model_series_data['title'].$p_dd_sn?></h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="dc_img">
                                            <?=$device_img_htm?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    if($dd_sn == 3) { ?>
                        <div class="col-xl-12 c-l-lg-12 col-md-12 col-sm-6 col-12">
                            <a href="<?=$model_series_data['sef_url']?>" class="dc_inner_img">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 v-aligh">
                                        <div class="dc_img">
                                            <h5 <?=$text_color_style?>><?=$model_series_data['title'].$p_dd_sn?></h5>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="dc_img">
                                            <?=$device_img_htm?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    if($dd_sn == 3 || ($num_of_device==$dd_n && $num_d_row_arr[$dd_n]<=3)) {echo '</div></div>';}
                }
                if($dd_sn == 4) { ?>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 dc_section">
                        <a href="<?=$model_series_data['sef_url']?>" class="dc_inner_img">
                            <div class="dc_img">
                                <h5 <?=$text_color_style?>><?=$model_series_data['title'].$p_dd_sn?></h5>
                                <?=$device_img_htm?>
                            </div>
                        </a>
                    </div>
                <?php
                }
                if($dd_sn == 4 || ($num_of_device==$dd_n && $num_d_row_arr[$dd_n]<=4)) {echo '</div>';}
                
                if($dd_sn == 5) {
                echo '<div class="row">'; ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 dc_second">
                        <a href="<?=$model_series_data['sef_url']?>" class="dc_inner_img ">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 v-aligh">
                                    <div class="dc_img">
                                        <h5 <?=$text_color_style?>><?=$model_series_data['title'].$p_dd_sn?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="dc_img">
                                        <?=$device_img_htm?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
                if($dd_sn == 6) { ?>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 dc_second">
                        <a href="<?=$model_series_data['sef_url']?>" class="dc_inner_img ">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 v-aligh">
                                    <div class="dc_img">
                                        <h5 <?=$text_color_style?>><?=$model_series_data['title'].$p_dd_sn?></h5>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="dc_img">
                                        <?=$device_img_htm?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php
                }
                if($dd_sn==6 || ($num_of_device==$dd_n && $num_d_row_arr[$dd_n]<=6)) {echo '</div>';}

                if($dd_n%6==0){$dd_sn=0;}
            } ?>
         </div>
      </div> 
   </div>
</section>