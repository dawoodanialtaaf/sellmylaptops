<section id="shipping_options_home" <?= $section_bg_styles ?>>
	<?= $section_bg_video ?>
	<a name="shipping_options_section"></a>
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
					<?php }
					if ($section_intro_text && $section_show_intro_text == '1') {
						echo '<div class="subtitlebox" ' . $heading_text_color_style . '>' . $section_intro_text . '</div>';
					}
					if ($section_description && $section_show_description == '1') {
						echo $section_description;
					} ?>
				</div>
			</div>
		</div>
		<div class="row justify-content-center shipping_options_list_home">
			<?php
			foreach ($shipping_option_ordr_arr as $sooa_k => $sooa_v) {
				if (!empty($shipping_options_arr[$sooa_v . '_show_in_section']) && $shipping_options_arr[$sooa_v . '_show_in_section'] == '1') {
					if ($shipping_option['post_me_a_prepaid_label'] == $sooa_v) { ?>
						<div class="col-md-4 col-sm-6 col-xl-4 col-lg-4 col-12">
							<div class="shipping_option_home mt-4">
								<?php
								if ($shipping_option[$sooa_v . '_image'] != "") {
									echo '<div class="image"><img src="' . SITE_URL . '/media/images/' . $shipping_option[$sooa_v . '_image'] . '" width="200"></div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_name'] ?></h5>
								<p <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_instruction'] ?></p>
							</div>
						</div>
					<?php
					}
					if ($shipping_option['print_a_prepaid_label'] == $sooa_v) { ?>
						<div class="col-md-4 col-sm-6 col-xl-4 col-lg-4 col-12">
							<div class="shipping_option_home mt-4">
								<?php
								if ($shipping_option[$sooa_v . '_image'] != "") {
									echo '<div class="image"><img src="' . SITE_URL . '/media/images/' . $shipping_option[$sooa_v . '_image'] . '" width="200"></div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_name'] ?></h5>
								<p <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_instruction'] ?></p>
							</div>
						</div>
					<?php
					}
					if ($shipping_option['use_my_own_courier'] == $sooa_v) { ?>
						<div class="col-md-4 col-sm-6 col-xl-4 col-lg-4 col-12">
							<div class="shipping_option_home mt-4">
								<?php
								if ($shipping_option[$sooa_v . '_image'] != "") {
									echo '<div class="image"><img src="' . SITE_URL . '/media/images/' . $shipping_option[$sooa_v . '_image'] . '" width="200"></div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_name'] ?></h5>
								<p <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_instruction'] ?></p>
							</div>
						</div>
					<?php
					}
					if ($shipping_option['we_come_for_you'] == $sooa_v) { ?>
						<div class="col-md-4 col-sm-6 col-xl-4 col-lg-4 col-12">
							<div class="shipping_option_home mt-4">
								<?php
								if ($shipping_option[$sooa_v . '_image'] != "") {
									echo '<div class="image"><img src="' . SITE_URL . '/media/images/' . $shipping_option[$sooa_v . '_image'] . '" width="200"></div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_name'] ?></h5>
								<p <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_instruction'] ?></p>
							</div>
						</div>
					<?php
					}

					$store_location_list = get_store_location_list('', 'store');
					if ($shipping_option['store'] == $sooa_v && !empty($store_location_list)) { ?>
						<div class="col-md-4 col-sm-6 col-xl-4 col-lg-4 col-12">
							<div class="shipping_option_home mt-4">
								<?php
								if ($shipping_option[$sooa_v . '_image'] != "") {
									echo '<div class="image"><img src="' . SITE_URL . '/media/images/' . $shipping_option[$sooa_v . '_image'] . '" width="200"></div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_name'] ?></h5>
								<p <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_instruction'] ?></p>
							</div>
						</div>
					<?php
					}

					$starbucks_location_list = get_store_location_list('', 'starbucks');
					if ($shipping_option['starbucks'] == $sooa_v && !empty($starbucks_location_list)) { ?>
						<div class="col-md-4 col-sm-6 col-xl-4 col-lg-4 col-12">
							<div class="shipping_option_home mt-4">
								<?php
								if ($shipping_option[$sooa_v . '_image'] != "") {
									echo '<div class="image"><img src="' . SITE_URL . '/media/images/' . $shipping_option[$sooa_v . '_image'] . '" width="200"></div>';
								} ?>
								<h5 <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_name'] ?></h5>
								<p <?= $text_color_style ?>><?= $shipping_option[$sooa_v . '_instruction'] ?></p>
							</div>
						</div>
			<?php
					}
				}
			} ?>
		</div>
	</div>
</section>