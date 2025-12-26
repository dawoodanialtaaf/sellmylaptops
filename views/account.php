<?php
$meta_title = "Account - Profile / My Orders / Change Password";
$active_menu = "account";

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

$tooltips_data_array = array();

$order_dlist = get_order_list_by_user_id($user_id);
$order_data_list = $order_dlist['order_list']; ?>

<section id="showAccount" class="py-0 order_page_section">
	<div class="container-fluid">	
	  <div class="block setting-page order_page_section account py-0 clearfix"> 
		<div class="row">
		  <div class="col-md-5 left-menu col-lg-4 col-xl-3">
			<?php require_once('views/account_menu.php');?>
		  </div>
		  <div class="col-12 col-sm-12 col-md-5 col-lg-8 col-xl-9 right-content">
			<div class="block heading page-heading setting-heading clearfix">
				<h3 class="float-left"><?=_lang('heading_text','orders_list')?></h3>
			</div>
			<div class="block order-list text-center">
			  <?php
			  if(!empty($order_data_list)) { ?>
			  <table id="ac_table_id" class="display">
				<thead>
				  <tr>
					<th class="no-sort"><?=_lang('column_id_text','orders_list')?></th>
					<th><?=_lang('column_date_text','orders_list')?><span></span></th>
					<th><?=_lang('column_qty_text','orders_list')?><span></span></th>
					<th><?=_lang('column_last_update_text','orders_list')?><span></span></th>
					<th class="no-sort"><?=_lang('column_status_text','orders_list')?></th>
					<th class="d-md-none"></th>
				  </tr>
				</thead>
				<tbody>
				  <?php
				  foreach($order_data_list as $order_data) {
				  $order_data = json_decode(gzdecode($order_data),true); ?>
				  <tr>
					<td><span><?=_lang('column_id_text','orders_list')?></span><a href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>"><?=$order_data['order_code']?></a></td>
					<td data-sort="<?=$order_data['date']?>"><span><?=_lang('column_date_text','orders_list')?></span><?=format_date($order_data['date'])?></td>
					<td><span><?=_lang('column_qty_text','orders_list')?></span><?=$order_data['items_quantity']?></td>
					<td><span><?=_lang('column_last_update_text','orders_list')?></span><?=($order_data['update_date']!='0000-00-00 00:00:00'?format_date($order_data['update_date']):'No updates yet')?></td>
					<td><span><?=_lang('column_status_text','orders_list')?></span>
						<label class="badge badge-danger text-light" style="background:#<?=$order_data['order_status_color']?> !important;color:#<?=$order_data['order_status_text_color']?> !important;"><small><?=replace_us_to_space($order_data['order_status_name'])?></small> <b data-toggle="modal" data-target="#order_status_popup-<?=$order_data['id']?>"><i class="fa fa-question-circle" style="color:#<?=$order_data['order_status_text_color']?> !important;"></i></b></label>
					</td>
					<td class="d-md-none"><a class="btn btn-lg btn-outline-dark rounded-pill ml-lg-5" href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>"><?=_lang('column_more_info_text','orders_list')?></a></td>
				  </tr>
				  <?php
				  } ?>
				</tbody>
			  </table>
	
			  <div class="table d-block d-md-none">
				<?php
				$pagination = new Paginator($page_list_limit,'p');
				
				$order_dlist = get_order_list_by_user_id($user_id,'',$page_list_limit,'1');
				$order_data_list = $order_dlist['order_list'];
				foreach($order_data_list as $order_data) {
					$order_data = json_decode(gzdecode($order_data),true);
					
				 $tooltips_data_array[] = array('tooltip'=>$order_data['order_status_description'], 'id'=>'order_status_popup-'.$order_data['id'], 'name'=>$order_data['order_status_name']); ?>
				<div class="tr clearfix">
				  <div class="td head"><span><?=_lang('column_id_text','orders_list')?></span><a href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>"><?=$order_data['order_code']?></a></div>
				  <div class="td"><span><?=_lang('column_date_text','orders_list')?></span><?=format_date($order_data['date'])?></div>
				  <div class="td"><span><?=_lang('column_qty_text','orders_list')?></span><?=$order_data['items_quantity']?></div>
				  <div class="td"><span><?=_lang('column_last_update_text','orders_list')?></span><?=($order_data['update_date']!='0000-00-00 00:00:00'?format_date($order_data['update_date']):'No updates yet')?></div>
				  <div class="td"><span><?=_lang('column_status_text','orders_list')?></span><span class="text-danger d-block" style="background:#<?=$order_data['order_status_color']?> !important;color:#<?=$order_data['order_status_text_color']?> !important;"><?=replace_us_to_space($order_data['order_status_name'])?></span> <b data-toggle="modal" data-target="#order_status_popup-<?=$order_data['id']?>"><i class="fa fa-question-circle" style="color:#<?=$order_data['order_status_text_color']?> !important;"></i></b></div>
				  <div class="td last"><a class="btn btn-lg btn-outline-dark rounded-pill ml-lg-5" href="<?=SITE_URL?>order/<?=$order_data['order_id'].'/'.$order_data['access_token']?>"><?=_lang('column_more_info_text','orders_list')?></a></div>
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
				echo '<h4>'._lang('no_orders_text','orders_list').'</h4>';
			  } ?>
	
			</div>
		  </div>
		</div>
	  </div>
	</div>
</section>

<?php
if(!empty($tooltips_data_array)) {
	foreach($tooltips_data_array as $tooltips_data) { ?>
		<div class="modal fade common_popup" id="<?=$tooltips_data['id']?>" role="dialog">
			<div class="modal-dialog small_dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal"><img src="<?=SITE_URL?>media/images/payment/close.png" alt=""></button>
					<div class="modal-body">
						<h3 class="title"><?=$tooltips_data['name']?></h3>
						<?=$tooltips_data['tooltip']?>
					</div>
				</div>
			</div>
		</div>
	<?php
	}
} ?>