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



<?php
//Header Image
if($header_section == '1' && ($header_image || $show_title == '1' || $image_text)) { ?>
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" style="background:#e9e9e9;">  
		<div class="container">
			<div class="row">
			<div class="col-md-12">
				<div class="block breadcrumb clearfix text-center" >
					<ul class="breadcrumb m-0">
						<li class="breadcrumb-item">
							<a href="<?=SITE_URL?>">Home</a>
						</li>
						<li class="breadcrumb-item active"><a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a></li>
					</ul>
				</div>
			</div>
				<div class="col-md-12">
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1 style="color:black !important;">'.$page_title.'</h1>';
						}
						if($image_text) {
							echo '<div class="image_text" style="color:black !important;">'.$image_text.'</div>';
						} ?>
					</div>

			
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
}

//Get data from admin/_config/functions.php, get_brand_data function
$brand_data_list = get_brand_data();
if(!empty($brand_data_list)) { ?>
  <section id="showCategory" class="pb-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block heading page-heading text-center">
            <h1><?=_lang('heading_text','brand_list')?></h1>
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
} else { ?>
  <section id="showCategory" class="pb-0 pt-0">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="block text-center">
            <h3><?=_lang('items_not_available_text','brand_list')?></h3>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} ?>