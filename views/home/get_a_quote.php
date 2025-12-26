<!-- select 2 -->
<link rel="stylesheet" href="<?=SITE_URL?>assets/css/select2.min.css">

<section id="get_a_quote" <?=$section_bg_styles?>>
    <?=$section_bg_video?>
    <a name="request-quote"></a>
    <div class="container">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="block heading thin-title text-center">
                <?php
                if($section_title && $section_show_title == '1' || $section_sub_title && $section_show_sub_title == '1') { ?>
                    <h5>
                    <?php
                    if($section_title && $section_show_title == '1') {
                        echo $section_title;
                    }
                    if($section_sub_title && $section_show_sub_title == '1') {
                        echo ' <span '.$heading_text_color_style.'>'.$section_sub_title.'</span>';
                    } ?>
                    </h5>
                <?php
                }
                if($section_intro_text && $section_show_intro_text == '1') { 
                    echo '<div class="subtitlebox" '.$heading_text_color_style.'>'.$section_intro_text.'</div>';
                } ?>
            </div>
            <div class="block quick-search_section">
                <form method="post" id="instant_quote_form">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="quote_category" ><?=_lang('quote_form_category_label_text','home')?></label>
                           
                            <select class="form-control quote_category" name="quote_category" id="quote_category" onchange="getQuoteBrands(this.value);">
                                <option value=""> <?=_lang('quote_form_category_dropdown_default_text','home')?> </option>
                                <?php
                                foreach($quick_s_category_list as $quick_s_category_data) {
                                    echo '<option value="'.$quick_s_category_data['id'].'">'.$quick_s_category_data['title'].'</option>';
                                } ?>
                            </select>
                            <div id="quote_category_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="quote_brand"><?=_lang('quote_form_brand_label_text','home')?></label>
                            <select class="form-control" name="quote_brand" id="quote_brand" onchange="getQuoteModels(this.value);">
                                <option value=""> <?=_lang('quote_form_brand_dropdown_default_text','home')?> </option>
                            </select>
                            <span class="quote_brand_spining_icon"></span>
                            <div id="quote_brand_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="quote_model"><?=_lang('quote_form_model_label_text','home')?></label>
                            <select class="form-control select-2" name="quote_model" id="quote_model">
                                <option value=""> <?=_lang('quote_form_model_dropdown_default_text','home')?> </option>
                            </select>
                            <span class="quote_model_spining_icon"></span>
                            <div id="quote_model_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                        </div>
                    </div>
                    <div class="form-group text-center mb-0">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-lg mr-0 my-2 instant_quote_form_sbmt_btn" name="submit_quote"><?=_lang('quote_form_submit_button_text','home')?></button>
                    </div>
					<input type="hidden" name="controller" value="home">
                </form>
            </div>
        </div>
    </div>
</section>

<!-- select 2 -->
<script src="<?=SITE_URL?>assets/js/select2.min.js"></script>

<script>
function check_instant_quote_form() {
    jQuery(".m_validations_showhide").hide();				

    var quote_category = jQuery("#quote_category").val();
    var quote_brand = jQuery("#quote_brand").val();
    var quote_model = jQuery("#quote_model").val();
    if(quote_category=="") {
        jQuery("#quote_category_error_msg").show().text('<?=_lang('quote_form_category_validation_text','home')?>');
        return false;
    }
    if(quote_brand=="") {
        jQuery("#quote_brand_error_msg").show().text('<?=_lang('quote_form_brand_validation_text','home')?>');
        return false;
    }
    if(quote_model=="") {
        jQuery("#quote_model_error_msg").show().text('<?=_lang('quote_form_model_validation_text','home')?>');
        return false;
    }
}

(function ($) {
    $(function () {
        $("#instant_quote_form").on('blur keyup change paste', 'input, select, textarea', function(event) {
            check_instant_quote_form();
        });
        $(".instant_quote_form_sbmt_btn").click(function() {
            var ok = check_instant_quote_form();
            if(ok == false) {
                return false;
            }
        });
    });
})(jQuery);

function getQuoteBrands(val) {
    var cat_id = val.trim();
    if(cat_id) {
        jQuery(".quote_brand_spining_icon").html('<div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div>');
        jQuery(".quote_brand_spining_icon").show();
    
        post_data = "cat_id="+cat_id+"&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url:"ajax/get_quote_brand.php",
                data:post_data,
                success:function(data) {
                    if(data!="") {
                        $('#quote_brand').html(data);
                        $(".quote_brand_spining_icon").html('');
                        $(".quote_brand_spining_icon").hide();
        
                        $('#quote_model').html('<option value=""> <?=_lang('quote_form_model_dropdown_default_text','home')?> </option>');
                    } else {
                        alert('<?=_lang('something_went_wrong_message_text')?>');
                        return false;
                    }
                }
            });
        });
    }
}

function getQuoteModels(val) {
    var cat_id = jQuery("#quote_category").val().trim();
    var brand_id = val.trim();
    if(cat_id && brand_id) {
        jQuery(".quote_model_spining_icon").html('<div class="spining-icon"><i class="fa fa-spinner fa-spin"></i></div>');
        jQuery(".quote_model_spining_icon").show();
        
        post_data = "brand_id="+brand_id+"&cat_id="+cat_id+"&token=<?=get_unique_id_on_load()?>";
        jQuery(document).ready(function($) {
            $.ajax({
                type: "POST",
                url:"ajax/get_quote_model.php",
                data:post_data,
                success:function(data) {
                    if(data!="") {
                        $('#quote_model').html(data);
                        $(".quote_model_spining_icon").html('');
                        $(".quote_model_spining_icon").hide();
                    } else {
                        alert('<?=_lang('something_went_wrong_message_text')?>');
                        return false;
                    }
                }
            });
        });
    }
}

jQuery(window).on("load", function() {
	//Clear fields when back
	jQuery("#quote_category").val("");
	jQuery("#quote_brand").val("");
	jQuery("#quote_model").val("");
});

jQuery(document).ready(function() {
    jQuery('.select-2').select2({
        placeholder: 'Select Your Device Model',
        allowClear: true
    });
});

</script>