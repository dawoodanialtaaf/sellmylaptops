<section id="showcase" class="slider_bg_color py-0">
    <?=$section_bg_video?>
    <div class="container-fluid">
      <div class="home-slide" style="visibility:hidden;">
         <?php
         foreach($items_data_array as $id_k=>$items_data) { ?>
         <div class="home-slide-item" <?=($id_k>0?'style="display:none;"':'')?>>
            <div class="row justify-content-center">
           
                <div class="col-md-6 col-lg-6 col-xl-6">
                  <div class="block showcase-text calculate-cost pr-0 mr-0">
                     <h1><?=$items_data['item_title']?></h1>
                     <p><?=$items_data['item_sub_title']?></p>
                     <?php
                     if($items_data['button_text'] && $items_data['button_url']) { ?>
                     <div class="list-inline">
                        <a href="<?=$items_data['button_url']?>" class="btn btn-lg mr-3 btn-outline-light" <?php if($items_data['button_open_new_tab'] == '1'){echo 'target="_blank"';}?>><?=$items_data['button_text']?></a>
                     </div>
                     <?php
                     }
                     if($is_show_search_box == '1') { ?>
                    
                     <form class="form-inline" action="<?=SITE_URL?>search" method="post">
                        <div class="form-group">
                           <input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>">
                           <button type="button" class="btn btn-clear" id="ftr_signup_btn"><i class="fas fa-arrow-right"></i></button>
                        </div>
                     </form>
                     <?php
                     } ?>
                  </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6">
                  <div class="block px-0 mx-0 pb-0 mb-0 showcase-image">
                     <?php
                     if($items_data['item_image']!="") { ?>
                        <img class="animated fadeIn" src="<?=SITE_URL.'media/images/home_section/'.$items_data['item_image']?>" alt="<?=strip_tags($items_data['item_title'])?>">
                     <?php
                     } ?>
                  </div> 
                </div>
            </div>
         </div>
         <?php
         } ?>
      </div>
    </div>
</section>