<?php
//Header section
include("include/header.php");

$search_by = isset($post['search'])?$post['search']:'';

//Get model data list from functions.php, function get_model_data_list_for_search
$model_data_list = get_model_data_list_for_search($search_by);
$search_count = $model_data_list;
if(!empty($model_data_list) && $search_by) { ?>
	<section id="select-device" class="sectionbox white-bg">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
				<h3><?=_lang('heading_text','search_page')?></h3>
			  </div>
			  <div class="block devices inner_page_step mb-0 pb-0 clearfix">
				<div class="row justify-content-center category model-category">
				<?php
				foreach($model_data_list as $model_list) {
				  $cat_ids_array[] = $model_list['cat_id']; 

				  $model_upto_price = 0;
				  $model_upto_price_data = get_model_upto_price($model_list['id'],$model_list['price']);
				  $model_upto_price = $model_upto_price_data['price']; ?>
				  <div class="col-6 col-md-4 col-lg-4 col-sm-4 col-xl-3 p-2">
					<a href="<?=SITE_URL.$model_details_page_slug.$model_list['sef_url']?>" class="card">
					  <div class="image">
						<?php
						if($model_list['model_img']) {
							$md_img_path = SITE_URL.'media/images/model/'.$model_list['model_img'];
							echo '<img src="'.$md_img_path.'" alt="'.$model_list['title'].'">';
						} ?>
					  </div>
					  <h5><?=$model_list['title']?></h5>
					  <?php
					  if($model_upto_price>0) {
						echo '<h6 class="price">Up to '.amount_fomat($model_upto_price).'</h6>';
					  } ?>
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
	<section id="head-graphics">
		<img src="<?=SITE_URL?>media/images/apple_header_img.jpg" alt="" class="img-fluid">
		<div class="header-caption text-center search_section">
			<h2><?=_lang('not_exist_models_heading_text','search_page')?></h2>
			<p><?=_lang('not_exist_models_sub_heading_text','search_page')?></p>
			<div class="device-h-search">
				<form action="<?=SITE_URL?>search" method="post">
					<input type="text" name="search" class="srch_list_of_model" placeholder="<?=_lang('searchbox_placeholder_text')?>" required><br/>
					<button type="submit" class="btn btn-primary btn-lg search_btn"><?=_lang('search_button_text')?></button>
				</form>
			</div>
		</div>
	</section>
	
	<?php
	if($search_by) { ?>
	<section id="select-device" class="sectionbox white-bg">
		<div class="wrap">
			<div class="text-center"><h3><?=_lang('not_exist_models_text','search_page')?></h3></div>
		</div>
	</section>
	<?php
	}
} ?>
