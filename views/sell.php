<?php
$meta_title = "Sell Devices";
$meta_desc = "Sell Devices";
$meta_keywords = "Sell Devices";

$is_show_title = true;
$header_section = $active_page_data['header_section'];
$header_image = $active_page_data['image'];
$show_title = $active_page_data['show_title'];
$image_text = $active_page_data['image_text'];
$header_text_color = $active_page_data['header_text_color'];
$page_title = $active_page_data['title'];
?>

<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-12">
					<div class="block header-caption">
						<?php
						
						if($image_text) {
							echo '<div class="image_text">'.$image_text.'</div>'; 
						} ?>
					</div>
				</div>
		</div>
	</div>
</section> 

<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	 
<?php
$is_show_title = false;
}

if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h1 style='color:red;><?=$page_title?></h1>
				</div>
			</div>
		</div>
	</section>
<?php
}

if(trim($active_page_data['content'])) { ?>
<section class="pt-5 pb-0" id="sell_page">
	<div class="container-fluid <?=$active_page_data['css_page_class']?>">
	    <div class="row">
			<div class="col-md-12">
				<div class="block mt-0 pt-0">
					<?=$active_page_data['content']?>
				</div>
			</div>
	    </div>
	</div>
</section>
<?php
}	

$display_categories = $active_page_data['display_categories'];
$display_brands = $active_page_data['display_brands'];
$display_models_series = $active_page_data['display_models_series'];

if($display_categories == '1') {
	//Get data from admin/_config/functions.php, get_category_data_list function
	$category_data_list = get_category_data_list();
	if(!empty($category_data_list)) { ?>
		<section class="sell_cat" id="showCategory" class="pb-0">
			<div class="container-fluid">
			  <div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 sellCat">
				  <div class="block heading search_section text-center">
					<h3 class="pb-2"><?=_lang('categories_heading_text','sell')?></h3>
					<form action="<?=SITE_URL?>search" method="post">
					  <div class="form-group">
						<input type="text" name="search" class="form-control center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>">
					  </div>
					</form> 
				  </div>
				  <div class="block devices category-card h_img clearfix">
					<div class="row category pb-2 center_content">
					  <?php
					  foreach($category_data_list as $category_data) { ?>
					  <div class="col-md-4 col-sm-4 col-xl-3 col-lg-4 col-6 p-2 device_category device-model-category">
						<a href="<?=SITE_URL.$category_data['sef_url']?>" class="card">
						  <div class="image">
							<?php
							if($category_data['icon_type']=="fa" && $category_data['fa_icon']!="") {
								echo '<i class="fa '.$category_data['fa_icon'].'"></i>';
							} elseif($category_data['icon_type']=="custom" && $category_data['image']!="") {
								$ct_img_path = SITE_URL.'media/images/categories/'.$category_data['image'];
								$ct_h_img_path = SITE_URL.'media/images/categories/'.$category_data['hover_image'];
								echo '<img class="main_img" src="'.$ct_img_path.'" alt="'.$category_data['title'].'">';
								echo '<img class="main_hover_img" src="'.$ct_h_img_path.'" alt="'.$category_data['title'].'">';
							} ?>
						  </div>
						  <h5><?=$category_data['title']?></h5>
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
	}
}

if($display_brands == '1') {
	//Get data from admin/_config/functions.php, get_brand_data function
	$brand_data_list = get_brand_data();
	if(!empty($brand_data_list)) { ?>
	  <section id="showCategory" class="pb-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading page-heading text-center">
				<h3><?=_lang('brands_heading_text','sell')?></h3>
			  </div>
			  <div class="block device-brands clearfix inner_brands_section">
				<div class="brand-roll d-flex justify-content-center">
				<?php
				foreach($brand_data_list as $brand_data) { ?>
				  <div class="brand">
					  <a href="<?=SITE_URL.$brand_data['sef_url']?>">
					  <?php
					  if($brand_data['image']) {
						$md_img_path = SITE_URL.'media/images/brand/'.$brand_data['image'];
						echo '<img src="'.$md_img_path.'" alt="'.$brand_data['title'].'">';
					  }
					  if($brand_data['show_title'] == '1') {
						echo '<div class="phone-info"><h3>'.$brand_data['title'].'</h3></div>';
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
	}
}

if($display_models_series == '1') {
	//Get data from admin/_config/functions.php, get_model_series_data_list function
	$model_series_data_list = get_model_series_data_list();
	if(!empty($model_series_data_list)) {
		$num_of_device = count($model_series_data_list); ?>
		<section id="new_devicesection">
		   <div class="container-fluid">
			  <div class="block heading text-center">
				 <h3><?=_lang('model_series_heading_text','sell')?></h3>
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
										<h5><?=$model_series_data['title'].$p_dd_sn?></h5>
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
													<h5><?=$model_series_data['title'].$p_dd_sn?></h5>
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
													<h5><?=$model_series_data['title'].$p_dd_sn?></h5>
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
										<h5><?=$model_series_data['title'].$p_dd_sn?></h5>
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
												<h5><?=$model_series_data['title'].$p_dd_sn?></h5>
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
												<h5><?=$model_series_data['title'].$p_dd_sn?></h5>
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
	<?php
	}
} ?>