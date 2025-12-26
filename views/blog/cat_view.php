<?php
//Header section
include("include/header.php"); ?>

<div class="all_blog_detail_section">
	<section class="blog clearfix multiple_post">
	  <div class="container-fluid">
		<div class="row">
		  <div class="col-xl-9 col-lg-8 col-md-8">
			<?php
			//Get blog list data based on respective cat
			get_blog_list_based_on_cat($cat_url, $blog_rm_words_limit,$page_list_limit); ?>
		  </div>
		  <?php
		  if($blog_recent_posts == '1' || $blog_categories == '1') { ?>
			<div class="col-xl-3 col-lg-4 col-md-4 right-sidebar">
				<div class="right-side_blog"> 
				  <?php
				  //Get recent posts
				  get_recent_posts($blog_recent_posts);
				  
				  //Get Catgories
				  get_blog_categories($blog_categories); ?>
				</div>  
			</div>
		  <?php
		  } ?>
		</div>
	  </div>
	</section>
</div>