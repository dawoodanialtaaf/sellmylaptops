<?php
$sell_link = SITE_URL.get_inbuild_page_url('sell');

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
						<li class="breadcrumb-item active">
							<a href="javascript:void(0);"><?=$active_page_data['menu_name']?></a>
						</li>
					</ul>	
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
} ?>

<section>	
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="block heading page-heading text-center offers">
					<div class="head text-center clearfix">
						<h3><?=_lang('heading_text','offers')?><span class="text-primary"><?=_lang('sub_heading_text','offers')?></span></h3>
						<p><?=_lang('heading_desc','offers')?></p>	
					</div>  
				</div>
			</div>  	
		</div>	    
	</div>
</section>
   
<section class="offer-section offer-detail-section">		
	<div class="container">			
		<div class="row justify-content-center">				
			<?php
			$promocode_list = get_promocode_list('future');	
			if(count($promocode_list) > 0) {
				foreach($promocode_list as $promocode_data) { ?>
					<div class="col-md-4 col-lg-3 col-xl-3">	
						<div class="card">	
							<div class="card-body">	
								<?php
								if($promocode_data['image']!="") {
									echo '<img src="'.SITE_URL.'media/images/promocodes/'.$promocode_data['image'].'" alt=""/>';
								} ?>	
								<p class="discount mb-1">			
								<?php
								if($promocode_data['discount_type']=="flat") {
									echo amount_fomat($promocode_data['discount']).' OFF';
								} elseif($promocode_data['discount_type']=="percentage") {
									echo $promocode_data['discount'].'% OFF';
								} ?></p>
								<p class="mb-1"><?=$promocode_data['description']?></p>
								<p class="date mb-0"><strong>
								<?php
								if($promocode_data['never_expire'] == '1') {
									echo _lang('never_expire_text','offers');	
								} else {
									echo date("m/d/Y",strtotime($promocode_data['to_date']));
								} ?></strong></p>
								<h4 class="mb-0 pt-3"><div class="coupon"><span class="scissors">✂</span><code><?=$promocode_data['promocode']?></code></div></h4>
								<?php
								if($promocode_data['multiple_act_by_same_cust']=='1' && $promocode_data['multi_act_by_same_cust_qty']>0) {
									echo '<p class="pt-4 text-right mb-0"><small>'._lang('limited_per_customer_text','offers').'</small></p>';
								} ?>
							</div>				
						</div>		
					</div>
				<?php 
				}		
			} else { ?>
				<div class="col-md-12">
					<div class="block">
						<h3><?=_lang('no_coupons_text','offers')?></h3>
					</div>
				</div>
			<?php
			} ?>
		</div>
	</div>
</section>			
<section id="best-deals-section">			
	<div class="container">	
		<div class="row">
			<div class="col-md-12">
				<div class="block text-center clearfix">
					<img src="<?=SITE_URL?>media/images/gift_box.png" alt="">
					<h1><?=_lang('deal_heading_text','offers')?></h1>
					<h3><?=_lang('deal_sub_heading_text','offers')?></h3>
					<a href="<?=$sell_link?>" class="btn btn-primary btn-lg pl-5 pr-5 my-2"><?=_lang('deal_your_device_button_text','offers')?></a>		
				</div>
			</div>
		</div>	
	</div>		
</section>
