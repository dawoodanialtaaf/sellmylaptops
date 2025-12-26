<section id="breadcrumb" class="<?= htmlspecialchars($active_page_data['css_page_class'] ?? 'default-class', ENT_QUOTES, 'UTF-8') ?> py-0">
    <div class="container-fluid">
        <div class="row">     
            <div class="col-md-12">
                <div class="block breadcrumb clearfix">
                    <ul class="breadcrumb m-0">
                        <!-- Home Link -->
                        <li class="breadcrumb-item">
                            <a href="<?= htmlspecialchars(SITE_URL, ENT_QUOTES, 'UTF-8') ?>">Home</a>
                        </li>
                        <!-- Blog Index Link -->
                        <li class="breadcrumb-item">
                            <a href="<?= htmlspecialchars(SITE_URL . 'blog', ENT_QUOTES, 'UTF-8') ?>">Blog</a>
                        </li>
                         <li class="breadcrumb-item active">
                          <?php 
                          // Get the current URI
                          $current_uri = rtrim($_SERVER['REQUEST_URI'], '/'); 
                          
                          // Remove the leading slash and split into parts
                          $uri_parts = explode('/', trim($current_uri, '/')); 
                          
                          // Check if 'blog' exists in the URL and get the remaining part
                          if (isset($uri_parts[0]) && $uri_parts[0] === 'blog') {
                              $current_blog_slug = $uri_parts[1] ?? ''; // Get the blog slug if it exists
                          }
                          ?>
                          
                          <!-- Display the breadcrumb with sliced parts -->
                          <a href="<?= htmlspecialchars(SITE_URL . 'blog/' . ($current_blog_slug ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                              <?= htmlspecialchars(ucwords(str_replace('-', ' ', $current_blog_slug)), ENT_QUOTES, 'UTF-8') ?>
                          </a>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="all_blog_detail_section">
<section class="blog clearfix multiple_post">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-9 col-lg-8 col-md-8">
        <?php
		//Get blog details based on slug of blog
		get_blog_details($blog_url); ?>
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

