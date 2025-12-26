<?php
$meta_title = "My Coupons";
$active_menu = "coupons";

//Header section
include("include/header.php");

//If direct access then it will redirect to home page
if($user_id<=0) {
	setRedirect(SITE_URL);
	exit();
} elseif($user_data['status'] == '0' || empty($user_data)) {
	$is_include = 1;
	$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
	setRedirectWithMsg(SITE_URL.'?controller=logout',$msg,'warning');
	exit();
}

$promocode_list = get_promocode_list(); ?>

  <section id="showAccount" class="py-0"> 
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix">
        <div class="row">
          <div class="col-md-5 left-menu col-lg-4 col-xl-3">
          	<?php require_once('views/account_menu.php');?> 
          </div>
          <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
			<div class="block heading page-heading setting-heading clearfix">
				<h3 class="float-left"><?=_lang('heading_text','coupons_list')?></h3>
			</div>
            <div class="block order-list text-center">
			  <?php
			  if(!empty($promocode_list)) { ?>
              <table id="ac_table_id" class="display">
                <thead>
                  <tr>
                    <th class="no-sort"><?=_lang('column_code_text','coupons_list')?></th>
                    <th class="no-sort"><?=_lang('column_name_text','coupons_list')?><span></span></th>
                    <th><?=_lang('column_expiration_date_text','coupons_list')?><span></span></th>
                    <th><?=_lang('column_value_text','coupons_list')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_status_text','coupons_list')?></th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  foreach($promocode_list as $promocode_data) { ?>
				  <tr>
					<td><span><?=_lang('column_code_text','coupons_list')?></span><?=$promocode_data['promocode']?></td>
					<td><span><?=_lang('column_name_text','coupons_list')?></span><?=$promocode_data['name']?></td>
					<td data-sort="<?=($promocode_data['never_expire'] != '1'?$promocode_data['to_date']:'')?>"><span><?=_lang('column_expiration_date_text','coupons_list')?></span><?php
					if($promocode_data['never_expire'] == '1') {
						echo _lang('never_expire_text','coupons_list');
					} else {
						echo format_date($promocode_data['to_date']);
					} ?></td>
					<td><span><?=_lang('column_value_text','coupons_list')?></span><?php
					if($promocode_data['discount_type']=="flat") {
						echo amount_fomat($promocode_data['discount']).' OFF';
					} elseif($promocode_data['discount_type']=="percentage") {
						echo $promocode_data['discount'].'% OFF';
					} ?></td>
					<td><span><?=_lang('column_status_text','coupons_list')?></span>
					<?php
					if($promocode_data['never_expire'] == '1') {
						echo '<span class="badge badge-primary d-block">'._lang('active_status_text','coupons_list').'</span>';
					} elseif($promocode_data['to_date']>=date("Y-m-d")) {
						echo '<span class="badge badge-success d-block">'._lang('active_status_text','coupons_list').'</span>';
					} else {
						echo '<span class="badge badge-danger d-block">'._lang('expired_status_text','coupons_list').'</span>';
					} ?>
					</td>
				  </tr>
				  <?php
				  } ?>
                </tbody>
              </table>
			  
              <div class="table d-block d-md-none">
				  <?php
				  $pagination = new Paginator($page_list_limit,'p');

				  $promocode_list = get_promocode_list('',$page_list_limit,'1');
				  foreach($promocode_list as $promocode_data) { ?>
					<div class="tr clearfix">
					  <div class="td head"><span><?=_lang('column_code_text','coupons_list')?></span><?=$promocode_data['promocode']?></div>
					  <div class="td"><span><?=_lang('column_name_text','coupons_list')?></span><?=$promocode_data['name']?></div>
					  <div class="td"><span><?=_lang('column_expiration_date_text','coupons_list')?></span><?php
						if($promocode_data['never_expire'] == '1') {
							echo _lang('never_expire_text','coupons_list');
						} else {
							echo format_date($promocode_data['to_date']);
						} ?></div>
					  <div class="td"><span><?=_lang('column_value_text','coupons_list')?></span><?php
						if($promocode_data['discount_type']=="flat") {
							echo amount_fomat($promocode_data['discount']).' OFF';
						} elseif($promocode_data['discount_type']=="percentage") {
							echo $promocode_data['discount'].'% OFF';
						} ?></div>
					  <div class="td"><span><?=_lang('column_status_text','coupons_list')?></span><span class="text-primary d-block"><?php
						if($promocode_data['never_expire'] == '1') {
							echo '<span class="text-primary d-block">'._lang('active_status_text','coupons_list').'</span>';
						} elseif($promocode_data['to_date']>=date("Y-m-d")) {
							echo '<span class="text-primary d-block">'._lang('active_status_text','coupons_list').'</span>';
						} else {
							echo '<span class="text-danger d-block">'._lang('expired_status_text','coupons_list').'</span>';
						} ?></span></div>
					</div>
				  <?php
				  } ?>
              </div>
			  
			  <div class="d-block div-table-pagination d-md-none">
			  	<?php
			  	echo $pagination->page_links(); ?>
			  </div>
			  <?php
			  } else {
			  	echo '<h4>'._lang('no_coupons_text','coupons_list').'</h4>';
			  } ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>