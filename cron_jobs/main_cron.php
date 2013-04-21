﻿<?php
#################################################################
## MyPHPAuction v6.05															##
##-------------------------------------------------------------##
## Copyright ©2009 MyPHPAuction. All rights reserved.	##
##-------------------------------------------------------------##
#################################################################
  if (!isset($_SESSION))
    session_start();

  if (!defined('IN_SITE'))
    define('IN_SITE', 1);

  if (!$manual_cron || @IN_ADMIN == 1) {
    include_once ('../includes/global.php');
    $parent_dir = '../';
  }
  else {
    $parent_dir = '';
  }

  include_once ($parent_dir . 'includes/class_formchecker.php');
  include_once ($parent_dir . 'includes/class_custom_field.php');
  include_once ($parent_dir . 'includes/class_user.php');
  include_once ($parent_dir . 'includes/class_fees.php');
  include_once ($parent_dir . 'includes/class_shop.php');
  include_once ($parent_dir . 'includes/class_item.php');
  include_once ($parent_dir . 'includes/functions_item.php');
  include_once ($parent_dir . 'includes/class_messaging.php');


  $sql_select_cron_wa = $db->query("SELECT * FROM " . DB_PREFIX . "wanted_ads WHERE
	active=1 AND closed=0 AND end_time<'" . CURRENT_TIME . "' LIMIT 0, 50");

  $nb_cron_wa = $db->num_rows($sql_select_cron_wa);

  if ($nb_cron_wa) {
    (array) $cron_wa = null;
    (array) $cron_wa_id = null;
    (array) $poster_counter = null;
    (array) $wa_counter = null;

    while ($wa_row = $db->fetch_array($sql_select_cron_wa)) {
      ## add counter removal
      wanted_counter($wa_row['category_id'], 'remove');
      wanted_counter($wa_row['addl_category_id'], 'remove');

      $cron_wa = $wa_row;
      $cron_wa_id[] = $wa_row['wanted_ad_id'];
    }

    $cron_wa_id_array = $db->implode_array($cron_wa_id);

    $db->query("UPDATE " . DB_PREFIX . "wanted_ads SET closed=1 WHERE
		wanted_ad_id IN (" . $cron_wa_id_array . ")");

    for ($i = 0; $i < $nb_cron_wa; $i++) {
      $poster_counter[$cron_wa[$i]['owner_id']]++;
      $wa_counter[$cron_wa[$i]['owner_id']] = $cron_wa[$i]['wanted_ad_id'];
    }

    foreach ($poster_counter as $key => $value) {
      if ($value == 1) {
        $mail_input_id = $wa_counter[$key];
        include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/wa_closed_seller_notification.php');
      }
      else if ($value > 1) {
        $mail_input_id = $key;
        include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/wa_closed_seller_notification_multiple.php');
      }
    }
  }
  /**
   * Close auctions - relist/assign winners etc
   */
  $cron_item = new item();
  $cron_item->setts = &$setts;
  $cron_item->layout = &$layout;

  $cron_item->extension = $parent_dir;

  /**
   * Possible solution to avoiding the cron to create more winner rows than necessary.
   * 
   * if there are any auctions that need to be closed, we will lock the auctions table for exclusive access so that no other
   * cron will try to read from the table and select and close the same auction 
   */
  $db->query("LOCK TABLE " . DB_PREFIX . "auctions READ, " . DB_PREFIX . "auctions AS a_update WRITE");

## basically we will close up to 50 auctions at a time to avoid any server load.
  $sql_select_cron_auctions = $db->query("SELECT * FROM " . DB_PREFIX . "auctions WHERE
	active=1 AND closed=0 AND deleted=0 AND end_time<'" . CURRENT_TIME . "'
	AND close_in_progress=0 AND bid_in_progress=0 LIMIT 0, 50"); ## the query only uses where

  $nb_cron_auctions = $db->num_rows($sql_select_cron_auctions);

  if ($nb_cron_auctions) {
    ## create an array of the auctions
    (array) $cron_auction = null;
    (array) $cron_auction_id = null;
    (array) $seller_counter = null;
    (array) $auction_counter = null;

    while ($auction_row = $db->fetch_array($sql_select_cron_auctions)) {
      $cron_auction[] = $auction_row;
      $cron_auction_id[] = $auction_row['auction_id']; ## used to mark close_in_progress.
    }

    $cron_auction_id_array = $db->implode_array($cron_auction_id);

    $db->query("UPDATE " . DB_PREFIX . "auctions AS a_update SET close_in_progress=1 WHERE
		auction_id IN (" . $cron_auction_id_array . ")");
  }
  $db->query("UNLOCK TABLES");

  if ($nb_cron_auctions) {
    for ($i = 0; $i < $nb_cron_auctions; $i++) {
      $winner_output = $cron_item->assign_winner($cron_auction[$i]);

      $cron_item->close($cron_auction[$i], true);

      ## only add to counter if no sale - the closed item notifs are made only if 
      ## there was no sale for the item that was just closed
      if (!$winner_output['result']) {
        $seller_counter[$cron_auction[$i]['owner_id']]++;
        $auction_counter[$cron_auction[$i]['owner_id']] = $cron_auction[$i]['auction_id'];
      }
    }

    if (count($seller_counter)) {
      foreach ($seller_counter as $key => $value) {
        if ($value == 1) {
          $mail_input_id = $auction_counter[$key];
          include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/no_sale_seller_notification.php');
        }
        else if ($value > 1) {
          $mail_input_id = $key;
          include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/no_sale_seller_notification_multiple.php');
        }
      }
    }

    $db->query("UPDATE " . DB_PREFIX . "auctions SET close_in_progress=0 WHERE
		auction_id IN (" . $cron_auction_id_array . ")");
  }

## mark deleted all auctions that are older than closed_auction_deletion_days days
  (array) $cron_mark_deleted = null;
  $exp_limit = CURRENT_TIME - ($setts['closed_auction_deletion_days'] * 24 * 60 * 60); // closed_auction_deletion_days days ago

  $sql_select_exp_items = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE 
	end_time<" . $exp_limit . " AND deleted=0 AND creation_in_progress=0");

  while ($exp_item = $db->fetch_array($sql_select_exp_items)) {
    $cron_mark_deleted[] = $exp_item['auction_id'];
  }

  if (count($cron_mark_deleted) > 0) {
    $cron_delete_array = $db->implode_array($cron_mark_deleted);
    $cron_item->delete($cron_delete_array, 0, false, true);
  }

## start scheduled auctions
  (array) $cron_scheduled_id = null;
  $sql_select_sch_cron_items = $db->query("SELECT auction_id, category_id, addl_category_id FROM " . DB_PREFIX . "auctions WHERE 
	active=1 AND start_time<" . CURRENT_TIME . " AND end_time>" . CURRENT_TIME . " AND closed=1 AND approved=1 AND deleted=0");

  while ($scheduled_item = $db->fetch_array($sql_select_sch_cron_items)) {
    $cron_scheduled_id[] = $scheduled_item['auction_id'];
  }

  if (count($cron_scheduled_id) > 0) {
    $cron_scheduled_array = $db->implode_array($cron_scheduled_id);

    ## auctions counter - add process - multiple auctions (start scheduled auctions)
    foreach ($cron_scheduled_id as $value) {
      $cnt_details = $db->get_sql_row("SELECT auction_id, active, approved, closed, deleted, list_in, category_id, addl_category_id FROM
			" . DB_PREFIX . "auctions WHERE auction_id='" . intval($value) . "'");

      if ($cnt_details['active'] == 1 && $cnt_details['approved'] == 1 && $cnt_details['closed'] == 1 && $cnt_details['deleted'] == 0 && $cnt_details['list_in'] != 'store') {
        auction_counter($cnt_details['category_id'], 'add', $cnt_details['auction_id']);
        auction_counter($cnt_details['addl_category_id'], 'add', $cnt_details['auction_id']);
      }
    }

    $db->query("UPDATE " . DB_PREFIX . "auctions SET closed=0 WHERE auction_id IN (" . $cron_scheduled_array . ")");
  }

## delete winner details which have both s_deleted and b_deleted = 1
  $db->query("DELETE FROM " . DB_PREFIX . "winners WHERE s_deleted=1 AND b_deleted=1");

## inactivate stores - no items are inactivated!
  $db->query("UPDATE " . DB_PREFIX . "users SET shop_active=0 WHERE shop_active=1 AND shop_account_id>0 AND 
	shop_next_payment>0 AND shop_next_payment<" . CURRENT_TIME);

## unverify sellers - no items are inactivated!
  $db->query("UPDATE " . DB_PREFIX . "users SET seller_verified=0 WHERE seller_verified=1 AND 
	seller_verif_next_payment>0 AND seller_verif_next_payment<" . CURRENT_TIME);

## deleted old cache files
  remove_cache_img();

## email auction listed notifications to all relisted items
  $is_relisted_items = $db->count_rows('auctions', "WHERE is_relisted_item=1 AND notif_item_relisted=0");

  if ($is_relisted_items) {
    include($parent_dir . 'language/' . $setts['site_lang'] . '/mails/seller_relist_notification_multiple.php');
    $db->query("UPDATE " . DB_PREFIX . "auctions SET notif_item_relisted=1 WHERE 
		is_relisted_item=1 AND notif_item_relisted=0");
  }

## suspend users in account mode that have their credit limit exceeded.
  $remove_session = suspend_debit_users();
  if ($remove_session) {
    $session->unregister('membersarea');
  }

## remove all items with creation_in_progress=1 (after 1 day from their creation)

  $sql_select_creation_progress = $db->query("SELECT auction_id FROM " . DB_PREFIX . "auctions WHERE 
	creation_in_progress=1 AND creation_date<" . (CURRENT_TIME - 24 * 60 * 60));

  $is_delete_cp = $db->num_rows($sql_select_creation_progress);

  if ($is_delete_cp) {
    (array) $cp_item = null;
    while ($cp_item_details = $db->fetch_array($sql_select_creation_progress)) {
      $cp_item[] = $cp_item_details['auction_id'];
    }

    $cp_delete_array = $db->implode_array($cp_item);

    $cron_item->delete($cp_delete_array, 0, true, true);
  }

## remove all wanted ads with creation_in_progress=1 (after 1 day from their creation)

  $sql_select_wa_creation_progress = $db->query("SELECT wanted_ad_id FROM " . DB_PREFIX . "wanted_ads WHERE 
	creation_in_progress=1 AND creation_date<" . (CURRENT_TIME - 24 * 60 * 60));

  $is_wa_delete_cp = $db->num_rows($sql_select_wa_creation_progress);

  if ($is_wa_delete_cp) {
    (array) $wa_cp_item = null;
    while ($wa_cp_item_details = $db->fetch_array($sql_select_wa_creation_progress)) {
      $wa_cp_item[] = $wa_cp_item_details['wanted_ad_id'];
    }

    $wa_cp_delete_array = $db->implode_array($wa_cp_item);

    $cron_item->delete_wanted_ad($wa_cp_delete_array, 0, true);
  }

  /**
   * Workaround: unmark close_in_progress and bid_in_progress for auctions with the end_time which
   * expired 30 minutes ago and closed=0
   */
  $half_hour = 60 * 30;
  $db->query("UPDATE " . DB_PREFIX . "auctions SET bid_in_progress=0, close_in_progress=0 WHERE 
	closed=0 AND end_time<" . (CURRENT_TIME - $half_hour));

## reset preferred seller status for users with the status expired
  $db->query("UPDATE " . DB_PREFIX . "users SET preferred_seller=0 WHERE 
	preferred_seller=1 AND preferred_seller_exp_date<" . CURRENT_TIME);

## google base plugin
//define('Gbase_plugin', $parent_dir); // Path to plugin folder
//include_once(Gbase_plugin . 'google_base/gbase.inc.php');
?>