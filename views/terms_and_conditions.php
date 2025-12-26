<?php
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

				<div class="block header-caption">
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
	<section class="head-graphics <?=$active_page_data['css_page_class']?>" id="head-graphics" <?php if($header_image != ""){echo 'style="background: url('.SITE_URL.'media/images/pages/'.$header_image.')no-repeat; background-size:cover; width: 100%;"';}?>>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="block header-caption text-center">
						
					</div>
				</div>
			</div>
		</div>
	</section>
<?php
$is_show_title = false;
}

if($is_show_title && $show_title == '1') { ?>
	<section id="head-graphics-title" class="<?=$active_page_data['css_page_class']?> pt-5 pb-0">
		<div class="container">
			<div class="col-md-12">
				<div class="heading page-heading text-center">
					
				</div>
			</div> 
		</div>
	</section>
<?php
} ?>

<section class="py-5" id="term_condition">
	<div class="container-fluid <?=$active_page_data['css_page_class']?>">
	    <div class="row">
			<div class="col-md-12">
				<?php
				/*if($is_show_title && $show_title == '1') { ?>
					<div class=" heading page-heading faq-heading text-center">
						<?=$page_title?>
					</div>
				<?php
				}*/ ?>
				<div class="block mt-0 pt-0">
					<?=$active_page_data['content']?>
				</div>
			</div>
	    </div>
	</div>
</section>