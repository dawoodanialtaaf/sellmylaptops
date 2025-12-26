<?php
$category_data = get_category_data($category_id);

$meta_title = $category_data['meta_title'];
$meta_desc = $category_data['meta_desc'];
$meta_keywords = $category_data['meta_keywords'];
$meta_canonical_url = $category_data['meta_canonical_url'];
$main_title = $category_data['title'];
$custom_schema = !empty($category_data['custom_schema']) ? $category_data['custom_schema'] : "";
$custom_schema_title = !empty($main_title) ? $main_title : "";
$description = $category_data['description'];

$schema_patterns = array('{$page_title}');
$schema_replacements = array($custom_schema_title);
$custom_schema = str_replace($schema_patterns, $schema_replacements, $custom_schema);
$custom_schema = str_replace($company_constants_patterns, $company_constants_replacements, $custom_schema);

// Header section
include("include/header.php");

// Breadcrumb section
?>
<section style="background:gray;" id="breadcrumb" class="<?= htmlspecialchars($active_page_data['css_page_class'] ?? 'default-class') ?> py-0">
    <div class="container-fluid">
        <div class="row">     
            <div class="col-md-12">
                <div class="block breadcrumb clearfix">
                    <ul class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="<?= SITE_URL ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="<?= htmlspecialchars(rtrim($_SERVER['REQUEST_URI'], '/')) ?>">
                                <?= ltrim(urldecode(rtrim($_SERVER['REQUEST_URI'], '/')), '/') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-10">
                  <div class="block heading page-heading text-center" >   
                        <h1>Select Your Device Brand</h1>
                    </div>
            </div>

            <div class="col-md-2">
                  <div class="block heading page-heading text-center">
                        <?php
                        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) { ?>
                            <a class="btn btn-primary back-button" href="javascript:void(0);" onclick="history.back();">
                                <?= _lang('back_button_text') ?>
                            </a>
                        <?php } ?>
                        
                    </div>
            </div>
        </div>
    </div>
</section>

<?php
// Get data from functions.php, get_brand_data_list function
$brand_data_list = get_brand_data_list($category_id);

if (count($brand_data_list) == '1') {
    if ($brand_data_list['0']['brand_sef_url']) {
        $brand_cat_url = SITE_URL . $category_data['sef_url'] . '/' . $brand_data_list['0']['brand_sef_url'];
        setRedirect($brand_cat_url, '');
        exit();
    }
}

if (count($brand_data_list) > 0) { ?>
    <section id="showCategory" class="pb-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    
                    <div class="block device-brands clearfix">
                        <div class="brand-roll justify-content-center">
                            <?php foreach ($brand_data_list as $brand_data) { ?>
                                <div class="brand">
                                    <a href="<?= SITE_URL . $category_data['sef_url'] . '/' . $brand_data['brand_sef_url'] ?>">
                                        <?php
                                        if ($brand_data['brand_image']) {
                                            $md_img_path = SITE_URL . 'media/images/brand/' . $brand_data['brand_image'];
                                            echo '<img src="' . $md_img_path . '" alt="' . $brand_data['brand_title'] . '">';
                                        }
                                        if ($brand_data['brand_show_title'] == '1') {
                                            echo '<div class="phone-info"><h3>' . $brand_data['brand_title'] . '</h3></div>';
                                        }
                                        ?>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section id="showCategory" class="pb-0 pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="block text-center">
                        <h3><?= _lang('items_not_available_text', 'brand_list') ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }

// Sections
$is_review_sec_show = $review_sec_show_in_cat_brands;
$is_why_choose_us_sec_show = $why_choose_us_sec_show_in_cat_brands;
$is_how_it_works_sec_show = $how_it_works_sec_show_in_cat_brands;
require_once('views/sections/sections.php');

if ($description != "") { ?>
    <section class="sectionbox white-bg">
        <div class="container">
            <?= $description ?>
        </div>
    </section>
<?php } ?>
</div>
