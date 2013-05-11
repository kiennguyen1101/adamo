<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

session_start();

  define('IN_SITE', 1);

  include_once ('includes/global.php');
  include_once ('includes/class_formchecker.php');
  include_once ('includes/class_custom_field.php');
  include_once ('includes/class_user.php');
  include_once ('includes/class_fees.php');
  include_once ('includes/class_item.php');
  include_once ('includes/functions_item.php');
  include_once ('includes/class_shop.php');

  (array) $user_details = null;
  if ($session->value('user_id')) {
    $user_details = $db->get_sql_row("SELECT user_id, username, shop_account_id, shop_categories,
		shop_active, preferred_seller, reg_date, country, state, zip_code, balance,
		default_name, default_description, default_duration, default_hidden_bidding,
		default_enable_swap, default_shipping_method, default_shipping_int, default_postage_amount,
		default_insurance_amount, default_type_service, default_shipping_details, default_payment_methods, seller_verified, 
		default_currency, default_direct_payment FROM
		" . DB_PREFIX . "users WHERE user_id=" . $session->value('user_id'));
  }

  if ($session->value('membersarea') != 'Active') {
    if ($session->value('user_id')) /* user inactive - redirect to account management page */ {
      header_redirect('members_area.php?page=account&section_management');
    }
    else {
      header_redirect('login.php?redirect=sell_item');
    }
  }
  else if (!$session->value('is_seller')) {
    header_redirect('members_area.php?page=selling');
  }
  /*
    else if ($setts['enable_seller_verification'] && $setts['seller_verification_mandatory'] && !$user_details['seller_verified'])
    {
    header_redirect('fee_payment.php?do=seller_verification');
    }
   */
  else {
    require ('global_header.php');

    (string) $sale_step = $_POST['current_step'];

    $start_time_id = 1;
    $end_time_id = 2;

    $item = new item();
    $item->setts = &$setts;
    $item->layout = &$layout;

    $template->set('item', $item);

    /**
     * We create a temporary row in the items table for every ad that is made. If the ad is placed, this temporary row
     * will become the final ad row.
     */
    if (!$session->is_set('auction_id') && !$session->is_set('refresh_id')) {
      $session->set('auction_id', $item->create_temporary_item($session->value('user_id')));
    }

    if ($session->value('user_id')) {
      $shop = new shop();
      $shop->setts = &$setts;
      $shop->user_id = $session->value('user_id');
    }

    $setup_fee = new fees();
    $setup_fee->setts = &$setts;

    /**
     * We will establish the sale_step variable depending on
     * form_next_step/form_previous_step and the current_step
     * values, and depending on the ad type and other settings as well
     */
    $current_step_post = $_REQUEST['current_step'];
    if ($setts['enable_seller_verification'] && $setts['seller_verification_mandatory'] && !$user_details['seller_verified']) {
      $current_step_post = null;
    }
    else if ($setts['enable_store_only_mode'] && !$user_details['shop_active'] && $current_step_post != 'verification_checked') {
      $current_step_post = null;
    }

    switch ($current_step_post) {
      case 'preview':
        if ($_POST['form_next_step'] || $_POST['form_save_draft']) {
          $sale_step = 'finish';
        }
        else {
          $sale_step = 'shipping';
        }
        break;

      case 'shipping':
        if ($_POST['form_next_step']) {
          $sale_step = 'preview';
        }
        else {
          $sale_step = 'settings';
        }
        break;

      case 'settings':
        if ($_POST['form_next_step']) {
          $sale_step = 'shipping';
        }
        else if ($_POST['box_submit'] == 1) {
          $sale_step = 'settings';
        }
        else {
          $sale_step = 'details';
        }
        break;

      case 'details':
        if ($_POST['form_next_step']) {
          $sale_step = 'settings';
        }
        else if ($_POST['box_submit'] == 1) {
          $sale_step = 'details';
        }
        else {
          $shop_status = $shop->shop_status($user_details, true);

          if ($user_details['shop_active'] && $shop_status['remaining_items'] > 0) {
            $sale_step = 'list_in';
          }
          else {
            $sale_step = 'main_category';
          }
        }
        break;

      case 'addl_category':
        $sale_step = 'details';
        break;

      case 'main_category':
        if ($setts['enable_addl_category']) {
          $sale_step = 'addl_category';
        }
        else {
          $sale_step = 'details';
        }
        break;

      case 'list_in':
        if ($_POST['form_next_step']) {
          $sale_step = 'main_category';
        }
        else {
          $sale_step = '';
        }
        break;

      default:
        /**
         * v6.02 -> all checks will be done here.
         * first step will be either:
         * - seller verification splash page
         * 	-> on this page, we only have a next step button if verification is not mandatory.
         * 	Otherwise there will only be a "Get Verified" button
         * - store only mode splash page
         * 	-> here we will not get a next step, just a "Enable Store" button
         */
        $shop_status = $shop->shop_status($user_details, true);

        if ($setts['enable_seller_verification'] && !$user_details['seller_verified'] && $current_step_post != 'verification_checked') {
          $sale_step = 'splash_page_seller_verification';
        }
        else if ($setts['enable_store_only_mode'] && (!$user_details['shop_active'] || $shop_status['remaining_items'] <= 0)) {
          $sale_step = 'splash_page_store_only_mode';

          $template->set('shop_status', $shop_status);
        }
        else if ($user_details['shop_active'] && $shop_status['remaining_items'] > 0) {
          if ($setts['enable_store_only_mode']) {
            $sale_step = 'main_category';
          }
          else {
            $sale_step = 'list_in';
          }
        }
        else {
          $sale_step = 'main_category';
        }
    }

    $custom_fld = new custom_field();
    $item_details = $_POST;

    if ($setts['enable_store_only_mode']) {
      $item_details['start_price'] = $item_details['buyout_price'];
    }

    /**
     * add sell similar procedure here -> will start with the details step
     */
    if ($_REQUEST['option'] == 'sell_similar') {
      $similar_item_details = $db->get_sql_row("SELECT * FROM " . DB_PREFIX . "auctions WHERE
			auction_id='" . $_REQUEST['auction_id'] . "'");

      if ($similar_item_details['owner_id'] == $session->value('user_id')) {
        $shop_status = $shop->shop_status($user_details, true);

        $sale_step = 'details';
        $item_details = $item->edit_set_checkboxes($similar_item_details);

        $item_details['list_in'] = ($shop_status['remaining_items'] <= 0 && $similar_item_details['list_in'] != 'auction') ? 'auction' : $item_details['list_in'];
        $custom_fld->save_edit_vars($_REQUEST['auction_id'], 'auction'); ## MyPHPAuction 2009 now import auction media
        $similar_item_media = $item->auction_media_fields($_REQUEST['auction_id'], $session->value('auction_id'));

        $item_details['ad_image'] = $similar_item_media['ad_image'];
        $item_details['ad_video'] = $similar_item_media['ad_video'];
      }
    }
    else if ($_REQUEST['option'] == 'new_item') /* prefilled fields */ {
      $item_details['name'] = $user_details['default_name'];
      $item_details['description'] = $user_details['default_description'];
      $item_details['duration'] = $user_details['default_duration'];
      $item_details['hidden_bidding'] = $user_details['default_hidden_bidding'];
      $item_details['enable_swap'] = $user_details['default_enable_swap'];
      $item_details['shipping_method'] = $user_details['default_shipping_method'];
      $item_details['shipping_int'] = $user_details['default_shipping_int'];
      $item_details['postage_amount'] = $user_details['default_postage_amount'];
      $item_details['insurance_amount'] = $user_details['default_insurance_amount'];
      $item_details['type_service'] = $user_details['default_type_service'];
      $item_details['shipping_details'] = $user_details['default_shipping_details'];
      $item_details['payment_methods'] = $user_details['default_payment_methods'];
      $item_details['currency'] = $user_details['default_currency'];
      $item_details['direct_payment'] = $user_details['default_direct_payment'];
    }

    $item_details['auction_id'] = $session->value('auction_id');

    if (!$item_details['currency']) {
      $item_details['currency'] = ($_POST['currency']) ? $_POST['currency'] : $setts['currency'];
    }

    $item_details['addl_category_id'] = ($_POST['form_next_step'] == MSG_SKIP_THIS_STEP) ? 0 : $item_details['addl_category_id'];
    $item_details['quantity'] = $item->set_quantity($item_details['quantity']);

    $item_details['auto_relist_nb'] = ($item_details['auto_relist_nb'] > 1) ? $item_details['auto_relist_nb'] : 1;
    $item_details['country'] = (!empty($item_details['country'])) ? $item_details['country'] : $user_details['country'];
    $item_details['state'] = (!empty($item_details['state'])) ? $item_details['state'] : $user_details['state'];
    $item_details['zip_code'] = (!empty($item_details['zip_code'])) ? $item_details['zip_code'] : $user_details['zip_code'];

    $custom_fld->save_vars($item_details);

    $page_handle = 'auction';

    if ($_POST['current_step'] == 'settings') {
      $item_details['start_time'] = ($item_details['start_time_type'] == 'now') ? CURRENT_TIME : get_box_timestamp($item_details, $start_time_id);
      $item_details['end_time'] = ($item_details['end_time_type'] == 'duration') ? ($item_details['start_time'] + $item_details['duration'] * 86400) : get_box_timestamp($item_details, $end_time_id);

      /**
       * We will need to save the custom fields here so they can be used in the preview page.
       * If the item wont be saved, the custom fields will be deleted together with the
       * temporary item.
       */
      $custom_fld->update_page_data($session->value('auction_id'), $page_handle, $item_details);
    }

    $item_details['name'] = $db->rem_special_chars($item_details['name']);

    $item_details['description'] = $db->rem_special_chars((($_POST['description_main']) ? $_POST['description_main'] : $item_details['description']));

    $item_details['state'] = $db->rem_special_chars($item_details['state']);
    $item_details['zip_code'] = $db->rem_special_chars($item_details['zip_code']);

    $item_details['shipping_details'] = $db->rem_special_chars($item_details['shipping_details']);

    $item_details['direct_payment'] = (count($_POST['payment_gateway'])) ? $db->implode_array($_POST['payment_gateway']) : $item_details['direct_payment'];
    $item_details['payment_methods'] = (count($_POST['payment_option'])) ? $db->implode_array($_POST['payment_option']) : $item_details['payment_methods'];

    $hidden_custom_fields = $custom_fld->output_hidden_form_fields();
    $template->set('hidden_custom_fields', $hidden_custom_fields);

    if (empty($_POST['file_upload_type'])) {
      $template->set('media_upload_fields', $item->upload_manager($item_details));
    }
    else if (is_numeric($_POST['file_upload_id'])) /* means we remove a file / media url */ {
      $media_upload = $item->media_removal($item_details, $item_details['file_upload_type'], $item_details['file_upload_id']);
      $media_upload_fields = $media_upload['display_output'];

      $item_details['ad_image'] = $media_upload['post_details']['ad_image'];
      $item_details['ad_video'] = $media_upload['post_details']['ad_video'];

      $template->set('media_upload_fields', $media_upload_fields);
    }
    else /* means we have a file upload */ {
      $media_upload = $item->media_upload($item_details, $item_details['file_upload_type'], $_FILES);
      $media_upload_fields = $media_upload['display_output'];

      $item_details['ad_image'] = $media_upload['post_details']['ad_image'];
      $item_details['ad_video'] = $media_upload['post_details']['ad_video'];

      $template->set('media_upload_fields', $media_upload_fields);
    }

    $template->set('item_details', $item_details);

    if (isset($_POST['form_next_step'])) /* formchecker code snippet */ {
      define('FRMCHK_ITEM', 1);
      (int) $item_post = 1;

      $frmchk_details = $item_details;

      include('includes/procedure_frmchk_item.php');

      if ($fv->is_error()) {
        $template->set('display_formcheck_errors', $fv->display_errors());
        $sale_step = $_POST['current_step'];
      }
    }

    (int) $ad_steps = 6;

    if ($setts['enable_addl_category']) {
      $ad_steps++;
    }

    // voucher settings
    if (!empty($item_details['voucher_value'])) {
      $voucher_details = $item->check_voucher($item_details['voucher_value'], 'setup');

      if ($sale_step != 'finish') {
        $template->set('check_voucher_message', $voucher_details['display']);
      }
      else {
        ## voucher is deducted
        $item->check_voucher($item_details['voucher_value'], 'setup', true);
      }
    }

    $template->set('ad_steps', $ad_steps);

    $header_menu_cell_width = number_format((100 / $ad_steps), 2, '.', '') . '%';
    $template->set('header_menu_cell_width', $header_menu_cell_width);

    $template->set('sale_step', $sale_step);
    $template->set('session_user_id', $session->value('user_id'));

    if ($sale_step == 'main_category' || $sale_step == 'addl_category') {
      (string) $categories_initialize_msg = null;

      $sell_item_header_menu = $template->process('sell_item_header_menu.tpl.php');
      $template->set('sell_item_header_menu', $sell_item_header_menu);

      $sql_select_categories = $db->query("SELECT category_id, parent_id FROM
			" . DB_PREFIX . "categories ORDER BY category_id ASC");

      while ($cat_details = $db->fetch_array($sql_select_categories)) {
        $categories_initialize_msg .= "c[" . $cat_details['category_id'] . "] = new Array(); \n";
      }

      (int) $counter_a = 0;
      (int) $counter_b = 0;

      (string) $display_message = null;

      $sql_select_subcategories = $db->query("SELECT category_id, is_subcat, parent_id FROM
			" . DB_PREFIX . "categories WHERE parent_id!=0 ORDER BY parent_id ASC, order_id ASC, name ASC");

      while ($subcat_details = $db->fetch_array($sql_select_subcategories)) {
        $parent[$counter_a] = $subcat_details['parent_id'];

        if ($parent[$counter_a] != $parent[$counter_a - 1]) {
          $counter_b = 0;
        }
        else {
          $counter_b++;
        }

        $counter_a++;

        $display_message = $db->add_special_chars($category_lang[$subcat_details['category_id']]);
        $display_message = str_replace("'", "`", $display_message);

        $categories_initialize_msg .= "x(" . $subcat_details['parent_id'] . ", " .
          $counter_b . ", '" . $display_message . " " . $subcat_details['is_subcat'] . "', '" .
          $subcat_details['category_id'] . "'); \n";
      }
      $template->set('categories_initialize_msg', $categories_initialize_msg);

      (string) $categories_subquery = null;

      if ($user_details['shop_active'] && ($_POST['list_in'] == 'store' || $_POST['list_in'] == 'both') && !empty($user_details['shop_categories'])) {
        $shop_categories = last_char($user_details['shop_categories']);

        $categories_subquery = " AND category_id IN (" . $shop_categories . ") ";
      }

      if ($_REQUEST['list_in'] == 'store') {
        $categories_subquery .= " AND (user_id=0 OR user_id=" . intval($session->value('user_id')) . ") ";
      }
      else {
        $categories_subquery .= " AND user_id=0 ";
      }

      $sql_select_main_categories = $db->query("SELECT category_id, is_subcat FROM
			" . DB_PREFIX . "categories WHERE parent_id=0
			" . $categories_subquery . " ORDER BY order_id ASC");

      $main_categories_select = '<select class="contentfont" id="selector_0" onchange="populate(0)" size="20" name="selector_0" style="width: 100%; "> ';

      while ($cat_details = $db->fetch_array($sql_select_main_categories)) {
        $main_categories_select .= '<option value="' . $cat_details['category_id'] . '">' . $category_lang[$cat_details['category_id']] . ' ' . $cat_details['is_subcat'] . '</option>';
      }

      $main_categories_select .= '</select>';

      $template->set('main_categories_select', $main_categories_select);
    }

    if ($sale_step == 'finish') /* auction submission page */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_FINISH)));

      $sell_item_header_menu = $template->process('sell_item_header_menu.tpl.php');
      $template->set('sell_item_header_menu', $sell_item_header_menu);

      $template->set('current_step', 'finish'); ## MyPHPAuction 2009 add setup fee procedure here.
      $setup_fee = new fees();
      $setup_fee->setts = &$setts;

      $shop_status = $shop->shop_status($user_details, true);

      $show_list_similar = true;
      if ($session->value('refresh_id') > 0) {
        $template->set('sell_item_finish_content', '<p align="center" class="contentfont">' . MSG_DOUBLE_POST_ERROR . '</p>');
      }
      else if (in_array($item_details['list_in'], array('store', 'both')) && $shop_status['remaining_items'] <= 0) {
        $template->set('sell_item_finish_content', '<p align="center">' . MSG_NO_MORE_STORE_ITEMS_LIST . '</p>');
        $show_list_similar = false;
      }
      else {
        if (isset($_POST['form_save_draft'])) {
          $template->set('sell_item_finish_content', '<table class="errormessage" align="center"><tr><td align="center"> ' . MSG_DRAFT_SAVED_SUCCESS_DESC . '</td></tr></table>');

          // first the insert procedure
          $refresh_id = $item->insert($item_details, $session->value('user_id'), 'auction', true);
        }
        else {
          $setup_result = $setup_fee->setup($user_details, $item_details, $voucher_details);

          $template->set('sell_item_finish_content', $setup_result['display']);

          // first the insert procedure
          $refresh_id = $item->insert($item_details, $session->value('user_id'));

          $mail_input_id = $refresh_id; ## MyPHPAuction 2009 confirm posting to seller
          include('language/' . $setts['site_lang'] . '/mails/new_item_seller_confirmation.php'); ## MyPHPAuction 2009 if listed in store, announce users that have the store added to their favorites about the new item
          include('language/' . $setts['site_lang'] . '/mails/new_item_fav_store_confirmation.php');
        }
        $session->unregister('auction_id');
        $session->set('refresh_id', $refresh_id);
      }

      $template->set('show_list_similar', $show_list_similar);
      $sell_item_page_content = $template->process('sell_item_finish.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
      // if there are fees to be paid, then call the setup fee
    }
    else if ($sale_step == 'preview') /* auction preview page - preview/fees/terms display */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_PREVIEW)));

      $sell_item_header_menu = $template->process('sell_item_header_menu.tpl.php');
      $template->set('sell_item_header_menu', $sell_item_header_menu);

      $template->set('current_step', 'preview');

      $template->set('buyout_only', $item->buyout_only($item_details));

      $template->set('user_details', $user_details);

      $template->set('main_category_display', category_navigator($item_details['category_id'], false, true, null, null, GMSG_NONE_CAT));
      $template->set('addl_category_display', category_navigator($item_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT));

      $template->set('ad_display', 'preview'); /* if ad_display = preview, then some table fields will be disabled */

      $template->set('show_buyout', show_buyout($item_details));

      $tax = new tax();
      $seller_country = $tax->display_countries($user_details['country']);
      $template->set('seller_country', $seller_country);

      $template->set('auction_location', $item->item_location($item_details));
      $template->set('auction_country', $tax->display_countries($item_details['country']));

      $auction_tax = $tax->auction_tax($session->value('user_id'), $setts['enable_tax']);
      $template->set('apply_tax_message', $auction_tax['display']);

      $custom_fld->new_table = false;
      $custom_fld->field_colspan = 1;
      $custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, true, $session->value('auction_id'), $db->main_category($item_details['category_id']));
      $template->set('custom_sections_table', $custom_sections_table);

      $ad_image_thumbnails = $item->item_media_thumbnails($item_details, 1);
      $template->set('ad_image_thumbnails', $ad_image_thumbnails);

      $ad_video_thumbnails = $item->item_media_thumbnails($item_details, 2, false);
      $template->set('ad_video_thumbnails', $ad_video_thumbnails);

      $video_play_file = (!empty($_REQUEST['video_name'])) ? $_REQUEST['video_name'] : $item_details['ad_video'][0];
      $ad_video_main_box = $item->video_box($video_play_file);
      $template->set('ad_video_main_box', $ad_video_main_box);

      if (!empty($item_details['direct_payment'])) {
        $dp_methods = $item->select_direct_payment($item_details['direct_payment'], $session->value('user_id'), true);

        $direct_payment_methods_display = $template->generate_table($dp_methods, 2, 3, 3, null, '', '');
        $template->set('direct_payment_methods_display', $direct_payment_methods_display);
      }

      if (!empty($item_details['payment_methods'])) {
        $offline_payments = $item->select_offline_payment($item_details['payment_methods'], true);

        $offline_payment_methods_display = $template->generate_table($offline_payments, 4, 3, 3, null, '', '');
        $template->set('offline_payment_methods_display', $offline_payment_methods_display);
      }

      //$template->set('fees', $fees);

      $template->change_path('themes/' . $setts['default_theme'] . '/templates/');
      $auction_details_page = $template->process('auction_details.tpl.php');
      $template->set('auction_details_page', $auction_details_page);
      $template->change_path('templates/');

      $auction_fees = $setup_fee->auction_setup_fees($item_details, $user_details, $voucher_details);
      $template->set('auction_fees_box', $auction_fees['display']);
      $template->set('auction_terms_box', terms_box('auction_setup', ''));

      $sell_item_page_content = $template->process('sell_item_preview.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'shipping') /* shipping and payment page */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_SHIPPING_PAYMENT)));

      $sell_item_header_menu = $template->process('sell_item_header_menu.tpl.php');
      $template->set('sell_item_header_menu', $sell_item_header_menu);

      $template->set('current_step', 'shipping');

      $template->set('shipping_methods_drop_down', $item->shipping_methods_drop_down('type_service', $item_details['type_service']));

      $direct_payments = $item->select_direct_payment($item_details['direct_payment'], $session->value('user_id'));

      $direct_payment_table = $template->generate_table($direct_payments, 4, 1, 1, '75%');
      $template->set('direct_payment_table', $direct_payment_table);

      $offline_payments = $item->select_offline_payment($item_details['payment_methods']);

      $offline_payment_table = $template->generate_table($offline_payments, 4, 1, 1, '75%');
      $template->set('offline_payment_table', $offline_payment_table);

      $sell_item_page_content = $template->process('sell_item_shipping.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'settings') /* settings page */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_ITEM_SETTINGS)));

      $sell_item_header_menu = $template->process('sell_item_header_menu.tpl.php');
      $template->set('sell_item_header_menu', $sell_item_header_menu);

      $template->set('current_step', 'settings');

      $selected_currency = ($item_details['currency']) ? $item_details['currency'] : $setts['currency'];
      $template->set('currency_drop_down', $item->currency_drop_down('currency', $selected_currency, 'ad_create_form'));

      $tax = new tax();
      $can_add_tax = $tax->can_add_tax($session->value('user_id'), $setts['enable_tax']);
      $template->set('can_add_tax', $can_add_tax['can_add_tax']);

      $template->set('duration_drop_down', $item->durations_drop_down('duration', $item_details['duration']));

      $buyout_fee = $setup_fee->display_fee('buyout_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($buyout_fee['amount']) {
        $buyout_fee_expl_message = '(<b>+' . $fees->display_amount($buyout_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('buyout_fee_expl_message', $buyout_fee_expl_message);
      }

      $makeoffer_fee = $setup_fee->display_fee('makeoffer_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($makeoffer_fee['amount']) {
        $makeoffer_fee_expl_message = '(<b>+' . $fees->display_amount($makeoffer_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('makeoffer_fee_expl_message', $makeoffer_fee_expl_message);
      }

      $rp_fee = $setup_fee->display_fee('rp_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($rp_fee['amount']) {
        $rp_fee_expl_message = '(<b>+' . $fees->display_amount($rp_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('rp_fee_expl_message', $rp_fee_expl_message);
      }

      $hpfeat_fee = $setup_fee->display_fee('hpfeat_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($hpfeat_fee['amount']) {
        $hpfeat_fee_expl_message = '(<b>+' . $fees->display_amount($hpfeat_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('hpfeat_fee_expl_message', $hpfeat_fee_expl_message);
      }

      $catfeat_fee = $setup_fee->display_fee('catfeat_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($catfeat_fee['amount']) {
        $catfeat_fee_expl_message = '(<b>+' . $fees->display_amount($catfeat_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('catfeat_fee_expl_message', $catfeat_fee_expl_message);
      }

      $hl_fee = $setup_fee->display_fee('hlitem_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($hl_fee['amount']) {
        $hl_fee_expl_message = '(<b>+' . $fees->display_amount($hl_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('hl_fee_expl_message', $hl_fee_expl_message);
      }

      $bold_fee = $setup_fee->display_fee('bolditem_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($bold_fee['amount']) {
        $bold_fee_expl_message = '(<b>+' . $fees->display_amount($bold_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('bold_fee_expl_message', $bold_fee_expl_message);
      }

      $custom_start_fee = $setup_fee->display_fee('custom_start_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($custom_start_fee['amount']) {
        $custom_start_fee_expl_message = '(<b>+' . $fees->display_amount($custom_start_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('custom_start_fee_expl_message', $custom_start_fee_expl_message);
      }

      $start_date_box = date_form_field($item_details['start_time'], $start_time_id, 'ad_create_form');
      $template->set('start_date_box', $start_date_box);

      $end_date_box = date_form_field($item_details['end_time'], $end_time_id, 'ad_create_form');
      $template->set('end_date_box', $end_date_box);

      $custom_fld->new_table = false;
      $custom_fld->field_colspan = 2;
      $custom_sections_table = $custom_fld->display_sections($item_details, $page_handle, false, 0, $db->main_category($item_details['category_id']));

      $template->set('custom_sections_table', $custom_sections_table);

      $picture_fee = $setup_fee->display_fee('picture_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($picture_fee['amount']) {
        $picture_fee_expl_message = '(<b>+' . $fees->display_amount($picture_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('picture_fee_expl_message', $picture_fee_expl_message);
      }

      $item->show_free_images = true;

      $image_upload_manager = $item->upload_manager($item_details, 1, 'ad_create_form', true, false, true, $picture_fee_expl_message);
      $template->set('image_upload_manager', $image_upload_manager);

      $video_fee = $setup_fee->display_fee('video_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($video_fee['amount']) {
        $video_fee_expl_message = '(<b>+' . $fees->display_amount($video_fee['amount'], $setts['currency'], true) . '</b>)';
        $template->set('video_fee_expl_message', $video_fee_expl_message);
      }
      $video_upload_manager = $item->upload_manager($item_details, 2, 'ad_create_form', true, false, true, $video_fee_expl_message);
      $template->set('video_upload_manager', $video_upload_manager);

      $template->set('country_dropdown', $tax->countries_dropdown('country', $item_details['country'], 'ad_create_form', 'setup'));
      $template->set('state_box', $tax->states_box('state', $item_details['state'], $item_details['country']));

      $sell_item_page_content = $template->process('sell_item_settings.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'details') /* details page */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_ITEM_DETAILS)));

      $sell_item_header_menu = $template->process('sell_item_header_menu.tpl.php');
      $template->set('sell_item_header_menu', $sell_item_header_menu);

      $template->set('current_step', 'details');

      $item_description_editor = "<script> \n" .
        " 	var oEdit1 = new InnovaEditor(\"oEdit1\"); \n" .
        " 	oEdit1.width=\"100%\";//You can also use %, for example: oEdit1.width=\"100%\" \n" .
        "	oEdit1.height=300; \n" .
        "	oEdit1.REPLACE(\"description_main\");//Specify the id of the textarea here \n" .
        "</script>";

      $template->set('item_description_editor', $item_description_editor);

      $template->set('setup_voucher_box', voucher_form('setup', $item_details['voucher_value'], false));

      $template->set('main_category_display', category_navigator($item_details['category_id'], false, true, null, null, GMSG_NONE_CAT));
      $template->set('addl_category_display', category_navigator($item_details['addl_category_id'], false, true, null, null, GMSG_NONE_CAT));

      $sell_item_page_content = $template->process('sell_item_details.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'main_category') /* choose a main category for your item */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_SELECT_MAIN_CAT)));

      $template->set('choose_category_title', MSG_MAIN_CATEGORY);

      $template->set('current_step', 'main_category');

      $template->set('category_id_type', 'category_id');

      $choose_category_expl_message = '<span class="contentfont cat_explain_message"><h2>' . MSG_SUBMIT_ITEM_MAIN_CAT . '</h2></span>';
      $template->set('choose_category_expl_message', $choose_category_expl_message);

      $sell_item_page_content = $template->process('sell_item_choose_category.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'addl_category') /* choose an additional category for your item */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_SELECT_ADDL_CAT)));

      $template->set('choose_category_title', MSG_ADDL_CATEGORY);

      $template->set('current_step', 'addl_category');

      $template->set('category_id_type', 'addl_category_id');

      $choose_category_expl_message = '<span class="contentfont cat_explain_message"><h2>' . MSG_SUBMIT_ITEM_ADDL_CAT_A . '</h2> ';

      $category_fee = $setup_fee->display_fee('second_cat_fee', $user_details, $item_details['category_id'], $item_details['list_in'], $voucher_details);

      if ($category_fee['amount']) {
        $choose_category_expl_message .= '<h3>' . MSG_A_FEE_OF . ' <b>' . $fees->display_amount($category_fee['amount'], $setts['currency'], true) . '</b> ' . MSG_WILL_BE_APPLIED . '</h3>';
      }

      $choose_category_expl_message .= '</span><br>';
      $template->set('choose_category_expl_message', $choose_category_expl_message);

      $sell_item_page_content = $template->process('sell_item_choose_category.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'splash_page_seller_verification') {
      $template->set('sell_item_header', header7(strtoupper(MSG_SELLER_VERIFICATION)));

      $template->set('current_step', '');

      $sell_item_page_content = $template->process('splash_page_seller_verification.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else if ($sale_step == 'splash_page_store_only_mode') {
      $template->set('sell_item_header', header7(strtoupper(MSG_STORE_ONLY_MODE_WARNING)));

      $template->set('current_step', '');

      $sell_item_page_content = $template->process('splash_page_store_only_mode.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }
    else /* this will be the first step (but only if stores are enabled) */ {
      $template->set('sell_item_header', header7(strtoupper(MSG_CHOOSE_WHERE_TO_LIST)));

      $template->set('current_step', 'list_in');

      $sell_item_page_content = $template->process('sell_item_list_in.tpl.php');
      $template->set('sell_item_page_content', $sell_item_page_content);
    }

    $template_output .= $template->process('sell_item.tpl.php');

    include_once ('global_footer.php');

    echo $template_output;
  }
?>