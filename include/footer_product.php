<?php
$footer_top_bg_color = 'class="footer-top-bg-color"';
$footer_copyright_bg_color = 'footer-copyright-bg-color';
$footer_bottom_bg_color = 'class="footer-bottom-bg-color"';


$footer_bg_image_style = "";
if($settings['footer_bg_image']) {
   $footer_top_bg_color = ''; $footer_copyright_bg_color = ''; $footer_bottom_bg_color = '';
   $footer_bg_image_style = 'style="background:url('.SITE_URL.'media/images/'.$settings['footer_bg_image'].') no-repeat 0 0; background-size:cover;"';
} ?>


<footer <?=$footer_bg_image_style?>>
   <?php
   if($hide_footer_top_bar != '1') { ?>
   <div id="top" <?=$footer_top_bg_color?>>
       <div class="container-fluid">
           <div class="block">
               <div class="row">
                 <?php
                 if($footer_logo_url || $company_description || $socials_link) { ?>
                     <div class="col-6 col-lg-3 col-md-6 footer-logo">
                         <?php
                         //Footer logo
                         if($footer_logo_url) {
                           echo '<div class="footer-logo mb-3"><img src="'.$footer_logo_url.'" width="'.$footer_logo_width.'" height="'.$footer_logo_height.'" alt="'.SITE_NAME.'"></div>';
                         }
          
                         //Company description
                         if($company_description) {
                             echo $company_description;
                         }
          
                         //START for socials link
                         if($socials_link) { ?>
                         <div class="social text-center">
                           <h5><?=_lang('follow_us_heading_text','footer')?></h5>
                           <ul class="list-inline">
                               <?=$socials_link?>
                           </ul>
                         </div>
                         <?php
                         } //END for socials link ?>
                     </div>
                 <?php
                 }
                
                 if($site_phone || $site_email || $company_address) { ?>
                     <div class="col-6 col-lg-3 col-md-6">
                       <div class="">
                         <div class="customer_support">
                           <?php
                           if($site_phone || $site_email) { ?>
                           <h5><?=_lang('customer_support_heading_text','footer')?></h5> 
                           <ul>
                               <?php
                               if($site_phone) { ?>
                                   <li><a class="border-0" href="tel:<?=$site_phone?>"><?=$site_phone?></a></li>
                               <?php
                               }
                               if($site_email) { ?>
                                   <li><a class="border-0" href="mailto:<?=$site_email?>"><?=$site_email?></a></li>
                               <?php
                               } ?>
                           </ul>
                           <?php
                           }
                           if($company_address) { ?>
                           <h5 class="mt-3"><?=_lang('address_heading_text','footer')?></h5>
                           <ul class="mt-2 our_address_section">
                               <li>
                                   <?php
                                   if($company_address) {
                                       echo $company_address;
                                   }
                                   if($company_city || $company_state || $company_zipcode || $company_country) {
                                       echo '<br />'.trim($company_city.' '.$company_state.' '.$company_zipcode.'<br>'.strtoupper($company_country));
                                   } ?>
                               </li>
                           </ul>
                           <?php
                           } ?>
                         </div>
                       </div>
                     </div>
                 <?php
                 }
                
                 if($is_act_footer_menu_column1 == '1') {
                     $footercolumn1_menu_list = get_menu_list('footer_column1');
                     if(!empty($footercolumn1_menu_list)) { ?>
                         <div class="col-6 col-lg-3 col-md-6">
                           <div class="company">
                               <h5><?=$footer_menu_column1_title?></h5>
                               <ul>
                                 <?php
                                 foreach($footercolumn1_menu_list as $footercolumn1_menu_data) {
                                     $is_open_new_window = $footercolumn1_menu_data['is_open_new_window'];
                                     if($footercolumn1_menu_data['page_id']>0) {
                                         $menu_url = $footercolumn1_menu_data['p_url'];
                                     } else {
                                         $menu_url = $footercolumn1_menu_data['url'];
                                     }
      
                                     $is_custom_url = $footercolumn1_menu_data['is_custom_url'];
                                     $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
                                     $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
      
                                     $menu_fa_icon = "";
                                     if($footercolumn1_menu_data['css_menu_fa_icon']) {
                                         $menu_fa_icon = '&nbsp;<i class="'.$footercolumn1_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
                                     }
      
                                     $f_fix_menu_popup = "";
                                     if($footercolumn1_menu_data['menu_name'] == "Contact us") {
                                         $f_fix_menu_popup = 'data-toggle="modal" data-target="#contactusForm"';
                                     } ?>
      
                                     <li <?=(!empty($footercolumn1_menu_data['submenu'])?'class="submenu"':'')?>>
                                       <a class="<?=$footercolumn1_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window.$f_fix_menu_popup?>><?=$footercolumn1_menu_data['menu_name'].$menu_fa_icon?></a>
      
                                       <?php
                                       if(!empty($footercolumn1_menu_data['submenu'])) {
                                           $footercolumn1_submenu_list = $footercolumn1_menu_data['submenu']; ?>
                                           <ul>
                                               <?php
                                               foreach($footercolumn1_submenu_list as $footercolumn1_submenu_data) {
                                                   $s_is_open_new_window = $footercolumn1_submenu_data['is_open_new_window'];
                                                   if($footercolumn1_submenu_data['page_id']>0) {
                                                       $s_menu_url = $footercolumn1_submenu_data['p_url'];
                                                   } else {
                                                       $s_menu_url = $footercolumn1_submenu_data['url'];
                                                   }
      
                                                   $s_is_custom_url = $footercolumn1_submenu_data['is_custom_url'];
                                                   $s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
                                                   $s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
      
                                                   $submenu_fa_icon = "";
                                                   if($footercolumn1_submenu_data['css_menu_fa_icon']) {
                                                       $submenu_fa_icon = '&nbsp;<i class="'.$footercolumn1_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
                                                   } ?>
      
                                                   <li><a href="<?=$s_menu_url?>" class="<?=$footercolumn1_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn1_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
                                               <?php
                                               } ?>
                                           </ul>
                                       <?php
                                       } ?>
                                     </li>
                                 <?php
                                 } ?>
                               </ul>
                             </div>
                         </div>
                     <?php
                     }
                 }
      
                 if($is_act_footer_menu_column2 == '1') {
                     $footercolumn2_menu_list = get_menu_list('footer_column2');
                     if(!empty($footercolumn2_menu_list)) { ?>
                         <div class="col-6 col-lg-3 col-md-6">
                           <div class="">
                             <div class="marketing-collaboration">
                               <h5><?=$footer_menu_column2_title?></h5>
                               <ul>
                                 <?php
                                 foreach($footercolumn2_menu_list as $footercolumn2_menu_data) {
                                     $is_open_new_window = $footercolumn2_menu_data['is_open_new_window'];
                                     if($footercolumn2_menu_data['page_id']>0) {
                                         $menu_url = $footercolumn2_menu_data['p_url'];
                                     } else {
                                         $menu_url = $footercolumn2_menu_data['url'];
                                     }
                                     $is_custom_url = $footercolumn2_menu_data['is_custom_url'];
                                     $menu_url = ($is_custom_url>0?$menu_url:SITE_URL.$menu_url);
                                     $is_open_new_window = ($is_open_new_window>0?'target="_blank"':'');
      
                                     $menu_fa_icon = "";
                                     if($footercolumn2_menu_data['css_menu_fa_icon']) {
                                         $menu_fa_icon = '&nbsp;<i class="'.$footercolumn2_menu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
                                     }
                                     $f_fix_menu_popup = "";
                                     if($footercolumn2_menu_data['menu_name'] == "Contact us") {
                                         $f_fix_menu_popup = 'data-toggle="modal" data-target="#contactusForm"';
                                     } ?>
                                     <li <?=(!empty($footercolumn2_menu_data['submenu'])?'class="submenu"':'')?>>
                                       <a class="<?=$footercolumn2_menu_data['css_menu_class']?>" href="<?=$menu_url?>" <?=$is_open_new_window.$f_fix_menu_popup?>><?=$footercolumn2_menu_data['menu_name'].$menu_fa_icon?></a>
                                       <?php
                                       if(!empty($footercolumn2_menu_data['submenu'])) {
                                           $footercolumn2_submenu_list = $footercolumn2_menu_data['submenu']; ?>
                                           <ul>
                                               <?php
                                               foreach($footercolumn2_submenu_list as $footercolumn2_submenu_data) {
                                                   $s_is_open_new_window = $footercolumn2_submenu_data['is_open_new_window'];
                                                   if($footercolumn2_submenu_data['page_id']>0) {
                                                       $s_menu_url = $footercolumn2_submenu_data['p_url'];
                                                   } else {
                                                       $s_menu_url = $footercolumn2_submenu_data['url'];
                                                   }
                                                   $s_is_custom_url = $footercolumn2_submenu_data['is_custom_url'];
                                                   $s_menu_url = ($s_is_custom_url>0?$s_menu_url:SITE_URL.$s_menu_url);
                                                   $s_is_open_new_window = ($s_is_open_new_window>0?'target="_blank"':'');
                                                   $submenu_fa_icon = "";
                                                   if($footercolumn2_submenu_data['css_menu_fa_icon']) {
                                                       $submenu_fa_icon = '&nbsp;<i class="'.$footercolumn2_submenu_data['css_menu_fa_icon'].'" aria-hidden="true"></i>';
                                                   } ?>
                                                   <li><a href="<?=$s_menu_url?>" class="<?=$footercolumn2_submenu_data['css_menu_class']?>" <?=$s_is_open_new_window?>><?=$footercolumn2_submenu_data['menu_name'].$submenu_fa_icon?></a></li>
                                               <?php
                                               } ?>
                                           </ul>
                                       <?php
                                       } ?>
                                     </li>
                                 <?php
                                 } ?>
                               </ul>
                             </div>
                           </div>
                         </div>
                    <?php
                    }
                 } ?>
               </div>
           </div>
       </div>
   </div>
   <?php
   }


   if($copyright) { ?>
   <div id="copyright" class="py-1 <?=$footer_copyright_bg_color?>">
       <div class="container-fluid">
       <div class="row">
         <div class="col-md-12">
           <div class="block copyright text-center">  
               <?='<p class="my-2">'.$copyright.'</p>'?>
           </div>
         </div>    
       </div> 
       </div>                    
   </div>
   <?php
   }


   if($footer_devices_menus == '1') {
       $f_model_series_data_list = get_f_model_series_data_list();


       $model_series_data_exist = false;
       foreach($f_model_series_data_list as $pre_f_model_series_data) {
           $ft_model_data_list = get_f_model_data_list($pre_f_model_series_data['id']);
           if(!empty($ft_model_data_list)) {
               $model_series_data_exist = true;
           }
       }


       if(!empty($f_model_series_data_list) && $model_series_data_exist) { ?>
           <div id="bottom" <?=$footer_bottom_bg_color?>>
             <div class="container-fluid">
               <div class="row justify-content-center">
                 <div class="col-md-12">
                   <div class="block product-links">
                     <div class="row">
                       <?php
                       foreach($f_model_series_data_list as $f_d_k=>$f_model_series_data) {
                           $f_d_b_class = "col-6 col-md-6 col-lg-3 pt-3";
                           $f_d_k = ($f_d_k+1);
                           if($f_d_k%2==0) {
                               $f_d_b_class = "col-6 col-md-6 col-lg-3 pt-3";
                           }


                           $ft_model_data_list = get_f_model_data_list($f_model_series_data['id']);
                           if(!empty($ft_model_data_list)) { ?>
                               <div class="<?=$f_d_b_class?>">
                                 <h4><?=$f_model_series_data['title']?></h4>
                                 <ul>
                                   <?php
                                   $ftm_n = 0;
                                   foreach($ft_model_data_list as $ft_model_data) {
                                       $ftm_n = ($ftm_n+1);
                                       if($ftm_n<=5) { ?>
                                           <li><a href="<?=SITE_URL.$model_details_page_slug.$ft_model_data['sef_url']?>"><?=$ft_model_data['title']?></a></li>
                                       <?php
                                       }
                                   }


                                   if($f_model_series_data['sef_url'] && $ftm_n > 5) {
                                       echo '<li class="readmore"><a href="'.SITE_URL.$f_model_series_data['sef_url'].'"><b>'._lang('viewmore_link_text','footer').'</b> &nbsp;&nbsp;<i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>';
                                   } ?>
                                 </ul>
                               </div>
                           <?php
                           }
                       } ?>
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
       <?php
       }
   } ?>
 </footer>


<div class="modal fade" id="contactusForm" tabindex="-1" role="dialog" aria-labelledby="contactusFormLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title"><?=_lang('heading_text','contact_us_popup')?></h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
         </button>
       </div>  


       <div class="modal-body pt-3 text-center">
         <?php
         $contact_us_fill_data = array();
         if(isset($_SESSION['contact_us_fill_data'])) {
           $contact_us_fill_data = $_SESSION['contact_us_fill_data'];
           unset($_SESSION['contact_us_fill_data']);
         } ?>


         <form method="post" class="sign-in" id="contact_p_form">
           <div class="form-row">
             <div class="form-group col-md-6">
               <input type="text" class="form-control" name="name" id="name" placeholder="<?=_lang('name_field_placeholder_text','contact_us_popup')?>" value="<?=(isset($contact_us_fill_data['name'])?$contact_us_fill_data['name']:'')?>">
               <div id="contactus_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
             </div>


             <div class="form-group <?php /*?>telephone-form<?php */?> tlpphone_error_section mt-0 col-md-6">
               <input type="tel" id="contact_cell_phone" name="cell_phone" class="form-control" placeholder="<?=_lang('phone_field_placeholder_text','contact_us_popup')?>">
               <input type="hidden" name="phone" id="contact_phone" />
               <div id="contactus_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
             </div>
           </div>


           <div class="form-row">
             <div class="form-group col-md-6">
               <input type="text" class="form-control" name="email" id="email" placeholder="<?=_lang('email_field_placeholder_text','contact_us_popup')?>" value="<?=(isset($contact_us_fill_data['email'])?$contact_us_fill_data['email']:'')?>">
               <div id="contactus_email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
             </div>


             <div class="form-group mt-0 col-md-6">
               <input type="text" class="form-control" name="order_id" id="order_id" placeholder="<?=_lang('order_id_field_placeholder_text','contact_us_popup')?>" value="<?=(isset($contact_us_fill_data['order_id'])?$contact_us_fill_data['order_id']:'')?>">
               <div id="contactus_order_id_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
             </div>
           </div>


           <div class="form-row">
             <div class="form-group col-md-12">
               <input type="text" class="form-control" name="subject" id="subject" placeholder="<?=_lang('subject_field_placeholder_text','contact_us_popup')?>" value="<?=(isset($contact_us_fill_data['subject'])?$contact_us_fill_data['subject']:'')?>">
               <div id="contactus_subject_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
             </div>
           </div>


           <div class="form-row">
              <div class="form-group col-md-12">
                <textarea class="form-control" name="message" id="message" placeholder="<?=_lang('message_field_placeholder_text','contact_us_popup')?>"><?=(isset($contact_us_fill_data['message'])?$contact_us_fill_data['message']:'')?></textarea>
                <div id="contactus_message_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
              </div>
           </div>


           <?php
           if($contact_form_captcha == '1') { ?>
           <div class="form-row">
               <div class="form-group col-md-12">
                   <div id="p_c_g_form_gcaptcha"></div>
                   <input type="hidden" id="p_c_g_captcha_token" name="g_captcha_token" value=""/>
                   <?php
                   if(isset($contact_us_fill_data['msg_field']) && $contact_us_fill_data['msg_field'] == "captcha") {
                       echo '<small style="display:inline;color:red;">'.$contact_us_fill_data['msg_label'].'</small>';
                   } ?>
                   <div id="contactus_captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
           </div>
           <?php
           } else {
               echo '<input type="hidden" id="p_c_g_captcha_token" name="g_captcha_token" value="yes"/>';
           } ?>


           <div class="form-group double-btn pt-5 text-center">
               <button type="submit" class="btn btn-primary btn-lg ml-lg-3 contact_p_form_sbmt_btn"><?=_lang('submit_button_text')?></button>
               <input type="hidden" name="submit_form" id="submit_form" />
           </div>         


           <?php
           $ct_csrf_token = generateFormToken('contact');
           echo '<input type="hidden" name="csrf_token" value="'.$ct_csrf_token.'">'; ?>
           <input type="hidden" name="controller" value="contact" />
         </form>
       </div>
     </div>
   </div>
 </div>


 <div class="modal fade" id="trackOrder" tabindex="-1" role="dialog" aria-labelledby="trackOrder" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content track_order_found_info"></div>
   </div>
 </div>


 <div class="modal fade" id="SignInRegistration" tabindex="-1" role="dialog" aria-labelledby="SignInRegistration" aria-hidden="true">
   <div class="modal-dialog" role="document">  
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <img src="<?=SITE_URL?>media/images/payment/close.png" alt="">
         </button>
       </div>


       <div class="modal-body text-center pt-4">
         <ul class="nav nav-tabs signInUpTab" id="myTab" role="tablist">
           <li class="nav-item">
             <a class="nav-link active rounded-pill" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
               <p><?=_lang('signin_tab_text','signin_register_popup')?></p>
             </a>
           </li>


           <li class="nav-item">
             <a class="nav-link rounded-pill" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">
               <p>
                 <?=_lang('signup_tab_text','signin_register_popup')?>
               </p>
             </a>
           </li>
         </ul>


         <div class="tab-content" id="myTabContent">
           <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
             <form method="post" class="sign-in f-login-form" id="popup_login_form">
               <div class="f-signin-form-msg" style="display:none;"></div>
               <span id="signin_p_spining_icon"></span>
               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="Email"><?php */?>
                 <input type="email" class="form-control" id="username" name="username" placeholder="<?=_lang('email_field_placeholder_text','signin_register_popup')?>" value="<?=(isset($email_while_add_to_cart)?$email_while_add_to_cart:'')?>" autocomplete="nope" required>
                 <div id="login_username_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>


               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/lock.png" alt="Password"><?php */?>
                 <input type="password" class="form-control" id="password" name="password" placeholder="<?=_lang('password_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                 <div id="login_password_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>


               <?php
               if($login_form_captcha == '1') { ?>
               <div class="form-group">
                   <div id="p_l_g_form_gcaptcha"></div>
                   <input type="hidden" id="p_l_g_captcha_token" name="p_l_g_captcha_token" value=""/>
                   <div id="login_captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
               <?php
               } else {
                   echo '<input type="hidden" id="p_l_g_captcha_token" name="p_l_g_captcha_token" value="yes"/>';
               } ?>


               <div class="form-group">
                 <a href="javascript:void(0);" id="forgot_password_link"><?=_lang('forgot_password_link_text')?></a>
               </div>


               <div class="form-group text-center">
                   <button type="button" class="btn btn-primary btn-lg signin_p_form_btn"><?=_lang('continue_button_text')?></button>
                   <input type="hidden" name="submit_form" id="submit_form" />
               </div>


               <?php
               if($social_login=='1') { ?>
                   <div class="divider">
                     <span>or</span>
                   </div>


                   <ul class="social">
                       <?php
                       if($social_login_option=="g_f") { ?>
                         <li class="facebook">
                           <a href="javascript:void(0);" class="s_facebook_auth"><i class="fab fa-facebook-f"></i><?=_lang('facebook_social_button_text','signin_register_popup')?><span class="s_facebook_auth_spining_icon"></span></a>
                         </li>
                         <li class="google">
                           <a href="javascript:void(0);" id="h_google_auth_btn"><i class="fab fa-google"></i><?=_lang('google_social_button_text','signin_register_popup')?> <span class="h_google_auth_btn_spining_icon"></span></a>
                         </li>
                       <?php
                       } elseif($social_login_option=="g") { ?>
                         <li class="google">
                           <a href="javascript:void(0);" id="h_google_auth_btn"><i class="fab fa-google"></i><?=_lang('google_social_button_text','signin_register_popup')?> <span class="h_google_auth_btn_spining_icon"></span></a>
                         </li>
                       <?php
                       } elseif($social_login_option=="f") { ?>
                         <li class="facebook">
                           <a href="javascript:void(0);" class="s_facebook_auth"><i class="fab fa-facebook-f"></i><?=_lang('facebook_social_button_text','signin_register_popup')?><span class="s_facebook_auth_spining_icon"></span></a>
                         </li>
                       <?php
                       } ?>
                   </ul>
               <?php
               }


               $p_l_csrf_token = generateFormToken('ajax');
               echo '<input type="hidden" name="csrf_token" value="'.$p_l_csrf_token.'">';


               if($is_review_order_page_with_cart_items) {
                   echo '<input type="hidden" name="from_cart" value="1" />';
               } ?>
             </form>


             <?php
             if($settings['login_verification']=="email" || $settings['login_verification']=="sms") { ?>
             <form method="post" class="sign-in needs-validation f-login-verifycode-form" style="display:none;" novalidate>
               <div class="f-login-verifycode-form-msg" style="display:none;"></div>
               <span id="resend_login_verifycode_p_spining_icon"></span>
               <div class="form-group">
                 <input type="text" class="form-control" name="login_verification_code" id="login_verification_code" placeholder="<?=_lang('verification_code_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" onkeyup="this.value=this.value.replace(/[^\d]/,'');" required>
                 <div class="invalid-feedback">
                   <?=_lang('verification_code_field_validation_text','signin_register_popup')?>
                 </div>
               </div>


               <div class="form-group pt-3 text-center">
                 <button type="submit" class="btn btn-primary btn-lg login_verifycode_form_btn"><?=_lang('verify_button_text')?></button>
                 <input type="hidden" name="submit_form" id="submit_form" />
                 <input type="hidden" name="user_id" id="login_verifycode_user_id" />


                 <button type="button" class="btn btn-outline-dark btn-md resend_login_verifycode_btn"><?=_lang('resend_button_text')?></button>
               </div> 
              
               <?php
               $l_v_a_csrf_token = generateFormToken('ajax');
               echo '<input type="hidden" name="csrf_token" value="'.$l_v_a_csrf_token.'">'; ?>
             </form>
             <?php
             } ?>


             <form method="post" class="sign-in needs-validation f-lost-psw-form" style="display:none;" novalidate>
               <h5 class="modal-title"><?=_lang('forgot_password_heading_text','signin_register_popup')?></h5>
               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt=""><?php */?>
                 <input type="email" class="form-control" id="forgot_password_email" name="email" placeholder="<?=_lang('email_field_placeholder_text','signin_register_popup')?>" autocomplete="nope">
                 <div id="forgot_password_email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>


               <div class="form-group mt-2">
                 <p class="info-text form-text text-left"><?=_lang('forgot_password_info_text','signin_register_popup')?><br><?=_lang('forgot_password_help_text','signin_register_popup')?> <a href="<?=$contact_link?>"><?=_lang('forgot_password_help_link_text','signin_register_popup')?></a></p>
               </div>


               <div class="form-group double-btn pt-5 text-center">
                   <button type="button" class="btn btn-lg btn-outline-dark  mr-lg-3" id="forgot_password_back"><?=_lang('back_button_text')?></button>
                   <button type="submit" class="btn btn-primary btn-lg forgot_password_form_btn"><?=_lang('password_reset_button_text','signin_register_popup')?> <span id="forgot_password_form_spining_icon"></span></button>
                   <input type="hidden" name="reset" id="reset" />
               </div>


               <?php
               $l_p_csrf_token = generateFormToken('lost_password');
               echo '<input type="hidden" name="csrf_token" value="'.$l_p_csrf_token.'">'; ?>
               <input type="hidden" name="controller" value="user/lost_password" />
             </form>
           </div>


           <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
             <form method="post" class="sign-in f-signup-form" id="popup_signup_form">
               <div class="f-signup-form-msg" style="display:none;"></div>
                <?php
                if($is_review_order_page_with_cart_items) { ?>
                   <div class="form-group">
                       <div class="custom-control custom-checkbox">
                         <input type="checkbox" class="custom-control-input" name="is_guest" id="is_guest" value="1"/>
                         <label class="custom-control-label" for="is_guest"><?=_lang('checkout_as_guest_checkbox_text','signin_register_popup')?></label>
                       </div>
                   </div>
               <?php
               } else {
                   echo '<input type="hidden" name="is_guest" id="is_guest" value="0"/>';
               } ?>


               <span id="signup_p_spining_icon"></span>
              
               <?php
               if($enable_signup_first_name_field == "1" && !$is_review_order_page_with_cart_items) { ?>
               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="First Name"><?php */?>
                 <input type="text" class="form-control" name="signup_p_first_name" id="signup_p_first_name" placeholder="<?=_lang('first_name_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                 <div id="signup_first_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
               <?php
               }
              
               if($enable_signup_last_name_field == "1" && !$is_review_order_page_with_cart_items) { ?>
               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="First Name"><?php */?>
                 <input type="text" class="form-control" name="signup_p_last_name" id="signup_p_last_name" placeholder="<?=_lang('last_name_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                 <div id="signup_last_name_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
               <?php
               } ?>
              
               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="Email"><?php */?>
                 <input type="email" class="form-control" name="signup_p_email" id="signup_p_email" placeholder="<?=_lang('email_field_placeholder_text','signin_register_popup')?>" value="<?=(isset($email_while_add_to_cart)?$email_while_add_to_cart:'')?>" autocomplete="nope" required>
                 <div id="signup_email_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>


               <?php
               if(!$is_review_order_page_with_cart_items && $enable_signup_phone_field == "1") { ?>
               <div class="form-group">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/phone_dial.png" alt="Phone"><?php */?>
                 <input type="tel" class="form-control" id="signup_cell_phone" name="signup_cell_phone" placeholder="<?=_lang('phone_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                 <input type="hidden" name="signup_phone_c_code" id="signup_phone_c_code" />
                 <div id="signup_cell_phone_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
               <?php
               } ?>


               <div class="form-group password-field">
                 <?php /*?><img src="<?=SITE_URL?>media/images/icons/lock.png" alt=""><?php */?>
                 <input type="password" class="form-control" name="signup_p_password" id="signup_p_password" placeholder="<?=_lang('password_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                 <div id="signup_password_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
              
               <?php
               if($enable_signup_address_fields == "1" && !$is_review_order_page_with_cart_items) { ?>
               <div class="form-row">
                   <div class="col-md-12">
                       <div class="form-group">
                         <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="address"><?php */?>
                         <input type="text" class="form-control" name="signup_p_address" id="signup_p_address" placeholder="<?=_lang('address_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                         <div id="signup_address_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                       </div>
                   </div>
               </div>
               <?php
               if($show_house_number_field == '1') { ?>
               <div class="form-row">
                   <div class="col-md-12">
                       <div class="form-group">
                         <input type="text" class="form-control" name="signup_p_house_number" id="signup_p_house_number" placeholder="<?=_lang('house_number_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                         <div id="signup_house_number_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                       </div>
                   </div>
               </div>
               <?php
               } ?>
               <div class="form-row">
                   <div class="col-md-12">
                       <div class="form-group">
                         <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="address2"><?php */?>
                         <input type="text" class="form-control" name="signup_p_address2" id="signup_p_address2" placeholder="<?=_lang('address2_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                         <div id="signup_address2_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                       </div>
                   </div>
               </div>
              
               <div class="form-row">
                   <div class="col-md-<?php if($hide_state_field == '1'){echo '6';}else{echo '4';}?>">
                       <div class="form-group">
                         <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="city"><?php */?>
                         <input type="text" class="form-control" name="signup_p_city" id="signup_p_city" placeholder="<?=_lang('city_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                         <div id="signup_city_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                       </div>
                   </div>
                   <?php
                   if($hide_state_field != '1') { ?>
                   <div class="col-md-4">
                       <div class="form-group">
                         <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="state"><?php */?>
                         <input type="text" class="form-control" name="signup_p_state" id="signup_p_state" placeholder="<?=_lang('state_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                         <div id="signup_state_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                       </div>
                   </div>
                   <?php
                   } ?>
                   <div class="col-md-<?php if($hide_state_field == '1'){echo '6';}else{echo '4';}?>">
                       <div class="form-group">
                         <?php /*?><img src="<?=SITE_URL?>media/images/icons/user-gray.png" alt="postcode"><?php */?>
                         <input type="text" class="form-control" name="signup_p_postcode" id="signup_p_postcode" placeholder="<?=_lang('postcode_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" required>
                         <div id="signup_postcode_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
                       </div>
                   </div>
               </div>
               <?php
               }
              
               if($display_terms_array['ac_creation']=="ac_creation") { ?>
               <div class="form-group">
                   <div class="custom-control custom-checkbox">
                       <input type="checkbox" class="custom-control-input" name="p_ac_terms_conditions" id="p_ac_terms_conditions" value="1" required/>
                       <label class="custom-control-label" for="p_ac_terms_conditions">I accept <a href="javascript:void(0)" class="help-icon click_terms_of_website_use"><?=_lang('terms_and_conditions_link_text','signin_register_popup')?></a></label>
                   </div>
                   <div id="signup_terms_conditions_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
               <?php
               } else {
                   echo '<input type="hidden" name="ac_terms_conditions" id="ac_terms_conditions" value="1"/>';
               }


               if($signup_form_captcha == '1') { ?>
               <div class="form-group">
                   <div id="p_s_g_form_gcaptcha"></div>
                   <input type="hidden" id="p_s_g_captcha_token" name="p_s_g_captcha_token" value=""/>
                   <div id="signup_captcha_error_msg" class="invalid-feedback m_validations_showhide" style="display:none;"></div>
               </div>
               <?php
               } else {
                   echo '<input type="hidden" id="p_s_g_captcha_token" name="p_s_g_captcha_token" value="yes"/>';
               } ?>


               <div class="form-group pt-3 text-center">
                 <button type="button" class="btn btn-primary btn-lg signup_p_form_btn"><?=_lang('continue_button_text')?></button>
                 <input type="hidden" name="submit_form" id="submit_form" />
               </div>


               <?php
               if($social_login=='1') { ?>
                   <div class="divider">
                     <span>or</span>
                   </div>
                   <ul class="social">
                       <?php
                       if($social_login_option=="g_f") { ?>
                         <li class="facebook">
                           <a href="javascript:void(0);" class="s_facebook_auth"><i class="fab fa-facebook-f"></i><?=_lang('facebook_social_button_text','signin_register_popup')?><span class="s_facebook_auth_spining_icon"></span></a>
                         </li>
                         <li class="google">
                           <a href="javascript:void(0);" id="hsp_google_auth_btn"><i class="fab fa-google"></i><?=_lang('google_social_button_text','signin_register_popup')?> <span class="hsp_google_auth_btn_spining_icon"></span></a>
                         </li>
                       <?php
                       } elseif($social_login_option=="g") { ?>
                         <li class="google">
                           <a href="javascript:void(0);" id="hsp_google_auth_btn"><i class="fab fa-google"></i><?=_lang('google_social_button_text','signin_register_popup')?> <span class="hsp_google_auth_btn_spining_icon"></span></a>
                         </li>
                       <?php
                       } elseif($social_login_option=="f") { ?>
                         <li class="facebook">
                           <a href="javascript:void(0);" class="s_facebook_auth"><i class="fab fa-facebook-f"></i><?=_lang('facebook_social_button_text','signin_register_popup')?><span class="s_facebook_auth_spining_icon"></span></a>
                         </li>
                       <?php
                       } ?>
                   </ul>
               <?php
               }


               $p_s_csrf_token = generateFormToken('ajax');
               echo '<input type="hidden" name="csrf_token" value="'.$p_s_csrf_token.'">'; ?>


               <input type="hidden" name="from_cart" value="1" />
             </form>


             <form method="post" class="sign-in needs-validation f-verifycode-form" style="display:none;" novalidate>
               <div class="f-verifycode-form-msg" style="display:none;"></div>
               <span id="resend_verifycode_p_spining_icon"></span>
               <div class="form-group">
                 <input type="text" class="form-control" name="verification_code" id="verification_code" placeholder="<?=_lang('verification_code_field_placeholder_text','signin_register_popup')?>" autocomplete="nope" onkeyup="this.value=this.value.replace(/[^\d]/,'');" required>
                 <div class="invalid-feedback">
                   <?=_lang('verification_code_field_validation_text','signin_register_popup')?>
                 </div>
               </div>


               <div class="form-group pt-3 text-center">
                 <button type="submit" class="btn btn-primary btn-lg verifycode_form_btn"><?=_lang('verify_button_text')?></button>
                 <input type="hidden" name="submit_form" id="submit_form" />
                 <input type="hidden" name="user_id" id="verifycode_user_id" />


                 <button type="button" class="btn btn-primary btn-lg resend_verifycode_btn"><?=_lang('resend_button_text')?></button>
               </div>
              
               <?php
               $v_a_csrf_token = generateFormToken('ajax');
               echo '<input type="hidden" name="csrf_token" value="'.$v_a_csrf_token.'">'; ?>
               <input type="hidden" name="controller" value="user/verify_account" />
             </form>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>


<?php
//START for offer popup
if(isset($active_page_data['slug']) && $active_page_data['slug'] == "home" && $allow_offer_popup == '1') { ?>
   <div class="modal fade common_popup offer-popup-model" id="instant_offer_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">         
               <?php
               if($offer_popup_title!="") {
                   echo '<h5 class="modal-title">'.$offer_popup_title.'</h5>';
               } ?>
           </div>
           <div class="modal-body">
               <?php
               if($offer_popup_content!="") {
                   echo $offer_popup_content;
               } ?>
           </div>
           <div class="modal-footer footer_btn_section">
                <a href="javascript:void(0)" class="close_offer_popup_later btn-off offer-button"><?=_lang('may_be_later_button_text')?></a> <?php /*?><span>|</span> <a href="javascript:void(0)" class="close_offer_popup_no_thanks"><?=_lang('no_thanks_button_text')?></a> <?php */?>     
           </div>
       </div>         
     </div>
   </div>


   <a href="#" id="back-to-top" title="Back to top">
       <i class="ion ion-ios-arrow-up"></i>
   </a>


   <script src="<?=SITE_URL?>assets/js/offer-popup.js"></script>
<?php
} //END for offer popup


//For social signup/signin
if($social_login=='1') {
   echo '<script src="'.SITE_URL.'social/js/oauthpopup.js"></script>';
}


//For captcha of login, signup, contact form popup
if($login_form_captcha == '1' || $signup_form_captcha == '1' || $contact_form_captcha == '1') {
   echo '<script src="https://www.google.com/recaptcha/api.js?onload=PopupCaptchaCallback&render=explicit"></script>';
} ?>


<script src="<?=SITE_URL?>assets/js/popper.min.js"></script>
<script src="<?=SITE_URL?>assets/js/bootstrap_4.3.1.min.js"></script>
<script src="<?=SITE_URL?>assets/js/slick.min.js"></script>
<script src="<?=SITE_URL?>assets/js/jquery.autocomplete.min.js"></script>
<script src="<?=SITE_URL?>assets/js/intlTelInput.js"></script>
<script src="<?=SITE_URL?>assets/js/comman_product.js?v=1.0"></script>

<script>
<?php
//For captcha of login, signup, contact form popup
if($login_form_captcha == '1' || $signup_form_captcha == '1' || $contact_form_captcha == '1') { ?>
   var PopupCaptchaCallback = function() {
       <?php
       if($login_form_captcha == '1') { ?>
           if(jQuery('#p_l_g_form_gcaptcha').length) {
               g_c_login_wdt_id = grecaptcha.render('p_l_g_form_gcaptcha', {
                   'sitekey' : '<?=$captcha_key?>',
                   'callback' : onSubmitFormOfpl,
               });
           }
       <?php
       }


       if($signup_form_captcha == '1') { ?>
           if(jQuery('#p_s_g_form_gcaptcha').length) {
               g_c_signup_wdt_id = grecaptcha.render('p_s_g_form_gcaptcha', {
                   'sitekey' : '<?=$captcha_key?>',
                   'callback' : onSubmitFormOfps,
               });
           }
       <?php
       }


       if($contact_form_captcha == '1') { ?>
           if(jQuery('#p_c_g_form_gcaptcha').length) {
               g_c_contact_wdt_id = grecaptcha.render('p_c_g_form_gcaptcha', {
                   'sitekey' : '<?=$captcha_key?>',
                   'callback' : onSubmitFormOfpc,
               });
           }
       <?php
       } ?>
   };


   <?php
   if($login_form_captcha == '1') { ?>
   var onSubmitFormOfpl = function(response) {
       if(response.length == 0) {
           jQuery("#p_l_g_captcha_token").val('');
       } else {
           jQuery("#p_l_g_captcha_token").val('yes');
           check_p_login_form();
       }
   };
   <?php
   }


   if($signup_form_captcha == '1') { ?>
   var onSubmitFormOfps = function(response) {
       if(response.length == 0) {
           jQuery("#p_s_g_captcha_token").val('');
       } else {
           jQuery("#p_s_g_captcha_token").val('yes');
           check_p_signup_form();
       }
   };
   <?php
   }


   if($contact_form_captcha == '1') { ?>
   var onSubmitFormOfpc = function(response) {
       if(response.length == 0) {
           jQuery("#p_c_g_captcha_token").val('');
       } else {
           jQuery("#p_c_g_captcha_token").val('yes');
           jQuery('.contact_form_sbmt_btn').prop('disabled', false);
           check_p_contactus_form();
       }
   };
   <?php
   }
} ?>


var iti_signup;
var iti_contact;
(function ($) {
   $(function () {
       <?php
       //For social signup/signin
       if($social_login=='1') {

           if($social_login_option=="g_f" || $social_login_option=="f") { ?>
               //For Facebook
               $.ajaxSetup({ cache: true });
               $.getScript('https://connect.facebook.net/en_US/sdk.js', function() {
                   $(".s_facebook_auth").click(function() {
                       FB.init({
                         appId: '<?=$fb_app_id?>',
                         version: 'v10.0'
                       });


                       FB.login(function(response) {
                           if(response.authResponse) {
                            $(".s_facebook_auth_spining_icon").html('<?=$spining_icon_html?>');
                            $(".s_facebook_auth_spining_icon").show();


                            console.log('Welcome! Fetching your information...');
                            FB.api('/me?fields=id,name,first_name,middle_name,last_name,email,gender,locale', function(response) {
                                console.log('Response',response);                             


                                $("#name").val(response.name);
                                $("#email").val(response.email);


                                if(response.email!="") {
                                    $.ajax({
                                       type: "POST",
                                       url:"<?=SITE_URL?>ajax/social_login.php",
                                       data:response,
                                       success:function(data) {
                                           if(data!="") {
                                               var resp_data = JSON.parse(data);
                                               if(resp_data.msg!="" && resp_data.status == true) {
                                                   location.reload(true);
                                               } else {
                                                   alert("Something went wrong!!!");
                                               }
                                           } else {
                                               alert("Something went wrong!!!");
                                           }


                                           $(".s_facebook_auth_spining_icon").html('');
                                           $(".s_facebook_auth_spining_icon").hide();
                                       }
                                   });
                               } else {
                                   $(".s_facebook_auth_spining_icon").html('');
                                   $(".s_facebook_auth_spining_icon").hide();
                               }
                            });
                           } else {
                               $(".s_facebook_auth_spining_icon").html('');
                               $(".s_facebook_auth_spining_icon").hide();
                               console.log('User cancelled login or did not fully authorize.');
                           }
                       },{scope: 'email'});
                   });
               });
           <?php
           }
       }


       if(!$is_review_order_page_with_cart_items && $enable_signup_phone_field == "1") { ?>
       var telInput = document.querySelector("#signup_cell_phone");
       iti_signup = window.intlTelInput(telInput, {
         initialCountry: "<?=$phone_country_short_code?>",
         allowDropdown: false,
         geoIpLookup: function(callback) {
           $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
             var countryCode = (resp && resp.country) ? resp.country : "";
             callback(countryCode);
           });
         },
         utilsScript: "<?=SITE_URL?>assets/js/intlTelInput-utils.js" //just for formatting/placeholders etc
       });
       <?php
       } ?>


       var telInput2 = document.querySelector("#contact_cell_phone");
       iti_contact = window.intlTelInput(telInput2, {
         initialCountry: "<?=$phone_country_short_code?>",
         allowDropdown: false,
         geoIpLookup: function(callback) {
           $.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
             var countryCode = (resp && resp.country) ? resp.country : "";
             callback(countryCode);
           });
         },
         utilsScript: "<?=SITE_URL?>assets/js/intlTelInput-utils.js"
       });


       <?php
       if(isset($contact_us_fill_data['phone']) && $contact_us_fill_data['phone']) { ?>
       iti_contact.setNumber("<?=$contact_us_fill_data['phone']?>");
       $("#contactusForm").modal();
       <?php
       } ?>
   });
})(jQuery);
</script>


<?php
if(!empty($google_client_id) && !empty($google_client_secret) && ($social_login_option=="g_f" || $social_login_option=="g") && $social_login=='1') { ?>
<script src="https://apis.google.com/js/api:client.js"></script>
<script>
var googleUser = {};
var startgApp = function() {
   gapi.load('auth2', function() {
       // Retrieve the singleton for the GoogleAuth library and set up the client.
       auth2 = gapi.auth2.init({
           client_id: '<?=$google_client_id?>',
           cookiepolicy: 'single_host_origin',
           plugin_name: "<?=SITE_NAME?>"
           // Request scopes in addition to 'profile' and 'email'
           //scope: 'additional_scope'
       });
       attachGSignin(document.getElementById('google_auth_btn'), "google_auth");
       attachGSignin(document.getElementById('h_google_auth_btn'), "h_google_auth");
       attachGSignin(document.getElementById('hsp_google_auth_btn'), "hsp_google_auth");
   });
};


function attachGSignin(element, uqid) {
   auth2.attachClickHandler(element, {},
       function(googleUser) {
           var name = googleUser.getBasicProfile().getName();
           var first_name = googleUser.getBasicProfile().getGivenName();
           var last_name = googleUser.getBasicProfile().getFamilyName();
           var email = googleUser.getBasicProfile().getEmail();


           jQuery("."+uqid+"_btn_spining_icon").html('<?= $full_spining_icon_html ?>');
           jQuery("."+uqid+"_btn_spining_icon").show();


           jQuery.ajax({
               type: 'POST',
               url: SITE_URL + 'ajax/google_auth.php',
               data: {name: name, first_name: first_name, last_name: last_name, email: email},
               success: function(data) {
                   if(data != "") {
                       var resp_data = JSON.parse(data);
                       if(resp_data.status == "success" && resp_data.msg != "") {
                           window.location.href = "<?=SITE_URL?>checkout";
                       } else if(resp_data.status == "fail" && resp_data.msg != "") {
                           //$('#google_auth_msg').html("Auth failed. Please try again.");
                       }
                       jQuery("."+uqid+"_btn_spining_icon").html('');
                       jQuery("."+uqid+"_btn_spining_icon").hide();
                   }
               }
           });
                  
       }, function(error) {
           //alert(JSON.stringify(error, undefined, 2));
       }
   );
}


startgApp();
</script>
<?php
} ?>


<?=$before_body_js_code?>


<?php
if($url_first_param == "order-completion" && !empty($order_id)) { ?>
<script>
window.dataLayer = window.dataLayer || [];
dataLayer.push({
   'event': 'purchase',
   'transactionId': '<?=$order_id?>',
   'transactionTotal': <?=$order_total?>,
   'transactionTax': 0.00,
   'transactionProducts': <?=$transaction_product_str?>
});
</script>
<?php
} ?>


<script type="text/javascript">
   jQuery('.site_search').click(function() {
       jQuery(this).toggleClass('active');
       jQuery('.showcase-text').toggleClass('active');
   });

   	jQuery(function () {
		jQuery('[data-toggle="tooltip"]').tooltip()
	});

</script>

</body>
</html>