<?php
$meta_title = "View Order";
$active_menu = "account";

//Header section
include("include/header.php");

//Get order batch data, path of this function (get_order_data) admin/_config/functions.php
$order_detail = get_order_data($order_id, $email = "", $access_token);
if(empty($order_detail)) {
	$msg='Direct access denied';
	setRedirectWithMsg(SITE_URL,$msg,'warning');
	exit();
}

$order_code = $order_detail['order_code'];

//Get order price based on orderID, path of this function (get_order_price) admin/_config/functions.php
$sum_of_orders = get_order_price($order_id);

//Get order item list based on orderID, path of this function (get_order_item_list) admin/_config/functions.php
$order_item_list = get_order_item_list($order_id);

$paid_amount_arr = array();
$order_payment_status_list = get_order_payment_status_log($order_id);
if(!empty($order_payment_status_list)) {
	foreach($order_payment_status_list as $order_payment_status_data) {
		$hsty_item_id = $order_payment_status_data['item_id'];
		$log_type = $order_payment_status_data['log_type'];
		if($log_type == "payment" && $order_payment_status_data['paid_amount']>0) {
			$paid_amount_arr[$hsty_item_id] = $order_payment_status_data['paid_amount'];
		}
	}
}
$sum_of_paid_order = array_sum($paid_amount_arr);

$promocode_amt = 0;
$discount_amt_label = "";
if($order_detail['promocode_id']>0 && $order_detail['promocode_amt']>0) {
	$promocode_amt = $order_detail['promocode_amt'];
	if($order_detail['discount_type']=="percentage") {
		$discount_amt_label = " (".$order_detail['discount']."%)";
	}

	$total_of_order = $sum_of_orders+$order_detail['promocode_amt'];
	$is_promocode_exist = true;
} else {
	$total_of_order = $sum_of_orders;
}
$bonus_percentage = $order_detail['bonus_percentage'];
$bonus_amount = $order_detail['bonus_amount'];
		
if(!empty($order_detail) && $order_detail['user_type'] == "guest") {
	$order_status_dt = get_order_status_data('order_status','',$order_detail['status'])['data'];

	$order_status = $order_detail['order_status_name'];
	$order_status_slug = $order_detail['order_status_slug'];
	$payment_method_details = json_decode($order_detail['payment_method_details'],true);
	
	$shipment_label_d_url = '';
	$shipment_label_url = $order_detail['shipment_label_url'];
	if($order_detail['sales_pack']=="print_a_prepaid_label" && $shipment_label_url!="") {
		$shipment_label_d_url = SITE_URL.'?controller=download&download_link='.$shipment_label_url;
	} ?>

  <section id="showCategory" class="py-0">
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix main_order_place_section">         
        <div class="row">
          <div class="col-12 right-content col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="block heading page-heading">
              <div class="d-flex justify-content-center">
                <h3><?=_lang('heading_text','order_view').$order_code?></h3>
              </div>
            </div>
            <div class="block pl-lg-0">
              <?php /*?><div class="order-progress-bar clearfix">
                <span class="shipped <?=($act_parcel_shipped?'active':'')?>"></span>
                <span class="checked <?=($act_device_checked?'active':'')?>"></span>
                <span class="paid <?=($act_order_paid?'active':'')?>"></span>
              </div><?php */?>
              <?php /*?><div class="order-status text-center">
                <div class="shipped <?=($act_parcel_shipped?'active':'')?>">
                  <img src="<?=SITE_URL?>media/images/icons/shipped.png" alt="">
                  <span><?=_lang('progress_bar_shipped_text','order_view')?></span>
                </div>
                <div class="checked <?=($act_device_checked?'active':'')?>">
                  <img src="<?=SITE_URL?>media/images/icons/chcked.png" alt="">
                  <span><?=_lang('progress_bar_checked_text','order_view')?></span>
                </div>
                <div class="paid <?=($act_order_paid?'active':'')?>">
                  <img src="<?=SITE_URL?>media/images/icons/paid.png" alt="">
                  <span><?=_lang('progress_bar_paid_text','order_view')?></span>
                </div>
              </div><?php */?>
              <table id="ac_nopage_table_id" class="display order-details">
                <thead>
                  <tr>
                    <th class="no-sort"><?=_lang('column_id_text','order_view')?></th>
                    <th class="no-sort"><?=_lang('column_date_text','order_view')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_qty_text','order_view')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_last_update_text','order_view')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_status_text','order_view')?></th>
                    <th class="d-md-none no-sort"></th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  $quantity_array = array();
				  $order_num_of_rows = count($order_item_list);
				  if($order_num_of_rows>0) {
					foreach($order_item_list as $order_item_list_data) {
						$quantity_array[] = $order_item_list_data['quantity'];
					}
				  } ?>
                  <tr>
                    <td><span><?=_lang('column_id_text','order_view')?></span><?=$order_code?></td>
                    <td><span><?=_lang('column_date_text','order_view')?></span><?=format_date($order_detail['order_date'])?></td>
                    <td><span><?=_lang('column_qty_text','order_view')?></span><?=array_sum($quantity_array)?></td>
                    <td><span><?=_lang('column_last_update_text','order_view')?></span><?=($order_detail['order_update_date']!='0000-00-00 00:00:00'?format_date($order_detail['order_update_date']):_lang('column_last_update_not_update_msg','order_view'))?></td>
                    <td><span><?=_lang('column_status_text','order_view')?></span><?=replace_us_to_space($order_status).' '.($order_status_slug == "completed" && $sum_of_paid_order>0?amount_fomat($sum_of_paid_order):'')?> <b data-toggle="modal" data-target="#order_status_popup-1"><i class="fa fa-question-circle"></i></b></td>
					<td></td>
                  </tr>
                </tbody>
              </table>
              <div class="table d-block d-md-none">
                <div class="tr clearfix">
                  <div class="td head"><span><?=_lang('column_id_text','order_view')?></span><?=$order_code?></div>
                  <div class="td"><span><?=_lang('column_date_text','order_view')?></span><?=format_date($order_detail['order_date'])?></div>
                  <div class="td"><span><?=_lang('column_qty_text','order_view')?></span><?=array_sum($quantity_array)?></div>
                  <div class="td"><span><?=_lang('column_last_update_text','order_view')?></span><?=($order_detail['order_update_date']!='0000-00-00 00:00:00'?format_date($order_detail['order_update_date']):_lang('column_last_update_not_update_msg','order_view'))?></div>
                  <div class="td"><span><?=_lang('column_status_text','order_view')?></span><span class="text-danger d-block"><?=replace_us_to_space($order_status).' '.($order_status_slug == "completed" && $sum_of_paid_order>0?amount_fomat($sum_of_paid_order):'')?> <b data-toggle="modal" data-target="#order_status_popup-1"><i class="fa fa-question-circle"></i></b></span></span></div>
				  <?php
				  $tooltips_data_array[] = array('tooltip'=>$order_status_dt['description'], 'id'=>'order_status_popup-1', 'name'=>$order_status_dt['name']); ?>
                </div>
              </div> 
            </div>
            <div class="block order-info-box order_detail_inner">  
              <div class="card">
                <div class="card-body"> 
				  <?php
				  if($order_detail['payment_method'] == "paypal" && !empty($payment_method_details['paypal_address'])) { ?>
                  <p><?=_lang('paypal_address_label_text','order_view')?><a href="javascript:void(0);"><?=$payment_method_details['paypal_address']?></a></p>
				  <?php
				  } ?>
                  <?=($order_detail['shipment_tracking_code']?'<p>'._lang('shipping_label_tracking_code_label_text','order_view').$order_detail['shipment_tracking_code']:'')?> <?=($order_detail['shipment_tracking_code']?'&nbsp; <a href="'.$shipment_label_d_url.'">'._lang('shipment_label_button_text','order_view').'</a>':'')?></p>
				  <?php
				  if($show_cust_delivery_note == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2 mr-2" href="javascript:open_window('<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id.'&access_token='.$access_token?>')"><?=_lang('delivery_note_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  }
				  if($show_cust_order_form == '1' && $order_detail['packing_slip']) { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2 mr-2" href="<?=SITE_URL?>media/pdf/<?=$order_detail['packing_slip']?>" target="_blank"><?=_lang('packing_slip_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  }
				  if($show_cust_sales_confirmation == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank"><?=_lang('receipt_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  }
				  if($order_detail['shipment_label_broker_qrcode_url']) {
				  $shipment_label_broker_qrcode_d_url = SITE_URL.'?controller=download&download_link='.$order_detail['shipment_label_broker_qrcode_url']; ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2" href="<?=$shipment_label_broker_qrcode_d_url?>"><?=_lang('label_broker_qrcode_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  } ?>
				  
                </div>
              </div>
            </div>
            <div class="block order-detail-page">
              <h3><?=_lang('ordered_devices_heading_text','order_view')?></h3>
              <table class="table table-border parent table-responsive"> 
                <tr>
                  <th class="sl"><?=_lang('ordered_devices_column_no_text','order_view')?></th> 
                  <th class="description"><?=_lang('ordered_devices_column_desc_text','order_view')?></th> 
				  <th class="quantity"><?=_lang('ordered_devices_column_qty_text','order_view')?></th>
                  <th class="price"><?=_lang('ordered_devices_column_price_text','order_view')?></th>
                  <th class="action mobile-action-show"><?=_lang('ordered_devices_column_status_text','order_view')?></th>
                </tr>
				<?php
				$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
				
				$o_n = 1;
				foreach($order_item_list as $order_item_list_data) {
				$order_item_data = get_order_item($order_item_list_data['id'],'list');
				$order_item_id = $order_item_list_data['order_item_id']; ?>
                <tr>
                  <td class="sl"><?=$order_item_id?></td>
                  <td class="description item-description-<?=$order_item_list_data['id']?>">
					<?php
					if($order_item_data['device_name']) {
						echo '<h6>'.$order_item_data['device_name'].'</h6>';
					}
					echo $order_item_data['item_name'];
					$item_images_array = json_decode($order_item_list_data['images_from_shop'],true);
					if(!empty($item_images_array)) {
						foreach($item_images_array as $ii_k=>$ii_v) {
							if($ii_v) {
								$ii_k_n=$ii_k_n+1; ?>
								<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>media/images/order/items/<?=$ii_v?>"><img src="<?=SITE_URL?>media/images/icons/image-icon.png" alt="Photo-0<?=$ii_k_n?>"><?=$ii_k_n?></a>
							<?php
							}
						}
					}
					$item_videos_array = json_decode($order_item_list_data['videos_from_shop'],true);
					if(!empty($item_videos_array)) {
						foreach($item_videos_array as $iv_k=>$iv_v) {
							if($iv_v) {
								$iv_k_n=$iv_k_n+1; ?>
								<a class="attachment-btn" target="_blank" href="<?=$iv_v?>"><img src="<?=SITE_URL?>media/images/icons/video-icon.png" alt="Video-0<?=$iv_k_n?>"><?=$iv_k_n?></a>
							<?php
							}
						}
					} ?>
                  </td>
				  <td class="quantity"><?=$order_item_list_data['quantity']?></td>
                  <td class="price">
				    <?php
					echo amount_fomat($order_item_list_data['price']);
					if($order_item_list_data['item_status'] == $price_is_reduced_order_item_status_id) {
						$item_prev_price_dt = get_item_price_of_prev_history($order_item_list_data['id']);
						echo '<small><br>Was '.amount_fomat($item_prev_price_dt['prev_price']).'</small>';
					} ?>
				  </td>
                  <td class="action mobile-action-show">
				  	<?php
					if($order_item_list_data['item_status'] == $price_is_reduced_order_item_status_id) { ?>
						<a href="<?=SITE_URL?>?controller=order&t=<?=$access_token?>&item_id=<?=$order_item_list_data['id']?>&mode=offer_accepted" class="text-success"><?=_lang('offer_accept_link_text','order_view')?></a>&nbsp;/&nbsp;<a href="<?=SITE_URL?>?controller=order&t=<?=$access_token?>&item_id=<?=$order_item_list_data['id']?>&mode=offer_rejected" class="text-danger"><?=_lang('offer_decline_link_text','order_view')?></a><br />
					<?php
					} ?>
				  	<span class="text-success"><?=replace_us_to_space($order_item_list_data['order_item_status_name'])?> <b data-toggle="modal" data-target="#order_item_status_popup-<?=$order_item_list_data['id']?>"><i class="fa fa-question-circle"></i></b></span>
				  </td>
                </tr>
				<?php
				$tooltips_data_array[] = array('tooltip'=>$order_item_list_data['order_item_status_description'], 'id'=>'order_item_status_popup-'.$order_item_list_data['id'], 'name'=>replace_us_to_space($order_item_list_data['order_item_status_name']));
				$o_n++;
				} ?>
              </table>
            </div>
			
			<?php
			$paid_order_item_status_id = get_order_status_data('order_item_status','paid')['data']['id'];
			
			$paid_order_item_list = array();
			foreach($order_item_list as $order_item_list_data) {
				if($order_item_list_data['item_status'] == $paid_order_item_status_id) {
					$paid_order_item_list[] = $order_item_list_data;
				}
			}
			if(!empty($paid_order_item_list)) { ?>
				<div class="block order-summary">
				  <table class="table">
					<tr>
					  <th></th>
					  <th colspan="2"><?=_lang('paid_devices_heading_text','order_view')?> </th>
					</tr>
					<?php
					$paid_total_amt_array = array();
					$o_n = 1;
					$paid_device_avail = false;
					foreach($paid_order_item_list as $paid_order_item_list_data) {
						$paid_device_avail = true;
						$paid_item_amount = @$paid_amount_arr[$paid_order_item_list_data['id']];
						$paid_total_amt_array[] = $paid_item_amount;
						$order_item_data = get_order_item($paid_order_item_list_data['id'],'print'); ?>
						<tr>
						  <td class="sl"><?=$o_n?></td>
						  <td><?=$paid_order_item_list_data['model_title']?></td>
						  <td><?=amount_fomat($paid_item_amount)?></td>
						</tr>
						<?php
						$o_n++;
					}
					if(!empty($paid_total_amt_array)) { ?>
						<tr>
						  <td colspan="3" class="device-total">
							<?php
							if($order_detail['payment_method'] == "paypal") { ?>
								= <?=amount_fomat(array_sum($paid_total_amt_array))?> by PayPal to <a href="javascript:void(0);"><?=$payment_method_details['paypal_address']?></a>
							<?php
							} else { ?>
								= <?=amount_fomat(array_sum($paid_total_amt_array))?> by <?=replace_us_to_space($order_detail['payment_method'])?>
							<?php
							} ?>
						  </td>
						</tr>
						
						<?php
						if($promocode_amt>0) { ?>
						<tr>
						  <td colspan="3" class="device-total">
							 <b><?=_lang('promocode_label_text','order_view')?></b> <?=$order_detail['promocode'].$discount_amt_label.' on paid device'?>
						  </td>
						</tr>
						<?php
						}
					} ?>
				  </table>
				</div>
			<?php
			} ?>
			
            <div class="block tracking-update">
              <h3><?=_lang('order_status_updates_heading_text','order_view')?></h3>
              <table class="table">
			    <?php
				$order_payment_status_list = get_order_payment_status_log($order_id);
				foreach($order_payment_status_list as $order_payment_status_data) {
					$log_type = $order_payment_status_data['log_type'];
					$order_status = isset($order_payment_status_data['order_status'])?$order_payment_status_data['order_status']:'';
					$item_status = isset($order_payment_status_data['item_status'])?$order_payment_status_data['item_status']:'';
					$shipping_method = isset($order_payment_status_data['shipping_method'])?replace_us_to_space_pmt_mthd($order_payment_status_data['shipping_method']):"";
					$status_log_date = format_date($order_payment_status_data['date']).' '.format_time($order_payment_status_data['date']);
					$item_id = $order_payment_status_data['item_id'];
					$order_item_id = $order_payment_status_data['order_item_id'];
					$shipment_tracking_code = isset($order_payment_status_data['shipment_tracking_code'])?$order_payment_status_data['shipment_tracking_code']:'';
					
					$order_item_name = "";
					if($order_payment_status_data['item_id']>0) {
						$order_item_data = get_order_item($order_payment_status_data['item_id'], 'email');
						$order_item_name = $order_item_data['item_name'];
					}
					
					$oh_const_patterns = array(
						'{$status_log_date}',
						'{$shipment_tracking_code}',
						'{$company_name}',
						'{$item_id}',
						'{$order_item_name}',
						'{$shipping_method}'
					);
					
					$oh_const_replacements = array(
						$status_log_date,
						($shipment_tracking_code?'# '.$shipment_tracking_code:''),
						$company_name,
						($order_item_id?$order_item_id:''),
						$order_item_name,
						$shipping_method
					);
					
					if($log_type == "payment") { ?>
					<tr>
					  <td>
					    <?php
						echo $status_log_date?> - <?=$company_name?> paid <?=amount_fomat($order_payment_status_data['paid_amount'])?> by <?=replace_us_to_space($order_detail['payment_method'])?> for device #<?=$order_item_id.($order_payment_status_data['transaction_id']?', transaction id: '.$order_payment_status_data['transaction_id']:'');
						$payment_receipt_array = json_decode($order_payment_status_data['payment_receipt'],true);
						if(!empty($payment_receipt_array)) {
							echo '<br>';
							$pr_v_n = 1;
							foreach($payment_receipt_array as $pr_k=>$pr_v) {
								if($pr_v) {
									$pr_v_n = $pr_v_n+1; ?>
									<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>media/images/order/payment/<?=$pr_v?>"><img src="<?=SITE_URL?>media/images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n?>"> Photo-0<?=$pr_v_n?></a>
								<?php
								}
							}
						}
						if($order_payment_status_data['cheque_photo']) { ?>
							<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>media/images/order/payment/<?=$order_payment_status_data['cheque_photo']?>"><img src="<?=SITE_URL?>media/images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n+1?>"> Photo-0<?=$pr_v_n+1?></a>
						<?php
						} ?>
					  </td>
					</tr>
					<?php
					} elseif($order_status > 0) {
						$order_status_data_for_hist = get_order_status_data('order_status',"",$order_status)['data'];
						if($order_status_data_for_hist['text_in_order_history']) {
							$order_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_status_data_for_hist['text_in_order_history']); ?>
							<tr>
							  <td>
								<?=$order_status_data_for_hist['text_in_order_history']?>
							  </td>
							</tr>
						<?php
						} else { ?>
							<tr>
							  <td>
								<?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_status_data_for_hist['name'])?> the order
							  </td>
							</tr>
						<?php
						}
					} elseif($item_status > 0) {
						$order_item_status_data_for_hist = get_order_status_data('order_item_status',"",$item_status)['data'];
						if($order_item_status_data_for_hist['text_in_order_history']) {
							$order_item_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_item_status_data_for_hist['text_in_order_history']); ?>
							<tr>
							  <td>
								<span class="d-none d-md-block"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
								<span class="d-lg-none"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
							  </td>
							</tr>
						<?php
						} else { ?>
							<tr>
							  <td>
								<span class="d-none d-md-block"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$order_item_id?></span>
								<span class="d-lg-none"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$order_item_id?></span>
							  </td>
							</tr>
						<?php
						}
					}
				} ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} elseif(!empty($order_detail)) {
	//If direct access then it will redirect to home page
	if($user_id<=0) {
		$msg='Direct access denied';
		setRedirectWithMsg(SITE_URL,$msg,'warning');
		exit();
	} elseif($user_data['status'] == '0' || empty($user_data)) {
		$is_include = 1;
		$msg='Your account is inactive or removed by shop owner so please contact with support team OR re-create account.';
		setRedirectWithMsg(SITE_URL.'?controller=logout',$msg,'warning');
		exit();
	}

	if($user_id!=$order_detail['user_id']) {
		setRedirect(SITE_URL);
		exit();
	}
	
	$order_status_dt = get_order_status_data('order_status','',$order_detail['status'])['data'];

	$order_status = $order_detail['order_status_name'];
	$order_status_slug = $order_detail['order_status_slug'];
	/*$act_parcel_shipped = false;
	$act_device_checked = false;
	$act_order_paid = false;
	if($order_status_slug == "shipped" || $order_status_slug == "delivered" || $order_status_slug == "shipment_problem") {
		$act_parcel_shipped = true;
	} elseif($order_status_slug == "processing" || $order_status_slug == "approved" || $order_status_slug == "counter_offer" || $order_status_slug == "offer_accepted" || $order_status_slug == "offer_declined") {
		$act_parcel_shipped = true;
		$act_device_checked = true;
	} elseif($order_status_slug == "returned_to_sender" || $order_status_slug == "completed" || $order_status_slug == "expired") {
		$act_parcel_shipped = true;
		$act_device_checked = true;
		$act_order_paid = true;
	}*/
	
	$payment_method_details = json_decode($order_detail['payment_method_details'],true);
	
	$shipment_label_d_url = '';
	$shipment_label_url = $order_detail['shipment_label_url'];
	if($order_detail['sales_pack']=="print_a_prepaid_label" && $shipment_label_url!="") {
		$shipment_label_d_url = SITE_URL.'?controller=download&download_link='.$shipment_label_url;
	} ?>

  <section id="showCategory" class="py-0">
    <div class="container-fluid">
      <div class="block setting-page account py-0 clearfix main_order_place_section">         
        <div class="row">  
          <div class="col-md-5 left-menu col-lg-4 col-xl-3"> 
            <?php require_once('views/account_menu.php');?>
          </div>
          <div class="col-12 right-content col-sm-12 col-md-5 col-lg-8 col-xl-9">
            <div class="block heading page-heading">
              <div class="d-flex justify-content-center">
                <h3><?=_lang('heading_text','order_view').$order_code?></h3>
              </div>
            </div>
            <div class="block pl-lg-0">
              <?php /*?><div class="order-progress-bar clearfix">
                <span class="shipped <?=($act_parcel_shipped?'active':'')?>"></span>
                <span class="checked <?=($act_device_checked?'active':'')?>"></span>
                <span class="paid <?=($act_order_paid?'active':'')?>"></span>
              </div><?php */?>
              <?php /*?><div class="order-status text-center">
                <div class="shipped <?=($act_parcel_shipped?'active':'')?>">
                  <img src="<?=SITE_URL?>media/images/icons/shipped.png" alt="">
                  <span><?=_lang('progress_bar_shipped_text','order_view')?></span>
                </div>
                <div class="checked <?=($act_device_checked?'active':'')?>">
                  <img src="<?=SITE_URL?>media/images/icons/chcked.png" alt="">
                  <span><?=_lang('progress_bar_checked_text','order_view')?></span>
                </div>
                <div class="paid <?=($act_order_paid?'active':'')?>">
                  <img src="<?=SITE_URL?>media/images/icons/paid.png" alt="">
                  <span><?=_lang('progress_bar_paid_text','order_view')?></span>
                </div>
              </div><?php */?>
              <table id="ac_nopage_table_id" class="display order-details">
                <thead>
                  <tr>
                    <th class="no-sort"><?=_lang('column_id_text','order_view')?></th>
                    <th class="no-sort"><?=_lang('column_date_text','order_view')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_qty_text','order_view')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_last_update_text','order_view')?><span></span></th>
                    <th class="no-sort"><?=_lang('column_status_text','order_view')?></th>
                    <th class="d-md-none no-sort"></th>
                  </tr>
                </thead>
                <tbody>
				  <?php
				  $quantity_array = array();
				  $order_num_of_rows = count($order_item_list);
				  if($order_num_of_rows>0) {
					foreach($order_item_list as $order_item_list_data) {
						$quantity_array[] = $order_item_list_data['quantity'];
					}
				  } ?>
                  <tr>
                    <td><span><?=_lang('column_id_text','order_view')?></span><?=$order_code?></td>
                    <td><span><?=_lang('column_date_text','order_view')?></span><?=format_date($order_detail['order_date'])?></td>
                    <td><span><?=_lang('column_qty_text','order_view')?></span><?=array_sum($quantity_array)?></td>
                    <td><span><?=_lang('column_last_update_text','order_view')?></span><?=($order_detail['order_update_date']!='0000-00-00 00:00:00'?format_date($order_detail['order_update_date']):_lang('column_last_update_not_update_msg','order_view'))?></td>
                    <td><span><?=_lang('column_status_text','order_view')?></span><?=replace_us_to_space($order_status).' '.($order_status_slug == "completed" && $sum_of_paid_order>0?amount_fomat($sum_of_paid_order):'')?> <b data-toggle="modal" data-target="#order_status_popup-1"><i class="fa fa-question-circle"></i></b></td>
					<td></td>
                  </tr>
                </tbody>
              </table>
              <div class="table d-block d-md-none">
                <div class="tr clearfix">
                  <div class="td head"><span><?=_lang('column_id_text','order_view')?></span><?=$order_code?></div>
                  <div class="td"><span><?=_lang('column_date_text','order_view')?></span><?=format_date($order_detail['order_date'])?></div>
                  <div class="td"><span><?=_lang('column_qty_text','order_view')?></span><?=array_sum($quantity_array)?></div>
                  <div class="td"><span><?=_lang('column_last_update_text','order_view')?></span><?=($order_detail['order_update_date']!='0000-00-00 00:00:00'?format_date($order_detail['order_update_date']):_lang('column_last_update_not_update_msg','order_view'))?></div>
                  <div class="td"><span><?=_lang('column_status_text','order_view')?></span><span class="text-danger d-block"><?=replace_us_to_space($order_status).' '.($order_status_slug == "completed" && $sum_of_paid_order>0?amount_fomat($sum_of_paid_order):'')?> <b data-toggle="modal" data-target="#order_status_popup-1"><i class="fa fa-question-circle"></i></b></span></span></div>
				  <?php
				  $tooltips_data_array[] = array('tooltip'=>$order_status_dt['description'], 'id'=>'order_status_popup-1', 'name'=>$order_status_dt['name']); ?>
                </div>
              </div> 
            </div>
            <div class="block order-info-box order_detail_inner">  
              <div class="card">
                <div class="card-body"> 
				  <?php
				  if($order_detail['payment_method'] == "paypal" && !empty($payment_method_details['paypal_address'])) { ?>
                  <p><?=_lang('paypal_address_label_text','order_view')?><a href="javascript:void(0);"><?=$payment_method_details['paypal_address']?></a></p>
				  <?php
				  } ?>
                  <?=($order_detail['shipment_tracking_code']?'<p>'._lang('shipping_label_tracking_code_label_text','order_view').$order_detail['shipment_tracking_code']:'')?> <?=($order_detail['shipment_tracking_code']?'&nbsp; <a href="'.$shipment_label_d_url.'">'._lang('shipment_label_button_text','order_view').'</a>':'')?></p>
				  <?php
				  if($show_cust_delivery_note == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2 mr-2" href="javascript:open_window('<?=SITE_URL?>views/print/print_delivery_note.php?order_id=<?=$order_id.'&access_token='.$access_token?>')"><?=_lang('delivery_note_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  }
				  if($show_cust_order_form == '1' && $order_detail['packing_slip']) { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2 mr-2" href="<?=SITE_URL?>media/pdf/<?=$order_detail['packing_slip']?>" target="_blank"><?=_lang('packing_slip_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  }
				  if($show_cust_sales_confirmation == '1') { ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2" href="<?=SITE_URL?>views/print/sales_confirmation.php?order_id=<?=$order_id.'&access_token='.$access_token?>" target="_blank"><?=_lang('receipt_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  }
				  if($order_detail['shipment_label_broker_qrcode_url']) {
				  $shipment_label_broker_qrcode_d_url = SITE_URL.'?controller=download&download_link='.$order_detail['shipment_label_broker_qrcode_url']; ?>
				  <a class="btn btn-primary btn-lg rounded-pill mb-2 mb-md-2" href="<?=$shipment_label_broker_qrcode_d_url?>"><?=_lang('label_broker_qrcode_button_text','order_view')?> <i class="fas fa-download"></i></a>
				  <?php
				  } ?>
				  
                </div>
              </div>
            </div>
            <div class="block order-detail-page">
              <h3><?=_lang('ordered_devices_heading_text','order_view')?></h3>
              <table class="table table-border parent table-responsive"> 
                <tr>
                  <th class="sl"><?=_lang('ordered_devices_column_no_text','order_view')?></th> 
                  <th class="description"><?=_lang('ordered_devices_column_desc_text','order_view')?></th> 
				  <th class="quantity"><?=_lang('ordered_devices_column_qty_text','order_view')?></th>
                  <th class="price"><?=_lang('ordered_devices_column_price_text','order_view')?></th>
                  <th class="action mobile-action-show"><?=_lang('ordered_devices_column_status_text','order_view')?></th>
                </tr>
				<?php
				$price_is_reduced_order_item_status_id = get_order_status_data('order_item_status','price-is-reduced')['data']['id'];
				
				$o_n = 1;
				foreach($order_item_list as $order_item_list_data) {
				$order_item_data = get_order_item($order_item_list_data['id'],'list');
				$order_item_id = $order_item_list_data['order_item_id']; ?>
                <tr>
                  <td class="sl"><?=$order_item_id?></td>
                  <td class="description item-description-<?=$order_item_list_data['id']?>">
					<?php
					if($order_item_data['device_name']) {
						echo '<h6>'.$order_item_data['device_name'].'</h6>';
					}
					echo $order_item_data['item_name'];
					$item_images_array = json_decode($order_item_list_data['images_from_shop'],true);
					if(!empty($item_images_array)) {
						foreach($item_images_array as $ii_k=>$ii_v) {
							if($ii_v) {
								$ii_k_n=$ii_k_n+1; ?>
								<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>media/images/order/items/<?=$ii_v?>"><img src="<?=SITE_URL?>media/images/icons/image-icon.png" alt="Photo-0<?=$ii_k_n?>"><?=$ii_k_n?></a>
							<?php
							}
						}
					}
					$item_videos_array = json_decode($order_item_list_data['videos_from_shop'],true);
					if(!empty($item_videos_array)) {
						foreach($item_videos_array as $iv_k=>$iv_v) {
							if($iv_v) {
								$iv_k_n=$iv_k_n+1; ?>
								<a class="attachment-btn" target="_blank" href="<?=$iv_v?>"><img src="<?=SITE_URL?>media/images/icons/video-icon.png" alt="Video-0<?=$iv_k_n?>"><?=$iv_k_n?></a>
							<?php
							}
						}
					} ?>
                  </td>
				  <td class="quantity"><?=$order_item_list_data['quantity']?></td>
                  <td class="price">
				    <?php
					echo amount_fomat($order_item_list_data['price']);
					if($order_item_list_data['item_status'] == $price_is_reduced_order_item_status_id) {
						$item_prev_price_dt = get_item_price_of_prev_history($order_item_list_data['id']);
						echo '<small><br>Was '.amount_fomat($item_prev_price_dt['prev_price']).'</small>';
					} ?>
				  </td>
                  <td class="action mobile-action-show">
				  	<?php
					if($order_item_list_data['item_status'] == $price_is_reduced_order_item_status_id) { ?>
						<a href="<?=SITE_URL?>?controller=order&t=<?=$access_token?>&item_id=<?=$order_item_list_data['id']?>&mode=offer_accepted" class="text-success"><?=_lang('offer_accept_link_text','order_view')?></a>&nbsp;/&nbsp;<a href="<?=SITE_URL?>?controller=order&t=<?=$access_token?>&item_id=<?=$order_item_list_data['id']?>&mode=offer_rejected" class="text-danger"><?=_lang('offer_decline_link_text','order_view')?></a><br />
					<?php
					} ?>
				  	<span class="text-success"><?=replace_us_to_space($order_item_list_data['order_item_status_name'])?> <b data-toggle="modal" data-target="#order_item_status_popup-<?=$order_item_list_data['id']?>"><i class="fa fa-question-circle"></i></b></span>
				  </td>
                </tr>
				<?php
				$tooltips_data_array[] = array('tooltip'=>$order_item_list_data['order_item_status_description'], 'id'=>'order_item_status_popup-'.$order_item_list_data['id'], 'name'=>replace_us_to_space($order_item_list_data['order_item_status_name']));
				$o_n++;
				} ?>
              </table>
            </div>
			
			<?php
			$paid_order_item_status_id = get_order_status_data('order_item_status','paid')['data']['id'];
			
			$paid_order_item_list = array();
			foreach($order_item_list as $order_item_list_data) {
				if($order_item_list_data['item_status'] == $paid_order_item_status_id) {
					$paid_order_item_list[] = $order_item_list_data;
				}
			}
			if(!empty($paid_order_item_list)) { ?>
				<div class="block order-summary">
				  <table class="table">
					<tr>
					  <th></th>
					  <th colspan="2"><?=_lang('paid_devices_heading_text','order_view')?> </th>
					</tr>
					<?php
					$paid_total_amt_array = array();
					$o_n = 1;
					$paid_device_avail = false;
					foreach($paid_order_item_list as $paid_order_item_list_data) {
						$paid_device_avail = true;
						$paid_item_amount = @$paid_amount_arr[$paid_order_item_list_data['id']];
						$paid_total_amt_array[] = $paid_item_amount;
						$order_item_data = get_order_item($paid_order_item_list_data['id'],'print'); ?>
						<tr>
						  <td class="sl"><?=$o_n?></td>
						  <td><?=$paid_order_item_list_data['model_title']?></td>
						  <td><?=amount_fomat($paid_item_amount)?></td>
						</tr>
						<?php
						$o_n++;
					}
					if(!empty($paid_total_amt_array)) { ?>
						<tr>
						  <td colspan="3" class="device-total">
							<?php
							if($order_detail['payment_method'] == "paypal") { ?>
								= <?=amount_fomat(array_sum($paid_total_amt_array))?> by PayPal to <a href="javascript:void(0);"><?=$payment_method_details['paypal_address']?></a>
							<?php
							} else { ?>
								= <?=amount_fomat(array_sum($paid_total_amt_array))?> by <?=replace_us_to_space($order_detail['payment_method'])?>
							<?php
							} ?>
						  </td>
						</tr>
						
						<?php
						if($promocode_amt>0) { ?>
						<tr>
						  <td colspan="3" class="device-total">
							 <b><?=_lang('promocode_label_text','order_view')?></b> <?=$order_detail['promocode'].$discount_amt_label.' on paid device'?>
						  </td>
						</tr>
						<?php
						}
					} ?>
				  </table>
				</div>
			<?php
			} ?>
			
            <div class="block tracking-update">
              <h3><?=_lang('order_status_updates_heading_text','order_view')?></h3>
              <table class="table">
			    <?php
				$order_payment_status_list = get_order_payment_status_log($order_id);
				foreach($order_payment_status_list as $order_payment_status_data) {
					$log_type = $order_payment_status_data['log_type'];
					$order_status = isset($order_payment_status_data['order_status'])?$order_payment_status_data['order_status']:'';
					$item_status = isset($order_payment_status_data['item_status'])?$order_payment_status_data['item_status']:'';
					$shipping_method = isset($order_payment_status_data['shipping_method'])?replace_us_to_space_pmt_mthd($order_payment_status_data['shipping_method']):"";
					$status_log_date = format_date($order_payment_status_data['date']).' '.format_time($order_payment_status_data['date']);
					$item_id = $order_payment_status_data['item_id'];
					$order_item_id = $order_payment_status_data['order_item_id'];
					$shipment_tracking_code = isset($order_payment_status_data['shipment_tracking_code'])?$order_payment_status_data['shipment_tracking_code']:'';
					
					$order_item_name = "";
					if($order_payment_status_data['item_id']>0) {
						$order_item_data = get_order_item($order_payment_status_data['item_id'], 'email');
						$order_item_name = $order_item_data['item_name'];
					}
					
					$oh_const_patterns = array(
						'{$status_log_date}',
						'{$shipment_tracking_code}',
						'{$company_name}',
						'{$item_id}',
						'{$order_item_name}',
						'{$shipping_method}'
					);
					
					$oh_const_replacements = array(
						$status_log_date,
						($shipment_tracking_code?'# '.$shipment_tracking_code:''),
						$company_name,
						($order_item_id?$order_item_id:''),
						$order_item_name,
						$shipping_method
					);
					
					if($log_type == "payment") { ?>
					<tr>
					  <td>
					    <?php
						echo $status_log_date?> - <?=$company_name?> paid <?=amount_fomat($order_payment_status_data['paid_amount'])?> by <?=replace_us_to_space($order_detail['payment_method'])?> for device #<?=$order_item_id.($order_payment_status_data['transaction_id']?', transaction id: '.$order_payment_status_data['transaction_id']:'');
						$payment_receipt_array = json_decode($order_payment_status_data['payment_receipt'],true);
						if(!empty($payment_receipt_array)) {
							echo '<br>';
							$pr_v_n = 1;
							foreach($payment_receipt_array as $pr_k=>$pr_v) {
								if($pr_v) {
									$pr_v_n = $pr_v_n+1; ?>
									<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>media/images/order/payment/<?=$pr_v?>"><img src="<?=SITE_URL?>media/images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n?>"> Photo-0<?=$pr_v_n?></a>
								<?php
								}
							}
						}
						if($order_payment_status_data['cheque_photo']) { ?>
							<a class="attachment-btn" target="_blank" href="<?=SITE_URL?>media/images/order/payment/<?=$order_payment_status_data['cheque_photo']?>"><img src="<?=SITE_URL?>media/images/icons/image-icon.png" alt="Photo-0<?=$pr_v_n+1?>"> Photo-0<?=$pr_v_n+1?></a>
						<?php
						} ?>
					  </td>
					</tr>
					<?php
					} elseif($order_status > 0) {
						$order_status_data_for_hist = get_order_status_data('order_status',"",$order_status)['data'];
						if($order_status_data_for_hist['text_in_order_history']) {
							$order_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_status_data_for_hist['text_in_order_history']); ?>
							<tr>
							  <td>
								<?=$order_status_data_for_hist['text_in_order_history']?>
							  </td>
							</tr>
						<?php
						} else { ?>
							<tr>
							  <td>
								<?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_status_data_for_hist['name'])?> the order
							  </td>
							</tr>
						<?php
						}
					} elseif($item_status > 0) {
						$order_item_status_data_for_hist = get_order_status_data('order_item_status',"",$item_status)['data'];
						if($order_item_status_data_for_hist['text_in_order_history']) {
							$order_item_status_data_for_hist['text_in_order_history'] = str_replace($oh_const_patterns, $oh_const_replacements, $order_item_status_data_for_hist['text_in_order_history']); ?>
							<tr>
							  <td>
								<span class="d-none d-md-block"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
								<span class="d-lg-none"><?=$order_item_status_data_for_hist['text_in_order_history']?></span>
							  </td>
							</tr>
						<?php
						} else { ?>
							<tr>
							  <td>
								<span class="d-none d-md-block"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$order_item_id?></span>
								<span class="d-lg-none"><?=$status_log_date?> - <?=$company_name?> <?=replace_us_to_space($order_item_status_data_for_hist['name'])?> for device #<?=$order_item_id?></span>
							  </td>
							</tr>
						<?php
						}
					}
				} ?>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
}

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
} ?>

<script language="javascript" type="text/javascript">
function open_window(url) {
	window.open(url,"Loading",'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,width=1000,height=800');
}
</script>
