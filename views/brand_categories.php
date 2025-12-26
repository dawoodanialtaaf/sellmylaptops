<?php
$brand_data = get_brand_data($brand_id);

$meta_title = $brand_data['meta_title'];
$meta_desc = $brand_data['meta_desc'];
$meta_keywords = $brand_data['meta_keywords'];
$meta_canonical_url = $brand_data['meta_canonical_url'];
$main_title = $brand_data['title'];
$custom_schema = !empty($brand_data['custom_schema'])?$brand_data['custom_schema']:"";
$custom_schema_title = !empty($main_title)?$main_title:"";
$description = $brand_data['description'];

$schema_patterns = array('{$page_title}');
$schema_replacements = array($custom_schema_title);
$custom_schema = str_replace($schema_patterns, $schema_replacements, $custom_schema);
$custom_schema = str_replace($company_constants_patterns, $company_constants_replacements, $custom_schema);

//Header section
include("include/header.php");

//Get data from admin/_config/functions.php, get_brand_categories_data_list function
$cat_data_list = get_brand_categories_data_list($brand_id);
if(count($cat_data_list) == '1') {
	$brand_cat_url = SITE_URL.$cat_data_list['0']['cat_sef_url'].'/'.$brand_data['sef_url'];
	setRedirect($brand_cat_url,'');
	exit();
}
if(count($cat_data_list)>0) { ?>
  <section id="showCategory" class="pb-0">
	<div class="container-fluid">
	  <div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block heading page-heading text-center">
		    <?php
			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) { ?>
		  	<a class="btn btn-primary back-button" href="javascript:void(0);" onclick="history.back();"><?=_lang('back_button_text')?></a>
			<?php
			} ?>
            <h1><?=_lang('heading_text','category_list')?></h1>
          </div>
          <div class="block devices category-card h_img clearfix">
			<div class="row category pb-2 center_content">
			    <?php
				foreach($cat_data_list as $cat_data) { ?>
					<!-- <div class="col-md-4 col-sm-4 col-xl-3 col-lg-4 col-6 device_category"> -->
					<div class="device_category device-model-category">
						<a href="<?=SITE_URL.$cat_data['cat_sef_url'].'/'.$brand_data['sef_url']?>" class="card">
							<div class="image">
								<?php
								if($cat_data['icon_type']=="fa" && $cat_data['fa_icon']!="") {
									echo '<i class="fa '.$cat_data['fa_icon'].'"></i>';
								} elseif($cat_data['icon_type']=="custom" && $cat_data['cat_image']!="") {
									$ct_img_path = SITE_URL.'media/images/categories/'.$cat_data['cat_image'];
									$ct_h_img_path = SITE_URL.'media/images/categories/'.$cat_data['cat_hover_image'];
									echo '<img class="main_img" src="'.$ct_img_path.'" alt="'.$cat_data['cat_title'].'">';
									echo '<img class="main_hover_img" src="'.$ct_h_img_path.'" alt="'.$cat_data['cat_title'].'">';
								} ?>
							</div>
							<h5><?=$cat_data['cat_title']?></h5>
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
<?php
} else { ?>
  <section id="showCategory" class="pb-0 pt-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block text-center">
            <h3><?=_lang('items_not_available_text','category_list')?></h3>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
}

if($description!="") { ?>
	<section class="sectionbox white-bg">
		<div class="container">
			<?=$description?>
		</div>
	</section>
<?php
} ?>	
</div>