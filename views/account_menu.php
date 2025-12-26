<?php
$num_of_order = get_order_list_by_user_id($user_id)['num_of_orders']; ?>

<div class="inner clearfix">
  <ul>
	<li>
	  <a <?php if($active_menu == "account"){echo 'class="active"';}?> href="<?=SITE_URL?>account"><span><img src="<?=SITE_URL?>media/images/icons/orders.png" alt="orders"></span><?=_lang('orders_menu_name','account_menu')?> <?php if($num_of_order>0){echo '<span class="count">('.$num_of_order.')</span>';}?></a>
	</li>
	<li>
	  <a <?php if($active_menu == "coupons"){echo 'class="active"';}?> href="<?=SITE_URL?>coupons"><span><img src="<?=SITE_URL?>media/images/icons/coupon.png" alt="coupons"></span><?=_lang('coupons_menu_name','account_menu')?></a>
	</li>
	<li>
	  <a <?php if($active_menu == "profile"){echo 'class="active"';}?> href="<?=SITE_URL?>profile"><span><img src="<?=SITE_URL?>media/images/icons/setting.png" alt="settings"></span><?=_lang('settings_menu_name','account_menu')?></a>
	</li>
	<li>
	  <a <?php if($active_menu == "change_password"){echo 'class="active"';}?> href="<?=SITE_URL?>change-password"><span><img src="<?=SITE_URL?>media/images/icons/change-password.png" alt="change password"></span><?=_lang('change_password_menu_name','account_menu')?></a>
	</li>
	<li>
	  <a <?php if($active_menu == "statistics"){echo 'class="active"';}?> href="<?=SITE_URL?>statistics"><span><img src="<?=SITE_URL?>media/images/icons/statistics.png" alt="statistics"></span><?=_lang('statistics_menu_name','account_menu')?></a>
	</li>
	<?php /*?><li>
	  <a <?php if($active_menu == "bonus-system"){echo 'class="active"';}?> href="<?=SITE_URL?>bonus-system"><span><img src="<?=SITE_URL?>media/images/icons/bonus.png" alt="bonus system"></span>Bonus system</a>
	</li><?php */?>
	<li>
	  <a href="<?=SITE_URL?>?controller=logout"><span><i class="fas fa-sign-out-alt"></i></span><?=_lang('logout_link_text')?></a>
	</li>
  </ul>
 
  <?php
  /*$bonus_data = get_bonus_data_info_by_user($user_id);
  $bonus_percentage = $bonus_data['bonus_data']['percentage'];
  if($active_menu == "bonus-system" && $bonus_percentage>0) { ?>
  <div class="row get-bonus pt-4">
	<div class="col-6">
	  <img src="media/images/icons/gift-icon-large.png" alt="">
	</div>
	<div class="col-6">
	  <h4>Your bonus</h4>
	  <p><?=$bonus_percentage?>%</p>
	</div>
  </div>
  <?php
  }*/ ?>
</div>