<?php
//Fetching data from model
require_once('helpers/page.php');

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
					<div class="block header-caption text-center">
						<?php
						if($show_title == '1') {
							echo '<h1>'.$page_title.'</h1>';
						}
						 ?>
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
} ?>

<section class="pt-5 pb-0">
	<div class="container-fluid <?=$active_page_data['css_page_class']?>">
	    <div class="row">
			<div class="col-md-12">
				<?php
				if($is_show_title && $show_title == '1') { ?>
					<div class="heading page-heading faq-heading text-center mb-5">
						
					</div>
				<?php
				} ?>
				<div class="block mt-0 pt-0">
					<?=$active_page_data['content']?>
				</div>
			</div>
	    </div>
	</div>
</section>

<?php
$f_items_data_array = array();
$items_data_array = json_decode($active_page_data['items'],true);
foreach($items_data_array as $p_items_data) {
	if($p_items_data['display_in_page'] == '1') {
		$f_items_data_array[] = $p_items_data;
	}
}

if(!empty($f_items_data_array)) { ?>
	<section class="pt-0 pb-5" style="background-color: #f3f5f8;" >
	   <div class="container-fluid">
		  <div class="row">
			 <div class="col-md-12">
				<div class="block why-choose m-whychoose-section">	
					<div class="card-group">
						<?php
						array_multisort(array_column($f_items_data_array, 'item_ordering'), SORT_ASC, $f_items_data_array);
						foreach($f_items_data_array as $items_data) {
							if($items_data['display_in_page'] == '1') {
								$item_fa_item = "";
								$item_icon_type = $items_data['item_icon_type'];
								if($item_icon_type=='fa' && $items_data['item_fa_icon']!="") {
									$item_fa_item = '<i class="'.$items_data['item_fa_icon'].'"></i>';
								} elseif($item_icon_type=='custom' && $items_data['item_image']!="") {
									$item_fa_item = '<img src="'.SITE_URL.'media/images/pages/'.$items_data['item_image'].'" class="img-fluid" alt="">';
								} ?>
								<div class="card">
								<div class="card-header">
                               <?php
								if($items_data['item_title']) {
									echo '<h5 class="card-title">'.$items_data['item_title'].'</h5>';
									}
								 ?>
								</div>
									<div class="card-body">
										<?php
										if($item_fa_item) {
											echo $item_fa_item;
										}
										
										if($items_data['item_description']) {
											echo '<p>'.$items_data['item_description'].'</p>';
										} ?>
									</div>
								</div>
							<?php
							}
						} ?>
					</div>
				</div>
			 </div>	
		  </div>
	   </div>
	</section>
<?php
} ?>
