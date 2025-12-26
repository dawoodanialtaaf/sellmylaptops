<?php
//Get review list
$review_list_data = get_review_list_data(1);
$total_num_of_rev = count($review_list_data);

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

if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?>">
		<div class="container">
			<div class="col-md-12">
				<div class="block heading page-heading text-center">
					<h1><?=$page_title?></h1>
				</div>
			</div>
		</div>
	</section>
<?php 
}

if($active_page_data['content']) { ?>
	<section>
		<div class="container">
			<div class="col-md-12">
				<div class="block mt-0 pt-0">
					<?=$active_page_data['content']?>
				</div>
			</div>
		</div>
	</section>
<?php 
}

$heading_text = _lang('heading_text','reviews');
$sub_heading_text = _lang('sub_heading_text','reviews'); ?>

<section class="<?=$active_page_data['css_page_class']?>"> 
	<div class="container-fluid">
		<div class="row">  
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<?php
				if($heading_text || $sub_heading_text) { ?>
				<div class="block heading page-heading text-center">
					<h3><?=$heading_text.($sub_heading_text?' <br><span class="text-primary">'.$sub_heading_text.'</span>':'')?></h3>
				</div>
				<?php
				}
				
				if($review_sec_is_snippet_code == '1' && $review_sec_snippet_code) {
					echo '<div class="snippet-code">'.$review_sec_snippet_code.'</div>';
				} else { ?>
					<div class="block review-slide page only_review">
						<?php
						if($total_num_of_rev > 0) { ?>
							<div class="card-columns reviews_detail"> 
								<?php
								$numOfCols = 2;
								$rowCount = 0;
								foreach($review_list_data as $key => $review_data) { ?>
									<div class="card">
										<div class="card">
											<div class="card-body">  
												<div class="row">
													<div class="image">
													<?php
													if($review_data['photo']) {
														echo '<img src="'.SITE_URL.'media/images/review/'.$review_data['photo'].'" class="rounded-circle">';
													} else {
														echo '<img src="media/images/placeholder_avatar.jpg" class="rounded-circle">';
													} ?>
													</div>
													<?php
													if($review_data['title']) { ?>
													<div class="col-12">
														<div class="media">
															<div class="media-body">
																<h4><?=$review_data['title']?></h4>
															</div>
														</div>
													</div>
													<?php
													} ?>
													<div class="col-md-12">
														<p><?=$review_data['content']?></p>
														<div class="rev-name"><?=$review_data['name'].($review_data['city']?' ('.$review_data['city'].($review_data['state']?', '.$review_data['state']:'').')':' ')?></div>
														<?php
														if($review_data['stars']) {
															echo '<div class="review-stars">';
																echo get_review_stars($review_data['stars'],"");
															echo '</div>';
														} ?>
													</div>
												</div>
											</div>		
										</div>
									</div> 
									<?php
									$rowCount++;
									if ($rowCount % $numOfCols == 0) {echo '</div><div class="card-columns reviews_detail">';}
								} ?>
							</div>
						<?php
						} ?>
					</div>
				<?php
				}

				if($review_sec_is_more_data_button == '1' && $review_sec_button_text && $review_sec_button_url && $review_sec_is_snippet_code == '1') { ?>
					<div class="block text-center">
						<a href="<?=$review_sec_button_url?>" class="btn btn-primary"><?=$review_sec_button_text?></a>
					</div>
				<?php
				} else { ?>
					<div class="block text-center">
						<a href="<?=$review_form_link?>" class="btn btn-primary"><?=_lang('write_a_review_button_text','reviews')?></a>
					</div>
				<?php
				} ?>
			</div>
		</div>
	</div>
</section>