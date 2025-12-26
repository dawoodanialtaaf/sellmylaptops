<?php
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$header_text_color = $active_page_data['header_text_color'];
$page_title = $active_page_data['title'];

if($model_series_id>0) {
	$device_single_data = get_device_single_data_by_id($model_series_id);
	$meta_title = $device_single_data['meta_title'];
	$meta_desc = $device_single_data['meta_desc'];
	$meta_keywords = $device_single_data['meta_keywords'];
	$meta_canonical_url = $device_single_data['meta_canonical_url'];
	$description = $device_single_data['description'];
	$custom_schema = !empty($device_single_data['custom_schema'])?$device_single_data['custom_schema']:"";
	$custom_schema_title = !empty($device_single_data['title'])?$device_single_data['title']:"";
} elseif($brand_id>0) {
	$brand_data = get_single_brand_data($brand_id);
	$description = $brand_data['description'];

	if(!empty($cat_single_data_resp['category_single_data']) && !empty($brand_data)) {
		$meta_title = $cat_single_data_resp['category_single_data']['meta_title'];
		$meta_desc = $cat_single_data_resp['category_single_data']['meta_desc'];
		$meta_keywords = $cat_single_data_resp['category_single_data']['meta_keywords'];
		$meta_canonical_url = $cat_single_data_resp['category_single_data']['meta_canonical_url'];
		$custom_schema = !empty($cat_single_data_resp['category_single_data']['custom_schema'])?$cat_single_data_resp['category_single_data']['custom_schema']:"";
		$custom_schema_title = !empty($cat_single_data_resp['category_single_data']['title'])?$cat_single_data_resp['category_single_data']['title']:"";
	} else {
		$meta_title = $brand_data['meta_title'];
		$meta_desc = $brand_data['meta_desc'];
		$meta_keywords = $brand_data['meta_keywords'];
		$meta_canonical_url = $brand_data['meta_canonical_url'];
		$custom_schema = !empty($brand_data['custom_schema'])?$brand_data['custom_schema']:"";
		$custom_schema_title = !empty($brand_data['title'])?$brand_data['title']:"";
	}
} else {
	$description = $active_page_data['content'];
}

$category_single_data = array();
$category_sef_url = "";
if($category_id>0) {
	$category_single_data = $cat_single_data_resp['category_single_data'];
	$category_sef_url = $category_single_data['sef_url'];
}

$schema_patterns = array('{$page_title}');
$schema_replacements = array($custom_schema_title);
$custom_schema = str_replace($schema_patterns, $schema_replacements, $custom_schema);
$custom_schema = str_replace($company_constants_patterns, $company_constants_replacements, $custom_schema);

//Header section
include("include/header.php");

//Get model data list from functions.php, function get_cat_brand_model_series_data_list
$model_series_data_list = get_cat_brand_model_series_data_list($category_id, $brand_id);

//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background: url('.SITE_URL.'media/images/pages/'.$header_image.') no-repeat; background-size:cover; width: 100%;"';}?>>   
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<div class="image_text">'.$image_text.'</div>';   
						} ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
} ?>

<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
    <div class="container-fluid">
        <div class="row">     
            <div class="col-md-12">
                <div class="block breadcrumb clearfix">
                    <ul class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="<?=SITE_URL?>">Home</a>
                        </li>
                        <?php if (!empty($category_single_data['title'])): ?>
                        <li class="breadcrumb-item">
                            <a href="<?=SITE_URL . $category_single_data['sef_url']?>"><?=htmlspecialchars($category_single_data['title'])?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (!empty($brand_data['title'])): ?>
                        <li class="breadcrumb-item">
                            <a href="<?=SITE_URL . $category_single_data['sef_url'] . '/' . $brand_data['sef_url']?>"><?=htmlspecialchars($brand_data['title'])?></a>
                        </li>
                        <?php endif; ?>
                        
                    </ul>
                </div>	
            </div>

			<div class="col-md-11">
			   <div class="block heading search_section text-center mx-auto">

				<h1 class="mb-0 text-center"><?=_lang('heading_text','model_list')?></h1>

				<form action="<?=SITE_URL?>search" method="post">

				  <div class="form-group">

					<input type="text" name="search" class="form-control center srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>">

				  </div>

				</form>

			  </div>
			
			</div>

			<div class="col-md-1">
			   <div class="block heading search_section text-center">

			    <?php

				if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {

			    	echo '<a class="btn btn-primary back-button" href="javascript:void(0);" onclick="history.back();">'._lang('back_button_text').'</a>';

				} ?>


			  </div>
			
			</div>
        </div>
    </div>
</section>

<?php
if(count($model_series_data_list)>1 && $brand_id>0 && ($model_series_id<=0 && $model_series_id!="other")) { ?>
	<section id="showCategory" class="pb-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
			    <?php
				if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
			    	echo '<a class="btn btn-primary back-button" href="javascript:void(0);" onclick="history.back();">'._lang('back_button_text').'</a>';
				} ?>
				<h3><?=_lang('heading_text','device_list')?></h3>
			  </div>

			  <div class="block devices inner_page_step clearfix">
				<div class="row justify-content-center category model-category">
					<?php
					foreach($model_series_data_list as $model_series_data) { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-4 col-6 p-2">
							<a href="<?=SITE_URL.($category_sef_url?$category_sef_url.'/':'').$brand_data['sef_url'].'/'.$model_series_data['sef_url']?>" class="card">
								<div class="image">
									<?php
									if($model_series_data['device_img']) {
										$md_img_path = SITE_URL.'media/images/model_series/'.$model_series_data['device_img'];
										echo '<img src="'.$md_img_path.'" alt="'.$model_series_data['title'].'">';
									} ?>
								</div>
								<h5><?=$model_series_data['title']?></h5>
							</a>
						</div>
					<?php
					}

					//Get model data list from functions.php, function get_c_b_d_model_data_list
					$c_b_d_extra_param_arr['model_type_source'] = '';
					$model_series_id = 'other';
					$model_data_list = get_c_b_d_model_data_list($brand_id, $category_id, $model_series_id, $model_series_id, $c_b_d_extra_param_arr);
					if(!empty($model_data_list)) { ?>
                        <div class="col-md-4 col-sm-4 col-xl-3 col-lg-4 col-6 p-2 other_series">
                            <a href="<?=SITE_URL.($category_sef_url?$category_sef_url.'/':'').$brand_data['sef_url'].'/other'?>" class="card">
                                <h5><?=_lang('other_series_text','device_list')?></h5>
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
	if($description) { ?>
		<section class="sectionbox">
			<div class="container">
				<?=$description?>
			</div>
		</section>
	<?php
	}
} else {

	$cat_ids_array = array();

	//Get model data list from functions.php, function get_c_b_d_model_data_list
	$c_b_d_extra_param_arr['model_type_source'] = $model_type_source;

	$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
	$limit = 15;
	$offset = ($page - 1) * $limit;

	$model_data_list = get_c_b_d_model_data_list($brand_id, $category_id, $model_series_id, $model_series_id, $c_b_d_extra_param_arr, $limit, $offset);
	if(!empty($model_data_list)) { ?>

	  <section id="showCategory" class="pb-0">

		<div class="container-fluid">

		  <div class="row">

			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

			 

			  <div class="block devices inner_page_step clearfix">

				<div class="row justify-content-center category model-category">

				<?php

				if($model_type_source == "brand") {

					echo '<div class="col-12">';

					foreach($model_data_list as $cd_k=>$cat_data) {

						if(!empty($cat_data['cat_data'])) {

							echo '<div class="row justify-content-center '.($cd_k>0?'pt-5':'').'"><h3>'.$cat_data['cat_data']['title'].'</h3></div>';

							echo '<div class="row">';

							if(!empty($cat_data['model_data'])) {

								foreach($cat_data['model_data'] as $model_list) {

								  $cat_ids_array[] = $model_list['cat_id'];

								  

								  $model_upto_price = 0;

								  $model_upto_price_data = get_model_upto_price($model_list['id'],$model_list['price']);

								  $model_upto_price = $model_upto_price_data['price']; ?>

								  <div class="col-6 col-md-4 col-lg-3 col-sm-4 col-xl-3 p-2 model-product-grid">

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
									  
									  echo '<h6 class="price">'._lang('upto_price_text','model_list').' '.amount_fomat($model_upto_price).'</h6>';

									  } ?>

									</a>

								  </div>

								<?php

								}

							}

							if($settings['missing_product_section']=='1') { ?>

							  <div class="col-6 col-md-3 col-lg-3 col-sm-4 col-xl-3 p-2 model-product-grid">

								<a href="javascript:void(0);" data-toggle="modal" data-target="#MissingProduct" class="card">

								  <div class="image">

									<?php

									$md_img_path = SITE_URL.'media/images/missing-product.png';

									echo '<img src="'.$md_img_path.'" alt="'._lang('missing_product_title','model_list').'">'; ?>

								  </div>

								  <h5><?=_lang('missing_product_title','model_list')?></h5>

								  <h6 class="price">&nbsp;</h6>

								</a>

							  </div>

							<?php

							}

							echo '</div>';

						}

					}

					echo '</div>';

				} else {

					$category_data = get_category_data($category_id);
					$fields_options_tooltips_arr = json_decode($category_data['fields_options_tooltips'],true);

					foreach($model_data_list as $model_list) {
					  $cat_ids_array[] = $model_list['cat_id'];

					  $model_upto_price = 0;
					  $model_upto_price_data = get_model_upto_price($model_list['id'], $model_list['price'], $fields_options_tooltips_arr);
					  $model_upto_price = $model_upto_price_data['price']; ?>

					  <div class="col-6 col-md-3 col-lg-3 col-sm-4 col-xl-3 p-2 model-product-grid">

						 <a href="<?= SITE_URL. $category_data['sef_url'] . '/' . $brand_data['sef_url'] . '/' . $model_details_page_slug . $model_list['sef_url'] ?>" class="card">

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

							echo '<h6 class="price">'._lang('upto_price_text','model_list').' '.amount_fomat($model_upto_price).'</h6>';	  

						  } ?>

						</a>

					  </div>

					<?php

					}

					if($settings['missing_product_section']=='1') { ?>

					  <div class="col-6 col-md-3 col-lg-3 col-sm-4 col-xl-3 p-2 model-product-grid">

						<a href="javascript:void(0);" data-toggle="modal" data-target="#MissingProduct" class="card">	

						  <div class="image">

							<?php

							$md_img_path = SITE_URL.'media/images/missing-product.png';

							echo '<img src="'.$md_img_path.'" alt="'._lang('missing_product_title','model_list').'">'; ?>

						  </div>

						  <h5><?=_lang('missing_product_title','model_list')?></h5>

						  <h6 class="price">&nbsp;</h6>

						</a>

					  </div>

					<?php

					}
					
					$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
					$limit = 20;
					$offset = ($page - 1) * $limit;

					$model_data_list = get_c_b_d_model_data_list($brand_id, $category_id, $model_series_id, $model_series_id, $extra_params, $limit, $offset);

					// Get total for pagination
					$total_rows = get_model_data_count($brand_id, $category_id, $model_series_id, $model_series_id, $extra_params); // ← You'll need to create this function
					$total_pages = ceil($total_rows / $limit);

					function render_pagination($page, $total_pages, $range = 2) {
						if ($total_pages <= 1) return;

						echo '<ul class="pagination justify-content-center">';

						// Previous
						if ($page > 1) {
							echo '<li class="page-item"><a class="page-link" href="?page='.($page - 1).'">&laquo;</a></li>';
						}

						// Always show first page
						if ($page > ($range + 2)) {
							echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
							echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
						}

						// Middle pages
						for ($i = max(1, $page - $range); $i <= min($total_pages, $page + $range); $i++) {
							$active = ($i == $page) ? ' active' : '';
							echo '<li class="page-item'.$active.'"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
						}

						// Always show last page
						if ($page < ($total_pages - $range - 1)) {
							echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
							echo '<li class="page-item"><a class="page-link" href="?page='.$total_pages.'">'.$total_pages.'</a></li>';
						}

						// Next
						if ($page < $total_pages) {
							echo '<li class="page-item"><a class="page-link" href="?page='.($page + 1).'">&raquo;</a></li>';
						}

						echo '</ul>';
					}
					?>

					<div class="col-12 mt-4">
						<?php render_pagination($page, $total_pages); ?>
					</div>

				<?php } ?>

				</div>

			  </div>

			</div>

		  </div>

		</div>

	  </section>



	  <section id="haveQuestion">

		<div class="container-fluid">

		  <div class="col-md-12">

			<div class="block heading thin-title text-center clearfix">

			  <h3 class="py-4"><?=_lang('contact_us_block_title','model_list')?></h3>

			  <a href="javascript:void(0);" data-toggle="modal" data-target="#contactusForm" class="btn btn-primary btn-lg my-2"><?=_lang('contact_us_button_text','model_list')?></a>

			</div>

		  </div>

		</div>

	  </section>


	
	<section style="background: #e9cdbc;">
	<?php
	  $is_review_sec_show = $review_sec_show_in_model_list;
	  ?>
	<section>
		<?php
	$is_why_choose_us_sec_show = $why_choose_us_sec_show_in_model_list;
	$is_how_it_works_sec_show = $how_it_works_sec_show_in_model_list;
	require_once('views/sections/sections.php'); 
	} else { ?>

	  <section id="showCategory" class="pb-0 pt-0">

		<div class="container-fluid">

		  <div class="row">

			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

			  <div class="block text-center">

				<h3><?=_lang('items_not_available_text','model_list')?></h3>

			  </div>

			</div>

		  </div>

		</div>

	  </section>

	<?php

	}



	if($model_series_id>0) {

		$model_series_data = get_device_single_data_by_id($model_series_id);

		$description = $model_series_data['description'];

	}



	if($description) { ?>

		<section class="sectionbox">

			<div class="container">

				<?php echo $description; ?>

			</div>

		</section>

	<?php

	}

	

	if(!empty($cat_ids_array)) {

		$faqs_groups_data_html = get_faqs_groups_with_html(array(),array_unique($cat_ids_array),'model_list');

		if($faqs_groups_data_html['html']!="") { ?>

			<section class="faq_page">

				<div class="container">

					<div class="block setting-page clearfix">

						<div class="wrap">

							<?=$faqs_groups_data_html['html']?>

						</div>

					</div>	

				</div>	

			</section>

		<?php	

		}

	}

}

//for missing product section popup
require_once('views/sections/missing_product_section_popup.php'); 
?>