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
                            <a href="<?= rtrim($_SERVER['REQUEST_URI']) ?>">blog</a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="all_blog_detail_section">
	<section class="main_blog_detail">
		<div class="container">
			<div class=" heading page-heading blog_head text-center">
	            <?php
				if ($active_page_data['show_title'] == '1') {
					echo '<div class="heading page-heading"><h1><strong>' . $active_page_data['title'] . '</strong></h1>';
				} ?>
			</div>
	    </div>    
	</section> 

	<section class="blog clearfix <?=$active_page_data['css_page_class']?> multiple_post">   
		<div class="container-fluid"> 
			<div class="row">
				<div class="col-xl-9 col-lg-8 col-md-8">
					<?php 
					//Get blog list data
					get_blog_list($page_list_limit, $blog_rm_words_limit, $page_url); ?>
				</div>
				<hr/>
				<?php
				if($blog_recent_posts == '1' || $blog_categories == '1') { ?>
					<div class="col-xl-3 col-lg-4 col-md-4 right-sidebar">   
						<div class="right-side_blog">     
							<?php
							//Get recent posts
							get_recent_posts($blog_recent_posts);
		
							//Get Catgories
							get_blog_categories($blog_categories);
							?>
						</div>
					</div>
				<?php
				} ?>
			</div>
		</div>
	</section>
</div>	