<?php
$tooltip_device_content = $model_data['tooltip_device'];
if ($exist_others_pro_fld <= 0) { ?>
	<div class="block text-center">
		<?php
		if ($model_data['model_img']) {
			$md_img_path = SITE_URL . 'media/images/model/' . $model_data['model_img'];
			echo '<img class="single-product-image" src="' . $md_img_path . '" alt="' . $model_data['title'] . '">';
		} ?>
	</div>
<?php
} else { ?>
	<div class="block phone-details position-relative m-detail clearfix pb-0">
		<div class="card">
			<?php
			if ($model_upto_price > 0) {
				echo '<h6 class="btn btn-secondary upto-price-button rounded-pill">' . _lang('upto_price_text', 'model_details') . ' ' . amount_fomat($model_upto_price) . '</h6>';
			} ?>

			<div class="row">
				<div class="col-md-4 phone-image-block text-center">
					<?php
					if ($model_data['model_img']) {
						$md_img_path = SITE_URL . 'media/images/model/' . $model_data['model_img'];
						echo '<img class="phone-image" src="' . $md_img_path . '" alt="' . $model_data['title'] . '">';
					}

					if ($exist_others_pro_fld > 0) {
						echo '<h4 class="device-name-dt"><span class="device_brand_name">' . $model_data['title'] . '</span> ' . ($tooltip_device_content ? '<span class="tips" data-toggle="modal" data-target="#device_info_popup"><i class="ml-1 fas fa-question-circle"></i></span>' : '') . ' </span> <span class="device-name"></span></h4>';
					}

					if ($show_instant_price_on_model_criteria_selections == '1') { ?>
						<h4 style="font-weight:normal;font-size:16px;" class="price-total show_final_amt_left"></h4>
					<?php
					} ?>

					<div class="price-promise d-flex p-4">
						<div class="image-box">
							<img class="img-fluid" src="<?=SITE_URL?>/media/images/price-promise.png" alt="price-promise">
						</div>
						<div class="content text-left">
							<h3><?=SITE_NAME?> Satisfaction Promise</h3>
							<p>Accurately describe your device and we promise the quoted value and a smooth, streamlined transaction. No bull. <a href="<?=SITE_URL?>sale-agreement">That's a promise.</a></p>
						</div>
					</div>
				</div>

				<div class="col-md-8 single_step-network-section">
					<?php
					$condition_list_arr[] = [
						"id" => "00001",
						"name" => "Condition",
						"title" => "Condition",
						"input_type" => "radio",
						"is_required" => "1",
						"sort_order" => "1",
						"tooltip" => "",
						"icon" => "",
						"product_id" => "00001",
						"type" => "condition",
						"is_conditional_field" => "0",
						"conditional_field_position" => "0",
						"exclude_fields" => "",
						"used_for_variation" => "0"
					];

					$condition_option_list_arr = [];
					foreach ($fields_options_tooltips_arr as $fot_k => $fields_options_tooltips_dt) {
						$condition_option_list_arr[] = [
							"id" => "000000" . ($fot_k + 1),
							"label" => $fields_options_tooltips_dt['title'],
							"add_sub" => "+",
							"price_type" => "0",
							"price" => "0",
							"sort_order" => "1",
							"is_default" => ($fot_k == '0' ? '1' : '0'),
							"icon" => "",
							"product_field_id" => "00001",
							"force_zero_price" => "0",
							"force_price_val" => "0",
							"tooltip_type" => "",
							"color" => "",
							"maximum_price" => "0",
							"tooltip" => $fields_options_tooltips_dt['description'],
							"video_url" => $fields_options_tooltips_dt['video_url'],
							"cond_image" => $fields_options_tooltips_dt['cond_image'],
						];
					}

					$fid = 1;
					foreach ($condition_list_arr as $row_cus_fld) {
						if (($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {
							continue;
						} ?>

						<div id="section<?= $fid ?>" data-required="<?= $row_cus_fld['is_required'] ?>" data-isdefect="0">
							<div class="h4">
								<?php
								echo $row_cus_fld['title'];
								if ($row_cus_fld['icon'] != "" && $icons_of_model_fields == '1') {
									echo '<img src="' . SITE_URL . 'media/images/model/fields/' . $row_cus_fld['icon'] . '" width="27px" class="field-icon" />';
								}
								if ($row_cus_fld['tooltip'] != "" && $tooltips_of_model_fields == '1') {
									$tooltips_data_array[] = array('tooltip' => $row_cus_fld['tooltip'], 'id' => 'p' . $row_cus_fld['id'], 'name' => $row_cus_fld['title']); ?>
									<span class="tips" data-toggle="modal" data-target="#info_popup<?= 'p' . $row_cus_fld['id'] ?>"><i class="ml-1 fas fa-question-circle"></i></span></span>
								<?php
								} ?>
							</div>
							<div class="storage-options">
								<?php
								$model_con_tooltips_arr = array();
								if ($row_cus_fld['input_type'] == "select" || $row_cus_fld['input_type'] == "radio") {
									$temp_fld_no = 1;
									if ($row_cus_fld['type'] == "condition") {
										foreach ($condition_option_list_arr as $row_cus_opt) {
											$checked = '';
											$sel_class = "";
											$tab_sel_class = "false";
											$tab_sel__content_class = "";

											$selected_con_opt_id = 0;
											if(in_array($row_cus_opt['label'],$opt_nm_arr)) {
												$checked = 'checked';
											} elseif (in_array($row_cus_opt['id'], $opt_id_array)) {
												$checked = 'checked';
												$selected_con_opt_id = $row_cus_opt['id'];
											} elseif ($temp_fld_no == $fid) {
												if ($row_cus_opt['is_default'] == 1) {
													$checked = 'checked';
													$selected_con_opt_id = $row_cus_opt['id'];
												}
											} ?>

											<div class="custom-control custom-radio custom-control-inline" id="model_details_tab">
												<input type="radio" id="<?= $row_cus_opt['id'] ?>" data-id="<?= $row_cus_opt['id'] ?>" name="condition" value="<?= $row_cus_opt['label'] ?>" <?= $checked ?> class="custom-control-input m-fields-input click-condition-radio" data-default="<?= $row_cus_opt['is_default'] ?>">
												<label class="custom-control-label" for="<?= $row_cus_opt['id'] ?>"  id="model_details_label">
													<?php
													if ($row_cus_opt['icon'] != "" && $icons_of_model_field_options == '1') {
														echo '<img src="' . SITE_URL . 'media/images/model/fields/' . $row_cus_opt['icon'] . '" id="' . $row_cus_opt['id'] . '" />';
													} else {
														echo '<span id="model_tab">' . $row_cus_opt['label'] . '</span>';
													}

													if ($tooltips_of_model_field_options == '1') {
														if ($row_cus_opt['tooltip'] || $row_cus_opt['video_url'] || $row_cus_opt['cond_image']) {
															$model_con_tooltips_arr[] = ['id' => $row_cus_opt['id'], 'text' => $row_cus_opt['tooltip'], 'selected_con_opt_id' => $selected_con_opt_id, 'video_url' => $row_cus_opt['video_url'], 'cond_image' => $row_cus_opt['cond_image']];
														}
													} ?>
												</label>
											</div>
										<?php
										}
										$temp_fld_no++;
									}
								}

								if (!empty($model_con_tooltips_arr)) {
									echo '<div class="condition-tooltips-list">';
									foreach ($model_con_tooltips_arr as $model_con_tooltips_dt) {
										echo '<div class="condition-tooltips-l condition-tooltip-' . $model_con_tooltips_dt['id'] . '" ' . ($model_con_tooltips_dt['selected_con_opt_id'] == $model_con_tooltips_dt['id'] ? 'style="display:block;"' : 'style="display:none;"') . '>' . $model_con_tooltips_dt['text'];
										if ($model_con_tooltips_dt['cond_image']) {
											echo '<div class="clearfix"></div><a href="javascript:void(0);" data-toggle="modal" data-target="#condition_examples_model"><i class="fas fa-exclamation-circle"></i> See Condition Examples</a>';
										}
										if ($model_con_tooltips_dt['video_url']) {
											echo '<div class="clearfix pt-2"></div><a href="javascript:void(0);" class="click_commonly_missed_defects_btn" data-video_url="' . $model_con_tooltips_dt['video_url'] . '"><i class="fas fa-video"></i> Watch Our Commonly Missed Defects</a>';
										}
										echo '</div>';
									}
									echo '</div>';
								} ?>

							</div>
							<span class="validation-msg validation-msg-1"></span>
						</div>
						<?php
						$fid++;
					} ?>

					<div id="section2" data-required="1" data-isdefect="0">
						<div class="storage-options">
							<label class="container-radio" for="condition_defective">
								<input <?php if(in_array("Defective/Broken or Missing parts",$opt_nm_arr)){echo 'checked="checked"';}?> type="radio" class="m-fields-input click-defect-radio" id="condition_defective" name="condition_type" value="defective">
								My Device is Defective/Broken or Missing parts
							</label>
							<br />
							<label class="container-radio" for="condition_functional">
								<input <?php if(in_array("Fully Functional & iCloud unlocked",$opt_nm_arr)){echo 'checked="checked"';}?> type="radio" class="m-fields-input click-defect-radio" id="condition_functional" name="condition_type" value="functional">
								My Device is Fully Functional & iCloud unlocked
							</label>
						</div>
						<span class="validation-msg validation-msg-2"></span>
					</div>

					<div id="section3" data-required="1" data-isdefect="1" class="mt-md-3 defect-showhide" <?php if(in_array("Defective/Broken or Missing parts",$opt_nm_arr)){echo 'style="display:block;"';}else{echo 'style="display:none;"';}?>>
						<?php
						if (!empty($defect_percentage_arr)) { ?>
							<strong style="padding-left:24px; display:block;">Use bellow check-boxes to best describe your device:</strong>
							<div class="storage-options" style="margin-top:10px;">
								<?php
								$defect_percentage_n = 1;
								foreach ($defect_percentage_arr as $defect_percentage_k => $defect_percentage_v) {
									if (!empty($defect_percentage_k)) { ?>
										<label class="container-checkbox" for="defect<?= $defect_percentage_n ?>">
											<input <?php if(in_array($defect_percentage_k,$opt_nm_arr)){echo 'checked="checked"';}?> type="checkbox" class="click-condition-checkbox m-fields-input-chkbox" id="defect<?= $defect_percentage_n ?>" name="defect[<?= $defect_percentage_k ?>]" value="<?= $defect_percentage_v ?>">
											<?= $defect_percentage_k ?>
											<?php
											if(!empty($defect_description_arr[$defect_percentage_k])) { ?>
												<a href="javascript:void(0);" data-toggle="modal" data-target="#defect_examples_model_<?=$defect_percentage_n?>">
													<i class="fas fa-exclamation-circle"></i>
												</a>
												<?php
												$cus_opt_tooltips_data_arr[] = [
																					'tooltip'=>$defect_description_arr[$defect_percentage_k], 
																					'id'=>$defect_percentage_n, 
																					'name'=>$defect_percentage_k
																				 ];
											} ?>
										</label>
										<?php
										$defect_percentage_n++;
									}
								} ?>
							</div>
							<span class="validation-msg validation-msg-3"></span>
						<?php
						} ?>
					</div>
					
					<div class="storage-options">
						<div class="block condition-tab m-0">
							<div class="show-price p-0">
								<?php
								/*if ($is_allow_multi_quantity == '1') { ?>
									<div class="row">
										<div class="col-md-12 text-center">
											<div class="number">
												<div class="quantity_detail single_step"><?= _lang('quantity_text', 'model_details') ?></div>
												<span class="minus qty-minus">
													<p>-</p>
												</span>
												<input type="text" id="pc_quantity" value="<?= $saved_quantity ?>" onkeyup="allow_only_digit(this);" />
												<span class="plus qty-plus">
													<p>+</p>
												</span>
											</div>
										</div>
									</div>
								<?php
								}*/
								
								if ($show_instant_price_on_model_criteria_selections == '1') { ?>
									<h4 class="price-total show_final_amt"></h4>
									<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
								<?php
								}
								
								if ($show_instant_price_on_model_criteria_selections != '1' || $ask_for_email_address_while_item_add_to_cart == '1' || $check_imei) { ?>
									<p><button type="button" class="btn btn-lg btn-primary show-price-popup"><?= ($show_instant_price_on_model_criteria_selections != '1' ? _lang('calculate_offer_button_text') : _lang('get_paid_button_text', 'model_details')) ?></button></p>
								<?php
								} else { ?>
									<button type="submit" class="btn btn-lg btn-primary "><?= _lang('get_paid_button_text', 'model_details') ?></button>
									<?php
									if ($is_show_accept_offer_and_add_another_device_button) { ?>
										<p><button type="submit" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" name="accept_offer"><?= _lang('accept_offer_button_text', 'model_details') ?></button></p>
									<?php
									}
								} ?>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<?php
} ?>

<?php /*?><div class="main-condation-tab block condition-tab clearfix condition-section position-relative mobile-shadow-none" <?php if ($exist_others_pro_fld > 0 && $exist_con_pro_fld > 0) {
																																																											echo 'style="display:none;"';
																																																										} ?>>
	<?php
	if ($model_upto_price > 0 && $exist_others_pro_fld <= 0) {
		echo '<h6 class="btn btn-primary upto-price-button">' . _lang('upto_price_text', 'model_details') . ' ' . amount_fomat($model_upto_price) . '</h6>';
	} ?>

	<div class="row">
		<?php
		$price_section_class = "col-md-12 col-lg-12 show-price text-center";
		if ($exist_con_pro_fld > 0) { ?>
			<div class="col-md-12 d-lg-none">
				<div class="accordion" id="accordionCondition">
					<?php
					$cus_opt_tooltips_data_array = array();
					$sql_cus_fld = "SELECT * FROM product_fields WHERE product_id = '" . $model_id . "' AND type = 'condition' ORDER BY sort_order DESC LIMIT 1";
					$exe_cus_fld = mysqli_query($db, $sql_cus_fld);
					$fid = 1;

					while ($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {

						if (($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {
							continue;
						}

						if ($row_cus_fld['input_type'] == "select" || $row_cus_fld['input_type'] == "radio" || $row_cus_fld['input_type'] == "checkbox") {
							$d_sql_cus_opt = mysqli_query($db, "SELECT * FROM product_options WHERE product_field_id = '" . $row_cus_fld['id'] . "' AND is_default='1' ORDER BY sort_order");

							$is_default_cond = mysqli_num_rows($d_sql_cus_opt);
							$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '" . $row_cus_fld['id'] . "' ORDER BY sort_order";

							$exe_cus_opt = mysqli_query($db, $sql_cus_opt);
							$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
							$temp_fld_no = 1;
							if ($no_of_dd_options > 0) {
								$c_c = 1;
								$condition_field = '';
								while ($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									$is_cond_active = '';
									if (in_array($row_cus_opt['id'], $opt_id_array)) {
										$is_cond_active = 'active';
									} elseif ($temp_fld_no == $fid && $edit_item_id <= 0) {
										if ($row_cus_opt['is_default'] == 1) {
											$is_cond_active = 'active';
										}
									}

									$con_tooltips_text = '';
									if ($tooltips_of_model_field_options == '1') {
										$field_option_tooltip_data = get_field_option_tooltip($row_cus_opt['id']);
										//if($field_option_tooltip_data['tooltip']) {
										$cus_opt_tooltips_data_array[] = array('is_cond_active' => $is_cond_active, 'tooltip' => $field_option_tooltip_data['tooltip'], 'tooltip_type' => $row_cus_opt['tooltip_type'], 'id' => $row_cus_opt['id'], 'name' => $row_cus_opt['label']);
										$con_tooltips_text = $field_option_tooltip_data['tooltip'];
										//}
									} ?>
									<div class="card">
										<div class="card-header" id="headingOne">
											<h2 class="mb-0">
												<a class="btn btn-link nav-link-mbl <?= ($is_cond_active ? '' : 'collapsed') ?>" id="v-pills-<?= $row_cus_opt['id'] ?>-tab" data-toggle="collapse" data-target="#collapse<?= $row_cus_opt['id'] ?>" aria-expanded="true" aria-controls="collapse<?= $row_cus_opt['id'] ?>" data-value="<?= $row_cus_opt['label'] . ':' . $row_cus_opt['id'] ?>:is_cond">
													<?php
													if ($row_cus_opt['icon'] != "" && $icons_of_model_field_options == '1') {
														echo '<img src="' . SITE_URL . 'media/images/model/fields/' . $row_cus_opt['icon'] . '" height="30" id="' . $row_cus_opt['id'] . '" />';
													} else {
														echo '<span>' . $row_cus_opt['label'] . '</span>';
													} ?>
												</a>
											</h2>
										</div>
										<div id="collapse<?= $row_cus_opt['id'] ?>" class="collapse <?= ($is_cond_active ? 'show' : '') ?>" aria-labelledby="headingOne" data-parent="#accordionCondition">
											<div class="card-body">
												<?= $con_tooltips_text ?>
											</div>
										</div>
									</div>
					<?php
									$c_c++;
								}
							}
						}
					} ?>
				</div>
			</div>

			<div class="col-md-12 col-lg-12 d-none d-lg-block">
				<div class="nav nav-pills nav-fill" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<?php
					$cus_opt_tooltips_data_array = array();
					$condition_dflt_name = '';
					$sql_cus_fld = "SELECT * FROM product_fields WHERE product_id = '" . $model_id . "' AND type = 'condition' ORDER BY sort_order DESC LIMIT 1";
					$exe_cus_fld = mysqli_query($db, $sql_cus_fld);
					$fid = 1;

					while ($row_cus_fld = mysqli_fetch_assoc($exe_cus_fld)) {

						if (($row_cus_fld['input_type'] == "text" && $text_field_of_model_fields == '0') || ($row_cus_fld['input_type'] == "textarea" && $text_area_of_model_fields == '0') || ($row_cus_fld['input_type'] == "datepicker" && $calendar_of_model_fields == '0') || ($row_cus_fld['input_type'] == "file" && $file_upload_of_model_fields == '0')) {

							continue;
						}

						if ($row_cus_fld['input_type'] == "select" || $row_cus_fld['input_type'] == "radio" || $row_cus_fld['input_type'] == "checkbox") {
							$d_sql_cus_opt = mysqli_query($db, "SELECT * FROM product_options WHERE product_field_id = '" . $row_cus_fld['id'] . "' AND is_default='1' ORDER BY sort_order");
							$is_default_cond = mysqli_num_rows($d_sql_cus_opt);
							$sql_cus_opt = "SELECT * FROM product_options WHERE product_field_id = '" . $row_cus_fld['id'] . "' ORDER BY sort_order";
							$exe_cus_opt = mysqli_query($db, $sql_cus_opt);
							$no_of_dd_options = mysqli_num_rows($exe_cus_opt);
							$temp_fld_no = 1;
							if ($no_of_dd_options > 0) {
								$c_c = 1;
								$condition_field = '';
								while ($row_cus_opt = mysqli_fetch_assoc($exe_cus_opt)) {
									$checked = '';
									$sel_class = "";
									$tab_sel_class = "false";
									$tab_sel__content_class = "";
									$is_cond_active = '';
									if (in_array($row_cus_opt['id'], $opt_id_array)) {
										$is_cond_active = 'active';
										$condition_dflt_name = $row_cus_opt['label'] . ':' . $row_cus_opt['id'] . ':is_cond';
									} elseif ($temp_fld_no == $fid && $edit_item_id <= 0) {
										if ($row_cus_opt['is_default'] == 1) {

											$is_cond_active = 'active';

											$condition_dflt_name = $row_cus_opt['label'] . ':' . $row_cus_opt['id'] . ':is_cond';
										}
									}

									if ($tooltips_of_model_field_options == '1') {
										$field_option_tooltip_data = get_field_option_tooltip($row_cus_opt['id']);
										//if($field_option_tooltip_data['tooltip']) {
										$cus_opt_tooltips_data_array[] = array('is_cond_active' => $is_cond_active, 'tooltip' => $field_option_tooltip_data['tooltip'], 'tooltip_type' => $row_cus_opt['tooltip_type'], 'id' => $row_cus_opt['id'], 'name' => $row_cus_opt['label']);
										//}
									}
									$condition_field = '<input type="hidden" name="' . $row_cus_fld['title'] . ':' . $row_cus_fld['id'] . '" value="' . $condition_dflt_name . '" class="condition_field">'; ?>
									<a class="nav-item nav-link <?= $is_cond_active ?>" id="v-pills-<?= $row_cus_opt['id'] ?>-tab" data-toggle="pill" href="#v-pills-<?= $row_cus_opt['id'] ?>" role="tab" aria-controls="v-pills-<?= $row_cus_opt['id'] ?>" aria-selected="true" data-value="<?= $row_cus_opt['label'] . ':' . $row_cus_opt['id'] ?>:is_cond">
										<?php
										if ($row_cus_opt['icon'] != "" && $icons_of_model_field_options == '1') {
											echo '<img src="' . SITE_URL . 'media/images/model/fields/' . $row_cus_opt['icon'] . '" height="30" id="' . $row_cus_opt['id'] . '" />';
										} else {
											echo '<span>' . $row_cus_opt['label'] . '</span>';
										} ?>
									</a>
					<?php
									$c_c++;
								}
								echo $condition_field;
							}
						}
						echo '<input type="hidden" id="is_condition_field_required" value="' . $row_cus_fld['is_required'] . '">';
					} ?>
				</div>
				<span class="condition-validation-msg"></span>
			</div>

			<div class="col-md-6 col-lg-6 d-none border-right d-lg-block">
				<div class="tab-content" id="v-pills-tabContent">
					<?php
					$c_n = 1;
					foreach ($cus_opt_tooltips_data_array as $cus_opt_tooltips_data) { ?>
						<div class="tab-pane fade <?= ($cus_opt_tooltips_data['is_cond_active'] ? 'show active' : '') ?>" id="v-pills-<?= $cus_opt_tooltips_data['id'] ?>" role="tabpanel" aria-labelledby="v-pills-<?= $cus_opt_tooltips_data['id'] ?>-tab">
							<div class="row">
								<div class="col-md-12 condition_tooltip">
									<?php
									if ($enabled_any_all_in_condition_heading == '1') {
										if ($cus_opt_tooltips_data['tooltip_type'] == "any") {
											echo '<h4 class="tooltip_title">' . _lang('any_condition_heading_text', 'model_details') . '</h4>';
										} elseif ($cus_opt_tooltips_data['tooltip_type'] == "all") {
											echo '<h4 class="tooltip_title">' . _lang('all_condition_heading_text', 'model_details') . '</h4>';
										}
									}
									echo $cus_opt_tooltips_data['tooltip']; ?>
								</div>
							</div>
						</div>
					<?php
						$c_n++;
					} ?>
				</div>
			</div>
		<?php
			$price_section_class = "col-md-12 col-lg-6 show-price text-center device_total_price";
		} ?>

		<div class="<?= $price_section_class ?> quantity_detail_main">
			<?php
			if ($is_allow_multi_quantity == '1') { ?>
				<div class="row">
					<div class="col-md-12 text-center">
						<div class="number">
							<div class="quantity_detail single_step"><?= _lang('quantity_text', 'model_details') ?></div>
							<span class="minus qty-minus">
								<p>-</p>
							</span>
							<input type="text" id="pc_quantity" value="<?= $saved_quantity ?>" onkeyup="allow_only_digit(this);" />
							<span class="plus qty-plus">
								<p>+</p>
							</span>
						</div>
					</div>
				</div>
			<?php
			}

			if ($show_instant_price_on_model_criteria_selections == '1') { ?>
				<h4 class="price-total show_final_amt"></h4>
				<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
			<?php
			}

			if ($show_instant_price_on_model_criteria_selections != '1' || $ask_for_email_address_while_item_add_to_cart == '1' || $check_imei) { ?>
				<p><button type="button" class="btn btn-lg btn-primary show-price-popup"><?= ($show_instant_price_on_model_criteria_selections != '1' ? _lang('calculate_offer_button_text') : _lang('get_paid_button_text', 'model_details')) ?></button></p>
			<?php
			} else { ?>
				<p><button type="submit" class="btn btn-lg btn-primary "><?= _lang('get_paid_button_text', 'model_details') ?></button></p>
				<?php
				if ($is_show_accept_offer_and_add_another_device_button) { ?>
					<p><button type="submit" class="btn btn-lg btn-outline-light accept-btn center_section mt-3" name="accept_offer"><?= _lang('accept_offer_button_text', 'model_details') ?></button></p>
				<?php
				}
			} ?>
		</div>
	</div>
</div><?php */?>

<div class="block condition-tab condition-section mobile_device_tab mt-4 d-lg-none clearfix m-get-paid-btns-section" <?php if ($exist_others_pro_fld > 0 && $exist_con_pro_fld > 0) {
																																																												echo 'style="display:none;"';
																																																											} ?>>
	<div class="row">
		<div class="col-md-12 show-price d-block d-lg-none text-center">
			<?php
			if ($is_allow_multi_quantity == '1') { ?>
				<div class="col-md-12 text-center">
					<span><?= _lang('quantity_text', 'model_details') ?></span> <input type="number" class="form-control" id="mb_quantity" value="<?= $saved_quantity ?>" min="1" max="999" style="width:100px;display:inline;" />
				</div>
			<?php
			}

			if ($show_instant_price_on_model_criteria_selections == '1') { ?>
				<h4 class="price-total show_final_amt"></h4>
				<h4 class="price-total apr-spining-icon" style="display:none;"></h4>
			<?php
			}

			if ($show_instant_price_on_model_criteria_selections != '1' || $ask_for_email_address_while_item_add_to_cart == '1' || $check_imei) { ?>
				<p><button type="button" class="btn btn-lg btn-primary rounded-pill show-price-popup"><?= ($show_instant_price_on_model_criteria_selections != '1' ? _lang('calculate_offer_button_text') : _lang('get_paid_button_text', 'model_details')) ?></button></p>
			<?php
			} else { ?>
				<p><button type="submit" class="btn btn-lg btn-primary rounded-pill"><?= _lang('get_paid_button_text', 'model_details') ?></button></p>
				<?php
				if ($is_show_accept_offer_and_add_another_device_button) { ?>
					<p><button type="submit" class="btn btn-lg rounded-pill btn-outline-light accept-btn mt-3" name="accept_offer"><?= _lang('accept_offer_button_text', 'model_details') ?></button></p>
			<?php
				}
			} ?>
		</div>
	</div>
</div>

<script>
	var tpj = jQuery;

	<?php
	if ($ask_for_email_address_while_item_add_to_cart == '1' && $start_your_order_with == "phone") { ?>
		var iti_ipt_pwc;
		tpj(document).ready(function($) {
			var telInput_pwc = document.querySelector("#phone_while_add_to_cart");
			iti_ipt_pwc = window.intlTelInput(telInput_pwc, {
				initialCountry: "<?= $phone_country_short_code ?>",
				allowDropdown: false,
				geoIpLookup: function(callback) {
					$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
						var countryCode = (resp && resp.country) ? resp.country : "";
						callback(countryCode);
					});
				},
				utilsScript: "<?= SITE_URL ?>assets/js/intlTelInput-utils.js" //just for formatting/placeholders etc
			});
			iti_ipt_pwc.setNumber("<?= (!empty($phone_while_add_to_cart_c_code) ? $phone_while_add_to_cart_c_code . $phone_while_add_to_cart : '') ?>");
		});
	<?php
	}

	/*if($check_imei) { ?>
function check_imei_number_form() {
	tpj(".m_validations_showhide").hide();
	var imei_number = document.getElementById("imei_number").value.trim();
	if(imei_number=="") {
		tpj("#imei_number_error_msg").show().text('<?=_lang('imei_number_field_validation_text','model_details')?>');
		return false;
	}
}
<?php
}

if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
function check_email_while_add_to_cart_form() {
	tpj(".m_validations_showhide").hide();
	<?php
	if($start_your_order_with == "email") { ?>
		var email_while_add_to_cart = document.getElementById("email_while_add_to_cart").value.trim();
		if(email_while_add_to_cart=="") {
			tpj("#email_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_email_address_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		} else if(!email_while_add_to_cart.match(mailformat)) {
			tpj("#email_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_valid_email_address_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}
	<?php
	} else { ?>
		if(document.getElementById("phone_while_add_to_cart").value.trim()=="") {
			tpj("#phone_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_phone_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}

		tpj("#phone_while_add_to_cart_c_code").val(iti_ipt_pwc.getSelectedCountryData().dialCode);
		if(!iti_ipt_pwc.isValidNumber()) {
			tpj("#phone_while_add_to_cart_error_msg").show().text('<?=_lang('ask_for_valid_phone_while_item_add_to_cart_field_validation_text','model_details')?>');
			return false;
		}
	<?php
	} ?>
}
<?php
}*/ ?>

	function check_m_details_validations(type) {
		<?php
		/*if($check_imei) { ?>
		if(type != "show-price-popup") {
			var ok = check_imei_number_form();
			if(ok == false) {
				return false;
			}
		}
	<?php
	}
	if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
		if(type != "show-price-popup") {
			var ok = check_email_while_add_to_cart_form();
			if(ok == false) {
				return false;
			}
		}
	<?php
	}*/ ?>

		tpj(".validation-msg").html("");

		//tpj("#payment_amt").val(tpj(".show_final_amt_val").html());
		var is_return = true;
		tpj('.m-fields-input').each(function(index) {
			var is_required = tpj(this).parent().parent().parent().attr("data-required");
			var is_checked = tpj(this).parent().parent().find("input:checked").length;
			var isdefect = tpj(this).parent().parent().parent().attr("data-isdefect");
			console.log('Is Defect:', isdefect);
			if (is_required == "1" && isdefect != "1") {
				if (is_checked == 0) {
					is_return = false;
					tpj(this).parent().parent().next().html("<?= _lang('fields_validation_text', 'model_details') ?>");
					return false;
				}
			}
		});

		if (tpj('#condition_defective').prop('checked')) {
			tpj('.m-fields-input-chkbox').each(function(index) {
				var is_required = tpj(this).parent().parent().parent().attr("data-required");
				var is_checked = tpj(this).parent().parent().find("input:checked").length;
				var isdefect = tpj(this).parent().parent().parent().attr("data-isdefect");
				console.log('Is Defect:', isdefect);
				console.log('Is Defect Chkd:', is_checked);
				if (is_required == "1" && isdefect == "1") {
					if (is_checked == 0) {
						is_return = false;
						tpj(this).parent().parent().next().html("<?= _lang('fields_validation_text', 'model_details') ?>");
						return false;
					}
				}
			});
		}

		<?php /*?>var is_condition_appear = tpj('#is_condition_appear').val();
	if(is_condition_appear == '1') {
		var is_condition_field_required = tpj('#is_condition_field_required').val();
		var condition_field = tpj('.condition_field').val();
		if(is_condition_field_required == '1' && condition_field == "") {
			is_return = false;
			tpj(".condition-validation-msg").html("<?=_lang('condition_field_validation_text','model_details')?>");
			return false;
		}
	}<?php */ ?>

		if (is_return == false) {
			return false;
		} else {
			return true;
		}
	}

	function get_price(mode) {
		<?php
		if ($exist_others_pro_fld > 0 && $exist_con_pro_fld > 0) { ?>
			var is_return = true;
			tpj('.m-fields-input').each(function(index) {
				var is_checked = tpj(this).parent().parent().find("input:checked").length;
				if (is_checked == 0) {
					is_return = false;
				}
			});

			if (is_return == false) {
				tpj('#is_condition_appear').val(0);
				tpj('.condition-section').hide();
			} else {
				var is_condition_appear = tpj('#is_condition_appear').val();
				tpj('#is_condition_appear').val(1);
				tpj(".condition-validation-msg").html("");
				/*if(!window.matchMedia("(max-width: 1024px)").matches) {
				 setTimeout(function() {
				 	tpj.scrollTo(tpj('.condition-section'), 1000);
				 }, 200);
				}*/

				if ((is_condition_appear != '1' && window.matchMedia("(max-width: 767px)").matches) || !window.matchMedia("(max-width: 767px)").matches) {
					setTimeout(function() {
						tpj.scrollTo(tpj('.condition-section'), 1000);
					}, 200);
				} else if (!window.matchMedia("(max-width: 1024px)").matches) {
					setTimeout(function() {
						tpj.scrollTo(tpj('.condition-section'), 1000);
					}, 200);
				}

				if (window.matchMedia("(max-width: 767px)").matches) {
					if (is_condition_appear == '1') {
						setTimeout(function() {
							tpj.scrollTo(tpj('.quantity_detail_main'), 1000);
						}, 200);
					}
				}

				tpj('.condition-section').show();
			}
		<?php
		} elseif ($exist_con_pro_fld > 0) { ?>
			tpj('#is_condition_appear').val(1);
			tpj(".condition-validation-msg").html("");
		<?php
		} ?>

		tpj.ajax({
			type: 'POST',
			url: '<?= SITE_URL ?>ajax/get_model_price.php?token=<?= get_unique_id_on_load() ?>',
			data: tpj('#model_details_form').serialize(),
			success: function(data) {
				if (data != "") {
					var resp_data = JSON.parse(data);
					var total_price = resp_data.payment_amt;
					var total_price_html = resp_data.payment_amt_html;
					tpj(".show_final_amt").show();
					tpj(".show_final_amt_left").show();
					if (resp_data.order_items) {
						tpj(".show_final_amt").html(total_price_html);
						tpj(".show_final_amt_left").html('<?php /*?><span style="font-weight:100;">Price Offered: </span><?php */?><b style="color:red;">' + total_price_html + '</b>');
						//tpj(".show_final_amt_val").html(total_price);
					} else {
						tpj(".show_final_amt").html('00<span>.00</span>');
						tpj(".show_final_amt_left").html('<?php /*?><span style="font-weight:100;">Price Offered: </span><?php */?><b style="color:red;">00<span>.00</span></b>');
						//tpj(".show_final_amt_val").html(0);
					}
					//tpj(".device-name").html(resp_data.order_items?' / '+resp_data.order_items:'');
					//if(mode == "click") {
					tpj(".device-name-dt").show();
					tpj(".device-name").html(resp_data.order_items);
					//}

					tpj(".apr-spining-icon").hide();
					tpj(".apr-spining-icon").html('');
				}
			}
		});
	}

	function price_updt_spining_icon() {
		tpj(".apr-spining-icon").html('<div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div>');
		tpj(".apr-spining-icon").show();
		tpj(".show_final_amt_left").hide();
		tpj(".show_final_amt").hide();
	}

	tpj(document).ready(function($) {
		$('#condition_defective').on('click', function(e) {
			var qty = $(".defect-showhide").show();
			$(".validation-msg").html("");
		});
		$('#condition_functional').on('click', function(e) {
			var qty = $(".defect-showhide").hide();
			$(".validation-msg").html("");
		});

		<?php
		/*if($check_imei) { ?>
	$('#imei_number').on('change keyup paste', function() {
		if($('#imei_number').val().length > 15) {
			$('#imei_number').val($('#imei_number').val().substr(0,15));
		}
	});

	$('.imei_number_check_btn').on('click', function(e) {
		var ok = check_imei_number_form();
		if(ok == false) {
			return false;
		}

		var imei_number = $("#imei_number").val();
		$(".imei_number_spining_icon").html('<?=$spining_icon_html?>');
		$(".imei_number_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/check_imei_number.php',
			data: {imei_number:imei_number, model_id:'<?=$model_long_id?>', edit_item_id:'<?=$order_item_long_id?>', cat_id:'<?=$model_data['cat_id']?>'},
			success: function(data) {
				$(".imei_number_spining_icon").html('');
				$(".imei_number_spining_icon").hide();
				var resp_data = JSON.parse(data);
				var success = resp_data.success;
				if(success) {
					$("#device_check_info").val(resp_data.html);
					<?php
					if($is_both_ask_for_email_address_and_check_imei_exist) { ?>
						$(".check_imei_showhide").hide();
						$(".email_while_add_to_cart_showhide").show();
					<?php
					} else { ?>
						$("#model_details_form").submit();
					<?php
					} ?>
				} else {
					tpj("#imei_number_error_msg").show().text(resp_data.msg);
					return false;
				}
			}
		});
		return false;
	});
	<?php
	}
	if($ask_for_email_address_while_item_add_to_cart=='1') { ?>
	$(".email_while_add_to_cart_popup").on('blur keyup change paste', 'input, select, textarea', function(event) {
		check_email_while_add_to_cart_form();
	});
	<?php
	}

	if($post_to_fb_msgr_page_id && $quote_post_to_facebook_messenger_button == '1') { ?>
	$('#post_to_fb_messenger').on('click', function(e) {
		//$("#payment_amt").val($(".show_final_amt_val").html());
		$(".post_to_fb_messenger_spining_icon").html('<?=$spining_icon_html?>');
		$(".post_to_fb_messenger_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/get_register_quote.php?type=fb_messenger',
			data: $('#model_details_form').serialize(),
			success: function(data) {
				$(".post_to_fb_messenger_spining_icon").html('');
				$(".post_to_fb_messenger_spining_icon").hide();
				var resp_data = JSON.parse(data);
				var status = resp_data.status;
				var url = resp_data.url;
				if(status && url) {
					window.open(url, '_blank');
				} else {
					alert('<?=_lang('something_went_wrong_message_text')?>');
					return false;
				}
			}
		});
	});
	<?php
	}
	if($quote_post_to_whatsapp_button == '1') { ?>
	$('#post_to_whatsapp').on('click', function(e) {
		//$("#payment_amt").val($(".show_final_amt_val").html());
		$(".post_to_whatsapp_spining_icon").html('<?=$spining_icon_html?>');
		$(".post_to_whatsapp_spining_icon").show();
		$.ajax({
			type: 'POST',
			url: '<?=SITE_URL?>ajax/get_register_quote.php?type=whatsapp',
			data: $('#model_details_form').serialize(),
			success: function(data) {
				$(".post_to_whatsapp_spining_icon").html('');
				$(".post_to_whatsapp_spining_icon").hide();
				var resp_data = JSON.parse(data);
				var status = resp_data.status;
				var url = resp_data.url;
				if(status) {
					window.open(url, '_blank');
				} else {
					alert('<?=_lang('something_went_wrong_message_text')?>');
					return false;
				}
			}
		});
	});
	<?php
	}*/ ?>

		$('.show-price-popup').on('click', function() {
			var ok = check_m_details_validations('show-price-popup');
			if (ok == false) {
				return false;
			}
			$("#ModalPriceShow").modal();
		});

		$('.nav-link, .nav-link-mbl').on('click', function() {
			var name = $(this).attr("data-value");
			$(".condition_field").val(name);
		});

		<?php
		/*if($is_allow_multi_quantity == '1') { ?>
	$('#mb_quantity').bind('keyup change', function(event) {
		var qty = $(this).val();
		if(qty<=0) {
			$('#mb_quantity').val(1);
			$('#quantity').val(1);
		} else if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#mb_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} else {
			$('#quantity').val(qty);
		}
		price_updt_spining_icon();
		setTimeout(function() {
			get_price('click');
		}, 500);
	});
	<?php
	}*/ ?>

		//, .nav-link, .nav-link-mbl
		$('.phone-details .custom-control-input, .phone-details .click-condition-checkbox, .phone-details .click-defect-radio').bind('click keyup', function(event) {
			$(".validation-msg").html("");

			price_updt_spining_icon();
			var is_required = $(this).parent().parent().parent().attr("data-required");
			var is_checked = $(this).parent().parent().find("input:checked").length;
			if (is_required == "1") {
				if (is_checked > 0) {
					$(this).parent().parent().next().html("");
				}
			}
			setTimeout(function() {
				get_price('click');
			}, 500);
		});

		<?php
		/*if($is_allow_multi_quantity == '1') { ?>
	$('.qty-minus').on('click', function(e) {
		var qty = $("#pc_quantity").val();
		if(qty<=0) {
			$('#pc_quantity').val(1);
			$('#quantity').val(1);
		} else if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#pc_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} 

		if(qty>=2) {
			var f_qty = (Number(qty) - 1);
			$('#pc_quantity').val(f_qty);
			$('#quantity').val(f_qty);
		}
		price_updt_spining_icon();
		setTimeout(function() {
			get_price();
		}, 500);
	});

	$('.qty-plus').on('click', function(e) {
		var qty = $("#pc_quantity").val();
		if(qty<=0) {
			$('#pc_quantity').val(1);
			$('#quantity').val(1);
		} else if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#pc_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} 

		if(qty<=998) {
			var f_qty = (Number(qty) + 1);
			$('#pc_quantity').val(f_qty);
			$('#quantity').val(f_qty);
		}
		price_updt_spining_icon();
		setTimeout(function() {
			get_price();
		}, 500);
	});

	$('#pc_quantity').bind('keyup change', function(e) {
		var qty = $(this).val();
		if(qty>999) {
			var tmp_qty = qty.slice(0,3);
			$('#pc_quantity').val(tmp_qty);
			$('#quantity').val(tmp_qty);
		} else {
			if(qty.trim() == "") {
				$('#pc_quantity').val(1);
				$('#quantity').val(1);
			} else {
				$('#pc_quantity').val(qty);
				$('#quantity').val(qty);
			}
		}

		price_updt_spining_icon();
		setTimeout(function() {
			get_price();
		}, 500);
	});

	$('#pc_quantity').bind('blur', function(e) {
		var qty = $(this).val();
		if(qty.trim() == "") {
			$('#pc_quantity').val(1);
			$('#quantity').val(1);
			price_updt_spining_icon();
			setTimeout(function() {
				get_price();
			}, 500);
		}
	});
	<?php
	}*/ ?>

		$(document).on('click', '.click_commonly_missed_defects_btn', function() {
			var video_url = $(this).attr("data-video_url");
			$('#commonly_missed_defects_video').attr('src', video_url);
			$('#commonly_missed_defects_model').modal('show');
		});

		$(document).on('click', '.click-condition-radio', function() {
			var id = $(this).attr("data-id");
			$('.condition-tooltips-l').hide();
			$('.condition-tooltip-' + id).show();
		});

		$(document).on('click', '.condition-tooltips', function() {
			var id = $(this).attr("data-id");
			$('#condition_tooltip_model').modal('show');
			$("#condition_tooltip_model_spining_icon").html('<div class="spining-full-wrap"><div class="spining-icon"><i class="fa fa-spinner fa-spin" style="font-size:34px;"></i></div></div>');
			$("#condition_tooltip_model_spining_icon").show();
			$.ajax({
				type: 'POST',
				url: '<?= SITE_URL ?>ajax/get_condition_tooltip_content.php?id=' + id,
				success: function(data) {
					if (data != "") {
						$('#condition_tooltip_model_content').html(data);
					}
					$("#condition_tooltip_model_spining_icon").html('');
					$("#condition_tooltip_model_spining_icon").hide();
				}
			});
			return false;
		});
	});

	setTimeout(function() {
		get_price('load');
	}, 1000);
</script>