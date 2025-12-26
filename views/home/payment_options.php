<section id="payment_options_home" <?= $section_bg_styles ?>>
	<?= $section_bg_video ?>
	<a name="payment_options_section"></a>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="block heading pb-0 mb-0 text-center">
					<?php
					if ($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
						<h3 class="pb-2" <?= $heading_text_color_style ?>>
							<?php
							if ($section_title && $section_show_title == '1') {
								echo $section_title;
							}
							if ($section_sub_title && $section_show_sub_title == '1') {
								echo ' <span ' . $heading_text_color_style . '>' . $section_sub_title . '</span>';
							} ?>
						</h3>
					<?php
					}
					if ($section_intro_text && $section_show_intro_text == '1') {
						echo '<div class="subtitlebox" ' . $heading_text_color_style . '>' . $section_intro_text . '</div>';
					}
					if ($section_description && $section_show_description == '1') {
						echo $section_description;
					} ?>
				</div>
			</div>
		</div>

		<div class="row justify-content-center payment_options_list_home">
			<?php
			foreach ($payment_option_ordr_arr as $pooa_k => $pooa_v) {
				if (!empty($payment_show_in_section_arr[$pooa_v . '_show_in_section']) && $payment_show_in_section_arr[$pooa_v . '_show_in_section'] == '1') {
					$payment_icon_img = '';
					if (!empty($payment_icon[$pooa_v . '_icon'])) {
						$payment_icon_img = '<img src="' . SITE_URL . 'media/images/payment/' . $payment_icon[$pooa_v . '_icon'] . '" width="200" alt="' . $pooa_v . '">';
					}

					if ($choosed_payment_option['bank'] == "bank" && $pooa_v == "bank") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['paypal'] == "paypal" && $pooa_v == "paypal") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['cheque'] == "cheque" && $pooa_v == "cheque") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['coupon'] == "coupon" && $pooa_v == "coupon") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['zelle'] == "zelle" && $pooa_v == "zelle") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['cash'] == "cash" && $pooa_v == "cash") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['venmo'] == "venmo" && $pooa_v == "venmo") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['amazon_gcard'] == "amazon_gcard" && $pooa_v == "amazon_gcard") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}

					if ($choosed_payment_option['cash_app'] == "cash_app" && $pooa_v == "cash_app") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['apple_pay'] == "apple_pay" && $pooa_v == "apple_pay") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['google_pay'] == "google_pay" && $pooa_v == "google_pay") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['coinbase'] == "coinbase" && $pooa_v == "coinbase") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
					<?php
					}
					if ($choosed_payment_option['facebook_pay'] == "facebook_pay" && $pooa_v == "facebook_pay") { ?>
						<div class="col-md-4 col-sm-4 col-xl-3 col-lg-3 col-6">
							<div class="shipping_option_home mt-4">
								<?php
								if ($payment_icon_img) {
									echo '<div class="image">' . $payment_icon_img . '</div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $payment_name_arr[$pooa_v . '_name'] ?></h5>
								<?php /*?><p <?=$text_color_style?>><?=(!empty($payment_instruction[$pooa_v])?$payment_instruction[$pooa_v]:"")?></p><?php */ ?>
							</div>
						</div>
			<?php
					}
				}
			} ?>
		</div>
	</div>
</section>