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

<section id="breadcrumb" class="<?=$active_page_data['css_page_class']?> py-0" style="background-imgage:url("https://www.shutterstock.com/image-vector/vector-illustration-realistic-silver-color-260nw-2182703761.jpg")">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix">
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Homess</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>

			<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1 style="font-weight:bold;">'.$page_title.'</h1>';
						}
						// if($image_text) {
						// 	echo '<div class="image_text">'.$image_text.'</div>'; 
						// } ?>
					</div>
				</div>
		</div>
	</div>
</section>

<?php
//Header Image


//Get data from admin/_config/functions.php, get_category_data_list function
$category_data_list = get_category_data_list();
$num_of_category = count($category_data_list);
if($num_of_category>0) { ?>
	<section id="showCategory" class="pb-0">
		<div class="container-fluid">
		  <div class="row">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			  <div class="block heading text-center">
				<h3 class="pb-3"><?=_lang('heading_text','category_list')?></h3>
				<form action="<?=SITE_URL?>search" method="post">
				  <div class="form-group">
					<input type="text" name="search" class="form-control center mx-auto srch_list_of_model" id="autocomplete" placeholder="<?=_lang('searchbox_placeholder_text')?>">
				  </div>
				</form>
			  </div>
			  <div class="block devices category-card h_img clearfix">
				<div class="row category center_content">
				  <?php
				  foreach($category_data_list as $category_data) { ?>
				  <div class="device_category device-model-category">
				  <!-- <div class="col-md-4 col-sm-4 col-xl-3 col-lg-4 col-6 device_category"> -->
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
} ?>