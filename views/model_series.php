<?php
//Header section
include("include/header.php");

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
						<li class="breadcrumb-item active"><a href="javascript:void(0);">category/brand</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<?php
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
$is_show_title = false;
}

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

	<?php /*?><section id="deviceSection" class="pt-0">
		<a name="device-section"></a>
		<div class="container-fluid">
		  	<div class="row align-items-center">
				<div class="col-md-6 col-xl-4">
					<div class="block calculate-cost clearfix">
						<img src="<?=SITE_URL?>media/images/white-logo-symbol.png" alt="">
						<h3><?=_lang('heading_text','device_list')?></h3>
						<form class="form-inline" action="<?=SITE_URL?>search" method="post">
							<div class="form-group">
								<input type="text" name="search" class="form-control border-bottom border-top-0 border-right-0 border-left-0 center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>">
								<button type="button" class="btn btn-clear" id="ftr_signup_btn"><i class="fas fa-arrow-right"></i></button>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-6 col-xl-8">
					<div id="deviceSlider" class="device-slider">
						<?php
						foreach($model_series_data_list as $model_series_data) { ?>
							<div class="device">
								<a href="<?=$model_series_data['sef_url']?>">
									<?php
									if($model_series_data['device_img']) {
										$device_img_path = SITE_URL.'media/images/model_series/'.$model_series_data['device_img']; ?>
										<img src="<?=$device_img_path?>" class="img-fluid" alt="<?=$model_series_data['title']?>">
									<?php
									} ?>
								</a>
								<h5><?=$model_series_data['title']?></h5>
							</div>
						<?php
						} ?>
					</div>
				</div>
		  	</div>
		</div>
	</section><?php */?>
<?php
} ?>