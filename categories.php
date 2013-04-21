﻿<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################

  session_start();

  define('IN_SITE', 1);

  include_once ('includes/global.php');

  include_once ('global_header.php');

  (array) $query = null;
  $parent_id = intval($_REQUEST['parent_id']);
  $advanced_search = ($_REQUEST['advanced_search'] == '') ? 1 : intval($_REQUEST['advanced_search']);
  $template->set('parent_id', $parent_id);

  define('IS_CATEGORIES', 1);

//$template->set('db', $db);

  (string) $subcategories_content = null;

  $main_category_id = $db->main_category($parent_id);
  $category_details = $db->get_sql_row("SELECT image_path, minimum_age FROM " . DB_PREFIX . "categories WHERE category_id='" . $main_category_id . "'");
  $category_logo = $category_details['image_path'];

  $category_logo = (!empty($category_logo)) ? '<img src="' . $category_logo . '" border="0">' : '';
  $template->set('category_logo', $category_logo);

  $categories_header_menu = category_navigator($parent_id, true, true, 'categories.php');
  $template->set('categories_header_menu', $categories_header_menu);

  if ($_REQUEST['option'] == 'agree_adult') {
    $session->set('adult_category', 1);
  }

  if ($category_details['minimum_age'] > 0 && !$session->value('adult_category')) {
    $template->set('minimum_age', $category_details['minimum_age']);
    $template_output .= $template->process('adult_category_warning.tpl.php');
  }
  else {
    $is_subcategories = $db->count_rows('categories', "WHERE parent_id='" . $parent_id . "'");
    $template->set('is_subcategories', $is_subcategories);

    $sql_select_categories = $db->query("SELECT category_id, items_counter FROM " . DB_PREFIX . "categories WHERE 
		parent_id='" . $parent_id . "' AND user_id=0 ORDER BY order_id ASC, name ASC");

    while ($cat_details = $db->fetch_array($sql_select_categories)) {
      $background = ($counter++ % 2) ? 'c1' : 'c2';

      $subcategories_content .= '<tr class="' . $background . '"> ' .
        '	<td width="100%">&nbsp;&raquo;&nbsp;<a href="categories.php?parent_id=' . $cat_details['category_id'] . '">' . $category_lang[$cat_details['category_id']] . '</a> ' .
        (($setts['enable_cat_counters']) ? (($cat_details['items_counter']) ? '(<strong>' . $cat_details['items_counter'] . '</strong>)' : '') : '') . '</td> ' .
        '</tr> ';
    }

    $template->set('subcategories_content', $subcategories_content);

    if ($parent_id) {
      (array) $src_cats = null;
      (string) $category_name = null;
      reset($categories_array);

      foreach ($categories_array as $key => $value) {
        if ($parent_id == $key) {

          list($category_name, $tmp_user_id) = $value;
        }
      }

      reset($categories_array);

      while (list($cat_array_id, $cat_array_details) = each($categories_array)) {
        list($cat_array_name, $cat_user_id) = $cat_array_details;

        $categories_match = strpos($cat_array_name, $category_name);
        if (trim($categories_match) == "0") {
          $src_cats[] = $cat_array_id;
        }

        $all_subcategories = $db->implode_array($src_cats, ', ');
      }

      $query[] = "(a.category_id IN (" . $all_subcategories . ") OR a.addl_category_id IN (" . $all_subcategories . "))";
    }

    $item_details = $db->rem_special_chars_array($_REQUEST);

    if ($_REQUEST['buyout_price'] == 1) {
      $query[] = "a.buyout_price>0";
    }
    if ($_REQUEST['reserve_price'] == 1) {
      $query[] = "a.reserve_price>0";
    }
    if ($_REQUEST['quantity_standard'] == 1) {
      $query[] = "a.quantity=1";
    }
    if ($_REQUEST['quantity'] == 1) {
      $query[] = "a.quantity>1";
    }
    if ($_REQUEST['enable_swap'] == 1) {
      $query[] = "a.enable_swap=1";
    }
    if ($_REQUEST['direct_payment_only'] == 1) {
      $query[] = "a.direct_payment!=''";
    }
    if ($_REQUEST['regular_payment_only'] == 1) {
      $query[] = "a.payment_methods!=''";
    }
    if ($_REQUEST['photos_only'] == 1) {
      $query[] = "IF ((SELECT count(*) AS nb_rows FROM " . DB_PREFIX . "auction_media am WHERE am.auction_id=a.auction_id AND 
			am.media_type=1 AND am.upload_in_progress=0)>0, 1, 0)=1";
    }
    $addl_where_query = $db->implode_array($query, ' AND ');
    $addl_where_query = (!empty($addl_where_query)) ? ' AND ' . $addl_where_query : ''; ## MyPHPAuction 2009 search in category procedure

    $option = 'category_search';
    $template->set('option', $option);
    $template->set('advanced_search', $advanced_search);

    if (!empty($_REQUEST['keywords_cat_search'])) {
      $keywords_cat_search = optimize_search_string($item_details['keywords_cat_search']);

      if ($_REQUEST['search_description'] == 1) {
        $addl_where_query .= " AND MATCH (a.name, a.description) AGAINST ('+" . $keywords_cat_search . "' IN BOOLEAN MODE)";
      }
      else {
        $addl_where_query .= " AND MATCH (a.name) AGAINST ('+" . $keywords_cat_search . "' IN BOOLEAN MODE)";
      }
      /**
       * or the old and SLOW search using LIKE - disabled by default, just added the line in case 
       * anyone might want to use this instead
       */## MyPHPAuction 2009 $addl_store_query = " AND (a.name LIKE '%" . $item_details['keywords_cat_search'] . "%' OR a.description LIKE '%" . $item_details['keywords_cat_search'] . "%')";
    }
    $template->set('item_details', $item_details);

    $cats_src_drop_down = '<select name="parent_id" id="parent_id" class="contentfont"> ' .
      (array) $src_categories = null;

    $src_categories[] = array('category_id' => $parent_id, 'name' => $category_lang[$parent_id]);

    if ($parent_id > 0 && $parent_id != $main_category_id) {
      $cat_id = $parent_id;

      while ($cat_id) {
        $cat_id = $db->get_sql_field("SELECT parent_id FROM " . DB_PREFIX . "categories WHERE category_id='" . $cat_id . "'", 'parent_id');
        if ($cat_id) {
          $src_categories[] = array('category_id' => $cat_id, 'name' => ' - ' . $category_lang[$cat_id]);
        }
      }

      $src_categories[] = array('category_id' => 0, 'name' => '----------------');

      $sql_select_src_subcats = $db->query("SELECT category_id FROM " . DB_PREFIX . "categories WHERE 
			parent_id=0 AND hidden=0 AND user_id=0 ORDER BY order_id ASC, name ASC");

      while ($row_cats = $db->fetch_array($sql_select_src_subcats)) {
        $src_categories[] = array('category_id' => $row_cats['category_id'], 'name' => $category_lang[$row_cats['category_id']]);
      }
    }
    else {
      $src_categories[] = array('category_id' => 0, 'name' => '----------------');
      $sql_select_src_subcats = $db->query("SELECT category_id FROM " . DB_PREFIX . "categories WHERE 
			parent_id='" . $parent_id . "' ORDER BY order_id ASC, name ASC");

      while ($row_cats = $db->fetch_array($sql_select_src_subcats)) {
        $src_categories[] = array('category_id' => $row_cats['category_id'], 'name' => $category_lang[$row_cats['category_id']]);
      }
    }

    foreach ($src_categories as $key => $value) {
      $category_link = process_link('categories', array('category' => $value['name'], 'parent_id' => $value['category_id']));

      $cats_src_drop_down .= '<option value="' . $value['category_id'] . '" ' . (($value['category_id'] == $parent_id) ? 'selected' : '') . '>' .
        $value['name'] . '</option> ';
    }
    $cats_src_drop_down .= '</select>';

    $cats_src_adv_search_link = ($advanced_search) ? '<a href="categories.php?parent_id=' . $parent_id . '&keywords_cat_search=' . $item_details['keywords_cat_search'] . '&advanced_search=0">' . MSG_BASIC_SEARCH . '</a>' :
      '<a href="categories.php?parent_id=' . $parent_id . '&keywords_cat_search=' . $item_details['keywords_cat_search'] . '&advanced_search=1">' . MSG_ADVANCED_SEARCH . '</a>';

    $template->set('cats_src_adv_search_link', '[ ' . $cats_src_adv_search_link . ' ]');
    $template->set('cats_src_drop_down', $cats_src_drop_down);
    $template->set('search_options_title', MSG_SEARCH_IN_THIS_CATEGORY);
    $categories_search_box = $template->process('search.tpl.php');
    $template->set('categories_search_box', $categories_search_box);

    /**
     * featured items, recently listed and ending soon code
     */
    if ($layout['catfeat_nb']) {
      (array) $item_details = null;

      $select_condition = "WHERE	a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0
			AND a.list_in!='store' AND a.catfeat='1'" . $addl_where_query;

      $template->set('featured_columns', min((floor($db->count_rows('auctions a', $select_condition) / $layout['catfeat_nb']) + 1), ceil($layout['catfeat_max'] / $layout['catfeat_nb'])));

      $item_details = $db->random_rows('auctions a', 'a.auction_id, a.name, a.start_price, a.max_bid, a.currency, a.end_time', $select_condition, $layout['catfeat_max']);
      $template->set('item_details', $item_details);
    }

    /**
     * shop in stores code snippet
     */
    if ($parent_id) {
      $sql_select_stores = $db->query("SELECT u.user_id, u.shop_name FROM 
			" . DB_PREFIX . "users u, " . DB_PREFIX . "auctions a WHERE a.active=1 AND a.approved=1 
			AND a.closed=0 AND a.deleted=0 AND	a.list_in!='auction'" . $addl_where_query . " AND 
			a.owner_id=u.user_id AND u.active='1' AND u.shop_active='1' GROUP BY u.user_id");

      $is_shop_stores = $db->num_rows($sql_select_stores);
      $template->set('is_shop_stores', $is_shop_stores);

      if ($is_shop_stores) {
        (string) $shop_stores_content = null;
        while ($store_details = $db->fetch_array($sql_select_stores)) {
          $background = ($counter++ % 2) ? 'c1' : 'c2';

          $shop_stores_content .= '<tr class="' . $background . '"> ' .
            '	<td width="100%">&nbsp;&raquo;&nbsp;<a href="shop.php?user_id=' . $store_details['user_id'] . '&parent_id=' . $parent_id . '">' . $store_details['shop_name'] . '</a></td> ' .
            '</tr> ';
        }

        $template->set('shop_stores_content', $shop_stores_content);
      }
    }
    $categories_header .= $template->process('categories_header.tpl.php');
    $categories_footer = $template->process('categories_footer.tpl.php');

    /**
     * below we have the variables that need to be declared in each separate browse page
     */
    $page_url = 'categories';

    $where_query = "WHERE a.active=1 AND a.approved=1 AND a.closed=0 AND a.deleted=0 AND
		a.list_in!='store' AND a.creation_in_progress=0" . $addl_where_query;

    $order_field = (in_array($_REQUEST['order_field'], $auction_ordering)) ? $_REQUEST['order_field'] : 'a.end_time';
    $order_type = (in_array($_REQUEST['order_type'], $order_types)) ? $_REQUEST['order_type'] : 'ASC';

    $additional_vars = '&parent_id=' . $parent_id . '&keywords_cat_search=' . $_REQUEST['keywords_cat_search'] .
      '&buyout_price=' . $_REQUEST['buyout_price'] . '&reserve_price=' . $_REQUEST['reserve_price'] .
      '&quantity=' . $_REQUEST['quantity'] . '&enable_swap=' . $_REQUEST['enable_swap'];

    $template->set('categories_header', $categories_header);
    $template->set('categories_footer', $categories_footer);

    include_once('includes/page_browse_auctions.php');
  }

  include_once ('global_footer.php');

  echo $template_output;
?>